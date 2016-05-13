<?php

class My_moneyApp extends MemberbaseApp
{


    function My_moneyApp()
    {
        parent::__construct();
        $this->my_money_mod =& m('my_money');
		$this->my_moneylog_mod =& m('my_moneylog');
		$this->my_mibao_mod =& m('my_mibao');
		$this->order_mod =& m('order');
		$this->my_card_mod =& m('my_card');
		$this->my_jifen_mod =& m('my_jifen');	
		$this->my_paysetup_mod =& m('my_paysetup');
    }
	
	function exits()
    {
	//执行关闭页面	
	echo "<script language='javascript'>window.opener=null;window.close();</script>";
	}	
	
 	function index()
    {
        $user_id = $this->visitor->get('user_id'); 
		/* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('shangfutong'),         'index.php?app=my_money&act=index',
                         LANG::get('jiaoyichaxun')
                         );
        /* 当前用户中心菜单 */
        $this->_curitem('jiaoyichaxun');	
        $this->assign('page_title', Lang::get('member_center') . ' - ' . Lang::get('shangfutong'));
        $my_money=$this->my_money_mod->getAll("select * from ".DB_PREFIX."my_money where user_id=$user_id");
        $this->assign('my_money', $my_money); 	
	    $this->display('my_money.index.html');
	}	
	
 	function loglist()
    {
	    $user_id = $this->visitor->get('user_id');   
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('shangfutong'),         'index.php?app=my_money&act=index',
                         LANG::get('jiaoyichaxun')
                         );
        /* 当前用户中心菜单 */
        $this->_curitem('jiaoyichaxun');	
	    $this->assign('page_title',Lang::get('member_center'). ' - ' .Lang::get('jiaoyichaxun').' - '.Lang::get('yuezhuanzhang'));
        $my_money=$this->my_money_mod->getAll("select * from ".DB_PREFIX."my_money where user_id=$user_id");
        $this->assign('my_money', $my_money); 
        $this->display('my_money.loglist.html');
    }
	
//买入查询
 	function buyer()
    {        
        $user_id = $this->visitor->get('user_id');	    
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('shangfutong'),         'index.php?app=my_money&act=index',
                         LANG::get('mairuchaxun')
                         );
        /* 当前用户中心菜单 */
        $this->_curitem('jiaoyichaxun');
		$this->assign('page_title',Lang::get('member_center'). ' - ' .Lang::get('jiaoyichaxun').' - '.Lang::get('mairuchaxun'));
	    $page = $this->_get_page();			
		$my_money=$this->my_moneylog_mod->find(array(
            'conditions' => "user_id='$user_id' and s_and_z=2 and user_log_del=0 and leixing=20" ,
            'limit' => $page['limit'],
			'order' => "id desc",
			'count' => true,
        ));	

		$page['item_count'] = $this->my_moneylog_mod->getCount();
        $this->_format_page($page);
	    $this->assign('page_info', $page);
		$this->assign('my_money', $my_money);
        $this->display('my_money.buyer.html');
    }
		
//收入查询	
   	function seller()
    {        
        $user_id = $this->visitor->get('user_id');	    
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('shangfutong'),         'index.php?app=my_money&act=index',
                         LANG::get('maichuchaxun')
                         );
        /* 当前用户中心菜单 */
        $this->_curitem('jiaoyichaxun');
		$this->assign('page_title',Lang::get('member_center'). ' - ' .Lang::get('jiaoyichaxun').' - '.Lang::get('maichuchaxun'));
	    $page = $this->_get_page();	
		
		$my_money=$this->my_moneylog_mod->find(array(
            'conditions' => "user_id='$user_id' and s_and_z=1 and user_log_del=0 and leixing=10" ,
            'limit' => $page['limit'],
			'order' => "id desc",
			'count' => true,
        ));	

		$page['item_count'] = $this->my_moneylog_mod->getCount();
        $this->_format_page($page);
	    $this->assign('page_info', $page);
		$this->assign('my_money', $my_money);
        $this->display('my_money.seller.html');
    }

//帐户转出
   	function outlog()
    {        
        $user_id = $this->visitor->get('user_id');	    
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('shangfutong'),         'index.php?app=my_money&act=index',
                         LANG::get('zhuanchuchaxun')
                         );
        /* 当前用户中心菜单 */
        $this->_curitem('jiaoyichaxun');
	    $this->assign('page_title',Lang::get('member_center'). ' - ' .Lang::get('jiaoyichaxun').' - '.Lang::get('zhuanchuchaxun'));
	    $page = $this->_get_page();			
		$my_money=$this->my_moneylog_mod->find(array(
            'conditions' => "user_id='$user_id' and s_and_z=2 and user_log_del=0 and leixing=21" ,
            'limit' => $page['limit'],
			'order' => "id desc",
			'count' => true,
        ));	

		$page['item_count'] = $this->my_moneylog_mod->getCount();
        $this->_format_page($page);
	    $this->assign('page_info', $page);
		$this->assign('my_money', $my_money);
        $this->display('my_money.outlog.html');
    }
	
//帐户转入
   	function intolog()
    {        
        $user_id = $this->visitor->get('user_id');	    
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('shangfutong'),         'index.php?app=my_money&act=index',
                         LANG::get('zhuanruchaxun')
                         );
        /* 当前用户中心菜单 */
		$this->assign('page_title',Lang::get('member_center'). ' - ' .Lang::get('jiaoyichaxun').' - '.Lang::get('zhuanruchaxun'));
        $this->_curitem('jiaoyichaxun');
	    $page = $this->_get_page();		
		
		$my_money=$this->my_moneylog_mod->find(array(
            'conditions' => "user_id='$user_id' and s_and_z=1 and user_log_del=0 and leixing=11" ,
            'limit' => $page['limit'],
			'order' => "id desc",
			'count' => true,
        ));	

		$page['item_count'] = $this->my_moneylog_mod->getCount();
        $this->_format_page($page);
	    $this->assign('page_info', $page);
		$this->assign('my_money', $my_money);
        $this->display('my_money.intolog.html');
    }

//充值查询
 	function paylist()
    {        
        $user_id = $this->visitor->get('user_id');	    
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('shangfutong'),         'index.php?app=my_money&act=index',
                         LANG::get('chongzhichaxun')
                         );
        /* 当前用户中心菜单 */
	    $this->assign('page_title',Lang::get('member_center'). ' - ' .Lang::get('chongzhichaxun').' - '.Lang::get('zaixianchongzhi'));
        $this->_curitem('chongzhichaxun');		

        $my_money=$this->my_money_mod->getAll("select * from ".DB_PREFIX."my_money where user_id=$user_id");
        $this->assign('my_money', $my_money); 
        $this->display('my_money.paylist.html');
    }	
//积分兑换
 	function jifen()
    {        
        $user_id = $this->visitor->get('user_id');	    
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('shangfutong'),         'index.php?app=my_money&act=index',
                         LANG::get('jifenduihuan')
                         );
        /* 当前用户中心菜单 */
	    $this->assign('page_title',Lang::get('member_center'). ' - ' .Lang::get('shangfutong').' - '.Lang::get('jifenduihuan'));
        $this->_curitem('jifenduihuan');
        $my_money=$this->my_money_mod->getAll("select * from ".DB_PREFIX."my_money where user_id=$user_id");
        $this->assign('my_money', $my_money); 	

	$page = $this->_get_page(2);
	$index=$this->my_jifen_mod->find(array(
	'conditions' => 'yes_no=1 and user_id=0',//条件
    'limit' => $page['limit'],
	'order' => 'jifen desc',
	'count' => true));	
	
        $page['item_count'] = $this->my_jifen_mod->getCount();
        $this->_format_page($page);
	    $this->assign('page_info', $page);
		$this->assign('index', $index); 
        $this->display('my_money.jifen.html');
    }
 	function jifen_post()
    {
	$id=$_GET["id"];      
	$user_id = $this->visitor->get('user_id');
	
	if($_POST)
	{
	$duihuanshu=trim($_POST['duihuanshu']);
	$my_jifen=$this->my_jifen_mod->getrow("select * from ".DB_PREFIX."my_jifen where id=$id");
    $shengyushuliang=$my_jifen['shuliang']-$my_jifen['yiduihuan'];//剩余可兑换数
	
	if(empty($duihuanshu))
    {
				$this->show_warning('shuliangbugou');
       	        return;
	}
	if(preg_match("/[^0.-9]/",$duihuanshu))
    {
	     $this->show_warning('cuowu_nishurudebushishuzilei'); 
         return;
    }
	if($duihuanshu > $shengyushuliang)
	{
			   	$this->show_warning('shuliangbugou');
       	        return;
	}
	$jifen=$my_jifen['jifen']*$duihuanshu;
    $money_row=$this->my_money_mod->getrow("select jifen from ".DB_PREFIX."my_money where user_id='$user_id'");
    if($jifen > $money_row['jifen'])
	{
			   	$this->show_warning('jifenbuzu');//积分不足
       	        return;	
	}
	//兑换成功，减少该用户的积分
	$xjifen=$money_row['jifen']-$jifen;
	$user_jifen=array(
	'jifen'=>$xjifen,													
    );
    $this->my_money_mod->edit('user_id='.$user_id,$user_jifen);
	//兑换成功，写入一条数据
	$add_array=array(
	'add_time'=>time(),
	'jifen'=>$jifen,
	'wupin_name'=>$my_jifen['wupin_name'],
	'wupin_img'=>$my_jifen['wupin_img'],
	'jiazhi'=>$my_jifen['jiazhi'],
	'shuliang'=>$duihuanshu,
	'user_id'=>$this->visitor->get('user_id'),
	'user_name'=>$this->visitor->get('user_name'),
	'my_name'=>trim($_POST['my_name']),
	'my_add'=>trim($_POST['my_add']),
	'my_tel'=>trim($_POST['my_tel']),
	'my_mobile'=>trim($_POST['my_mobile']),
	'log_text'=>$my_jifen['log_text'],
	);
	$this->my_jifen_mod->add($add_array);
	//兑换成功，更新ID对应的数量及已兑换数量
	$edit_array=array(
	'yiduihuan'=>$my_jifen['yiduihuan']+$duihuanshu,
	);
    $this->my_jifen_mod->edit('id='.$id,$edit_array);
				$this->show_message('duihuanchenggong','duihuanchenggong','index.php?app=my_money&act=duihuan_jilu');//兑换成功 index.php?app=my_money&act=duihuan_jilu
		        return;
	}
	else
	{
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('shangfutong'),         'index.php?app=my_money&act=index',
                         LANG::get('jifenduihuan')
                         );
        /* 当前用户中心菜单 */
	    $this->assign('page_title',Lang::get('member_center'). ' - ' .Lang::get('shangfutong').' - '.Lang::get('jifenduihuan'));
        $this->_curitem('jifenduihuan');		


	$index=$this->my_jifen_mod->find(array(
	'conditions' => "yes_no=1 and id='$id' and user_id=0",//条件
    'limit' => $page['limit'],
	'count' => true));	


		$this->assign('index', $index);
        $this->display('my_money.jifen_post.html');
    }
	}
