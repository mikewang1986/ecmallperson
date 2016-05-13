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
		
        //--------��֤state��ֹCSRF����
        if($_GET['state'] != $state){
            ErrorCase::showError("30001");
        }
        //-------��������б�
        $keysArr = array(
            "grant_type" => "authorization_code",
            "client_id" => $appid,
            "redirect_uri" => $callback,
            "client_secret" => $appkey,
            "code" => $_GET['code']
        );
		
        //------��������access_token��url
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
		$ms =& ms(); //�����û�����
		if ($this->visitor->has_login)
		{
			$this->show_warning('has_login');
	
			return;
		}
		$user=$this->_bink_mod->get(array('conditions'=>'openid="'.$openid.'" and app="'.$this->_app.'"'));
		
		if($user)
		{
			//��¼
			$this->_do_login($user['user_id']);
				
			/* ͬ����½�ⲿϵͳ */
			$synlogin = $ms->user->synlogin($user['user_id']);
			$this->show_message(Lang::get('login_successed') . $synlogin,
				'back_index',SITE_URL
			);
		}else{
			if(!$openid)
			{
				$this->show_warning('SESSION�ѹ��ڣ������µ�¼���ٰ󶨡�');
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
			//��¼
			$this->_do_login($user_id);
				
			/* ͬ����½�ⲿϵͳ */
			$synlogin = $ms->user->synlogin($user_id);
			
			// ������Ϣ�������ݿ�
			$data = array(
				'openid' => $openid,
				'user_id'=> $user_id,
				'app'   => $this->_app,
			);
			// ��������а󶨣����޸�
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
        //-------����Ψһ�������CSRF����
        $state = md5(uniqid(rand(), TRUE));
		$this->recorder->write('state',$state);
        //-------������������б�
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
 * @brief QC�࣬api�ⲿ���󣬵��ýӿ�ȫ�������ڴ˶���
 * */
class QC extends Oauth{
    private $kesArr, $APIMap;

    /**
     * _construct
     *
     * ���췽��
     * @access public 
     * @since 5
     * @param string $access_token  access_token value
     * @param string $openid        openid value
     * @return Object QC
     */
    public function __construct($access_token = "", $openid = ""){
        parent::__construct();
		
		//���access_token��openidΪ�գ����session��ȥȡ��������demoչʾ����
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

        //��ʼ��APIMap
        /*
         * ��#��ʾ�Ǳ��룬���򲻴���url(url�в�����ָò���)�� "key" => "val" ��ʾkey���û�ж�����ʹ��Ĭ��ֵval
         * ���� array( baseUrl, argListArr, method)
         */
        $this->APIMap = array(
            "get_user_info" => array(
                "https://graph.qq.com/user/get_user_info",
                array("format" => "json"),
                "GET"
            ),
        );
    }

    //������Ӧapi
    private function _applyAPI($arr, $argsList, $baseUrl, $method){
        $pre = "#";
        $keysArr = $this->keysArr;
		$keysArr['openid']=$_SESSION['QC_userData']['openid'];
        $optionArgList = array();//һЩ����ѡ�������ѡһ������
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

            //-----���û��������Ӧ�Ĳ���
            if(!isset($arr[$tmpKey]) || $arr[$tmpKey] === ""){

                if($tmpVal == $pre){//��ʹ��Ĭ�ϵ�ֵ
                    continue;
                }else if($tmpVal){
                    $arr[$tmpKey] = $tmpVal;
                }else{
                    if($v = $_FILES[$tmpKey]){

                        $filename = dirname($v['tmp_name'])."/".$v['name'];
                        move_uploaded_file($v['tmp_name'], $filename);
                        $arr[$tmpKey] = "@$filename";

                    }else{
                        $this->error->showError("api���ò�������","δ�������$tmpKey");
                    }
                }
            }

            $keysArr[$tmpKey] = $arr[$tmpKey];
        }
        //���ѡ���������һ������
        foreach($optionArgList as $val){
            $n = 0;
            foreach($val as $v){
                if(in_array($v, array_keys($keysArr))){
                    $n ++;
                }
            }

            if(! $n){
                $str = implode(",",$val);
                $this->error->showError("api���ò�������",$str."����һ��");
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
     * ħ����������api����ת��
     * @param string $name    ���õķ�������
     * @param array $arg      �����б�����
     * @since 5.0
     * @return array          ���ӵ��ý������
     */
    public function __call($name,$arg){
        //���APIMap��������Ӧ��api
        if(empty($this->APIMap[$name])){
            $this->error->showError("api�������ƴ���","�����ڵ�API: <span style='color:red;'>$name</span>");
        }

        //��APIMap��ȡapi��Ӧ����
        $baseUrl = $this->APIMap[$name][0];
        $argsList = $this->APIMap[$name][1];
        $method = isset($this->APIMap[$name][2]) ? $this->APIMap[$name][2] : "GET";

        if(empty($arg)){
            $arg[0] = null;
        }

        //����get_tenpay_addr�����⴦��php json_decode��\xA312�����ַ�֧�ֲ���
        if($name != "get_tenpay_addr"){
            $response = json_decode($this->_applyAPI($arg[0], $argsList, $baseUrl, $method));
            $responseArr = $this->objToArr($response);
        }else{
            $responseArr = $this->simple_json_parser($this->_applyAPI($arg[0], $argsList, $baseUrl, $method));
        }


        //��鷵��ret�ж�api�Ƿ�ɹ�����
        if($responseArr['ret'] == 0){
            return $responseArr;
        }else{
            $this->error->showError($response->ret, $response->msg);
        }

    }

    //php ��������ת��
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
     * ���access_token
     * @param void
     * @since 5.0
     * @return string ����access_token
     */
    public function get_access_token(){
        return $this->recorder->read("access_token");
    }

    //��ʵ��json��php����ת������
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
		
        //-------��������б�
        $keysArr = array(
            "access_token" => $this->recorder->read("access_token")
        );
        $graph_url = $this->urlUtils->combineURL(self::GET_OPENID_URL, $keysArr);
        $response = $this->urlUtils->get_contents($graph_url);

        //--------�������Ƿ���
        if(strpos($response, "callback") !== false){

            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response = substr($response, $lpos + 1, $rpos - $lpos -1);
        }

        $user = json_decode($response);
        if(isset($user->error)){
            $this->error->showError($user->error, $user->error_description);
        }

        //------��¼openid
        $_SESSION['QC_userData']['openid']=$user->openid;
		
        return $user->openid;

    }
}
/*
 * @brief ErrorCase�࣬����쳣
 * */
class ErrorCase{
    private $errorMsg;

    public function __construct(){
        $this->errorMsg = array(
            "20001" => "<h2>�����ļ��𻵻��޷���ȡ��������ִ��intall</h2>",
            "30001" => "<h2>The state does not match. You may be a victim of CSRF.</h2>",
            "50001" => "<h2>�����Ƿ������޷�����httpsЭ��</h2>����δ����curl֧��,�볢�Կ���curl֧�֣�����web�����������������δ���������ϵ����"
            );
    }

    /**
     * showError
     * ��ʾ������Ϣ
     * @param int $code    �������
     * @param string $description ������Ϣ����ѡ��
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
 * @brief url��װ�࣬�����õ�url���������װ��һ��
 * */
class URL{
    private $error;

    public function __construct(){
        $this->error = new ErrorCase();
    }

    /**
     * combineURL
     * ƴ��url
     * @param string $baseURL   ���ڵ�url
     * @param array  $keysArr   �����б�����
     * @return string           ����ƴ�ӵ�url
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
     * ������ͨ��get����������
     * @param string $url       �����url,ƴ�Ӻ��
     * @return string           ���󷵻ص�����
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

        //-------����Ϊ��
        if(empty($response)){
            $this->error->showError("50001");
        }

        return $response;
    }

    /**
     * get
     * get��ʽ������Դ
     * @param string $url     ���ڵ�baseUrl
     * @param array $keysArr  �����б�����      
     * @return string         ���ص���Դ����
     */
    public function get($url, $keysArr){
        $combined = $this->combineURL($url, $keysArr);
        return $this->get_contents($combined);
    }

    /**
     * post
     * post��ʽ������Դ
     * @param string $url       ���ڵ�baseUrl
     * @param array $keysArr    ����Ĳ����б�
     * @param int $flag         ��־λ
     * @return string           ���ص���Դ����
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