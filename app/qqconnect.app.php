<?
class QqconnectApp extends MallbaseApp
{
	var $_bink_mod;
	var $_app;
	var $qq_config = array();
	var $recorder;
	
    function __construct()
    {
        $this->QqconnectApp();
		$this->recorder=new Recorder();
    }
    function QqconnectApp()
    {
        parent::__construct();
		$this->_bink_mod = &m('member_bind');
		$this->_app      = 'qq';
		$this->qq_config = $this->_hook('on_qq_login');
		$this->qq_config['scope']='get_user_info';
		$this->qq_config['errorReport']=true;
    }
	
	function callback(){
		extract($this->qq_config);
        $state = $this->recorder->read("state");
		
        //--------验证state防止CSRF攻击
        if($_GET['state'] != $state){
            ErrorCase::showError("30001");
        }
        //-------请求参数列表
        $keysArr = array(
            "grant_type" => "authorization_code",
            "client_id" => $appid,
            "redirect_uri" => $callback,
            "client_secret" => $appkey,
            "code" => $_GET['code']
        );
		
        //------构造请求access_token的url
        $token_url = URL::combineURL(Oauth::GET_ACCESS_TOKEN_URL, $keysArr);
        $response = URL::get_contents($token_url);
        if(strpos($response, "callback") !== false){

            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
            $msg = json_decode($response);

            if(isset($msg->error)){
                 ErrorCase::showError($msg->error, $msg->error_description);
            }
        }

        $params = array();
        parse_str($response, $params);
		$_SESSION['QC_userData']["access_token"]= $params["access_token"];	
		
		$qc=new QC();
		$openid=$qc->get_openid();
		$ms =& ms(); //连接用户中心
		if ($this->visitor->has_login)
		{
			$this->show_warning('has_login');
	
			return;
		}
		$user=$this->_bink_mod->get(array('conditions'=>'openid="'.$openid.'" and app="'.$this->_app.'"'));
		
		if($user)
		{
			//登录
			$this->_do_login($user['user_id']);
				
			/* 同步登陆外部系统 */
			$synlogin = $ms->user->synlogin($user['user_id']);
			$this->show_message(Lang::get('login_successed') . $synlogin,
				'back_index',SITE_URL
			);
		}else{
			if(!$openid)
			{
				$this->show_warning('SESSION已过期，请重新登录后再绑定。');
				return;
			}
			$qq_info=$qc->get_user_info();
			if($ms->user->check_username($qq_info['nickname'])){
				$user_name=substr($qq_info['nickname'],0,14);
			}
			else
			{
				$user_name='qq'.mt_rand();
			}
			//$user_name='qq'.mt_rand();
			$email=mt_rand().'@qq.com';
			$password=md5(md5(mt_rand()));
			$user_id = $ms->user->register($user_name, $password,$email,array('portrait'=>$qq_info['figureurl_qq_2']));
			//登录
			$this->_do_login($user_id);
				
			/* 同步登陆外部系统 */
			$synlogin = $ms->user->synlogin($user_id);
			
			// 将绑定信息插入数据库
			$data = array(
				'openid' => $openid,
				'user_id'=> $user_id,
				'app'   => $this->_app,
			);
			// 如果存在有绑定，则修改
			if($this->_bink_mod->get(array('conditions'=>'user_id='.$user_id.' and app="'.$this->_app.'"','fields'=>'openid')))
			{
				$data = array('openid' => $openid);
				$this->_bink_mod->edit('user_id='.$user_id.' and app="'.$this->_app.'"', $data);
			} else {
				$this->_bink_mod->add($data);
			}
			$this->show_message(Lang::get('login_successed') . $synlogin,
				'back_index',SITE_URL
			);
		}
    }
	function login()
	{
		extract($this->qq_config);
        //-------生成唯一随机串防CSRF攻击
        $state = md5(uniqid(rand(), TRUE));
		$this->recorder->write('state',$state);
        //-------构造请求参数列表
        $keysArr = array(
            "response_type" => "code",
            "client_id" => $appid,
            "redirect_uri" => $callback,
            "state" => $state,
            "scope" => $scope
        );

        $login_url =  URL::combineURL(Oauth::GET_AUTH_CODE_URL, $keysArr);
        header("Location:$login_url");
	}
}
/*
 * @brief QC类，api外部对象，调用接口全部依赖于此对象
 * */