//已兑换记录
   	function duihuan_jilu()
    {
	$user_id = $this->visitor->get('user_id');	    
        /* 当前位置 */
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('shangfutong'),         'index.php?app=my_money&act=index',
                         LANG::get('jifenduihuan')
                         );
        /* 当前用户中心菜单 */
	    $this->assign('page_title',Lang::get('member_center'). ' - ' .Lang::get('shangfutong').' - '.Lang::get('jifenduihuan'));
        $this->_curitem('jifenduihuan');
	    $page = $this->_get_page();		
		
		$index=$this->my_jifen_mod->find(array(
	        'conditions' => "yes_no=0 and user_id='$user_id'",//条件
            'limit' => $page['limit'],
		    'order' => 'id desc',
			'count' => true,
        ));	

		$page['item_count'] = $this->my_jifen_mod->getCount();
        $this->_format_page($page);
	    $this->assign('page_info', $page);
		$this->assign('index', $index);
        $this->display('my_money.jifen_duihuan_jilu.html');
	}
//充值记录
   	function paylog()
    {        
        $user_id = $this->visitor->get('user_id');	    
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('shangfutong'),         'index.php?app=my_money&act=index',
                         LANG::get('zhuanruchaxun')
                         );
        /* 当前用户中心菜单 */
	$this->assign('page_title',Lang::get('member_center'). ' - ' .Lang::get('chongzhichaxun').' - '.Lang::get('chongzhijilu'));
        $this->_curitem('chongzhichaxun');	
	    $page = $this->_get_page();		
		
		$my_money=$this->my_moneylog_mod->find(array(
            'conditions' => "user_id='$user_id' and s_and_z=1 and user_log_del=0 and leixing=30" ,
            'limit' => $page['limit'],
			'order' => "id desc",
			'count' => true,
        ));	

		$page['item_count'] = $this->my_moneylog_mod->getCount();
        $this->_format_page($page);
	    $this->assign('page_info', $page);
		$this->assign('my_money', $my_money);
        $this->display('my_money.paylog.html');
    }	
		
//提现查询	
	function txlist()
    {        
	    $user_id = $this->visitor->get('user_id');   
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('shangfutong'),         'index.php?app=my_money&act=index',
                         LANG::get('tixianshenqing')
                         );
        /* 当前用户中心菜单 */
	$this->assign('page_title',Lang::get('member_center'). ' - ' .Lang::get('tixianshenqing'));
        $this->_curitem('tixianshenqing');	
	
        $my_money=$this->my_money_mod->getAll("select * from ".DB_PREFIX."my_money where user_id=$user_id");
        $this->assign('my_money', $my_money); 
        $this->display('my_money.txlist.html');
    }
	
//提现记录
   	function txlog()
    {        
        $user_id = $this->visitor->get('user_id');	    
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('shangfutong'),         'index.php?app=my_money&act=index',
                         LANG::get('tixianjilu')
                         );
        /* 当前用户中心菜单 */
	$this->assign('page_title',Lang::get('member_center'). ' - ' .Lang::get('tixianshenqing').' - '.Lang::get('tixianjilu'));
        $this->_curitem('tixianshenqing');	
	    $page = $this->_get_page();		
		
		$my_money=$this->my_moneylog_mod->find(array(
            'conditions' => "user_id='$user_id' and s_and_z=2 and user_log_del=0 and leixing=40" ,
            'limit' => $page['limit'],
			'count' => true,
        ));	

		$page['item_count'] = $this->my_moneylog_mod->getCount();
        $this->_format_page($page);
	    $this->assign('page_info', $page);
		$this->assign('my_money', $my_money);
        $this->display('my_money.txlog.html');
    }	
		
//用户设置		
 	function mylist()
    {        
        $user_id = $this->visitor->get('user_id');	   
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('shangfutong'),         'index.php?app=my_money&act=index',
                         LANG::get('zhanghushezhi')
                         );
        /* 当前用户中心菜单 */
        $this->_curitem('zhanghushezhi');	
        $this->assign('page_title', Lang::get('member_center') . ' - ' . Lang::get('zhanghushezhi'));
		//读取帐户金额
        $my_money=$this->my_money_mod->getAll("select * from ".DB_PREFIX."my_money where user_id=$user_id");
		$this->assign('my_money', $my_money); 
        $this->display('my_money.mylist.html');//对应风格文件
    }	

//用户隐藏流水，但不会删除数据
 	function user_log_del()
    {
        $user_id = $this->visitor->get('user_id');
		$id = trim($_GET['id']);
		if(empty($id))
        {
			   	$this->show_warning('feifacanshu');
       	        return;
		}
		else
		{
		$ids = explode(',', $id);
		$user_log_del=array(
		'user_log_del'=>1,
		);
        $this->my_moneylog_mod->edit($ids,$user_log_del);
				$this->show_message('shanchuchenggong');
		        return;
		}
	}
//用户显示流水，但不会删除数据，此功能暂时隐藏不使用
 	function user_log_huifu()
    {

        $user_id = $this->visitor->get('user_id');
		$id = trim($_GET['id']);
		if(empty($id))
        {
			   	$this->show_warning('feifacanshu');
       	        return;
		}
		else
		{
		$ids = explode(',', $id);
		$user_log_del=array(
		'user_log_del'=>0,
		);
        $this->my_moneylog_mod->edit($ids,$user_log_del);
				$this->show_message('ok');
		        return;
		}
	}	


//设置新支付密码
function newpassword()
{     	
	$user_id = $this->visitor->get('user_id');			
	if($_POST)//检测是否提交
	{
	$zf_pass = trim($_POST['zf_pass']);
	$zf_pass2 = trim($_POST['zf_pass2']);
	if(empty($zf_pass))
    {
	$this->show_warning('cuowu_zhifumimabunengweikong'); 
    return;
	}
	if($zf_pass != $zf_pass2)
	{
	$this->show_warning('cuowu_liangcishurumimabuyizhi'); 
    return;
	}
//读原始密码
$money_row=$this->my_money_mod->getrow("select zf_pass from ".DB_PREFIX."my_money where user_id='$user_id'");	
//转换32位 MD5
	$md5zf_pass=md5($zf_pass);	

	if(empty($money_row['zf_pass']))//检测为空密码才允许新设置
    {
	$newpass_array=array(
	'zf_pass'=>$md5zf_pass,													
    );
    $this->my_money_mod->edit('user_id='.$user_id,$newpass_array);
	$this->show_message('zhifumimaxiugaichenggong','zhifumimaxiugaichenggong','index.php?app=my_money&act=password');
	return;
    }
	else	
	{
	$this->show_warning('cuowu_yuanzhifumimayanzhengshibai'); 
    return;	
	}	

    }
    else
    {
//读原始密码
$money_row=$this->my_money_mod->getrow("select zf_pass from ".DB_PREFIX."my_money where user_id='$user_id'");
	if(!empty($money_row['zf_pass']))
    {
	header("Location: index.php?app=my_money&act=password");
	    return;
	}//检测空密码就跳到新密码设
	
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('shangfutong'),         'index.php?app=my_money&act=index',
                         LANG::get('zhifumimaxiugai')
                         );
        $this->_curitem('zhanghushezhi');
        $this->assign('page_title',Lang::get('member_center').' - '.Lang::get('zhanghushezhi').' - '.Lang::get('zhifumimaxiugai'));
        $this->display('my_money.newpassword.html');
	    return;
    }
}

//修改支付密码
function password()
{     	
	$user_id = $this->visitor->get('user_id');			
	if($_POST)//检测是否提交
	{
	$y_pass = trim($_POST['y_pass']);
	$zf_pass = trim($_POST['zf_pass']);
	$zf_pass2 = trim($_POST['zf_pass2']);
	if(empty($zf_pass))
    {
	$this->show_warning('cuowu_zhifumimabunengweikong'); 
    return;
	}
	if($zf_pass != $zf_pass2)
	{
	$this->show_warning('cuowu_liangcishurumimabuyizhi'); 
    return;
	}
//读原始密码
$money_row=$this->my_money_mod->getrow("select zf_pass from ".DB_PREFIX."my_money where user_id='$user_id'");	
//转换32位 MD5
	$md5y_pass=md5($y_pass);
	$md5zf_pass=md5($zf_pass);	
	
	if($money_row['zf_pass'] != $md5y_pass)
	{
	$this->show_warning('cuowu_yuanzhifumimayanzhengshibai'); 
    return;	
    }
    else
    {
	$newpass_array=array(
	'zf_pass'=>$md5zf_pass,													
    );
    $this->my_money_mod->edit('user_id='.$user_id,$newpass_array);
	$this->show_message('zhifumimaxiugaichenggong');
	return;
    }
    }
    else
    {
//读原始密码
$money_row=$this->my_money_mod->getrow("select zf_pass from ".DB_PREFIX."my_money where user_id='$user_id'");
	if(empty($money_row['zf_pass']))
    {
	header("Location: index.php?app=my_money&act=newpassword");
	    return;
	}//检测空密码就跳到新密码设置
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('shangfutong'),         'index.php?app=my_money&act=index',
                         LANG::get('zhifumimaxiugai')
                         );
        $this->_curitem('zhanghushezhi');
      $this->assign('page_title',Lang::get('member_center').' - '.Lang::get('zhanghushezhi').' - '.Lang::get('zhifumimaxiugai'));
        $this->display('my_money.password.html');
	    return;
    }
}

//显示找回支付密码		
 	function find_password()
    {
	header("Location: index.php?app=find_password");
	return;
	}
	
	


