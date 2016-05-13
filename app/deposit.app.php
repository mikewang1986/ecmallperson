<?php

class DepositApp extends DepositbaseApp
{
	var $_deposit_account_mod;
	var $_deposit_record_mod;
	var $_deposit_recharge_mod;
	var $_deposit_withdraw_mod;
	var $_deposit_refund_mod;
	var $_deposit_setting_mod;
	var $_bank_mod;
	var $_order_mod;
	var $_member_mod;
	var $_refund_mod;
	
	
	/* 构造函数 */
    function __construct()
    {
         $this->DepositApp();
    }

    function DepositApp()
    {
        parent::__construct();
		$this->_deposit_account_mod = &m('deposit_account');
		$this->_deposit_record_mod	= &m('deposit_record');
		$this->_deposit_recharge_mod= &m('deposit_recharge');
		$this->_deposit_withdraw_mod= &m('deposit_withdraw');
		$this->_deposit_refund_mod 	= &m('deposit_refund');
		$this->_deposit_setting_mod = &m('deposit_setting');
		$this->_bank_mod = &m('bank');
		$this->_order_mod = &m('order');
		$this->_member_mod = &m('member');
		$this->_refund_mod = &m('refund');
    }
    function index()
    {
		$deposit_account = $this->_deposit_account_mod->get(array('conditions'=>'user_id='.$this->visitor->get('user_id')));
		$bank_list = $this->_bank_mod->find(array('conditions'=>'user_id='.$this->visitor->get('user_id')));
		
		/* 读取最近10条收支记录 */
		$recordlist = $this->_deposit_record_mod->find(array(
			'conditions'	=>	"user_id=".$this->visitor->get('user_id'),
			'limit' 		=>  10,
			'order'			=>	'record_id desc',
			'count'			=>  true
		));
		
		foreach($recordlist as $key=>$record)
		{
			
			$refund = $this->_deposit_refund_mod->get('record_id='.$record['record_id'].' AND user_id='.$this->visitor->get('user_id'));
			$recordlist[$key]['refund'] = $refund;
			
			
			$party = $this->_deposit_account_mod->get(array(
				'conditions' => 'user_id='.$record['party_id'],
				'fields' 	 => 'real_name',
			));
			$recordlist[$key]['party_real_name'] = $party['real_name'];
			
			$recordlist[$key]['status_label'] = LANG::get(strtolower($record['status']));
		}

		
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('deposit'),         'index.php?app=deposit',
                         LANG::get('deposit_index')
		);
						 
