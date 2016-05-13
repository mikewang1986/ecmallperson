<?php

class WxApp extends MallbaseApp
{
    function index()
    {
        
		 import('weixin.lib');
      	$wxconfig=	& m('wxconfig');
		
	    $config = $wxconfig->get_info_user(2);
	   $wx =  new Init_Weixin();
	  
        $ACCESS_LIST = $wx->curl($config['appid'], $config['appsecret']);
        $access_token= $ACCESS_LIST['access_token'];
	    $wxid="oFdotuG2KAQv5a-Gp60YXldJb2i4";
	    $content="测试测dddd试";
	
	  //  $ret= Init_Weixin::wxsend($access_token,$wxid,$content);
			$ret=$wx->wxsend($access_token,$wxid,$content);
		
		print_r($ret);
		
    }
	
	function bbb()
	{
	   import('weixin.lib');
      	$wxconfig=	& m('wxconfig');
		
	    $config = $wxconfig->get_info_user(2);
	   $wx_mod =  new Init_Weixin();
	  $weixinuser_mod=  & m('weixinuser');
       echo  $ACCESS_LIST = $wx_mod->curl($config['appid'], $config['appsecret']);
        $access_token= $ACCESS_LIST['access_token'];
		$wxid="oFdotuG2KAQv5a-Gp60YXldJb2i4";
	   $user_info=$weixinuser_mod->get(array('conditions'=>" wxid ='".$wxid."'"));
	  print_r($user_info);
	
	$wx_mod->wxtj($access_token,$user_info);
	}
    
}

?>