//密保绑定页面		
 	function mibao()
    {        
        $user_id = $this->visitor->get('user_id');	   
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('shangfutong'),         'index.php?app=my_money&act=index',
                         LANG::get('mibaobangding')
                         );
        /* 当前用户中心菜单 */
        $this->_curitem('zhanghushezhi');
	$this->assign('page_title',Lang::get('member_center').' - '.Lang::get('zhanghushezhi').' - '.Lang::get('mibaobangding'));	
		//读取帐户金额
        $my_money=$this->my_money_mod->getAll("select * from ".DB_PREFIX."my_money where user_id=$user_id");
		$this->assign('my_money', $my_money); 
        $this->display('my_money.mibao.html');//对应风格文件
    }



//提现申请
function txsq()
{ 
	if($_POST)
	{
	$user_id = $this->visitor->get('user_id');
	$tx_money = trim($_POST['tx_money']);
	$post_zf_pass = trim($_POST['post_zf_pass']);
	$user_zimuz1 = trim($_POST['user_zimuz1']);
	$user_zimuz2 = trim($_POST['user_zimuz2']);
	$user_zimuz3 = trim($_POST['user_zimuz3']);
	$md5zf_pass=md5($post_zf_pass);	
	$user_shuzi1 = trim($_POST['user_shuzi1']);
	$user_shuzi2 = trim($_POST['user_shuzi2']);
	$user_shuzi3 = trim($_POST['user_shuzi3']);
$money_row=$this->my_money_mod->getrow("select * from ".DB_PREFIX."my_money where user_id='$user_id'");
//检测用户的银行信息
	if(empty($money_row['bank_sn']) or empty($money_row['bank_name']) or empty($money_row['bank_username']))
	{
	$this->show_warning('cuowu_nihaimeiyoushezhiyinhangxinxi'); 
    return;
	}
	if(empty($tx_money))
    {
	   	$this->show_warning('cuowu_tixianjinebunengweikong');
	    return;
	}
	if(preg_match("/[^0.-9]/",$tx_money))
    {
	     $this->show_warning('cuowu_nishurudebushishuzilei'); 
         return;
    }
	if($money_row['money'] <$tx_money)
	{
		$this->show_warning('duibuqi_zhanghuyuebuzu');
	    return;
	}
//检测是密保用户就执行
    if($money_row['mibao_id'] >0)
	{
	if(empty($user_shuzi1) or empty($user_shuzi2) or empty($user_shuzi3))
    {
	   	$this->show_warning('cuowu_dongtaimimabunengweikong');
	    return;
	}
$mibao_row=$this->my_mibao_mod->getrow("select * from ".DB_PREFIX."my_mibao where user_id='$user_id'");
//检测数字错，就提示并停止
    if($mibao_row[$user_zimuz1] != $user_shuzi1 or $mibao_row[$user_zimuz2] != $user_shuzi2 or $mibao_row[$user_zimuz3] != $user_shuzi3)
	{
		        echo Lang::get('money_banben');
	            $this->show_warning('cuowu_dongtaimimayanzhengshibai'); 
                return;
	}
	}
	else
	{
//否则检测 支付密码
	if(empty($post_zf_pass))
	{
	   	$this->show_warning('cuowu_zhifumimabunengweikong');
       	return;
	}
    if($money_row['zf_pass'] != $md5zf_pass)
    {
	   	$this->show_warning('cuowu_zhifumimayanzhengshibai'); 
       	return;
	}
	}
//通过验证 开始操作数据
$newmoney = $money_row['money']-$tx_money;
$newmoney_dj =$money_row['money_dj']+$tx_money;

    //添加日志
    $log_text =$this->visitor->get('user_name').Lang::get('tixianshenqingjine').$tx_money.Lang::get('yuan');
	$add_mymoneylog=array(
	'user_id'=>$user_id,
	'user_name'=>$this->visitor->get('user_name'),
	'order_id '=>Lang::get('tixian_dengdaiguanliyuangongbu'),
	'add_time'=>time(),
	'leixing'=>40,	
	's_and_z'=>2,
	'money_zs'=>$tx_money,	
	'money'=>'-'.$tx_money,		
	'log_text'=>$log_text,
	'caozuo'=>60,																				
    );
    $this->my_moneylog_mod->add($add_mymoneylog);
	$edit_mymoney=array(
	'money_dj'=>$newmoney_dj,	
	'money'=>$newmoney,																			
    );	
	$this->my_money_mod->edit('user_id='.$user_id,$edit_mymoney);
		$this->show_message('tixian_chenggong');
		return;

	}
	else
	{
		$this->show_warning('feifacanshu');
	    return;
	}
}	


//银行信息设置
function bank_set()
{ 
	if($_POST)
	{
    //检测两次银行号码
	if(trim($_POST['yes_bank_sn']) != trim($_POST['yes_bank_sn_queren']))
    {
                $this->show_warning('liangxitixianzhenghaobuyizhi'); 
                return;
    }
    $user_id = $this->visitor->get('user_id');
	$bank_edit = trim($_POST['bank_edit']);
	if($bank_edit=="YES")
	{
	$zf_pass     = trim($_POST['zf_pass']);
	$user_zimuz1 = trim($_POST['user_zimuz1']);
	$user_zimuz2 = trim($_POST['user_zimuz2']);
	$user_zimuz3 = trim($_POST['user_zimuz3']);
	$user_shuzi1 = trim($_POST['user_shuzi1']);
	$user_shuzi2 = trim($_POST['user_shuzi2']);
	$user_shuzi3 = trim($_POST['user_shuzi3']);

//读取密保卡资料
$money_row=$this->my_money_mod->getrow("select * from ".DB_PREFIX."my_money where user_id='$user_id'");
    if($money_row['mibao_id'] >0 )
	{
$mibao_row=$this->my_mibao_mod->getrow("select * from ".DB_PREFIX."my_mibao where user_id='$user_id'");
//检测数字错，就提示并停止
    if($mibao_row[$user_zimuz1]!=$user_shuzi1 or $mibao_row[$user_zimuz2]!=$user_shuzi2 or $mibao_row[$user_zimuz2]!=$user_shuzi2)
	{
		        echo Lang::get('money_banben');
	            $this->show_warning('cuowu_dongtaimimayanzhengshibai'); 
                return;
	}
	}
	else
	{
//检测密码回答
	if(empty($zf_pass))
    {
	   	$this->show_warning('cuowu_zhifumimabunengweikong');
	    return;
	}
    $md5zf_pass=md5($zf_pass);		
    if($money_row['zf_pass'] != $md5zf_pass)
    {
	$this->show_warning('cuowu_zhifumimayanzhengshibai'); 
    return;
	}	
	
	}//mibao>0
//验证都通过了开始修改数据
	$bank_array=array(
    'bank_name'=>trim($_POST['yes_bank_name']),	
    'bank_sn'=>trim($_POST['yes_bank_sn']),	
    'bank_username'=>trim($_POST['yes_bank_username']),	
	'bank_add'=>trim($_POST['yes_bank_add']),	
    );
//执行SQL操作
	$this->my_money_mod->edit('user_id='.$user_id,$bank_array);
	$this->show_message('baocuntixianxinxichenggong');	
	return;
	}//YES
	}//post
	else
	{
		$this->show_warning('feifacanshu');
	    return;
	}
}




//绑定密保卡
function add_mibao()
{ 
	if($_POST)
	{
    $user_id = $this->visitor->get('user_id');
	$zf_pass = trim($_POST['zf_pass']);
	$post_mb_sn = trim($_POST['post_mb_sn']);
	$user_zimuz1 = trim($_POST['user_zimuz1']);
	$user_zimuz2 = trim($_POST['user_zimuz2']);
	$user_zimuz3 = trim($_POST['user_zimuz3']);
	$user_shuzi1 = trim($_POST['user_shuzi1']);
	$user_shuzi2 = trim($_POST['user_shuzi2']);
	$user_shuzi3 = trim($_POST['user_shuzi3']);
	if(empty($zf_pass))
    {
	   	$this->show_warning('cuowu_zhifumimabunengweikong');
	    return;
	}
	if(empty($post_mb_sn))
    {
	   	$this->show_warning('mibaosnbunengweikong');
	    return;
	}
$money_row=$this->my_money_mod->getrow("select zf_pass from ".DB_PREFIX."my_money where user_id='$user_id'");

    if($money_row['mibao_id']>0)
	{
	$this->show_warning('cuowu_gaiyonghuyijingbangdingmibaole'); 
    return;
	}
    $md5zf_pass=md5($zf_pass);		
    if($money_row['zf_pass'] != $md5zf_pass)
    {
	$this->show_warning('cuowu_zhifumimayanzhengshibai'); 
    return;
	}
$mibao_row=$this->my_money_mod->getrow("select * from ".DB_PREFIX."my_mibao where mibao_sn='$post_mb_sn'");
	$mibao_id=$mibao_row['id'];
	$mibao_sn=$mibao_row['mibao_sn'];
	$mibao_shuzi1=$mibao_row[$user_zimuz1];
	$mibao_shuzi2=$mibao_row[$user_zimuz2];
	$mibao_shuzi3=$mibao_row[$user_zimuz3];
	if(empty($mibao_id) or empty($mibao_sn))
    {
	   	$this->show_warning('cuowu_mibaokasncuowu');
	    return;
	}
	if($mibao_row['user_id']>0)
	{
		$this->show_warning('cuowu_gaimibaokazhengzaishiyongzhong');
		return;
	}
	if ($user_shuzi1 != $mibao_shuzi1 or $user_shuzi2 != $mibao_shuzi2 or  $user_shuzi3 != $mibao_shuzi3) 
	{
		        echo Lang::get('money_banben');
	            $this->show_warning('cuowu_dongtaimimayanzhengshibai'); 
                return;
	}
	else
	{
    //检测绑定时间
	if(empty($mibao_row['bd_time']))
	{
	$mibao_array=array(
	'user_id'=>$this->visitor->get('user_id'),
	'user_name'=>$this->visitor->get('user_name'),
	'bd_time'=>time(),	
	'dq_time'=>time()+31536000,
	'ztai'=>1,
	);
    }
	else//绑时间 否则
	{
	$mibao_array=array(
	'user_id'=>$this->visitor->get('user_id'),
	'user_name'=>$this->visitor->get('user_name'),
	);
	}
	
	$money_edit=array(
	'mibao_id'=>$mibao_id,
	'mibao_sn'=>$mibao_sn,
	);

	$this->my_money_mod->edit('user_id='.$user_id,$money_edit);
	$this->my_mibao_mod->edit('id='.$mibao_id,$mibao_array);
	$this->show_message('bangding_chenggong');	
    }
    }
    else
    {
   		$this->show_warning('feifacanshu');
	    return;
    }
}