		/* 当前所处子菜单 */
        $this->_curmenu('deposit_index');
        /* 当前用户中心菜单 */
        $this->_curitem('deposit');
		$this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('deposit_index'));
		$this->assign('recordlist', $recordlist);
		$this->assign('bank_list', array('list'=>$bank_list,'count'=>count($bank_list)));
		$this->assign('deposit_account', $deposit_account);
		$this->display('deposit.index.html');
    }
	
	
	function config()
	{
		if(!IS_POST)
		{
			$deposit_account = $this->_deposit_account_mod->get(array('conditions'=>'user_id='.$this->visitor->get('user_id')));
			
			/* 当前位置 */
        	$this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('deposit'),         'index.php?app=deposit',
                         LANG::get('deposit_config')
			);
						 
			/* 当前所处子菜单 */
        	$this->_curmenu('deposit_config');
        	/* 当前用户中心菜单 */
        	$this->_curitem('deposit');
			$this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('deposit_config'));
			$this->assign('deposit_account', $deposit_account);
			$this->display('deposit.config.html');
		}
		else
		{
			$deposit_account = $this->_deposit_account_mod->get(array('conditions'=>'user_id='.$this->visitor->get('user_id')));
			
			$account = trim($_POST['account']);
			$real_name = trim($_POST['real_name']);
			$password = trim($_POST['password']);
			$password_config = trim($_POST['password_confirm']);
			$pay_status = strtoupper(trim($_POST['pay_status']));
			
			if(empty($account)) {
				$this->show_warning('account_empty');
				return;
			}
			if(!is_email($account)) {
				$this->show_warning('account_not_email');
				return;
			}
			if(!$this->_deposit_account_mod->_check_account($account,$this->visitor->get('user_id'))){
				$this->show_warning('account_exist');
				return;
			}
			if(empty($real_name))
			{
				$this->show_warning('real_name_empty');
				return;
			}
			if(!$deposit_account && empty($password)) {
				$this->show_warning('password_empty');
				return;
			}
			if($password != $password_config) {
				$this->show_warning('password_confirm_error');
				return;
			}
			if(!in_array($pay_status,array('ON','OFF')))
			{
				$this->show_warning('illegal_param');
				return;
			}
			
			if ((base64_decode($_SESSION['email_captcha']) != strtolower($_POST['email_captcha']) || ($_SESSION['email_captcha_time'] < gmtime())))
            {
                $this->show_warning('mail_captcha_failed');
                return;
            }
			
			$add_time = gmtime();
			$data = array(
				'user_id'		=>	$this->visitor->get('user_id'),
				'account'		=>	$account,
				'password'		=> 	md5($password),
				'real_name'		=>	$real_name,
				'pay_status'	=>	$pay_status,
				'add_time'		=>	$add_time,
				'last_update'	=> 	$add_time,
			);
			
			if($deposit_account)
			{
				unset($data['user_id'],$data['account'], $data['money'], $data['frozen'], $data['add_time']);
				if(empty($password)) unset($data['passowrd']);
				
				if($this->_deposit_account_mod->edit('user_id='.$this->visitor->get('user_id'), $data)){
					$this->show_message('edit_ok');
					return;
				}	
			}
			else
			{
				if($this->_deposit_account_mod->add($data)){
					$this->show_message('add_ok');
					return;
				}
			}
			
		}
	}
	
	
	function record()
	{
		$tradesn = trim($_GET['tradesn']);
		
		if(empty($tradesn)) {
			$this->show_warning('error');
			return;
		}
		$record = $this->_deposit_record_mod->find(array(
			'conditions'	=>	"user_id=".$this->visitor->get('user_id'). " AND tradesn='".$tradesn."'",
		));
		if(!$record) {
			$this->show_warning('no_record');
			return;
		}
		if(count($record)> 1)
		{
			$total = 0;
			foreach($record as $k=>$v) {
				$v['status'] == 'SUCCESS' && $total += $v['amount'];
			}
			
			reset($record);
			$record = current($record);
			$record['total'] = $total;
		}
		else
		{
			reset($record);
			$record = current($record);
			$record['total'] = $record['amount'];
		}
		
		
		if($record['party_id'])
		{
			$party_account = $this->_deposit_account_mod->get(array(
				'conditions'	=> 'user_id='.$record['party_id'],
				'fields'		=> 'real_name,account',
			));
			if($party_account) {
				$record = array_merge($record, $party_account);
			}
		}
		
		
		if($record['order_sn'])
		{
			$order = $this->_order_mod->findAll(array(
				'conditions'=>"order_sn='".$record['order_sn']."'", 
				'fields'=>'order.order_id,order_amount,shipping_fee,shipping_name',
				'join'=>'has_orderextm',
				'include'=> array('has_ordergoods')
			));
			reset($order);
			$order = current($order);
			if($order) 
			{
				$record['order_id'] = $order['order_id'];
				foreach ($order['order_goods'] as $k => $goods)
				{
					
					$refund = $this->_refund_mod->get(array(
						'conditions'=>'order_id='.$goods['order_id'].' and goods_id='.$goods['goods_id'].' and spec_id='.$goods['spec_id'],
						'fields'=>'status,order_id'
					));
					if($refund) {
						$order['order_goods'][$k]['refund_status'] = $refund['status'];
						$order['order_goods'][$k]['refund_id'] = $refund['refund_id'];
					}
				}
			}
			
			$this->assign('order', $order);
		}
		if($record['status']) {
			$record['status_label'] = LANG::get(strtolower($record['status']));
		}
		
		/* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                        LANG::get('deposit'),         'index.php?app=deposit',
                        LANG::get('record_detail')
		);
						 
		/* 当前所处子菜单 */
        $this->_curmenu('record_detail');
        /* 当前用户中心菜单 */
        $this->_curitem('deposit');
		$this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('record_detail'));
		$this->assign('deposit_record', $record);
		$this->display('deposit.record.html');
	}

	
	function recordlist()
	{
		$add_time_from	= trim($_GET['add_time_from']);
		$add_time_to	= trim($_GET['add_time_to']);
		$purpose		= trim($_GET['purpose']);
		
		$conditions = $conditions_time = $conditions_extra = '';
		if($add_time_from) {
			$conditions_time .= " AND add_time >='".gmstr2time($add_time_from)."'";
		}
		if($add_time_to) {
			$conditions_time .= " AND add_time <='".gmstr2time($add_time_to)."'";
		}
		if($purpose)
		{
			$conditions_extra .= " AND purpose = '".$purpose."'";
		}
		$conditions = $conditions_time . $conditions_extra;
		
		$page = $this->_get_page(10);
		
		$recordlist = $this->_deposit_record_mod->find(array(
			'conditions'	=>	"status != 'CLOSED' AND user_id=".$this->visitor->get('user_id'). $conditions,
			'limit' 		=>  $page['limit'],
			'order'			=>	'record_id desc',
			'count'			=>  true
		));

		
		$list = $this->_deposit_record_mod->find(array(
			'conditions'	=>	"status != 'CLOSED' AND user_id=".$this->visitor->get('user_id') . $conditions_time,
			'order'			=>	'record_id desc',
			'fields'		=>	'flow,amount',
		));
		
		$total_income = $total_outlay = 0;
		foreach($list as $key=>$val)
		{
			if($val['flow']=='income') $total_income += $val['amount'];
			else $total_outlay += $val['amount'];
		}
		
		$page['item_count'] = $this->_deposit_record_mod->getCount();
        $this->_format_page($page);
		
		/* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                        LANG::get('deposit'),         'index.php?app=deposit',
                        LANG::get('recordlist')
		);
						 
		/* 当前所处子菜单 */
        $this->_curmenu('recordlist');
        /* 当前用户中心菜单 */
        $this->_curitem('deposit');
		$this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('recordlist'));
        $this->import_resource(array(
            'script' => array(
                array(
                    'path' => 'dialog/dialog.js',
                    'attr' => 'id="dialog_js"',
                ),
                array(
                    'path' => 'jquery.ui/jquery.ui.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.ui/i18n/' . i18n_code() . '.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.plugins/jquery.validate.js',
                    'attr' => '',
                ),
            ),
            'style' =>  'jquery.ui/themes/ui-lightness/jquery.ui.css',
        ));
		
		$this->assign('page_info',$page);
		$this->assign('records', array('list'=>$recordlist,'total_income'=>$total_income,'total_outlay'=>$total_outlay));
		$this->display('deposit.recordlist.html');
	}
	
	
	function frozenlist()
	{
		$add_time_from	= trim($_GET['add_time_from']);
		$add_time_to	= trim($_GET['add_time_to']);
		$purpose		= trim($_GET['purpose']);
		
		$conditions = $conditions_time = $conditions_extra = '';
		if($add_time_from) {
			$conditions_time .= " AND add_time >='".gmstr2time($add_time_from)."'";
		}
		if($add_time_to) {
			$conditions_time .= " AND add_time <='".gmstr2time($add_time_to)."'";
		}
		
		
		$conditions_extra .= " AND purpose = 'withdraw' AND status='WAIT_ADMIN_VERIFY' ";
		
		$conditions = $conditions_time . $conditions_extra;
		
		$page = $this->_get_page(10);
		
		$recordlist = $this->_deposit_record_mod->find(array(
			'conditions'	=>	"user_id=".$this->visitor->get('user_id'). $conditions,
			'limit' 		=>  $page['limit'],
			'order'			=>	'record_id desc',
			'count'			=>  true
		));

		$total_income = $total_outlay = 0;
		foreach($recordlist as $key=>$val)
		{
			
			if($val['flow']=='income') $total_income += $val['amount'];
			else $total_outlay += $val['amount'];
			
			$recordlist[$key]['status_label'] = Lang::get(strtolower($val['status']));
		}

		$page['item_count'] = $this->_deposit_record_mod->getCount();
        $this->_format_page($page);
		
		/* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                        LANG::get('deposit'),         'index.php?app=deposit',
                        LANG::get('frozenlist')
		);
						 
		/* 当前所处子菜单 */
        $this->_curmenu('frozenlist');
        /* 当前用户中心菜单 */
        $this->_curitem('deposit');
		$this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('frozenlist'));
        $this->import_resource(array(
            'script' => array(
                array(
                    'path' => 'dialog/dialog.js',
                    'attr' => 'id="dialog_js"',
                ),
                array(
                    'path' => 'jquery.ui/jquery.ui.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.ui/i18n/' . i18n_code() . '.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.plugins/jquery.validate.js',
                    'attr' => '',
                ),
            ),
            'style' =>  'jquery.ui/themes/ui-lightness/jquery.ui.css',
        ));
		
		$this->assign('page_info',$page);
		$this->assign('records', array('list'=>$recordlist, 'total_outlay'=>$total_outlay));
		$this->display('deposit.frozenlist.html');
	}
	
	
	
	function recharge()
	{
		if(!$this->_has_account())
		{
			$this->show_warning('has_not_account');
			return;
		}
		
		if(!IS_POST)
		{
			$bank_list = $this->_bank_mod->find(array('conditions'=>'user_id='.$this->visitor->get('user_id')));

			/* 当前位置 */
        	$this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('deposit'),         'index.php?app=deposit',
                         LANG::get('deposit_recharge')
			);
						 
			/* 当前所处子菜单 */
        	$this->_curmenu('deposit_recharge');
        	/* 当前用户中心菜单 */
        	$this->_curitem('deposit');
			$this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('deposit_recharge'));
			$this->assign('alipaybank', $this->_get_bank_inc('alipaybank'));
			$this->assign('bank_list', $bank_list);
			$this->display('deposit.recharge.html');
		}
		else
		{
			$method = trim($_POST['method']);
			$money = trim($_POST['money']);
			
			if($method=='online')
			{
				$payment_code = trim($_POST['payment_code']);
				
				$payment_model =& m('payment');
			
				
            	if (!$payment_model->in_white_list($payment_code))
            	{
                	$this->show_warning('payment_disabled_by_system');

                	return;
            	}
				$payment_info  = $payment_model->get("payment_code ='{$payment_code}' AND store_id=0");
				
            	
            	if (!$payment_info['enabled'])
            	{
                	$this->show_warning('payment_disabled');

                	return;
            	}
				
				$tradesn = $this->_deposit_record_mod->_gen_trade_sn();
				
				
           	 	$payment    = $this->_get_platform_payment($payment_code, $payment_info);

           	 	$payment_form = $payment->get_payform(array(
					'defaultbank'	=> trim($_POST['defaultbank']),
					'total_fee'		=> $money,
					'tradesn' 		=> $tradesn,
					'subject'		=> Lang::get('recharge'),
				));
				
				
				$depopay_type    =&  dpt('income', 'recharge');
				
				$tradesn 	= $depopay_type->submit(array(
					'trade_info' =>  array('tradesn'=>$tradesn, 'user_id'=>$this->visitor->get('user_id'), 'party_id'=>0, 'amount'=>$money),
					'extra_info' =>  array('is_online'=>1, 'payment_code'=> $payment_code),
					'post'		 =>	 $_POST,
				));
			
				/* 跳转到真实收银台 */
            	$this->_config_seo('title', Lang::get('cashier'));
            	$this->assign('payform', $payment_form);
            	$this->assign('payment', $payment_info);
            	header('Content-Type:text/html;charset=' . CHARSET);
            	$this->display('deposit.payform.html');
			}
			
			else
			{
				if(empty($_POST['bid']) || intval($_POST['bid']) <=0) {
					$this->show_warning('recharge_bank_empty', 'back','index.php?app=deposit&act=recharge');
					return;
				}
				
				
				$depopay_type    =&  dpt('income', 'recharge');
				
				$tradesn 	= $depopay_type->submit(array(
					'trade_info' =>  array('user_id'=>$this->visitor->get('user_id'), 'party_id'=>0, 'amount'=>$money),
					'extra_info' =>  array('is_online'=>0),
					'post'		 =>	 $_POST,
				));
			
				if(!$tradesn)
				{
					$this->show_warning('add_trade_error');
					return;
				}
				
				$this->show_message('add_recharge_ok', 'back', 'index.php?app=deposit&act=rechargelist');
			}
		}
	}
	
	
	function rechargelist()
	{
		$add_time_from	= trim($_GET['add_time_from']);
		$add_time_to	= trim($_GET['add_time_to']);
		$status			= trim($_GET['status']);
		
		$conditions = '';
		if($add_time_from) {
			$conditions .= " AND add_time >='".gmstr2time($add_time_from)."'";
		}
		if($add_time_to) {
			$conditions .= " AND add_time <='".gmstr2time($add_time_to)."'";
		}
		if($status) {
			$status = strtoupper($status)=='VERIFING' ? 'WAIT_ADMIN_VERIFY' : 'SUCCESS';
			$conditions .= " AND status='".$status."'";
		}

		$page = $this->_get_page(10);
		
		$rechargelist = $this->_deposit_recharge_mod->find(array(
			'conditions'	=>	"user_id=".$this->visitor->get('user_id'). $conditions,
			'limit' 		=>  $page['limit'],
			'order' 		=>	'tradesn desc',
			'count'			=>  true
		));

		$total_amount = 0;
		foreach($rechargelist as $key=>$recharge)
		{
			$rechargelist[$key]['extra'] = unserialize($recharge['extra']);
			
			if($recharge['status']=='SUCCESS') {
				$total_amount += $recharge['amount'];
			}
		}
		
		$page['item_count'] = $this->_deposit_recharge_mod->getCount();
        $this->_format_page($page);
		
		/* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                        LANG::get('deposit'),         'index.php?app=deposit',
						LANG::get('indraw'),		'index.php?app=deposit&act=drawlist',
                        LANG::get('rechargelist')
		);
						 
		/* 当前所处子菜单 */
        $this->_curmenu('indraw');
        /* 当前用户中心菜单 */
        $this->_curitem('deposit');
		$this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('rechargelist'));
        $this->import_resource(array(
            'script' => array(
                array(
                    'path' => 'dialog/dialog.js',
                    'attr' => 'id="dialog_js"',
                ),
                array(
                    'path' => 'jquery.ui/jquery.ui.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.ui/i18n/' . i18n_code() . '.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.plugins/jquery.validate.js',
                    'attr' => '',
                ),
            ),
            'style' =>  'jquery.ui/themes/ui-lightness/jquery.ui.css',
        ));
		
        $this->assign('page_info',$page);
		$this->assign('recharges', array('list'=>$rechargelist,'total_amount'=>$total_amount));
		$this->display('deposit.rechargelist.html');
	}
	
	
	function withdraw()
	{
		$deposit_account = $this->_deposit_account_mod->get(array('conditions'=>'user_id='.$this->visitor->get('user_id'),'fields'=>'money'));
		$bank_list = $this->_bank_mod->find(array('conditions'=>'user_id='.$this->visitor->get('user_id')));
		
		/* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                        LANG::get('deposit'),         'index.php?app=deposit',
                        LANG::get('deposit_withdraw')
		);
						 
		/* 当前所处子菜单 */
        $this->_curmenu('deposit_withdraw');
        /* 当前用户中心菜单 */
        $this->_curitem('deposit');
		$this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('deposit_withdraw'));
		$this->assign('deposit_account', $deposit_account);
		$this->assign('bank_list', $bank_list);
		$this->display('deposit.withdraw.html');
	}
	
	
	function withdraw_confirm()
	{
		$bid = intval($_GET['bid']);
		$money = floatval($_GET['money']);

		if(!$this->_bank_mod->get($bid)) {
			$this->show_warning('select_bank_error');
			return;
		}
		
		
		if(empty($money) || $money <=0 )
		{
			$this->show_warning('money_error');
			return;
		}

		if(!IS_POST)
		{
			$bank = $this->_bank_mod->get($bid);
			$deposit_account = $this->_deposit_account_mod->get(array('conditions'=>'user_id='.$this->visitor->get('user_id'),'fields'=>'money'));
			
			/* 当前位置 */
        	$this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('deposit'),         'index.php?app=deposit',
                         LANG::get('deposit_withdraw')
			);
						 
			/* 当前所处子菜单 */
        	$this->_curmenu('deposit_withdraw');
        	/* 当前用户中心菜单 */
        	$this->_curitem('deposit');
			$this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('deposit_withdraw'));
			$_SESSION['withdraw_submit'] = 0; 
			$this->assign('widthdraw', array('money'=>$money, 'total' => $money));
			$this->assign('bank', $bank);
			$this->assign('deposit_account', $deposit_account);
			$this->display('deposit.withdraw_confirm.html');
		}
		else
		{	
			
			if(!isset($_SESSION['withdraw_submit']))
			{
				$this->show_warning('second_submit');
                return;
			}
			unset($_SESSION['withdraw_submit']);
			
			if (base64_decode($_SESSION['captcha']) != strtolower($_POST['captcha']))
            {
                $this->show_warning('captcha_failed');
                return;
            }
			
			$password = trim($_POST['password']);
			if(!$this->_deposit_account_mod->_check_account_password($password, $this->visitor->get('user_id')))
			{
				$this->show_warning('password_error');
				return;
			}
			
			
			$depopay_type    =&  dpt('outlay', 'withdraw');
			
			$ret_id = $depopay_type->submit(array(
				'trade_info' =>  array('user_id'=>$this->visitor->get('user_id'), 'party_id'=>0, 'amount'=>$money),
				'extra_info' =>  array(),
				'post'		 =>	 $_POST,
			));
			
			if(!$ret_id)
			{
				$this->show_warning('add_trade_error');
				return;
			}
			$this->show_message('add_ok_wait_verify', 'deposit_index', 'index.php?app=deposit');
		}
	}
	
	
	function drawlist()
	{
		$add_time_from	= trim($_GET['add_time_from']);
		$add_time_to	= trim($_GET['add_time_to']);
		$status			= trim($_GET['status']);
		
		$conditions = '';
		if($add_time_from) {
			$conditions .= " AND add_time >='".gmstr2time($add_time_from)."'";
		}
		if($add_time_to) {
			$conditions .= " AND add_time <='".gmstr2time($add_time_to)."'";
		}
		if($status) {
			$status = strtoupper($status)=='VERIFING' ? 'WAIT_ADMIN_VERIFY' : 'SUCCESS';
			$conditions .= " AND status='".$status."'";
		}

		$page = $this->_get_page(10);
		
		$recordlist = $this->_deposit_withdraw_mod->find(array(
			'conditions'	=>	"user_id=".$this->visitor->get('user_id') . $conditions,
			'limit' 		=>  $page['limit'],
			'order'			=>	'withdraw_id desc',
			'count'			=>  true
		));

		$total_amount = 0;
		foreach($recordlist as $key=>$record)
		{
			$card_info = unserialize($record['card_info']);
			$card_info['type_label'] = LANG::get($card_info['type']);
			$recordlist[$key]['card_info']  = $card_info;
			
			if($record['status']=='SUCCESS') {
				$total_amount += floatval($record['amount']);
			}
		}

		$page['item_count'] = $this->_deposit_withdraw_mod->getCount();
        $this->_format_page($page);
		
		/* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                        LANG::get('deposit'),         'index.php?app=deposit',
						LANG::get('indraw'),		'index.php?app=deposit&act=drawlist',
                        LANG::get('drawlist')
		);
						 
		/* 当前所处子菜单 */
        $this->_curmenu('indraw');
        /* 当前用户中心菜单 */
        $this->_curitem('deposit');
		
		$this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('drawlist'));
        $this->import_resource(array(
            'script' => array(
                array(
                    'path' => 'dialog/dialog.js',
                    'attr' => 'id="dialog_js"',
                ),
                array(
                    'path' => 'jquery.ui/jquery.ui.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.ui/i18n/' . i18n_code() . '.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.plugins/jquery.validate.js',
                    'attr' => '',
                ),
            ),
            'style' =>  'jquery.ui/themes/ui-lightness/jquery.ui.css',
        ));
		
        $this->assign('page_info',$page);
		$this->assign('withdraws', array('list'=>$recordlist,'total_amount'=>$total_amount));
		$this->display('deposit.drawlist.html');
	}
	
	
	function transfer()
	{
		
		$deposit_account = $this->_deposit_account_mod->get(array('conditions'=>'user_id='.$this->visitor->get('user_id'),'fields'=>'money,account'));
		$bank_list = $this->_bank_mod->find(array('conditions'=>'user_id='.$this->visitor->get('user_id')));
		
		/* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                        LANG::get('deposit'),         'index.php?app=deposit',
                        LANG::get('deposit_transfer')
		);
						 
		/* 当前所处子菜单 */
        $this->_curmenu('deposit_transfer');
        /* 当前用户中心菜单 */
        $this->_curitem('deposit');
		$this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('deposit_transfer'));
		$this->assign('deposit_account', $deposit_account);
		$this->display('deposit.transfer.html');	
	}
	
	
	function transfer_confirm()
	{
		$money = floatval($_GET['money']);
		$account = trim($_GET['account']);
		
		$deposit_account = $this->_deposit_account_mod->get(array('conditions'=>'user_id='.$this->visitor->get('user_id')));
		
		if($deposit_account['pay_status'] != 'ON')
		{
			$this->show_message('pay_status_off');
			return;
		}
		if($deposit_account['account'] == $account)
		{
			$this->show_message('select_account_yourself');
			return;
		}
		if(!$party = $this->_deposit_account_mod->get(array('conditions'=>" account='".$account."' ")))
		{
			$this->show_message('select_account_not_exist');
			return;
		}
		
		
		if(empty($money) || $money <=0 )
		{
			$this->show_warning('money_error');
			return;
		}
		
		if($rate = $this->_deposit_setting_mod->_get_deposit_setting($this->visitor->get('user_id'),'transfer_rate')){
			$fee = round($money * $rate, 2);
		}
		else $fee = 0;
		
		if(!IS_POST)
		{
			/* 当前位置 */
        	$this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('deposit'),         'index.php?app=deposit',
                         LANG::get('deposit_transfer')
			);
						 
			/* 当前所处子菜单 */
        	$this->_curmenu('deposit_transfer');
        	/* 当前用户中心菜单 */
        	$this->_curitem('deposit');
			$this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('deposit_transfer'));
			$_SESSION['transfer_submit'] = 0;  
			$this->assign('party', $party);
			$this->assign('transfer', array('money'=>$money, 'fee'=>$fee));
			$this->display('deposit.transfer_confirm.html');
		}
		else
		{	
			
			if(!isset($_SESSION['transfer_submit']))
			{
				$this->show_warning('second_submit');
                return;
			}
			unset($_SESSION['transfer_submit']);
			
			if (base64_decode($_SESSION['captcha']) != strtolower($_POST['captcha']))
            {
                $this->show_warning('captcha_failed');
                return;
            }
			
			$password = trim($_POST['password']);
			if(!$this->_deposit_account_mod->_check_account_password($password, $this->visitor->get('user_id')))
			{
				$this->show_warning('password_error');
				return;
			}
			$party = $this->_deposit_account_mod->get(array('conditions'=>" account='".$account."' ",'fields'=>'user_id'));
			
			
			$depopay_type    =&  dpt('outlay', 'transfer');
			
			$tradesn = $depopay_type->submit(array(
				'trade_info' =>  array('user_id'=>$this->visitor->get('user_id'), 'party_id'=>$party['user_id'], 'amount'=>$money, 'fee'=>$fee),
				'extra_info' =>  array(),
				'post'		 =>	 $_POST,
			));
			
			if(!$tradesn)
			{
				$this->show_warning('add_trade_error');
				return;
			}
			$this->show_message('add_ok', 'deposit_index', 'index.php?app=deposit');
		}	
	}
	
	
	function monthbill()
	{
		$monthbill = $this->_deposit_record_mod->find(array(
			'conditions'	=>	"user_id=".$this->visitor->get('user_id')." AND status='SUCCESS' AND end_time >0 ",
			'order'			=>	'record_id desc',
			'fields'		=>	'flow,purpose,this.amount,end_time',
		));
		
		$bill_list = array();
		
		
		if($monthbill)
		{
			foreach($monthbill as $key=>$bill)
			{
				$year_month = local_date('Y-m', $bill['end_time']);
				$bill_list[$year_month][$bill['flow'].'_money'] += $bill['amount'];
				$bill_list[$year_month][$bill['flow'].'_count'] += 1;
				
				
				if($bill['flow']=='outlay' && $bill['purpose']=='charge')
				{
					$bill_list[$year_month][$bill['purpose'].'_money'] += $bill['amount'];
					$bill_list[$year_month][$bill['purpose'].'_count'] += 1;
				}
			}
		}
		
		/* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                        LANG::get('deposit'),         'index.php?app=deposit',
                        LANG::get('monthbill')
		);
						 
		/* 当前所处子菜单 */
        $this->_curmenu('monthbill');
        /* 当前用户中心菜单 */
        $this->_curitem('deposit');
			
		$this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('monthbill'));
        	
		$this->assign('monthbill', $bill_list);
		$this->display('deposit.monthbill.html');
		
	}
	
	
	function downloadbill()
	{
		$month = trim($_GET['month']);
		if(empty($month)) return;

		
		$month_times = strtotime(local_date("Y-m"),$month);
		$monthday 	= local_date("t");
		$begin_this_month	= strtotime(local_date('Y-m-01 00:00:00'));
		$end_this_month		= strtotime(local_date("Y-m-$monthday 23:59:59",strtotime("this month",$month_times)));
			
		$monthbill = $this->_deposit_record_mod->find(array(
			'conditions'=>	"user_id=".$this->visitor->get('user_id')." AND status='SUCCESS' AND end_time>='".$begin_this_month."' AND end_time<='".$end_this_month."' ",
			'order'		=>	'record_id desc',
		));
		
		if(!$monthbill) return;
		
		import('phpzip.lib');
		$zip = new PHPZip;
		
		$lang_bill = array(
			'tradesn' 		=> 	'流水号',
    		'order_sn' 		=> 	'商户订单号',
    		'title' 		=> 	'商品名称',
    		'add_time' 		=> 	'发生时间',
    		'other_account' => 	'对方账号',
    		'income_money' 	=> 	'收入金额（+元）',
    		'outlay_money' 	=> 	'支出金额（-元）',
			'balance'		=>	'账户余额（元）',
			'payway'		=>	'交易渠道',
			'purpose'		=>	'业务类型',
			'remark'		=>	'备注',
		);
		
		/* csv文件数组 */
		$bill_value = array();
		foreach($lang_bill as $key=>$val)
		{
			$bill_value[$key] = '';
		}
		
		$content = implode("\t", $lang_bill) . "\n";
		
		$deposit_account = $this->_deposit_account_mod->_get_account_info($this->visitor->get('user_id'));
		
		$folder = local_date('Ym', strtotime($month)).'_'.$deposit_account['account'];
		$file = local_date('YmdHis', gmtime()).'_'.local_date('Y_m', strtotime($month));
		
		foreach($monthbill as $key=>$bill)
    	{
			$bill_value['tradesn']	=	$bill['tradesn'];
			$bill_value['order_sn']	=	$bill['order_sn'];
			$bill_value['title']	=	$bill['name'];
			$bill_value['add_time']	=	local_date('Y/m/d H:i:s',$bill['add_time']);
			$bill_value['balance']	=	$bill['balance'];
			$bill_value['payway']	=	$bill['payway'];
			$bill_value['purpose']	=	LANG::get($bill['purpose']);
			$bill_value['remark']   =   $bill['remark'];
			
			if($bill['flow']=='income'){
				$bill_value['outlay_money'] = 0;
				$bill_value['income_money']	= $bill['amount'];
			} else {
				$bill_value['income_money'] = 0;
				$bill_value['outlay_money'] = '-'.$bill['amount'];
			}
			if($bill['party_id']) {
				$other_account = $this->_deposit_account_mod->_get_account_info($bill['party_id']);
				$bill_value['other_account']	=	$other_account['real_name'].'('.$other_account['account'].')';
			}
			
        	
        	$content .= implode("\t", $bill_value) . "\n";
    	}

   	 	if (CHARSET != 'utf-8')
    	{
        	$content = ecm_iconv(CHARSET, 'utf-8', $content);
   		}
		$zip->add_file("\xFF\xFE" . $this->utf82u2($content), $file.'.csv');

    	header("Content-Disposition: attachment; filename=".$folder.".zip");
    	header("Content-Type: application/unknown");
    	die($zip->file());
	}
	
	
	function droprecharge()
	{
		$tradesn = trim($_GET['tradesn']);
		
		if(empty($tradesn)) {
			$this->show_warning('drop_fail');
			return;
		}
		
		if($deposit_recharge = $this->_deposit_recharge_mod->get(array('conditions'=>'tradesn='.$tradesn.' AND user_id='.$this->visitor->get('user_id'), 'fields'=>'status'))) {
			if($deposit_recharge['status'] != 'PENDING') {
				$this->show_warning('droprecharge_fail');
				return;
			}
			$this->_deposit_recharge_mod->drop($tradesn);
			$this->show_message('drop_ok');
		}
	}
	
	function pay_status()
	{
		$status = strtoupper(trim($_GET['status']));
		if(!in_array($status, array('ON','OFF'))){
			$this->show_warning('pay_status_error');
			return;
		}

		$status == 'OFF' ? 'ON' : 'OFF';
		
		if(!$this->_deposit_account_mod->edit('user_id='.$this->visitor->get('user_id'),array('pay_status'=> $status))){
			$this->show_warning('edit_error');
			return;
		}
		$this->show_message('edit_ok', 'deposit_index', 'index.php?app=deposit');
	}
	
	
	function send_email()
    {
        if (IS_POST)
        {
           
			
			$email_captcha = mt_rand(1000,9999);
			$_SESSION['email_captcha'] = base64_encode($email_captcha);
			$_SESSION['email_captcha_time'] = gmtime() + 60; // 过期时间设置为60秒
			
			$deposit_account = $this->_deposit_account_mod->get('user_id='.$this->visitor->get('user_id'));
			if($deposit_account) {
				$email = $deposit_account['account'];
			} else {
				$email = trim($_POST['email']);
			}

            $email_subject = Conf::get('site_title') . LANG::get('mail_account_active');
            $email_content = sprintf(LANG::get('mail_captcha'), Conf::get('site_title'), $email_captcha);

           
            
			$mail_result = $this->_mailto($email, addslashes($email_subject), addslashes($email_content), 1);
			if ($mail_result)
            {
                $this->json_result('', sprintf(LANG::get('mail_send_succeed'), $email));
            }
            else
            {
                $this->json_error('mail_send_failure', implode("\n", $mailer->errors));
           }  
        }
        else
        {
           $this->show_warning('Hacking Attempt');
        }
    }
	
	function _mailto($to, $subject, $message, $priority = MAIL_PRIORITY_MID)
	{
		$model_mailqueue =& m('mailqueue');
		$mails = array();
		$to_emails = is_array($to) ? $to : array($to);
		foreach ($to_emails as $_to)
		{
			$mails[] = array(
				'mail_to'       => $_to,
				'mail_encoding' => CHARSET,
				'mail_subject'  => $subject,
				'mail_body'     => $message,
				'priority'      => $priority,
				'add_time'      => gmtime(),
			);
		}
        
		$mq = $model_mailqueue->add($mails);
		$this->_sendmail(true);
			
		return $mq;
     }

	/**
     *    三级菜单
     *
     *    @author    psmb
     *    @return    void
     */
    function _get_member_submenu()
    {
        $data = array(
            array(
                'name'  => 'deposit_index',
                'url'   => 'index.php?app=deposit',
            ),
			array(
				'name'  => 'deposit_config',
				'url'	=> 'index.php?app=deposit&act=config',
			),
			array(
				'name'	=>	'recordlist',
				'url'	=>	'index.php?app=deposit&act=recordlist',
			),
			
			array(
				'name'	=>	'indraw',
				'url'	=> 	'index.php?app=deposit&act=drawlist',
			),
        );
		if(ACT=='withdraw' || ACT=='withdraw_confirm')
		{
			$data[] = array(
				'name'	=>	'deposit_withdraw',
				'url'	=>	'index.php?app=deposit&act=withdraw',
			);
		}
		if(ACT=='record')
		{
			$data[] = array(
				'name'	=>	'record_detail',
				'url'	=>	'index.php?app=deposit&act=record',
			);
		}
		if(ACT=='recharge')
		{
			$data[] = array(
				'name'	=> 'deposit_recharge',
				'url'	=> 'index.php?app=deposit&act=recharge',
			);
		}
		if(ACT=='monthbill')
		{
			$data[] = array(
				'name'	=> 'monthbill',
				'url'	=> 'index.php?app=deposit&act=monthbill',
			);
		}
		if(ACT=='transfer')
		{
			$data[] = array(
				'name'	=>	'deposit_transfer',
				'url'	=>	'index.php?app=deposti&act=transfer',
			);
		}
		if(ACT=='frozenlist')
		{
			$data[] = array(
				'name'	=>	'frozenlist',
				'url'	=>	'index.php?app=deposti&act=frozenlist',
			);
		}
		
		return $data;
    }
	
	function utf82u2($str)
	{
    	$len = strlen($str);
    	$start = 0;
    	$result = '';

   		if ($len == 0)
    	{
        	return $result;
    	}

    	while ($start < $len)
    	{
        	$num = ord($str{$start});
        	if ($num < 127)
        	{
            	$result .= chr($num) . chr($num >> 8);
            	$start += 1;
       	 	}
        	else
        	{
            	if ($num < 192)
            	{
                	/* 无效字节 */
                	$start ++;
            	}
            	elseif ($num < 224)
            	{
                	if ($start + 1 <  $len)
                	{
                    	$num = (ord($str{$start}) & 0x3f) << 6;
                    	$num += ord($str{$start+1}) & 0x3f;
                    	$result .=   chr($num & 0xff) . chr($num >> 8) ;
                	}
                	$start += 2;
            	}
            	elseif ($num < 240)
            	{
                	if ($start + 2 <  $len)
                	{
                   	 	$num = (ord($str{$start}) & 0x1f) << 12;
                    	$num += (ord($str{$start+1}) & 0x3f) << 6;
                    	$num += ord($str{$start+2}) & 0x3f;

                    	$result .=   chr($num & 0xff) . chr($num >> 8) ;
               	 	}
                	$start += 3;
            	}
            	elseif ($num < 248)
            	{

                	if ($start + 3 <  $len)
                	{
                    	$num = (ord($str{$start}) & 0x0f) << 18;
                    	$num += (ord($str{$start+1}) & 0x3f) << 12;
                    	$num += (ord($str{$start+2}) & 0x3f) << 6;
                    	$num += ord($str{$start+3}) & 0x3f;
                    	$result .= chr($num & 0xff) . chr($num >> 8) . chr($num >>16);
                	}
                	$start += 4;
            	}
            	elseif ($num < 252)
            	{
                	if ($start + 4 <  $len)
                	{
                    	/* 不做处理 */
                	}
                	$start += 5;
            	}
            	else
            	{
                	if ($start + 5 <  $len)
                	{
                    	/* 不做处理 */
                	}
                	$start += 6;
            	}
        	}

    	}
    	return $result;
	}
}

?>