class QC extends Oauth{
    private $kesArr, $APIMap;

    /**
     * _construct
     *
     * 构造方法
     * @access public 
     * @since 5
     * @param string $access_token  access_token value
     * @param string $openid        openid value
     * @return Object QC
     */
    public function __construct($access_token = "", $openid = ""){
        parent::__construct();
		
		//如果access_token和openid为空，则从session里去取，适用于demo展示情形
        if($access_token === "" || $openid === ""){
            $this->keysArr = array(
                "oauth_consumer_key" => $_SESSION['appid'],
                "access_token" => $_SESSION['QC_userData']['access_token'],
                "openid" => $_SESSION['QC_userData']['openid']
            );
        }else{
            $this->keysArr = array(
                "oauth_consumer_key" => $_SESSION['appid'],
                "access_token" => $access_token,
                "openid" => $openid
            );
        }

        //初始化APIMap
        /*
         * 加#表示非必须，无则不传入url(url中不会出现该参数)， "key" => "val" 表示key如果没有定义则使用默认值val
         * 规则 array( baseUrl, argListArr, method)
         */
        $this->APIMap = array(
            "get_user_info" => array(
                "https://graph.qq.com/user/get_user_info",
                array("format" => "json"),
                "GET"
            ),
        );
    }

    //调用相应api
    private function _applyAPI($arr, $argsList, $baseUrl, $method){
        $pre = "#";
        $keysArr = $this->keysArr;
		$keysArr['openid']=$_SESSION['QC_userData']['openid'];
        $optionArgList = array();//一些多项选填参数必选一的情形
        foreach($argsList as $key => $val){
            $tmpKey = $key;
            $tmpVal = $val;

            if(!is_string($key)){
                $tmpKey = $val;

                if(strpos($val,$pre) === 0){
                    $tmpVal = $pre;
                    $tmpKey = substr($tmpKey,1);
                    if(preg_match("/-(\d$)/", $tmpKey, $res)){
                        $tmpKey = str_replace($res[0], "", $tmpKey);
                        $optionArgList[$res[1]][] = $tmpKey;
                    }
                }else{
                    $tmpVal = null;
                }
            }

            //-----如果没有设置相应的参数
            if(!isset($arr[$tmpKey]) || $arr[$tmpKey] === ""){

                if($tmpVal == $pre){//则使用默认的值
                    continue;
                }else if($tmpVal){
                    $arr[$tmpKey] = $tmpVal;
                }else{
                    if($v = $_FILES[$tmpKey]){

                        $filename = dirname($v['tmp_name'])."/".$v['name'];
                        move_uploaded_file($v['tmp_name'], $filename);
                        $arr[$tmpKey] = "@$filename";

                    }else{
                        $this->error->showError("api调用参数错误","未传入参数$tmpKey");
                    }
                }
            }

            $keysArr[$tmpKey] = $arr[$tmpKey];
        }
        //检查选填参数必填一的情形
        foreach($optionArgList as $val){
            $n = 0;
            foreach($val as $v){
                if(in_array($v, array_keys($keysArr))){
                    $n ++;
                }
            }

            if(! $n){
                $str = implode(",",$val);
                $this->error->showError("api调用参数错误",$str."必填一个");
            }
        }

        if($method == "POST"){
            if($baseUrl == "https://graph.qq.com/blog/add_one_blog") $response = $this->urlUtils->post($baseUrl, $keysArr, 1);
            else $response = $this->urlUtils->post($baseUrl, $keysArr, 0);
        }else if($method == "GET"){
            $response = $this->urlUtils->get($baseUrl, $keysArr);
        }

        return $response;

    }