//解除密保卡
function del_mibao()
{ 
	if($_POST)
	{
    $user_id = $this->visitor->get('user_id');
	$post_mb_sn  = trim($_POST['post_mb_sn']);
	$user_zimuz1 = trim($_POST['user_zimuz1']);
	$user_zimuz2 = trim($_POST['user_zimuz2']);
	$user_zimuz3 = trim($_POST['user_zimuz3']);
	$user_shuzi1 = trim($_POST['user_shuzi1']);
	$user_shuzi2 = trim($_POST['user_shuzi2']);
	$user_shuzi3 = trim($_POST['user_shuzi3']);
	if(empty($post_mb_sn))
    {
	   	$this->show_warning('mibaosnbunengweikong');
	    return;
	}
	
$mibao_row=$this->my_money_mod->getrow("select * from ".DB_PREFIX."my_mibao where mibao_sn='$post_mb_sn'");

	$mibao_id=$mibao_row['id'];
	$mibao_sn=$mibao_row['mibao_sn'];

	$mibao_shuzi1=$mibao_row[$user_zimuz1];
	$mibao_shuzi2=$mibao_row[$user_zimuz2];
	$mibao_shuzi3=$mibao_row[$user_zimuz3];
	if(empty($mibao_id) or empty($mibao_sn))
    {
	   	$this->show_warning('cuowu_mibaokasncuowu');
	    return;
	}
	if ($user_shuzi1 != $mibao_shuzi1 or $user_shuzi2 != $mibao_shuzi2 or  $user_shuzi3 != $mibao_shuzi3) 
	{
		        echo Lang::get('money_banben');
	            $this->show_warning('cuowu_dongtaimimayanzhengshibai'); 
                return;
	}
	else
	{
	$mibao_array=array(
	'user_id'=>0,
	'user_name'=>"",
	);
	
	$money_array=array(
	'mibao_id'=>0,
	'mibao_sn'=>"",
	);
    }
	$this->my_mibao_mod->edit('id='.$mibao_id,$mibao_array);
	$this->my_money_mod->edit('user_id='.$user_id,$money_array);
	$this->show_message('jiechu_chenggong');		
   }//POST
   else
   {//POST
   		$this->show_warning('feifacanshu');
	    return;
   }//POST
}  



//支付定单
function payment()
{  
            $user_id = $this->visitor->get('user_id');
			$zf_pass = trim($_POST['zf_pass']);
			$user_zimuz1 = trim($_POST['user_zimuz1']);
			$user_zimuz2 = trim($_POST['user_zimuz2']);
			$user_zimuz3 = trim($_POST['user_zimuz3']);
			$user_shuzi1 = trim($_POST['user_shuzi1']);
			$user_shuzi2 = trim($_POST['user_shuzi2']);
			$user_shuzi3 = trim($_POST['user_shuzi3']);
			$post_money  = trim($_POST['post_money']);//提交过来的 金钱
            $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;//提交过来的 定单号码
	if(empty($order_id))
    {
	   	$this->show_warning('feifacanshu');
	    return;
	}
if($_POST)//检测是否提交
{
//读取moneylog 为了检测提交不重复
$moneylog_row=$this->my_moneylog_mod->getrow("select order_id from ".DB_PREFIX."my_moneylog where user_id='$user_id' and order_id='$order_id' and caozuo='10'");
if($moneylog_row['order_id']==$order_id) 
{
                $this->show_warning('cuowu_gaidingdanyijingzhufule'); 
                return;//定单已经支付
}
//读取买家SQL
$buyer_row=$this->my_money_mod->getrow("select * from ".DB_PREFIX."my_money where user_id='$user_id'");	 
$buyer_name=$buyer_row['user_name'];//买家用户名
$buyer_zf_pass =$buyer_row['zf_pass'];//支付密码
$buyer_money=$buyer_row['money'];//当前用户的原始金钱
//从定单中 读取卖家信息
$order_row=$this->order_mod->getrow("select * from ".DB_PREFIX."order where order_id='$order_id'");
$order_order_sn=$order_row['order_sn'];//定单号
$order_seller_id=$order_row['seller_id'];//定单里的 卖家ID
$order_money=$order_row['order_amount'];//定单里的 最后定单总价格
//读取卖家SQL
$seller_row=$this->my_money_mod->getrow("select * from ".DB_PREFIX."my_money where user_id='$order_seller_id'");	
$seller_id=$seller_row['user_id'];//卖家ID 
$seller_name=$seller_row['user_name'];//卖家用户名
$seller_money_dj=$seller_row['money_dj'] ;//卖家的原始冻结金钱
//读取密保卡资料
$mibao_row=$this->my_mibao_mod->getrow("select * from ".DB_PREFIX."my_mibao where user_id='$user_id'");
$mibao_user_id=$mibao_row['user_id'];
$mibao_shuzi1=$mibao_row[$user_zimuz1];
$mibao_shuzi2=$mibao_row[$user_zimuz2];
$mibao_shuzi3=$mibao_row[$user_zimuz3];	
if($mibao_user_id)
{
//检测提交的密保信息 是否于读取用户的相符
if ( $user_shuzi1 != $mibao_shuzi1 or $user_shuzi2 != $mibao_shuzi2 or  $user_shuzi3 != $mibao_shuzi3) 
{ //检测密保相符 开始
		        echo Lang::get('money_banben');
	            $this->show_warning('cuowu_dongtaimimayanzhengshibai'); 
                return;
} 
//检测密保 否则 结束
//同时检测是否使用支付密码 开始
$new_zf_pass=md5($zf_pass);
if ( $new_zf_pass != $buyer_zf_pass) 
{ //支付密码 错误 开始
                $this->show_warning('cuowu_zhifumimayanzhengshibai'); 
                return;
} 
//支付密码 错误 结束
}
else
{
//检测是否使用支付密码 开始
$new_zf_pass=md5($zf_pass);
if ( $new_zf_pass != $buyer_zf_pass) 
{ //支付密码 错误 开始
                $this->show_warning('cuowu_zhifumimayanzhengshibai'); 
                return;
} 
//支付密码 错误 结束
}



//检测余额是否足够
if ( $buyer_money < $order_money) 
{   //检测余额是否足够 开始
				$this->show_warning('cuowu_zhanghuyuebuzu',
                'lijichongzhi',  'index.php?app=my_money&act=paylist'
                 );
                return;
}	//检测余额是否足够 结束

/*
//金额是否相同
if ( $post_money != $order_money) 
{   //检测密保相符 开始
                $this->show_warning('fashengcuowu_jineshujukeyi'); 
                return;
}	//金额是否相同 结束
*/

//检测SESSION 是否存为空
if ($_SESSION['session_order_sn'] != $order_order_sn)
{//检测SESSION 开始

        //更新扣除买家的金钱
	    $buyer_array=array(
			'money'=>$buyer_money-$order_money,
			);
		$this->my_money_mod->edit('user_id='.$user_id,$buyer_array);

		//更新卖家的冻结金钱	
		$seller_array=array(
			'money_dj'=>$seller_money_dj+$order_money,																	
    	);		
	 	$seller_edit=$this->my_money_mod->edit('user_id='.$seller_id,$seller_array);	
         //买家添加日志
        $buyer_log_text =Lang::get('goumaishangpin_dianzhu').$seller_name;
		$buyer_add_array=array(
			'user_id'=>$user_id,
			'user_name'=>$buyer_name,
			'order_id '=>$order_id,
			'order_sn '=>$order_order_sn,
			'seller_id'=>$seller_id,
			'seller_name'=>$seller_name,
			'buyer_id'=>$user_id,
			'buyer_name'=>$buyer_name,
			'add_time'=>time(),
			'leixing'=>20,		
			'money_zs'=>"-".$order_money,
			'money'=>$order_money,
			'log_text'=>$buyer_log_text,	
			'caozuo'=>10,
			's_and_z'=>2,
    	);
    	$this->my_moneylog_mod->add($buyer_add_array);
		//卖家添加日志
        $seller_log_text=Lang::get('chushoushangpin_maijia').$buyer_name;
		$seller_add_array=array(
			'user_id'=>$seller_id,
			'user_name'=>$seller_name,
			'order_id '=>$order_id,
			'order_sn '=>$order_order_sn,
			'seller_id'=>$seller_id,
			'seller_name'=>$seller_name,
			'buyer_id'=>$user_id,
			'buyer_name'=>$buyer_name,
			'add_time'=>time(),
			'leixing'=>10,		
			'money_zs'=>$order_money,
			'money'=>$order_money,		
			'log_text'=>$seller_log_text,	
			'caozuo'=>10,
			's_and_z'=>1,																
    	);
    	$this->my_moneylog_mod->add($seller_add_array);
        //改变定单为 已支付等待卖家确认  status10改为20
		$payment_code="sft";
        //更新定单状态
		$order_edit_array=array(
            'payment_name'  =>Lang::get('shangfutong'),
			'payment_code'  =>$payment_code,
            'pay_time' =>time(),
            'out_trade_sn'=>$order_sn,
			'status'=>20,//20就是 待发货了
         );
        $this->order_mod->edit($order_id,$order_edit_array);
		//$edit_data['status']    =   ORDER_ACCEPTED;//定义 为 20 待发货
		//$order_model->edit($order_id, $edit_data);//直接更改为 20 待发货
	//支付成功
	$this->show_message('zhifu_chenggong',
                'sanmiaohouzidongtiaozhuandaodingdanliebiao',  'index.php?app=buyer_order',
				'chankandingdan',  'index.php?app=buyer_order',
                'guanbiyemian', 'index.php?app=my_money&act=exits'
    );
//定义SESSION值
$_SESSION['session_order_sn']=$order_order_sn;	
}//检测SESSION为空 执行完毕
else//检测SESSION为空 否则
{//检测SESSION为空 否则 开始
                $this->show_warning('jinggao_qingbuyaochongfushuaxinyemian'); 
                return;
}//检测SESSION为空 否则 结束
	}
	else
    {
                $this->show_warning('feifacanshu'); 
                return;
	}
	}





