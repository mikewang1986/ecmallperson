<?php

/**
 *    积分商城
 *
 *    @author    1hao5 team
 *    @usage    none
 */
class IntegralApp extends MallbaseApp
{
	var $my_jifen_mod;
	var $my_integral_mod;
	
    function __construct()
    {
        $this->IntegralApp();
    }

    function IntegralApp()
    {
        parent::__construct();;
		
		$this->my_jifen_mod =& m('my_jifen');	
		$this->my_integral_mod = & m('integral');	
    }
	
    function index()
    {
		$to_jifen = empty($_GET['to_jifen']) ? 0 : $_GET['to_jifen'];
		$from_jifen = empty($_GET['from_jifen']) ? 0 : $_GET['from_jifen'];
		$conditions = '';
		if($to_jifen!='' && $to_jifen>=0)
		{
			$conditions .= ' and jifen>='.$to_jifen;
		}
		if($from_jifen!='' && $from_jifen>=0)
		{
			$conditions .= ' and jifen<='.$from_jifen;
		}
        $user_id = $this->visitor->get('user_id');	    
        /* 当前用户中心菜单 */
	    $this->assign('page_title',Lang::get('jifenduihuan'));
    
        $my_integral=$this->my_integral_mod->getAll("select * from ".DB_PREFIX."integral where user_id=$user_id");
        $my_integral = current($my_integral);
        $this->assign('my_integral', $my_integral); 	
		$page = $this->_get_page(12);
		$index=$this->my_jifen_mod->find(array(
		'conditions' => 'yes_no=1 and user_id=0 '.$conditions,//条件
	    'limit' => $page['limit'],
		'order' => 'jifen desc',
		'count' => true));	
		foreach ($index as $key=>$value){
			$index[$key]['shengyu'] = $value['shuliang']-$value['yiduihuan'];
		}
        $page['item_count'] = $this->my_jifen_mod->getCount();
        $this->_format_page($page);
	    $this->assign('page_info', $page);
		$this->assign('index', $index); 
		$yiduihuan_list=$this->my_jifen_mod->find(array(
	        'conditions' => "yes_no=0 ",//条件
		    'order' => 'id desc',
			'count' => true,
        ));	
        $this->assign('yiduihuan_list',$yiduihuan_list);
    	
        $this->display('integral.index.html');
    }
    
    function view()
    {
    	$id = empty($_GET['id']) ? 0 : $_GET['id'];
    	$integral_info = $this->my_jifen_mod->get_info($id);
		$integral_info['shengyu'] = $integral_info['shuliang']-$integral_info['yiduihuan'];
    	$this->assign('integral_info',$integral_info);
    	
    	$this->display('integral.view.html');
    }
    
    function more_cate()
    {
    	$cate_name = empty($_GET['cate_name']) ? '' : $_GET['cate_name'];
    	$interal_list = $this->my_jifen_mod->get_jifen_list('0,12',$cate_name);
    	$this->assign('interal_list',$interal_list);
		$yiduihuan_list=$this->my_jifen_mod->find(array(
	        'conditions' => "yes_no=0 ",//条件
		    'order' => 'id desc',
			'count' => true,
        ));	
        $this->assign('yiduihuan_list',$yiduihuan_list);
        $user_id = $this->visitor->get('user_id');	    
        $my_integral=$this->my_integral_mod->getAll("select * from ".DB_PREFIX."integral where user_id=$user_id");
        $my_integral = current($my_integral);
        $this->assign('my_integral', $my_integral); 	
    	
    	$this->display('integral.list.html');
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
			$this->show_message('duihuanchenggong','duihuanchenggong','index.php?app=integral&act=duihuan_jilu');//兑换成功 index.php?app=my_money&act=duihuan_jilu
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
	
			$index=$this->my_jifen_mod->find(array(
			'conditions' => "yes_no=1 and id='$id' and user_id=0",//条件
		    'limit' => $page['limit'],
			'count' => true));	
	
			$this->assign('index', $index);
	        $this->display('integral.jifen_post.html');
	    }
	}
    
}

?>