<?php

class AffiliateApp extends MemberbaseApp 
{
    
         var $_user_mod;
 var $weixin_user;
    function __construct()
    {
        $this->UserApp();
    }

    function UserApp()
    {
        parent::__construct();
        $this->_user_mod =& m('member');
		$this->weixin_user =& m('weixinuser');
    }
    function index()
    {
		
		$affiliate =& m('affiliate');
		$page = $this->_get_page('10');
		
		$affiliate_list = $affiliate->find(array(
			'conditions'	=>	"user_id=".$this->visitor->get('user_id'),
			 'limit' => $page['limit'],
			'order'			=>	'log_id  desc',
			'count'			=>  true,
		
		));
			 $user_mod =& m('member');
		 foreach($affiliate_list as $key=>$v)
	 {
		
		 $userinfo = $user_mod->get("user_id=".$v['user_id']);
			
	   	 $affiliate_list[$key]['tname']=$userinfo['user_name'];
		 
		  $twx_info= $this->weixin_user->get("user_id=".$v['user_id']);
		  
		  if($twx_info)
		  {
			$affiliate_list[$key]['twx_nickname']=$twx_info['nickname']; 
			 $affiliate_list[$key]['twx_portrait']=$twx_info['headimgurl']; 
			
		 }else
		 {
		$affiliate_list[$key]['twx_portrait'] = portrait($userinfo['user_id'], $userinfo['portrait'], 'middle');
		 
		 }
		  
		 $userinfo = $user_mod->get("user_id=".$v['buyer_id']); 
		 
		 
		  
		  $bwx_info= $this->weixin_user->get("user_id=".$v['buyer_id']);
		 
		
		 if($bwx_info)
		  {
			$affiliate_list[$key]['bwx_nickname']=$bwx_info['nickname']; 
			 $affiliate_list[$key]['bwx_portrait']=$bwx_info['headimgurl']; 
			
		 }else
		 {
		
		$affiliate_list[$key]['bwx_portrait'] = portrait($userinfo['user_id'], $userinfo['portrait'], 'middle');
		 
		 }
		
	
	 }
	 
		
		  $page['item_count'] =  $affiliate->getCount();
        $this->_format_page($page); 
		 $this->assign('page_info', $page);
		  $this->_curlocal(LANG::get('member_center'),    'index.php?app=member',
                            '我的推荐分成', 'index.php?app=affiliate',
                            '推荐分成列表');
							
		    $this->assign('affiliate_list', $affiliate_list);					
        $this->_curitem('affiliate');
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . '我的推荐分成');
		 $this->display('affiliate.html');
		
    }
	
	 function store()
    {
		
		
		
		$affiliate =& m('affiliate');
		
		
		$affiliate_list = $affiliate->find(array(
			'conditions'	=>	"store=".$this->visitor->get('user_id'),
			'limit' 		=>  20,
			'order'			=>	'log_id  desc',
		
		));
		
	  
		
		  $this->_curlocal(LANG::get('member_center'),    'index.php?app=member',
                            '订单分成', 'index.php?app=affiliate2',
                            '订单分成列表');
							
		    $this->assign('affiliate_list', $affiliate_list);					
        $this->_curitem('affiliate2');
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . '订单分成');
		 $this->display('affiliate.html');
		
		
	}
    
   
}

?>