//筛选充值方式
function czfs()
{
  	if($_POST)
	{
	$user_id = $this->visitor->get('user_id');
	$user_name = $this->visitor->get('user_name');
	$cz_money     =trim($_POST['cz_money']);
	$czfs     =trim($_POST['czfs']);
	
    $pay_row=$this->my_paysetup_mod->getrow("select * from ".DB_PREFIX."my_paysetup");	
	$v_mid = $pay_row['chinabank_mid'];
	$v_url = $pay_row['chinabank_url'];
	$key   = $pay_row['chinabank_key'];

	if($czfs=='chinabank')
	{
    $v_oid = date('Ymd-His',time())."-".$user_id."-".$cz_money;      //网银定单号,不加商号了
    $v_moneytype = "CNY";                                            //币种
	$text = $cz_money.$v_moneytype.$v_oid.$v_mid.$v_url.$key;        //md5加密拼凑串,注意顺序不能变
	//充值金额+CMY+定单号+URL地址+KEY密匙
    $v_md5info = strtoupper(md5($text));                             //md5函数加密并转化成大写字母
?>
<body onLoad="javascript:document.E_FORM.submit()">
<form method="post" name="E_FORM" action="https://pay3.chinabank.com.cn/PayGate">
	<input type="hidden" name="v_mid"         value="<?php echo $v_mid;?>">
	<input type="hidden" name="v_oid"         value="<?php echo $v_oid;?>">
	<input type="hidden" name="v_amount"      value="<?php echo $cz_money;?>">
	<input type="hidden" name="v_moneytype"   value="<?php echo $v_moneytype;?>">
	<input type="hidden" name="v_url"         value="<?php echo $v_url;?>">
	<input type="hidden" name="v_md5info"     value="<?php echo $v_md5info;?>">
	<input type="hidden" name="remark1"       value="<?php echo $remark1;?>">
	<input type="hidden" name="remark2"       value="<?php echo $remark2;?>">
</form>
</body>
<?php
    return;//网银充值转向结束
	}
    

	else if($czfs =='yeepay')//易宝支付
	{
	$p1_MerId = $pay_row['yeepay_mid'];
	$p2_Order = date('Ymd-His',time())."-".$user_id."-".$cz_money;//给易宝的定单号
	$p3_Amt   =trim($_POST['cz_money']);//给易宝的提交金额
    $p8_Url   = $pay_row['yeepay_url'];//给易宝的返回URL
	//pr_NeedResponse是返回机制0不需要  1需要
?>
<body onLoad="document.yeepay.submit();">
<form name='yeepay' action='yeepay/req.php' method='post'>
<input type='hidden' name='p1_MerId'				value='<?php echo $p1_MerId; ?>'>
<input type='hidden' name='p2_Order'				value='<?php echo $p2_Order; ?>'>
<input type='hidden' name='p3_Amt'					value='<?php echo $p3_Amt; ?>'>
<input type='hidden' name='p5_Pid'					value=''>
<input type='hidden' name='p6_Pcat'					value=''>
<input type='hidden' name='p7_Pdesc'				value=''>
<input type='hidden' name='p8_Url'					value='<?php echo $p8_Url; ?>'>
<input type='hidden' name='p9_SAF'					value='0'>
<input type='hidden' name='pa_MP'					value='<?php echo $user_name; ?>'>
<input type='hidden' name='pd_FrpId'				value=''>
<input type='hidden' name='pr_NeedResponse'      	value='1'>
</form>
</body>
<?php
    return;
	}

	else if($czfs =='alipay')
	{
require_once("app/alipay/alipay_config.php");//支付宝即时到配置帐文件
?>
<body onLoad="javascript:document.ALI_FORM.submit()">
<form method="post" name="ALI_FORM" action="app/alipay/alipayto.php">
	<input type="hidden" name="user_id" value="<?php echo $user_id;?>">
	<input type="hidden" name="user_name" value="<?php echo $user_name;?>">
	<input type="hidden" name="aliorder" value="<?php echo $mainname.$cz_money;?>">
	<input type="hidden" name="alimoney" value="<?php echo $cz_money;?>">
</form>
</body>
<?
    return;
	}
	
	else if($czfs =='tenpay')
	{

?>
<body onLoad="javascript:document.TENPAY_FORM.submit()">
<form method="post" name="TENPAY_FORM" action="app/tenpay-js-php/tenpay.php">
	<input type="hidden" name="user_id" value="<?php echo $user_id;?>">
	<input type="hidden" name="user_name" value="<?php echo $user_name;?>">
	<input type="hidden" name="tenorder" value="<?php echo $mainname.$cz_money;?>">
	<input type="hidden" name="tenmoney" value="<?php echo $cz_money;?>">
</form>
</body>
<?
    return;
	}
	
	else if($czfs !='chinabank')
	{
	   $this->show_warning('kaifazhong'); 
    return;
	}

	}
	else
	{
	//不是提交的，直接跳到充值页，重新提交
	header("Location: index.php?app=my_money&act=paylist");
	return;
	}
}








//财付通充值成功 返回通知页面
function ten_return_url()
{
	require_once ("app/tenpay-js-php/classes/PayResponseHandler.class.php");
	require_once ("app/tenpay-js-php/tenpay_config.php");

	/* 密钥 */
	$key = $tenpaykey;

	/* 创建支付应答对象 */
	$resHandler = new PayResponseHandler();
	$resHandler->setKey($key);

	//判断签名
	if($resHandler->isTenpaySign()) {
	
		//交易单号
		$transaction_id = $resHandler->getParameter("transaction_id");
	
		//金额,以分为单位
		$total_fee = $resHandler->getParameter("total_fee");
	
		//支付结果
		$pay_result = $resHandler->getParameter("pay_result");
	
		$sp_billno = $resHandler->getParameter("sp_billno");
	
		if( "0" == $pay_result ) {
			
			
			/*站内宝读取数据库 验证*/
			$user_id   = $this->visitor->get('user_id');
			$user_name = $this->visitor->get('user_name');

   		 	$dingdan           = $sp_billno;		//获取订单号
    		$total_fee         = $total_fee/100;			//获取总价格
	
			$log_row=$this->my_moneylog_mod->getrow("select * from ".DB_PREFIX."my_moneylog where user_id='$user_id' and					order_sn='$dingdan'");
			if(empty($log_row['caozuo']))
   		 	{
    			$sOld_trade_status = 0;
			}
			else
			{
    			$sOld_trade_status = $log_row['caozuo'];
			}

			$verify_resultShow = "验证成功";
	
	 		if ($sOld_trade_status < 2) {
				$user_row=$this->my_money_mod->getrow("select money from ".DB_PREFIX."my_money where user_id='$user_id'");	
				$user_money=$user_row['money'];
				$user_jifen=$user_row['jifen'];

       			$new_money=$user_money+$total_fee;
				$new_jifen=$user_jifen+$total_fee;
	    		$edit_mymoney=array(
					'money'=>$new_money,																	
    			);
				$edit_myjifen=array(
					'jifen'=>$new_jifen,																	
    			);
				$this->my_money_mod->edit('user_id='.$user_id,$edit_mymoney);
				$this->my_money_mod->edit('user_id='.$user_id,$edit_myjifen);
				//添加日志
				$log_text =$this->visitor->get('user_name')."通过财付通充值".$total_fee.Lang::get('yuan');
	
				$add_mymoneylog=array(
					'user_id'=>$user_id,
					'user_name'=>$this->visitor->get('user_name'),
					'buyer_name'=>"财付通",
					'seller_id'=>$user_id,
					'seller_name'=>$this->visitor->get('user_name'),
					'order_sn '=>$dingdan,
					'add_time'=>time(),
					'leixing'=>30,		
					'money_zs'=>$total_fee,
					'money'=>$total_fee,
					'log_text'=>$log_text,		
					'caozuo'=>4,	
					's_and_z'=>1,																		
				);
				$this->my_moneylog_mod->add($add_mymoneylog);		
				$this->show_message('chongzhi_chenggong_jineyiruzhang',
				'chakancicichongzhi',  'index.php?app=my_money&act=paylog',
				'guanbiyemian', 'index.php?app=my_money&act=exits'
				);
			}
			else
			{//避免重复刷新
					$this->show_warning('jinggao_qingbuyaochongfushuaxinyemian',
					'guanbiyemian',  'index.php?app=my_money&act=exits'
					);
					return;	
			}

			$resHandler->doShow($tenpay_show_url);	
			
		} else {
			echo "<br/>" . "pay fail！" . "<br/>";
		}
	
	} else {
		echo "<br/>" . "sign fail！" . "<br/>";
	}

}













