<?php

/**
 *    管理员操作日志控制器
 *
 *    @author    fangyong
 *    @usage    none
 */
class UserApp extends MemberbaseApp
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
		
		
		
     $this->_curlocal(LANG::get('member_center'),   'index.php?app=member','会员管理'
                         );
      	
	    $this->_config_seo('title',Lang::get('member_center'). ' - ' .'会员管理');

		$user_id = $this->visitor->get('user_id');
	    $user_info=$this->_user_mod->get($user_id);
		

        $conditions = $this->_get_query_conditions(array(
            array(
                'field' => $_GET['field_name'],
                'name'  => 'field_value',
                'equal' => 'like',
            ),
        ));
        //更新排序
        if (isset($_GET['sort']) && !empty($_GET['order']))
        {
            $sort  = strtolower(trim($_GET['sort']));
            $order = strtolower(trim($_GET['order']));
            if (!in_array($order,array('asc','desc')))
            {
             $sort  = 'user_id';
             $order = 'asc';
            }
        }
        else
        {
            if (isset($_GET['sort']) && empty($_GET['order']))
            {
                $sort  = strtolower(trim($_GET['sort']));
                $order = "";
            }
            else
            {
                $sort  = 'user_id';
                $order = 'desc';
            }
        }



	
  
     /* 当前用户中心菜单 */
        $this->_curitem('affiliate_man');  
		$this->_curmenu('user1');
        $page = $this->_get_page('10');
		
	
	  $users = $this->_user_mod->find(array(
         
		   
		   'conditions' => '1=1 and tuijian_id='.$user_id.$conditions,
            'limit' => $page['limit'],
            'order' => "$sort $order",
            'count' => true,
        ));
 
	   foreach($users as $key=>$val)
	   {
		  
		 $weixin_info= $this->weixin_user->get("user_id=".$val['user_id']);
		  if($weixin_info)
		  {
			 
			 $users[$key]['nickname']=$weixin_info['nickname']; 
			 $users[$key]['portrait']=$weixin_info['headimgurl'];
		  }else{
			 
			$users[$key]['portrait'] = portrait($val['user_id'], $val['portrait'], 'middle');
			 
			 }
		
	   }
	
	
	
        $this->assign('users', $users);
		
			
        $page['item_count'] = $this->_user_mod->getCount();
        $this->_format_page($page);
        $this->assign('filtered', $conditions ? 1 : 0); //是否有查询条件
        $this->assign('page_info', $page);
		$this->assign('probability',Conf::get('probability'));
		 $this->assign('user_info', $user_info);
		 $this->assign('coin',Conf::get('coin'));
        /* 导入jQuery的表单验证插件 */
 
		
		

		
        $this->assign('query_fields', array(
            'user_name' => LANG::get('user_name'),
            'email'     => LANG::get('email'),
         
            'phone_mob' => LANG::get('phone_mob'),
        ));
        $this->assign('sort_options', array(
            'reg_time DESC'   => LANG::get('reg_time'),
            'last_login DESC' => LANG::get('last_login'),
            'logins DESC'     => LANG::get('logins'),
        ));
        $this->display('user.index.html');
    }
	
	
	
	
    function user2()
    {
		
		
		
     $this->_curlocal(LANG::get('member_center'),   'index.php?app=member','会员管理'
                         );
      	
	    $this->_config_seo('title',Lang::get('member_center'). ' - ' .'会员管理');

		$user_id = $this->visitor->get('user_id');
	    $user_info=$this->_user_mod->get($user_id);
        $conditions = $this->_get_query_conditions(array(
            array(
                'field' => $_GET['field_name'],
                'name'  => 'field_value',
                'equal' => 'like',
            ),
        ));
        //更新排序
        if (isset($_GET['sort']) && !empty($_GET['order']))
        {
            $sort  = strtolower(trim($_GET['sort']));
            $order = strtolower(trim($_GET['order']));
            if (!in_array($order,array('asc','desc')))
            {
             $sort  = 'user_id';
             $order = 'asc';
            }
        }
        else
        {
            if (isset($_GET['sort']) && empty($_GET['order']))
            {
                $sort  = strtolower(trim($_GET['sort']));
                $order = "";
            }
            else
            {
                $sort  = 'user_id';
                $order = 'desc';
            }
        }



	
  
     /* 当前用户中心菜单 */
        $this->_curitem('affiliate_man');  
		$this->_curmenu('user2');
		
		
		  $users = $this->_user_mod->find(array(
            'conditions' => '1=1 and tuijian_id='.$user_id,
       
           ));
		   $str='-999';
	      foreach($users as $val=>$key)
		  {
			 
			  $str .=','.$key['user_id']; 
	      }	
	
		
        $page = $this->_get_page('10');
		
	
	  $users = $this->_user_mod->find(array(
            'conditions' => "1=1 and tuijian_id in($str)".$conditions,
            'limit' => $page['limit'],
            'order' => "$sort $order",
            'count' => true,
        ));
 
 
   foreach($users as $key=>$val)
	   {
		  
		 $weixin_info= $this->weixin_user->get("user_id=".$val['user_id']);
		  if($weixin_info)
		  {
			 
			 $users[$key]['nickname']=$weixin_info['nickname']; 
			 $users[$key]['portrait']=$weixin_info['headimgurl'];
		  }else{
			 
			$users[$key]['portrait'] = portrait($val['user_id'], $val['portrait'], 'middle');
			 
			 }
		
	   }
	
        $this->assign('users', $users);
		
			
        $page['item_count'] = $this->_user_mod->getCount();
        $this->_format_page($page);
        $this->assign('filtered', $conditions ? 1 : 0); //是否有查询条件
        $this->assign('page_info', $page);
		$this->assign('probability',Conf::get('probability'));
		 $this->assign('user_info', $user_info);
		
        /* 导入jQuery的表单验证插件 */
 
		
		

		
        $this->assign('query_fields', array(
            'user_name' => LANG::get('user_name'),
            'email'     => LANG::get('email'),
         
            'phone_mob' => LANG::get('phone_mob'),
        ));
        $this->assign('sort_options', array(
            'reg_time DESC'   => LANG::get('reg_time'),
            'last_login DESC' => LANG::get('last_login'),
            'logins DESC'     => LANG::get('logins'),
        ));
        $this->display('user.index.html');
    }
	
	
	
	
	function user3()
    {
		
		
		
     $this->_curlocal(LANG::get('member_center'),   'index.php?app=member','会员管理'
                         );
      	
	    $this->_config_seo('title',Lang::get('member_center'). ' - ' .'会员管理');

		$user_id = $this->visitor->get('user_id');
	    $user_info=$this->_user_mod->get($user_id);
        $conditions = $this->_get_query_conditions(array(
            array(
                'field' => $_GET['field_name'],
                'name'  => 'field_value',
                'equal' => 'like',
            ),
        ));
        //更新排序
        if (isset($_GET['sort']) && !empty($_GET['order']))
        {
            $sort  = strtolower(trim($_GET['sort']));
            $order = strtolower(trim($_GET['order']));
            if (!in_array($order,array('asc','desc')))
            {
             $sort  = 'user_id';
             $order = 'asc';
            }
        }
        else
        {
            if (isset($_GET['sort']) && empty($_GET['order']))
            {
                $sort  = strtolower(trim($_GET['sort']));
                $order = "";
            }
            else
            {
                $sort  = 'user_id';
                $order = 'desc';
            }
        }



	
  
     /* 当前用户中心菜单 */
        $this->_curitem('affiliate_man');  
		$this->_curmenu('user3');
		
		
		  $users = $this->_user_mod->find(array(
            'conditions' => '1=1 and tuijian_id='.$user_id,
       
           ));
		   $str='-999';
		   
	      foreach($users as $val=>$key)
		  {
			 
			   $str .=','.$key['user_id']; 
	      }	
		  
		  //第三级
		    $users = $this->_user_mod->find(array(
            'conditions' => "1=1 and tuijian_id in($str)",
            ));
			
		
			   $str='-999';
		   
	      foreach($users as $val=>$key)
		  {
			 
			     $str .=','.$key['user_id']; 
	      }	
		  
	
		
        $page = $this->_get_page('10');
		
	
	   $users = $this->_user_mod->find(array(
            'conditions' => "1=1 and tuijian_id in($str)".$conditions,
            'limit' => $page['limit'],
            'order' => "$sort $order",
            'count' => true,
        ));
 
 
   foreach($users as $key=>$val)
	   {
		  
		 $weixin_info= $this->weixin_user->get("user_id=".$val['user_id']);
		  if($weixin_info)
		  {
			 
			 $users[$key]['nickname']=$weixin_info['nickname']; 
			 $users[$key]['portrait']=$weixin_info['headimgurl'];
		  }else{
			 
			$users[$key]['portrait'] = portrait($val['user_id'], $val['portrait'], 'middle');
			 
			 }
		
	   }
	
        $this->assign('users', $users);
		
			
        $page['item_count'] = $this->_user_mod->getCount();
        $this->_format_page($page);
        $this->assign('filtered', $conditions ? 1 : 0); //是否有查询条件
        $this->assign('page_info', $page);
		$this->assign('probability',Conf::get('probability'));
		 $this->assign('user_info', $user_info);
		
        /* 导入jQuery的表单验证插件 */
 
		
		

		
        $this->assign('query_fields', array(
            'user_name' => LANG::get('user_name'),
            'email'     => LANG::get('email'),
         
            'phone_mob' => LANG::get('phone_mob'),
        ));
        $this->assign('sort_options', array(
            'reg_time DESC'   => LANG::get('reg_time'),
            'last_login DESC' => LANG::get('last_login'),
            'logins DESC'     => LANG::get('logins'),
        ));
        $this->display('user.index.html');
    }
	
	
	
		function user4()
    {
		
		
		
     $this->_curlocal(LANG::get('member_center'),   'index.php?app=member','会员管理'
                         );
      	
	    $this->_config_seo('title',Lang::get('member_center'). ' - ' .'会员管理');

		$user_id = $this->visitor->get('user_id');
	    $user_info=$this->_user_mod->get($user_id);
        $conditions = $this->_get_query_conditions(array(
            array(
                'field' => $_GET['field_name'],
                'name'  => 'field_value',
                'equal' => 'like',
            ),
        ));
        //更新排序
        if (isset($_GET['sort']) && !empty($_GET['order']))
        {
            $sort  = strtolower(trim($_GET['sort']));
            $order = strtolower(trim($_GET['order']));
            if (!in_array($order,array('asc','desc')))
            {
             $sort  = 'user_id';
             $order = 'asc';
            }
        }
        else
        {
            if (isset($_GET['sort']) && empty($_GET['order']))
            {
                $sort  = strtolower(trim($_GET['sort']));
                $order = "";
            }
            else
            {
                $sort  = 'user_id';
                $order = 'desc';
            }
        }



	
  
     /* 当前用户中心菜单 */
        $this->_curitem('affiliate_man');  
		$this->_curmenu('user4');
		
		
		  $users = $this->_user_mod->find(array(
            'conditions' => '1=1 and tuijian_id='.$user_id,
       
           ));
		   $str='-999';
		   
	      foreach($users as $val=>$key)
		  {
			 
			  $str .=','.$key['user_id']; 
	      }	
		  
		  //第三级
		    $users = $this->_user_mod->find(array(
            'conditions' => "1=1 and tuijian_id in($str)",
            ));
			
			   $str='-999';
		   
	      foreach($users as $val=>$key)
		  {
			 
			   $str .=','.$key['user_id']; 
	      }	
		  
		  
		  	  //第四级
		    $users = $this->_user_mod->find(array(
            'conditions' => "1=1 and tuijian_id in($str)",
            ));
			
			
			 $str='-999';
		   
	      foreach($users as $val=>$key)
		  {
			 
			   $str .=','.$key['user_id']; 
	      }	
		  
	
		
        $page = $this->_get_page('10');
		
	
	  $users = $this->_user_mod->find(array(
            'conditions' => "1=1 and tuijian_id in($str)".$conditions,
            'limit' => $page['limit'],
            'order' => "$sort $order",
            'count' => true,
        ));
 
	
        $this->assign('users', $users);
		
			
        $page['item_count'] = $this->_user_mod->getCount();
        $this->_format_page($page);
        $this->assign('filtered', $conditions ? 1 : 0); //是否有查询条件
        $this->assign('page_info', $page);
		$this->assign('probability',Conf::get('probability'));
		 $this->assign('user_info', $user_info);
		
        /* 导入jQuery的表单验证插件 */
 
		
		

		
        $this->assign('query_fields', array(
            'user_name' => LANG::get('user_name'),
            'email'     => LANG::get('email'),
         
            'phone_mob' => LANG::get('phone_mob'),
        ));
        $this->assign('sort_options', array(
            'reg_time DESC'   => LANG::get('reg_time'),
            'last_login DESC' => LANG::get('last_login'),
            'logins DESC'     => LANG::get('logins'),
        ));
        $this->display('user.index.html');
    }
	
	
	
	
	
		function user5()
    {
		
		
		
     $this->_curlocal(LANG::get('member_center'),   'index.php?app=member','会员管理'
                         );
      	
	    $this->_config_seo('title',Lang::get('member_center'). ' - ' .'会员管理');

		$user_id = $this->visitor->get('user_id');
	    $user_info=$this->_user_mod->get($user_id);
        $conditions = $this->_get_query_conditions(array(
            array(
                'field' => $_GET['field_name'],
                'name'  => 'field_value',
                'equal' => 'like',
            ),
        ));
        //更新排序
        if (isset($_GET['sort']) && !empty($_GET['order']))
        {
            $sort  = strtolower(trim($_GET['sort']));
            $order = strtolower(trim($_GET['order']));
            if (!in_array($order,array('asc','desc')))
            {
             $sort  = 'user_id';
             $order = 'asc';
            }
        }
        else
        {
            if (isset($_GET['sort']) && empty($_GET['order']))
            {
                $sort  = strtolower(trim($_GET['sort']));
                $order = "";
            }
            else
            {
                $sort  = 'user_id';
                $order = 'desc';
            }
        }



	
  
     /* 当前用户中心菜单 */
        $this->_curitem('affiliate_man');  
		$this->_curmenu('user5');
		
		
		  $users = $this->_user_mod->find(array(
            'conditions' => '1=1 and tuijian_id='.$user_id,
       
           ));
		   $str='-999';
		   
	      foreach($users as $val=>$key)
		  {
			 
			  $str .=','.$key['user_id']; 
	      }	
		  
		  //第三级
		    $users = $this->_user_mod->find(array(
            'conditions' => "1=1 and tuijian_id in($str)",
            ));
			
			   $str='-999';
		   
	      foreach($users as $val=>$key)
		  {
			 
			   $str .=','.$key['user_id']; 
	      }	
		  
		  
		  	  //第四级
		    $users = $this->_user_mod->find(array(
            'conditions' => "1=1 and tuijian_id in($str)",
            ));
			
			
			 $str='-999';
		   
	      foreach($users as $val=>$key)
		  {
			 
			   $str .=','.$key['user_id']; 
	      }	
		  
		  
		    	  //第五级
		    $users = $this->_user_mod->find(array(
            'conditions' => "1=1 and tuijian_id in($str)",
            ));
			
			
			 $str='-999';
		   
	      foreach($users as $val=>$key)
		  {
			 
			   $str .=','.$key['user_id']; 
	      }	
	
		
        $page = $this->_get_page('10');
		
	
	  $users = $this->_user_mod->find(array(
            'conditions' => "1=1 and tuijian_id in($str)".$conditions,
            'limit' => $page['limit'],
            'order' => "$sort $order",
            'count' => true,
        ));
 
	
        $this->assign('users', $users);
		
			
        $page['item_count'] = $this->_user_mod->getCount();
        $this->_format_page($page);
        $this->assign('filtered', $conditions ? 1 : 0); //是否有查询条件
        $this->assign('page_info', $page);
		$this->assign('probability',Conf::get('probability'));
		 $this->assign('user_info', $user_info);
		
        /* 导入jQuery的表单验证插件 */
 
		
		

		
        $this->assign('query_fields', array(
            'user_name' => LANG::get('user_name'),
            'email'     => LANG::get('email'),
         
            'phone_mob' => LANG::get('phone_mob'),
        ));
        $this->assign('sort_options', array(
            'reg_time DESC'   => LANG::get('reg_time'),
            'last_login DESC' => LANG::get('last_login'),
            'logins DESC'     => LANG::get('logins'),
        ));
        $this->display('user.index.html');
    }
		
	
	
	function user_id($sid)
 {
	 global $str;
	 
    $users = $this->_user_mod->find(array(
         'conditions' => '1=1  AND tuijian_id='.$sid,
        
     )); 
	
	
/* print_r($users);
	exit();*/
 foreach($users as $key=>$val)
	{
		
       
	   

     $str .=  $val['user_id'].',';
	// $str .=  $val['id'].',';
	
	  $this->user_id($val['user_id']); 
	
	 	

		
    }
	
//echo $i;

  return $str; 
	 
 }
	
	 function _get_member_submenu()
    {
        return array(
            array(
                'name' => 'user1',
                'url'  => 'index.php?app=user',
            ),
			array(
				'name' => 'user2',
				'url'  => 'index.php?app=user&act=user2',
			),
			
				array(
				'name' => 'user3',
				'url'  => 'index.php?app=user&act=user3',
			),
			
				
			
			
        );
    }
	
	
	
}
?>