    /**
     * _call
     * 魔术方法，做api调用转发
     * @param string $name    调用的方法名称
     * @param array $arg      参数列表数组
     * @since 5.0
     * @return array          返加调用结果数组
     */
    public function __call($name,$arg){
        //如果APIMap不存在相应的api
        if(empty($this->APIMap[$name])){
            $this->error->showError("api调用名称错误","不存在的API: <span style='color:red;'>$name</span>");
        }

        //从APIMap获取api相应参数
        $baseUrl = $this->APIMap[$name][0];
        $argsList = $this->APIMap[$name][1];
        $method = isset($this->APIMap[$name][2]) ? $this->APIMap[$name][2] : "GET";

        if(empty($arg)){
            $arg[0] = null;
        }

        //对于get_tenpay_addr，特殊处理，php json_decode对\xA312此类字符支持不好
        if($name != "get_tenpay_addr"){
            $response = json_decode($this->_applyAPI($arg[0], $argsList, $baseUrl, $method));
            $responseArr = $this->objToArr($response);
        }else{
            $responseArr = $this->simple_json_parser($this->_applyAPI($arg[0], $argsList, $baseUrl, $method));
        }


        //检查返回ret判断api是否成功调用
        if($responseArr['ret'] == 0){
            return $responseArr;
        }else{
            $this->error->showError($response->ret, $response->msg);
        }

    }

    //php 对象到数组转换
    private function objToArr($obj){
        if(!is_object($obj) && !is_array($obj)) {
            return $obj;
        }
        $arr = array();
        foreach($obj as $k => $v){
            $arr[$k] = $this->objToArr($v);
        }
        return $arr;
    }

   
    /**
     * get_access_token
     * 获得access_token
     * @param void
     * @since 5.0
     * @return string 返加access_token
     */
    public function get_access_token(){
        return $this->recorder->read("access_token");
    }

    //简单实现json到php数组转换功能
    private function simple_json_parser($json){
        $json = str_replace("{","",str_replace("}","", $json));
        $jsonValue = explode(",", $json);
        $arr = array();
        foreach($jsonValue as $v){
            $jValue = explode(":", $v);
            $arr[str_replace('"',"", $jValue[0])] = (str_replace('"', "", $jValue[1]));
        }
        return $arr;
    }
}
class Oauth{

    const VERSION = "2.0";
    const GET_AUTH_CODE_URL = "https://graph.qq.com/oauth2.0/authorize";
    const GET_ACCESS_TOKEN_URL = "https://graph.qq.com/oauth2.0/token";
    const GET_OPENID_URL = "https://graph.qq.com/oauth2.0/me";

    protected $recorder;
    public $urlUtils;
    protected $error;
    

    function __construct(){
        $this->recorder = new Recorder();
        $this->urlUtils = new URL();
        $this->error = new ErrorCase();
    }

    public function get_openid(){
		
        //-------请求参数列表
        $keysArr = array(
            "access_token" => $this->recorder->read("access_token")
        );
        $graph_url = $this->urlUtils->combineURL(self::GET_OPENID_URL, $keysArr);
        $response = $this->urlUtils->get_contents($graph_url);

        //--------检测错误是否发生
        if(strpos($response, "callback") !== false){

            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response = substr($response, $lpos + 1, $rpos - $lpos -1);
        }

        $user = json_decode($response);
        if(isset($user->error)){
            $this->error->showError($user->error, $user->error_description);
        }

        //------记录openid
        $_SESSION['QC_userData']['openid']=$user->openid;
		
        return $user->openid;

    }
}
/*
 * @brief ErrorCase类，封闭异常
 * */
class ErrorCase{
    private $errorMsg;

    public function __construct(){
        $this->errorMsg = array(
            "20001" => "<h2>配置文件损坏或无法读取，请重新执行intall</h2>",
            "30001" => "<h2>The state does not match. You may be a victim of CSRF.</h2>",
            "50001" => "<h2>可能是服务器无法请求https协议</h2>可能未开启curl支持,请尝试开启curl支持，重启web服务器，如果问题仍未解决，请联系我们"
            );
    }