//支付宝充值成功 返回通知页面
function return_url()
{
require_once("app/alipay/class/alipay_notify.php");
require_once("app/alipay/alipay_config.php");
$_GET['app'] ="";$_GET['act'] ="";
//构造通知函数信息
$alipay = new alipay_notify($partner,$security_code,$sign_type,$_input_charset,$transport);
//计算得出通知验证结果
$verify_result = $alipay->return_verify();

//print_r($alipay);
if($verify_result) {
/*站内宝读取数据库 验证*/
	$user_id   = $this->visitor->get('user_id');
	$user_name = $this->visitor->get('user_name');
    //验证成功
    //获取支付宝的通知返回参数
    $dingdan           = $_GET['out_trade_no'];		//获取订单号
    $total_fee         = $_GET['total_fee'];			//获取总价格
	$log_row=$this->my_moneylog_mod->getrow("select * from ".DB_PREFIX."my_moneylog where user_id='$user_id' and order_sn='$dingdan'");
	if(empty($log_row['caozuo']))
    {
    $sOld_trade_status = 0;
	}
	else
	{
    $sOld_trade_status = $log_row['caozuo'];
	}

	$verify_resultShow = "验证成功";

    /*假设：
	sOld_trade_status="0"	表示订单未处理；
	sOld_trade_status="1"	表示买家已在支付宝交易管理中产生了交易记录，但没有付款
	sOld_trade_status="2"	表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货
	sOld_trade_status="3"	表示卖家已经发了货，但买家还没有做确认收货的操作
	sOld_trade_status="4"	表示买家已经确认收货，这笔交易完成
    */
    if($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS') 
	{
			$this->show_warning('qingbuyaoshiyongdanbaozhifu');
	        return;	
	}
	
    else if($_GET['trade_status'] == 'TRADE_FINISHED'||$_GET['trade_status'] == 'TRADE_SUCCESS') {

        //放入订单交易完成后的数据库更新程序代码，请务必保证echo出来的信息只有success
        //为了保证不被重复调用，或重复执行数据库更新程序，请判断该笔交易状态是否是订单未处理状态
        if ($sOld_trade_status < 2) {
			//当$_GET['trade_status'] 为WAIT_SELLER_SEND_GOODS，则说明买家用的支付方式是担保交易付款
			//当$_GET['trade_status'] 为TRADE_FINISHED，则说明买家用的支付方式是即时到帐付款
            //根据订单号更新订单，把订单处理成交易成功
			

$user_row=$this->my_money_mod->getrow("select money from ".DB_PREFIX."my_money where user_id='$user_id'");	
$user_money=$user_row['money'];
$user_jifen=$user_row['jifen'];

        $new_money=$user_money+$total_fee;
		$new_jifen=$user_jifen+$total_fee;
	    $edit_mymoney=array(
			'money'=>$new_money,																	
    	);
		$edit_myjifen=array(
			'jifen'=>$new_jifen,																	
    	);
		$this->my_money_mod->edit('user_id='.$user_id,$edit_mymoney);
		$this->my_money_mod->edit('user_id='.$user_id,$edit_myjifen);
         //添加日志
        $log_text =$this->visitor->get('user_name').Lang::get('tongguoalipaychongzhi').$total_fee.Lang::get('yuan');

		$add_mymoneylog=array(
			'user_id'=>$user_id,
			'user_name'=>$this->visitor->get('user_name'),
			'buyer_name'=>Lang::get('alipay'),
			'seller_id'=>$user_id,
			'seller_name'=>$this->visitor->get('user_name'),
			'order_sn '=>$dingdan,
			'add_time'=>time(),
			'leixing'=>30,		
			'money_zs'=>$total_fee,
			'money'=>$total_fee,
			'log_text'=>$log_text,		
			'caozuo'=>4,	
			's_and_z'=>1,																		
    	);
    	$this->my_moneylog_mod->add($add_mymoneylog);		
	    $this->show_message('chongzhi_chenggong_jineyiruzhang',
		'chakancicichongzhi',  'index.php?app=my_money&act=paylog',
        'guanbiyemian', 'index.php?app=my_money&act=exits'
		);
    
			
			
			
			
			
			
        }
		else
		{//避免重复刷新
			$this->show_warning('jinggao_qingbuyaochongfushuaxinyemian',
            'guanbiyemian',  'index.php?app=my_money&act=exits'
            );
	        return;	
		}
    }
    else {
      echo "trade_status=".$_GET['trade_status'];
    }
}
else {
    //验证失败
    //如要调试，请看alipay_notify.php页面的return_verify函数，比对sign和mysign的值是否相等，或者检查$veryfy_result有没有返回true
	$verify_resultShow = "验证失败";
    $this->show_warning('feifacanshu',
    'guanbiyemian',  'index.php?app=my_money&act=exits'
    );
	return;
}
}



function notify_url_222()
{
require_once("app/alipay/class/alipay_notify.php");
require_once("app/alipay/alipay_config.php");
$_POST['app'] ="";$_POST['act'] ="";
$_GET['app'] ="";$_GET['act'] ="";

	$user_id   = $this->visitor->get('user_id');
	$user_name = $this->visitor->get('user_name');
    $log_row=$this->my_moneylog_mod->getrow("select * from ".DB_PREFIX."my_moneylog");	
    //验证成功
    //获取支付宝的反馈参数
    $dingdan           = $_POST['out_trade_no'];	//获取支付宝传递过来的订单号
    $total_fee         = $_POST['price'];			//获取支付宝传递过来的总价格
	
	$user_row=$this->my_money_mod->getrow("select money from ".DB_PREFIX."my_money where user_id='$user_id'");	
    $user_money=$user_row['money'];
	$user_jifen=$user_row['jifen'];

        $new_money=$user_money+$total_fee;
		$new_jifen=$user_jifen+$total_fee;
	    $edit_mymoney=array(
			'money'=>$new_money,																	
    	);
		$edit_myjifen=array(
			'jifen'=>$new_jifen,																	
    	);
		$this->my_money_mod->edit('user_id='.$user_id,$edit_mymoney);
		$this->my_money_mod->edit('user_id='.$user_id,$edit_myjifen);

}
//支付宝充值成功 返回执行数据
function notify_url_111()
{
require_once("app/alipay/class/alipay_notify.php");
require_once("app/alipay/alipay_config.php");
$_POST['app'] ="";$_POST['act'] ="";
$_GET['app'] ="";$_GET['act'] ="";
$alipay = new alipay_notify($partner,$security_code,$sign_type,$_input_charset,$transport);    //构造通知函数信息
$verify_result = $alipay->notify_verify();  //计算得出通知验证结果

if($verify_result) {
/*站内宝读取数据库 验证*/
	$user_id   = $this->visitor->get('user_id');
	$user_name = $this->visitor->get('user_name');
    $log_row=$this->my_moneylog_mod->getrow("select * from ".DB_PREFIX."my_moneylog");	
    //验证成功
    //获取支付宝的反馈参数
    $dingdan           = $_POST['out_trade_no'];	//获取支付宝传递过来的订单号
    $total_fee         = $_POST['total_fee'];			//获取支付宝传递过来的总价格
    $sOld_trade_status = $log_row['caozuo'];		//获取商户数据库中查询得到该笔交易当前的交易状态
    /*假设：
	sOld_trade_status="0"	表示订单未处理；
	sOld_trade_status="1"	表示买家已在支付宝交易管理中产生了交易记录，但没有付款
	sOld_trade_status="2"	表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货
	sOld_trade_status="3"	表示卖家已经发了货，但买家还没有做确认收货的操作
	sOld_trade_status="4"	表示买家已经确认收货，这笔交易完成
    */
    if($_POST['trade_status'] == 'WAIT_BUYER_PAY') {
		//表示买家已在支付宝交易管理中产生了交易记录，但没有付款
		//放入订单交易完成后的数据库更新程序代码，请务必保证response.Write出来的信息只有success
		//为了保证不被重复调用，或重复执行数据库更新程序，请判断该笔交易状态是否是订单未处理状态
		//注：该交易状态下，也可不做数据库更新程序，此时，建议把该状态的通知信息记录到商户通知日志数据库表中。
        if($sOld_trade_status == 0) {
            //根据订单号更新订单，把订单处理成交易成功
        }
        echo "success";

        //调试用，写文本函数记录程序运行情况是否正常
        //log_result("这里写入想要调试的代码变量值，或其他运行的结果记录");
    }
	else if ($_POST['trade_status'] == 'WAIT_SELLER_SEND_GOODS'){
		//表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货
		//放入订单交易完成后的数据库更新程序代码，请务必保证response.Write出来的信息只有success
		//为了保证不被重复调用，或重复执行数据库更新程序，请判断该笔交易状态是否是WAIT_BUYER_PAY状态
		if (sOld_trade_status == 1 || sOld_trade_status == 0){
			//根据订单号更新订单，把订单处理成交易成功
		}
		
		echo "success";//请不要修改或删除
		
		//调试用，写文本函数记录程序运行情况是否正常
        log_result("222");
	}
	else if ($_POST['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS'){
		//表示卖家已经发了货，但买家还没有做确认收货的操作
		//放入订单交易完成后的数据库更新程序代码，请务必保证response.Write出来的信息只有success
		//为了保证不被重复调用，或重复执行数据库更新程序，请判断该笔交易状态是否是WAIT_SELLER_SEND_GOODS状态
		if (sOld_trade_status == 2){
			//根据订单号更新订单，把订单处理成交易成功
		}
		
		echo "success";//请不要修改或删除
		
		//调试用，写文本函数记录程序运行情况是否正常
        log_result("333");
	}
	else if ($_POST['trade_status'] == 'TRADE_FINISHED'||$_POST['trade_status'] == 'TRADE_SUCCESS'){
		//表示买家已经确认收货，这笔交易完成
		//放入订单交易完成后的数据库更新程序代码，请务必保证response.Write出来的信息只有success
		//为了保证不被重复调用，或重复执行数据库更新程序，请判断该笔交易状态是否是WAIT_BUYER_CONFIRM_GOODS状态
		if (sOld_trade_status == 3 || sOld_trade_status < 2){
			//当sOld_trade_status=3，则说明买家用的支付方式是担保交易付款
			//当sOld_trade_status<2，则说明买家用的支付方式是即时到帐付款
			//根据订单号更新订单，把订单处理成交易成功
			
		    //更新站内宝余额数据，sOld_trade_status 改变为 =4 ******************************************************************
//检测定单是否重复提交
$order_row=$this->my_moneylog_mod->getrow("select * from ".DB_PREFIX."my_moneylog where user_id='$user_id' and order_sn='$dingdan'");
   // if ($dingdan != $order_row['order_sn'])
	
$user_row=$this->my_money_mod->getrow("select money from ".DB_PREFIX."my_money where user_id='$user_id'");	
$user_money=$user_row['money'];
$user_jifen=$user_row['jifen'];

        $new_money=$user_money+$total_fee;
		$new_jifen=$user_jifen+$total_fee;
	    $edit_mymoney=array(
			'money'=>$new_money,																	
    	);
		$edit_myjifen=array(
			'jifen'=>$new_jifen,																	
    	);
		$this->my_money_mod->edit('user_id='.$user_id,$edit_mymoney);
		$this->my_money_mod->edit('user_id='.$user_id,$edit_myjifen);
		//添加日志
        $log_text =$this->visitor->get('user_name').Lang::get('tongguoalipaychongzhi').$total.Lang::get('yuan');

		$add_mymoneylog=array(
			'user_id'=>$user_id,
			'user_name'=>$this->visitor->get('user_name'),
			'buyer_name'=>Lang::get('alipay').$total,
			'seller_id'=>$user_id,
			'seller_name'=>$this->visitor->get('user_name'),
			'order_sn '=>$dingdan,
			'add_time'=>time(),
			'leixing'=>30,		
			'money_zs'=>$v_amount,
			'money'=>$total,
			'log_text'=>$log_text,		
			'caozuo'=>4,	
			's_and_z'=>1,																		
    	);
    	$this->my_moneylog_mod->add($add_mymoneylog);		
	    $this->show_message('chongzhi_chenggong_jineyiruzhang',
		'chakancicichongzhi',  'index.php?app=my_money&act=paylog',
        'guanbiyemian', 'index.php?app=my_money&act=exits'
		);


	
	
	
	
	
	
	
	
	
	
	
	
		}
		
		echo "success";//请不要修改或删除
		
		//调试用，写文本函数记录程序运行情况是否正常
        log_result("444");
	}
    else {
        echo "success";		//其他状态判断。普通即时到帐中，其他状态不用判断，直接打印success。

        //调试用，写文本函数记录程序运行情况是否正常
        //log_result ("这里写入想要调试的代码变量值，或其他运行的结果记录");
    }
}
else {
    //验证失败
    echo "fail";

    //调试用，写文本函数记录程序运行情况是否正常
    //log_result ("这里写入想要调试的代码变量值，或其他运行的结果记录");
}
}
//易宝支付返回数据 进行站内充值
/*可以用，但暂时不开放，
function yee_pay()
{
include('yeepay/yeepayCommon.php');
#	只有支付成功时易宝支付才会通知商户.
##支付成功回调有两次，都会通知到在线支付请求参数中的p8_Url上：浏览器重定向;服务器点对点通讯.
#	解析返回参数.
$return = getCallBackValue($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);
#	判断返回签名是否正确（True/False）
$bRet = CheckHmac($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);
#	以上代码和变量不需要修改.
#	校验码正确.
if($bRet){
	if($r1_Code=="1"){
	#	需要比较返回的金额与商家数据库中订单的金额是否相等，只有相等的情况下才认为是交易成功.
	#	并且需要对返回的处理进行事务控制，进行记录的排它性处理，防止对同一条交易重复发货的情况发生.      	  	
		if($r9_BType=="1")
		{
		$user_id = $this->visitor->get('user_id');
		//读取汇率
		$paysetup=$this->my_paysetup_mod->getrow("select * from ".DB_PREFIX."my_paysetup where id='1'");
		$rb_BankId	=$_GET["rb_BankId"];//读取易宝返回的银行编码，判定什么接口
//判断使用银行的  计算汇率
if($rb_BankId=="ICBC-NET" or $rb_BankId=="ICBC-WAP" or $rb_BankId=="CMBCHINA-NET" or $rb_BankId=="CMBCHINA-WAP" or $rb_BankId=="ABC-NET" or $rb_BankId=="CCB-NET" or $rb_BankId=="CCB-PHONE" or $rb_BankId=="BCCB-NET" or $rb_BankId=="BOCO-NET" or $rb_BankId=="CIB-NET" or $rb_BankId=="NJCB-NET" or $rb_BankId=="CMBC-NET" or $rb_BankId=="CEB-NET" or $rb_BankId=="BOC-NET" or $rb_BankId=="PINGANBANK-NET" or $rb_BankId=="CBHB-NET" or $rb_BankId=="HKBEA-NET" or $rb_BankId=="ECITIC-NET" or $rb_BankId=="SDB-NET" or $rb_BankId=="SPDB-NET" or $rb_BankId=="POST-NET" or $rb_BankId=="1000000-NET")
{
//银行 一般99%
//$r3_Amt=$r3_Amt / 100 * $paysetup['yeepay_bank'];
//sprintf("%0.2f",值) 是取0.00格式
$r3_Amt= sprintf("%0.2f", $r3_Amt / 100 * $paysetup['yeepay_bank']);
}
//骏网一卡通  
else if($rb_BankId=="JUNNET-NET")
{
$r3_Amt= sprintf("%0.2f", $r3_Amt / 100 * $paysetup['yeepay_junnet']);
}
//盛大卡
else if($rb_BankId=="SNDACARD-NET")
{
$r3_Amt= sprintf("%0.2f", $r3_Amt / 100 * $paysetup['yeepay_sndacard']);
}
//神州行
else if($rb_BankId=="SZX-NET")
{
$r3_Amt= sprintf("%0.2f", $r3_Amt / 100 * $paysetup['yeepay_szx']);
}
//征途卡
else if($rb_BankId=="ZHENGTU-NET")
{
$r3_Amt= sprintf("%0.2f", $r3_Amt / 100 * $paysetup['yeepay_zhengtu']);
}
//Q币卡 
else if($rb_BankId=="QQCARD-NET")
{

$r3_Amt= sprintf("%0.2f", $r3_Amt / 100 * $paysetup['yeepay_qqcard']);
}
//联通卡
else if($rb_BankId=="UNICOM-NET")
{
$r3_Amt= sprintf("%0.2f", $r3_Amt / 100 * $paysetup['yeepay_unicon']);
}
//久游卡 
else if($rb_BankId=="JIUYOU-NET")
{
$r3_Amt= sprintf("%0.2f", $r3_Amt / 100 * $paysetup['yeepay_jiuyou']);
}
//易宝一卡通
else if($rb_BankId=="YPCARD-NET")
{
$r3_Amt= sprintf("%0.2f", $r3_Amt / 100 * $paysetup['yeepay_ypcard']);
}
//联华OK卡 
else if($rb_BankId=="LIANHUAOKCARD-NET")
{
$r3_Amt= sprintf("%0.2f", $r3_Amt / 100 * $paysetup['yeepay_lianhuaokcard']);
}
//网易卡
else if($rb_BankId=="NETEASE-NET")
{
$r3_Amt= sprintf("%0.2f", $r3_Amt / 100 * $paysetup['yeepay_netease']);
}
//完美卡
else if($rb_BankId=="WANMEI")
{
$r3_Amt= sprintf("%0.2f", $r3_Amt / 100 * $paysetup['yeepay_wanmei']);
}
//搜狐卡
else if($rb_BankId=="SOHU")
{
$r3_Amt= sprintf("%0.2f", $r3_Amt / 100 * $paysetup['yeepay_sohu']);
}
//充值成功，出现错误，请联系管理员
else
{
	   $this->show_warning('yeepaychenggongdanchuxiancuowuqinglianxiadmin'); 
       return;
}

//检测定单是否重复提交
$order_row=$this->my_moneylog_mod->getrow("select order_sn from ".DB_PREFIX."my_moneylog where user_id='$user_id' and order_sn='$r6_Order'");
	
    if ($r6_Order != $order_row['order_sn'])

	{		
		//支付成功，可进行逻辑处理！
		//商户系统的逻辑处理（例如判断金额，判断支付状态，更新订单状态等等）......
$user_row=$this->my_money_mod->getrow("select money from ".DB_PREFIX."my_money where user_id='$user_id'");	
$user_money=$user_row['money'] ;

        $new_money=$user_money+$r3_Amt;
	    $edit_mymoney=array(
			'money'=>$new_money,																	
    	);
		$this->my_money_mod->edit('user_id='.$this->visitor->get('user_id'), $edit_mymoney);
         //添加日志
        $log_text =$this->visitor->get('user_name').Lang::get('tongguoyeepaychongzhi').$r3_Amt.Lang::get('yuan');

		$add_mymoneylog=array(
			'user_id'=>$user_id,
			'user_name'=>$this->visitor->get('user_name'),
			'buyer_name'=>Lang::get('yeepay'),
			'seller_id'=>$user_id,
			'seller_name'=>$this->visitor->get('user_name'),
			'order_sn '=>$r2_TrxId,
			'add_time'=>time(),
			'leixing'=>30,		
			'money_zs'=>$r3_Amt,
			'money'=>$r3_Amt,
			'log_text'=>$log_text,		
			'caozuo'=>50,	
			's_and_z'=>1,																		
    	);
    	$this->my_moneylog_mod->add($add_mymoneylog);
		}
	    else
	    {
			$this->show_warning('jinggao_qingbuyaochongfushuaxinyemian',
            'guanbiyemian',  'index.php?app=my_money&act=exits'
            );
	        return;	
	    }
			
		}
		elseif($r9_BType=="2"){
			#如果需要应答机制则必须回写流,以success开头,大小写不敏感.
 	    $this->show_warning('success'); 
        return;   
	   			 
		}
	}
	
	
	
	    $this->show_message('chongzhi_chenggong_jineyiruzhang',
		'chakancicichongzhi',  'index.php?app=my_money&act=paylog',
        'guanbiyemian', 'index.php?app=my_money&act=exits'
		);
    
	   	
}else{
	   $this->show_warning('feifacanshu'); 
       return;
}

}
易宝支付暂时关闭*/

//网银支付返回数据 进行站内充值
function chinabank_pay()
{
    $user_id = $this->visitor->get('user_id');	
  	if($_POST)
	{
$pay_row=$this->my_paysetup_mod->getrow("select * from ".DB_PREFIX."my_paysetup where id='1'");	
$key   =   $pay_row['chinabank_key'];	
						
$v_oid     =trim($_POST['v_oid']);       // 商户发送的v_oid定单编号   
$v_pmode   =trim($_POST['v_pmode']);    // 支付方式（字符串）   
$v_pstatus =trim($_POST['v_pstatus']);   //  支付状态 ：20（支付成功）；30（支付失败）
$v_pstring =trim($_POST['v_pstring']);   //提示中文"支付成功"字符串

$v_amount  =trim($_POST['v_amount']);     // 订单实际支付金额
$v_moneytype  =trim($_POST['v_moneytype']); //订单实际支付币种
$remark1   =trim($_POST['remark1' ]);      //备注字段1
$remark2   =trim($_POST['remark2' ]);     //备注字段2
$v_md5str  =trim($_POST['v_md5str' ]);   //拼凑后的MD5校验值

//重新计算md5的值                         
$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key));
    if ($v_md5str==$md5string)//校验MD5 开始
    {//校验MD5 IF括号
	if ($v_pstatus=="20")
	{
//检测定单是否重复提交
$order_row=$this->my_moneylog_mod->getrow("select order_sn from ".DB_PREFIX."my_moneylog where user_id='$user_id' and order_sn='$v_oid'");
	
    if ($v_oid != $order_row['order_sn'])

	{
		//支付成功，可进行逻辑处理！
		//商户系统的逻辑处理（例如判断金额，判断支付状态，更新订单状态等等）......
$user_row=$this->my_money_mod->getrow("select money from ".DB_PREFIX."my_money where user_id='$user_id'");	
$user_money=$user_row['money'];
$user_jifen=$user_row['jifen'];

        $new_money=$user_money+$v_amount;
		$new_jifen=$user_jifen+$v_amount;
	    $edit_mymoney=array(
			'money'=>$new_money,																	
    	);
		$edit_myjifen=array(	
			'jifen'=>$new_jifen,																
    	);
		$this->my_money_mod->edit('user_id='.$user_id,$edit_mymoney);
		$this->my_money_mod->edit('user_id='.$user_id,$edit_myjifen);
         //添加日志
        $log_text =$this->visitor->get('user_name').Lang::get('tongguowangyinjishichongzhi').$v_amount.Lang::get('yuan');

		$add_mymoneylog=array(
			'user_id'=>$user_id,
			'user_name'=>$this->visitor->get('user_name'),
			'buyer_name'=>Lang::get('chinabankzhifu').$v_pmode,
			'seller_id'=>$user_id,
			'seller_name'=>$this->visitor->get('user_name'),
			'order_sn '=>$v_oid,
			'add_time'=>time(),
			'leixing'=>30,		
			'money_zs'=>$v_amount,
			'money'=>$v_amount,
			'log_text'=>$log_text,		
			'caozuo'=>50,	
			's_and_z'=>1,																		
    	);
    	$this->my_moneylog_mod->add($add_mymoneylog);		
	    $this->show_message('chongzhi_chenggong_jineyiruzhang',
		'chakancicichongzhi',  'index.php?app=my_money&act=paylog',
        'guanbiyemian', 'index.php?app=my_money&act=exits'
		);
    }
	else
	{
			$this->show_warning('jinggao_qingbuyaochongfushuaxinyemian',
            'guanbiyemian',  'index.php?app=my_money&act=exits'
            );
	        return;	
	}
	
	}else{ 
        $this->show_warning('chongzhi_shibai_qingchongxintijiao',
        'guanbiyemian',  'index.php?app=my_money&act=exits'
        );
		return;
		}
    }else{ //否则 校验MD5
			$this->show_warning('wangyinshujuxiaoyanshibai_shujukeyi',
            'guanbiyemian',  'index.php?app=my_money&act=exits'
            );
			return;}//否则 校验MD5  结束 

    }
	else
	{
    $this->show_warning('feifacanshu',
    'guanbiyemian',  'index.php?app=my_money&act=exits'
    );
	return;
    }  
}




