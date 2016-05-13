<?php

/**
 *    积分商城
 *
 *    @author    xiaozhuge
 *    @usage    none
 */
class My_integralApp extends MemberbaseApp
{
	var $my_jifen_mod;
	var $my_integral_mod;
	
    function __construct()
    {
        $this->My_integralApp();
    }

    function My_integralApp()
    {
        parent::__construct();;
        
		$this->my_jifen_mod =& m('my_jifen');	
		$this->my_integral_mod = & m('integral');	
    }
	
    function index()
    {
		$user_id = $this->visitor->get('user_id');	    
        /* 当前位置 */
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('jifenduihuan')
                         );
        /* 当前用户中心菜单 */
	    $this->assign('page_title',Lang::get('member_center'). ' - ' .Lang::get('jifenduihuan'));
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

        $this->display('integral.jifen_duihuan_jilu.html');
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
		    $money_row=$this->my_integral_mod->getrow("select amount from ".DB_PREFIX."integral where user_id='$user_id'");
		    if($jifen > $money_row['amount'])
			{
					   	$this->show_warning('jifenbuzu');//积分不足
		       	        return;	
			}
			//兑换成功，减少该用户的积分
			$xjifen=$money_row['amount']-$jifen;
			$user_jifen=array(
			'amount'=>$xjifen,													
		    );
		    $this->my_integral_mod->edit('user_id='.$user_id,$user_jifen);
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
			$this->show_message('duihuanchenggong','duihuanchenggong','index.php?app=my_integral&act=duihuan_jilu');//兑换成功 index.php?app=my_money&act=duihuan_jilu
	        return;
		}
		else
		{
	        /* 当前位置 */
	        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
	                         LANG::get('jifenduihuan')
	                         );
	        /* 当前用户中心菜单 */
		    $this->assign('page_title',Lang::get('member_center'). ' - ' .' - '.Lang::get('jifenduihuan'));
	        $this->_curitem('jifenduihuan');		
	        $page = $this->_get_page(10);
			$index=$this->my_jifen_mod->find(array(
			'conditions' => "yes_no=1 and id='$id' and user_id=0",//条件
		    'limit' => $page['limit'],
			'count' => true));	
	
	        $page['item_count'] = $this->my_jifen_mod->getCount();
	        $this->_format_page($page);
		    $this->assign('page_info', $page);
			$this->assign('index', $index);

	        $this->display('integral.jifen_post.html');
	        return;
	    }
	}
	
   	function duihuan_jilu()
    {
		$user_id = $this->visitor->get('user_id');	    
        /* 当前位置 */
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('jifenduihuan')
                         );
        /* 当前用户中心菜单 */
	    $this->assign('page_title',Lang::get('member_center'). ' - ' .Lang::get('jifenduihuan'));
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
        $this->display('integral.jifen_duihuan_jilu.html');
	}
    
	function view()
	{
		
	}
}

?>