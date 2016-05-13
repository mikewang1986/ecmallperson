<?php



class WxloginApp extends MallbaseApp
{
	
	 function __construct() {
        $this->Wxlogin();
    }
	
	
	    function Wxlogin() {
        parent::__construct();
        $this->my_wxkeyword_mod = & m('wxkeyword');
        $this->my_wxconfig_mod = & m('wxconfig');
		$this->weixin_user =& m('weixinuser');
		$this->user_mod= &m('member');
    }
	
	
	  function index()
    {
		
		
		
	$my_wxconfig_mod= m('wxconfig');
	 $wxconfig = $my_wxconfig_mod->get_info_user(398);
		
		
	//echo 'wwwwww';
	//print_r($_GET);	
	$code=$_GET['code'];
	
	if(!$code)
	{
		    
			return false;
			exit();	
		
	}
	
	
	 $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$wxconfig['appid']."&secret=".$wxconfig['appsecret']."&code=".$code."&grant_type=authorization_code";
	

    $data=$this->getOpenid($url);

	
    $access_token =$data['access_token'];
	$openid= $data['openid'];
    $url="https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
    $data=$this->getOpenid($url);
	
    $user_info=$this->weixin_user->get(array('conditions'=>"wxid ='".$data['openid']."'"));
    $ms =& ms();
  if($user_info['user_id'])
 {
	
	 
	  $this->_do_login($user_info['user_id']);
            
            /* 同步登陆外部系统 */
    $synlogin = $ms->user->synlogin($user_info['user_id']);
	  		
	
	   $ret_url="index.php?app=member";
	    $this->show_message('登陆成功','返回会员中心', $ret_url);
 }else{
	 
	 
	  $local_user=$data['nickname'];
	  
	  $redadd=array(
	  'portrait'=>$data['headimgurl']
		 );
	 $user_id = $ms->user->register($local_user, '000000',time().'@qq.com',$redadd);
	 
	 
	 if(!$user_id)
	 {
	
	    $this->show_warning('注册失败');	 
	 }else{
		 
		  $data = array(
                    'user_id' => $user_id,
                    'wxid' => $data['openid'],
                    'setp' => '3',
                    'uname' => $local_user,
					
					'nickname'=>$data['nickname'],
					'sex'=>$data['sex'],
					'city'=>$data['city'],
					'country'=>$data['country'],
					'headimgurl'=>$data['headimgurl'],
					'subscribe_time'=>time,
               
          );
		  
		   $this->weixin_user->add($data);
		 
		 	  $this->_do_login($user_id);
            
            /* 同步登陆外部系统 */
       $synlogin = $ms->user->synlogin($user_id);
		 
		 $ret_url="index.php?app=member";
	    $this->show_message('登陆成功','返回会员中心', $ret_url);
		 
		 }
	 
	 
	 }



}
	
	
	
	function getOpenid($url)
	{
		
        //初始化curl
       	$ch = curl_init();
		//设置超时
		//curl_setopt($ch, CURLOP_TIMEOUT, $this->curl_timeout);
		curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		//运行curl，结果以jason形式返回
        $res = curl_exec($ch);
		curl_close($ch);
		//取出openid
		$data = json_decode($res,true);
	
		return 	$data;
	}
	
	

}
	


?>