//充值卡
function card_cz()
{  
	$user_name = trim($_POST['user_name2']);
	$card_sn = trim($_POST['card_sn']);
   	$card_pass = trim($_POST['card_pass']);
	if($_POST)//检测有提交
	{//检测有提交
    if (preg_match("/[^0.-9]/",$card_pass))
    {
	$this->show_warning('cuowu_nishurudebushishuzilei'); 
    return;
    }
    //充值对象不能为空
	if(empty($user_name))
    {
	$this->show_warning('cuowu_mubiaoyonghubucunzai'); 
    return;
	}	


$user_row=$this->my_money_mod->getrow("select * from ".DB_PREFIX."my_money where user_name='$user_name'");
$user_money=$user_row['money'];
$user_jifen=$user_row['jifen'];
$user_id=$user_row['user_id'];
	if(empty($user_id))
    {
	$this->show_warning('cuowu_mubiaoyonghubucunzai'); 
    return;
	}	
//$card_row=$this->my_card_mod->getrow("select * from ".DB_PREFIX."my_card where card_pass='$card_pass'");	
$card_row=$this->my_card_mod->getrow("select * from ".DB_PREFIX."my_card where card_pass='$card_pass' and card_sn='$card_sn'");
$card_id=$card_row['id'];
    //读取空 提示卡号、密码错误
	if(empty($card_row))
    {
	$this->show_warning('cuowu_card_pass'); 
    return;
	}
	//检测过期时间小于现在时间，则提示已经过期
	if($card_row['guoqi_time'] < time())
    {
	$this->show_warning('cuowu_cardyijingguoqi'); 
    return;
	}
	if($card_row['user_id'] !=0)
	{
	$this->show_warning('cuowu_cardyijingshiyongguole'); 
    return;
	}
    else
	{
    //添加日志
    $log_text =$user_name;
	$add_mymoneylog=array(
	'user_id'=>$user_id,
	'user_name'=>$user_name,
	'buyer_id'=>$this->visitor->get('user_id'),
	'buyer_name'=>$this->visitor->get('user_name'),
	'seller_id'=>$user_id,
	'seller_name'=>$user_name,
	'order_sn '=>$card_sn,
	'add_time'=>time(),
	'leixing'=>30,
	'money_zs'=>$card_row['money'],
	'money'=>$card_row['money'],	
	'log_text'=>$log_text,
	'caozuo'=>50,
	's_and_z'=>1,															
    );
	//写入日志
    $this->my_moneylog_mod->add($add_mymoneylog);
	//定义新资金
	$new_user_money = $user_money+$card_row['money'];
	$new_user_jifen = $user_jifen+$card_row['money'];
    //定义资金数组
	$add_money=array('money'=>$new_user_money,);
	$add_jifen=array('jifen'=>$new_user_jifen,);
	//更新该用户资金
	$this->my_money_mod->edit('user_id='.$user_id,$add_money);
	$this->my_money_mod->edit('user_id='.$user_id,$add_jifen);
	//改变充值卡信息 已使用
	$add_cardlog=array(
	'user_id'=>$user_id,
	'user_name'=>$user_name,
	'cz_time'=>time(),												
    );
	$this->my_card_mod->edit('id='.$card_id,$add_cardlog);
    //提示语言
	$this->show_message('chongzhi_chenggong_jineyiruzhang',
	'chakancicichongzhi',  'index.php?app=my_money&act=paylog',
    'guanbiyemian', 'index.php?app=my_money&act=exits');
	return;
    }	
	}
	else//检测提交 否则
	{//检测提交 开始
	header("Location: index.php?app=my_money");
	return;
	}//检测提交 结束
}

