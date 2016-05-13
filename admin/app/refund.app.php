<?php

/**
 *    退款维权管理员控制器
 *
 *    @author    Garbin
 *    @usage    none
 */
class RefundApp extends BackendApp
{
	var $_order_mod;
	var $_order_log_mod;
	var $_order_extm_mod;
	var $_goods_mod;
	var $_ordergoods_mod;
	var $_refund_mod;
	var $_store_mod;
	var $_member_mod;
	var $_refund_message_mod;
	
	function __construct()
    {
        $this->RefundApp();
    }
    function RefundApp()
    {
        parent::__construct();
        $this->_order_mod = &m('order');
		$this->_order_log_mod = &m('orderlog');
		$this->_order_extm_mod = &m('orderextm');
        $this->_goods_mod = &m('goods');
		$this->_ordergoods_mod = &m('ordergoods');
		$this->_refund_mod = &m('refund');
		$this->_store_mod = &m('store');
		$this->_member_mod = &m('member');
		$this->_refund_message_mod = &m('refund_message');
    }
	
    function index()
    {	
		$sort_order = str_replace('_',' ',trim($_GET['sort_order']));
		if(!empty($sort_order)){
			$order = $sort_order.',created desc';
		} else {
			$order = 'created desc';
		}
		
		$ask_customer = trim($_GET['ask_customer']);	
		if($ask_customer=='yes' || $ask_customer=='no'){
			$ask_customer = $ask_customer=='yes' ?  1 : 0;
			$conditions = 'ask_customer='. $ask_customer;
		} elseif($ask_customer=='all'){
			$conditions = '';
		} else {
			$conditions = 'ask_customer=1';
		}
		
		$page   =   $this->_get_page(10);   //获取分页信息
		$refunds = $this->_refund_mod->find(array(
			'conditions'=> $conditions,
			'limit'     => $page['limit'],
			'order'     => $order,
			'count'   => true
		));
		$page['item_count']=$this->_refund_mod->getCount();
		
		foreach($refunds as $key=>$refund)
		{
			$store = $this->_store_mod->get(array('conditions'=>'store_id='.$refund['seller_id'],'fields'=>'store_name,owner_name'));
			$refunds[$key]['store_name'] = $store['store_name'];
			$refunds[$key]['seller_name']  = $store['owner_name'];
			
			$member = $this->_member_mod->get(array('conditions'=>'user_id='.$refund['buyer_id'],'fields'=>'user_name'));
			$refunds[$key]['buyer_name'] = $member['user_name'];
			$goods = $this->_goods_mod->get(array('conditions'=>'goods_id='.$refund['goods_id'],'fields'=>'goods_name'));
			$refunds[$key]['goods_name'] = $goods['goods_name'];
			
			$order = $this->_order_mod->get(array('conditions'=>'order_id='.$refund['order_id'],'fields'=>'order_sn'));
			$refunds[$key]['order_sn'] = $order['order_sn'];
		}
		$this->_format_page($page);
		$this->assign('page_info', $page); 
	
		$this->assign('refunds',$refunds);
		$this->display('refund.index.html');
		
	}
	function view()
	{
		$refund_id = empty($_GET['refund_id'])? 0 : intval($_GET['refund_id']);
		if(!$refund_id){
			$this->show_warning('refund_id_miss', 'back_list', 'index.php?app=refund&act=view&refund_id='.$refund_id);
			return;
		}
		
		//  读取退款信息
		$refund = $this->_refund_mod->get($refund_id);
		
		if(!$refund){
			$this->show_warning('refund_not_find', 'back_list', 'index.php?app=refund&act=view&refund_id='.$refund_id);
			return;
		}
		
		if(!IS_POST)
		{
			$refund['shipped_text'] = Lang::get('shipped_'.$refund['shipped']);
			
			$order = $this->_order_mod->get($refund['order_id']);
			$order['items'] = $this->_ordergoods_mod->find(array(
				'conditions'=>'order_id='.$refund['order_id'],
			));
			$order['shipping'] = $this->_order_extm_mod->get($refund['order_id']);
			
			$page   =   $this->_get_page(10);   //获取分页信息
			$refund['message'] = $this->_refund_message_mod->find(array(
				'conditions'	=>'refund_id='.$refund_id,
				'order'			=>'created desc',
				'limit'			=>$page['limit'],
				'count'   		=> true			
			));	
			$page['item_count'] = $this->_refund_message_mod->getCount();
			$this->_format_page($page);
			$this->assign('page_info', $page); 
			$this->assign('refund',$refund);
			$this->assign('order',$order);
			$this->display('refund.view.html');	
					
		}
		
		else
		{
			
			$this->_check_post_data($refund);
			
			
			
			$order_id 		= $refund['order_id'];
		
			$order_info		= $this->_order_mod->get($order_id);
			$seller_info  	= $this->_member_mod->get($order_info['seller_id']);
			$buyer_info   	= $this->_member_mod->get($order_info['buyer_id']);
		
			
			if($order_info['payment_code'] == 'deposit')
			{
				
				$depopay_type    =&  dpt('outlay', 'refund');
				$tradesn 		= $depopay_type->submit(array(
					'trade_info' =>  array('user_id'=>$order_info['seller_id'],'party_id'=>$order_info['buyer_id'],'amount'=>$_POST['refund_goods_fee'] + $_POST['refund_shipping_fee']),
					'extra_info' =>  $order_info + array('refund_id'=> $refund_id, 'seller_user_name'=>$seller_info['user_name'], 'operator' => 'admin'),
					'post'		 =>	 $_POST,
				));
				if(!$tradesn)
				{
					$this->show_warning('system_handle_refund_error');
					return;
				}
			
				$this->show_message('system_handle_refund_ok', 'back_list', 'index.php?app=refund&act=view&refund_id='.$refund_id);
			}
			
			else{
			
				$this->show_warning('payment_not_support_refund', 'back_list', 'index.php?app=refund&act=view&refund_id='.$refund_id);
			}	
		}
	}
	
	function _check_post_data($refund = array())
	{
		
		if($refund['status'] == 'SUCCESS' || $refund['CLOSED']){
			$this->show_warning('add_refund_message_not_allow');
			exit;
		}	
		if(empty($_POST['refund_goods_fee']) || floatval($_POST['refund_goods_fee'])<0)
		{
			$this->show_warning('refund_fee_ge0');
			exit;
			
		} elseif(floatval($_POST['refund_goods_fee']) > $refund['goods_fee']){
			$this->show_warning('refund_fee_error');
			exit;
		}
		if($_POST['refund_shipping_fee'] !='' && floatval($_POST['refund_shipping_fee'])<0)
		{
			$this->show_warning('refund_shipping_fee_ge0');
			exit;
			
		}
		if(floatval($_POST['refund_shipping_fee']) > $refund['shipping_fee']){
			$this->show_warning('refund_shipping_fee_error');
			exit;
		}
	}
}

?>