    /**
     * showError
     * 显示错误信息
     * @param int $code    错误代码
     * @param string $description 描述信息（可选）
     */
    public function showError($code, $description = '$'){
        $recorder = new Recorder();
        if(! $recorder->readInc("errorReport")){
            die();//die quietly
        }


        echo "<meta charset=\"UTF-8\">";
        if($description == "$"){
            die($this->errorMsg[$code]);
        }else{
            echo "<h3>error:</h3>$code";
            echo "<h3>msg  :</h3>$description";
            exit(); 
        }
    }
    public function showTips($code, $description = '$'){
    }
}


class Recorder{
    private static $data;
    private $inc;
    private $error;

    public function __construct(){
		session_start();
        $this->error = new ErrorCase();
		$inc_list=array();
		$incFileContents=dirname(dirname(__FILE__)).'/data/plugins.inc.php';
		file_exists($incFileContents) && $inc_list= require($incFileContents);
		$this->inc=$inc_list['on_qq_login']['qqconnect'];
		$this->inc['callback']=urlencode($inc_list['on_qq_login']['qqconnect']['callback']);
		$this->inc['scope']='get_user_info';
		$this->inc['errorReport']=true;
        if(empty($this->inc)){
            $this->error->showError("20001");
        }
        if(empty($_SESSION['QC_userData'])){
            self::$data = array();
        }else{
            self::$data = $_SESSION['QC_userData'];
        }
		$_SESSION['appid']=$this->inc['appid'];
    }

    public function write($name,$value){
        self::$data[$name] = $value;
    }

    public function read($name){
        if(empty(self::$data[$name])){
            return null;
        }else{
            return self::$data[$name];
        }
    }

    public function readInc($name){
        if(empty($this->inc[$name])){
            return null;
        }else{
            return $this->inc[$name];
        }
    }

    public function delete($name){
        unset(self::$data[$name]);
    }

    function __destruct(){
        $_SESSION['QC_userData'] = self::$data;
    }
}


/*
 * @brief url封装类，将常用的url请求操作封装在一起
 * */
class URL{
    private $error;

    public function __construct(){
        $this->error = new ErrorCase();
    }

    /**
     * combineURL
     * 拼接url
     * @param string $baseURL   基于的url
     * @param array  $keysArr   参数列表数组
     * @return string           返回拼接的url
     */
    public function combineURL($baseURL,$keysArr){
        $combined = $baseURL."?";
        $valueArr = array();

        foreach($keysArr as $key => $val){
            $valueArr[] = "$key=$val";
        }

        $keyStr = implode("&",$valueArr);
        $combined .= ($keyStr);
        
        return $combined;
    }

    /**
     * get_contents
     * 服务器通过get请求获得内容
     * @param string $url       请求的url,拼接后的
     * @return string           请求返回的内容
     */
    public function get_contents($url){
        if (ini_get("allow_url_fopen") == "on") {
            $response = file_get_contents($url);
        }else{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_URL, $url);
            $response =  curl_exec($ch);
            curl_close($ch);
        }

        //-------请求为空
        if(empty($response)){
            $this->error->showError("50001");
        }

        return $response;
    }

    /**
     * get
     * get方式请求资源
     * @param string $url     基于的baseUrl
     * @param array $keysArr  参数列表数组      
     * @return string         返回的资源内容
     */
    public function get($url, $keysArr){
        $combined = $this->combineURL($url, $keysArr);
        return $this->get_contents($combined);
    }

    /**
     * post
     * post方式请求资源
     * @param string $url       基于的baseUrl
     * @param array $keysArr    请求的参数列表
     * @param int $flag         标志位
     * @return string           返回的资源内容
     */
    public function post($url, $keysArr, $flag = 0){

        $ch = curl_init();
        if(! $flag) curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        curl_setopt($ch, CURLOPT_POST, TRUE); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $keysArr); 
        curl_setopt($ch, CURLOPT_URL, $url);
        $ret = curl_exec($ch);

        curl_close($ch);
        return $ret;
    }
}
?>