//余额转帐
function to_user()
{  
	$to_user = trim($_POST['to_user']);
	$to_money = trim($_POST['to_money']);
   	$user_id = $this->visitor->get('user_id');	
	if($_POST)//检测有提交
	{//检测有提交
    if (preg_match("/[^0.-9]/",$to_money))
    {
	$this->show_warning('cuowu_nishurudebushishuzilei'); 
    return;
    }


$to_row=$this->my_money_mod->getrow("select * from ".DB_PREFIX."my_money where user_name='$to_user'");	
$to_user_id=$to_row['user_id'];
$to_user_name=$to_row['user_name'];
$to_user_money=$to_row['money'];

    if($to_user_id==$user_id)
    {
	$this->show_warning('cuowu_bunenggeizijizhuanzhang'); 
    return;
	}
	
	if(empty($to_user_id))
    {
	$this->show_warning('cuowu_mubiaoyonghubucunzai'); 
    return;
	}	
$user_row=$this->my_money_mod->getrow("select * from ".DB_PREFIX."my_money where user_id='$user_id'");	
$user_money=$user_row['money'];
$user_zf_pass=$user_row['zf_pass'];
$user_mibao_id=$user_row['mibao_id'];
	if(empty($user_mibao_id))
    {
	$zf_pass = md5(trim($_POST['zf_pass']));
	if($user_zf_pass != $zf_pass)
	{
	$this->show_warning('cuowu_zhifumimayanzhengshibai'); 
    return;	
	} 
	}
	else
	{
//读取密保卡资料
	$user_zimuz1 = trim($_POST['user_zimuz1']);
	$user_zimuz2 = trim($_POST['user_zimuz2']);
	$user_zimuz3 = trim($_POST['user_zimuz3']);
	$user_shuzi1 = trim($_POST['user_shuzi1']);
	$user_shuzi2 = trim($_POST['user_shuzi2']);
	$user_shuzi3 = trim($_POST['user_shuzi3']);
	if(empty($user_shuzi1) or empty($user_shuzi2) or empty($user_shuzi3))
    {
	            $this->show_warning('cuowu_dongtaimimayanzhengshibai'); 
                return;			
	}
$mibao_row=$this->my_mibao_mod->getrow("select * from ".DB_PREFIX."my_mibao where user_id='$user_id'");
$mibao_shuzi1=$mibao_row[$user_zimuz1];
$mibao_shuzi2=$mibao_row[$user_zimuz2];
$mibao_shuzi3=$mibao_row[$user_zimuz3];	

if ( $user_shuzi1 != $mibao_shuzi1 or $user_shuzi2 != $mibao_shuzi2 or $user_shuzi3 != $mibao_shuzi3) 
{ //检测密保相符 开始
		        echo Lang::get('money_banben');
	            $this->show_warning('cuowu_dongtaimimayanzhengshibai'); 
                return;
} //检测密保 否则 结束
	}


    $order_id = date('Ymd-His',time()).'-'.$to_money; 
    if ($user_money < $to_money)
    {
	    $this->show_warning('cuowu_zhanghuyuebuzu'); 
	    return;
	}
	else
	{
    //添加日志
    $log_text =$this->visitor->get('user_name').Lang::get('gei').$to_user.Lang::get('zhuanchujine').$to_money.Lang::get('yuan');
	
	$add_mymoneylog=array(
	'user_id'=>$user_id,
	'user_name'=>$this->visitor->get('user_name'),
	'buyer_name'=>$this->visitor->get('user_name'),
	'seller_name'=>$to_user_name,
	'order_sn '=>$order_id,
	'add_time'=>time(),
	'leixing'=>21,		
	'money_zs'=>$to_money,
	'money'=>'-'.$to_money,	
	'log_text'=>$log_text,
	'caozuo'=>50,
	's_and_z'=>2,															
    );
    $this->my_moneylog_mod->add($add_mymoneylog);
		
		
	$log_text_to =$this->visitor->get('user_name').Lang::get('gei').$to_user_name.Lang::get('zhuanrujine').$to_money.Lang::get('yuan');
	$add_mymoneylog_to=array(
			'user_id'=>$to_user_id,
			'user_name'=>$to_user_name,
			'order_sn '=>$order_id,
			'buyer_name'=>$this->visitor->get('user_name'),
			'seller_name'=>$to_user_name,
			'add_time'=>time(),
			'leixing'=>11,		
			'money_zs'=>$to_money,
			'money'=>'-'.$to_money,			
			'log_text'=>$log_text_to,	
			'caozuo'=>50,
			's_and_z'=>1,																				
    );
    $this->my_moneylog_mod->add($add_mymoneylog_to);
	
	$new_user_money = $user_money-$to_money;
	$new_to_user_money =$to_user_money+$to_money;
	
	$add_jia=array(	
			'money'=>$new_to_user_money,																	
    );
	$this->my_money_mod->edit('user_id='.$to_user_id,$add_jia);
	$add_jian=array(	
			'money'=>$new_user_money,																		
    );
	$this->my_money_mod->edit('user_id='.$user_id,$add_jian);
	
	$this->show_message('zhuanzhangchenggong');
	return;
    }	
	}
	else//检测提交 否则
	{//检测提交 开始
	header("Location: index.php?app=my_money");
	return;
	}//检测提交 结束
}
}
?>
