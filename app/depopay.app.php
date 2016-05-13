<?php

class DepopayApp extends MemberbaseApp
{
	var $_order_mod;
	var $_ordergoods_mod;
	var $_deposit_account_mod;
	var $_deposit_record_mod;
	
	/* 构造函数 */
    function __construct()
    {
         $this->DepopayApp();
    }

    function DepopayApp()
    {
        parent::__construct();
		$this->_order_mod	= &m('order');
		$this->_ordergoods_mod = &m('ordergoods');
		$this->_deposit_account_mod	= &m('deposit_account');
		$this->_deposit_record_mod  = &m('deposit_record');
		
    }
    function index()
    {
		if(!$this->_deposit_account_mod->_check_pay_status($this->visitor->get('user_id')))
		{
			$this->show_message('deposit_pay_status_close', 'config_deposit', 'index.php?app=deposit');
			return;
		}
		
		$order_id = intval($_GET['order_id']);
		
		if(!$order_id) {
			$this->show_warning('no_such_order');
			return;
		}
		
		$order_info = $this->_order_mod->get(array(
			'conditions'	=> 'order_alias.order_id='.$order_id,
			'join'          => 'has_orderextm',
		));
		

		if(!$order_info || $order_info['status'] != 11 || $order_info['payment_code'] != 'deposit' || $order_info['buyer_id'] != $this->visitor->get('user_id')){
			$this->show_warning('order_error');
			return;
		}
		
		if(!IS_POST)
		{
			$order_info['ordergoods'] = $this->_ordergoods_mod->find(array('conditions'=>'order_id='.$order_id,'fields'=>'goods_id,goods_name'));
			
			$deposit_account = $this->_deposit_account_mod->get(array('conditions'=>'user_id='.$order_info['buyer_id']));
		
			/* 当前位置 */
        	$this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('deposit'),         'index.php?app=deposit',
                         LANG::get('deposit_index')
			);
		
			$this->assign('order_info', $order_info);
			$this->assign('deposit_account', $deposit_account);
			$this->display('depopay.index.html');
		}
		else
		{
			$password = trim($_POST['password']);
			if(!$this->_deposit_account_mod->_check_account_password($password, $this->visitor->get('user_id'))){
				$this->show_warning('password_error');
            	return;
			}
			
			
			$depopay_type    =&  dpt('outlay', 'buygoods');
			$tradesn 		= $depopay_type->submit(array(
				'trade_info' => array('user_id'=>$this->visitor->get('user_id'),'party_id'=>$order_info['seller_id'],'amount'=>$order_info['order_amount']),
				'extra_info' => $order_info,
				'post'		 =>	$_POST,
			));
			
			if(!$tradesn)
			{
				$this->show_warning('add_trade_error');
				return;
			}
			$this->_curlocal(LANG::get('pay_successed'));
        	$this->assign('order', $order_info);
        	$this->display('paynotify.index.html');
		}
    }
	
	function check_deposit_password()
	{
		$password = trim($_GET['password']);
		
		if($this->_deposit_account_mod->_check_account_password($password, $this->visitor->get('user_id'))){
			echo ecm_json_encode(true);
            return;
		}
		echo ecm_json_encode(false);
        return;
	}
}

?>
