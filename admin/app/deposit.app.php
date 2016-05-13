<?php

/* 预存款控制器 */
class DepositApp extends BackendApp
{
	var $_deposit_withdraw_mod;
	var $_deposit_record_mod;
	var $_deposit_account_mod;
	var $_deposit_recharge_mod;
	var $_deposit_setting_mod;
	var $_member_mod;
	
    function __construct()
    {
        $this->DepositApp();
    }

    function DepositApp()
    {
        parent::__construct();
		$this->_deposit_withdraw_mod = &m('deposit_withdraw');
		$this->_deposit_record_mod   = &m('deposit_record');
		$this->_deposit_account_mod  = &m('deposit_account');
		$this->_deposit_recharge_mod = &m('deposit_recharge');
		$this->_deposit_setting_mod  = &m('deposit_setting');
		$this->_member_mod			 = &m('member');
    }
    function index()
    {
		$page = $this->_get_page(10);
		
		$accountlist = $this->_deposit_account_mod->find(array(
			'conditions'	=>	'',
			'limit' 		=>  $page['limit'],
			'order'			=>	'account_id',
			'count'			=>  true
		));
		
		foreach($accountlist as $key=>$account)
		{
			$member = $this->_member_mod->get(array('conditions'=>'user_id='.$account['user_id'],'fields'=>'user_name'));
			$accountlist[$key]['user_name'] = $member['user_name'];
		}
		
		$page['item_count'] = $this->_deposit_account_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info',$page);
		$this->assign('accountlist', $accountlist);
		$this->display('deposit.index.html');
        
    }
	
	
	function tradelist()
	{
		$search_options = array(
            'tradesn'   => Lang::get('tradesn'),
            'user_name' => Lang::get('user_name'),
        );
        $conditions = $this->_get_query_conditions(array(
			array(
                'field' => 'add_time',
                'name'  => 'add_time_from',
                'equal' => '>=',
                'handler'=> 'gmstr2time',
            ),array(
                'field' => 'add_time',
                'name'  => 'add_time_to',
                'equal' => '<=',
                'handler'   => 'gmstr2time_end',
            ),array(
                'field' => 'amount',
                'name'  => 'amount_from',
                'equal' => '>=',
                'type'  => 'numeric',
            ),array(
                'field' => 'amount',
                'name'  => 'amount_to',
                'equal' => '<=',
                'type'  => 'numeric',
            ),
        ));
		
		$search_name = trim($_GET['search_name']);
		if(!empty($search_name))
		{
			if($_GET['field']=='user_name') {
				$member = $this->_member_mod->get(array('conditions'=>"user_name='".$search_name."' ",'fields'=>'user_id'));
				if($member) $conditions .= ' AND user_id='.$member['user_id']; else $conditions .= ' AND user_id=0 ';
			} elseif($_GET['field']=='tradesn') {
				$conditions .= " AND tradesn='".$search_name."' ";
			}
		}
		if($_GET['status']){
			$conditions .= " AND status='".trim($_GET['status'])."' ";
		}
		
		$page = $this->_get_page(10);
		$recordlist = $this->_deposit_record_mod->find(array(
			'conditions'	=>	'1=1 ' . $conditions,
			'order'			=>	' record_id desc',
			'limit' 		=>  $page['limit'],
			'count'			=>  true,
		));

		
		foreach($recordlist as $key=>$record)
		{
			$card_info = unserialize($record['card_info']);
			$card_info['type_label'] = LANG::get($card_info['type']);
			$recordlist[$key]['card_info']  = $card_info;
			
			$recordlist[$key]['status_label'] = Lang::get(strtolower($record['status']));
				
			$member = $this->_member_mod->get(array('conditions'=>'user_id='.$record['user_id'],'fields'=>'user_name'));
			$recordlist[$key]['user_name'] = $member['user_name'];
		}

		$page['item_count'] = $this->_deposit_record_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info',$page);
		$this->assign('filtered', $conditions? 1 : 0); //是否有查询条件
		$this->assign('status_list', array(
			'WAIT_ADMIN_VERIFY'	=>	LANG::get('wait_admin_verify'),
			'SUCCESS' => Lang::get('success'),
            'ACCEPTED'=> Lang::get('accepted'),
			'SHIPPED' => Lang::get('shipped'),
			'CLOSED'  => Lang::get('closed'),
        ));
		$this->assign('search_options', $search_options);
		$this->assign('tradelist', $recordlist);
		
		$this->import_resource(array('script' => 'inline_edit.js,jquery.ui/jquery.ui.js,jquery.ui/i18n/' . i18n_code() . '.js',
                                      'style'=> 'jquery.ui/themes/ui-lightness/jquery.ui.css'));
		$this->display('deposit.tradelist.html');
	}
	
	function drop_trade()
    {
		$this->show_warning('drop_notice');
		return;
		
        $id = (isset($_GET['id']) && $_GET['id'] !='') ? trim($_GET['id']) : '';

        if (!$id){
            $this->show_warning('choose_record');
            return;
        }
		
		$ids = explode(',',$id);
		
		
		foreach($ids as $k=>$id) {
			if(!$this->_deposit_record_mod->get(array('conditions'=>'tradesn='.$id.' AND (status="SUCCESS" OR status="CLOSED") ','fields'=>'record_id'))) {
				unset($ids[$k]);	
			}
		}
        
        $conditions = " tradesn " . db_create_in($ids);
        if (!$res = $this->_deposit_record_mod->drop($conditions))
        {
            $this->show_warning('drop_failed');
            return;
        }
        $this->show_message('drop_ok', 'golist', 'index.php?app=deposit&act=tradelist');
    }
	
	function setting()
	{
		$sys_setting = $this->_deposit_setting_mod->_get_system_setting();
		
		if(!IS_POST)
		{
			foreach($sys_setting as $key=>$val)
			{
				if($val=='0.000') $sys_setting[$key] = 0;
			}
			
			$this->assign('setting', $sys_setting);
			$this->display('deposit.setting.html');
		}
		else
		{
			
			$trade_rate = trim($_POST['trade_rate']);
			$transfer_rate = trim($_POST['transfer_rate']);
			
			
			if(!$this->_check_rate_number(array($trade_rate, $transfer_rate)))
			{
				$this->show_warning('number_error');
				return;
			}
			
			$data_setting = array(
				'user_id'		=>	'0',
				'trade_rate'	=>	$trade_rate,
				'transfer_rate' =>	$transfer_rate,
			);
			
			if($sys_setting)
			{
				$this->_deposit_setting_mod->edit($setting['setting_id'], $data_setting);
			}
			else
			{
				$this->_deposit_setting_mod->add($data_setting);
			}
			
			$this->show_message('edit_ok');			
		}
		
	}
	
	
	function recharge()
	{
		$id = intval($_GET['id']);
		
		if(!$id)
		{
			$this->show_warning('choose_account');
            return;
		}
		
		if(!IS_POST)
		{
			$account = $this->_deposit_account_mod->get($id);
			
			$this->assign('account', $account);
			$this->display('deposit.recharge.html');
		}
		else
		{
			$account = $this->_deposit_account_mod->get($id);
			
			if(!$account)
			{
				$this->show_warning('account_error');
				return;
			}
			
			$money_change = trim($_POST['money_change']);
			$amount 	  = trim($_POST['money']);
			$remark		  = trim($_POST['remark']);
			
			if($amount <= 0)
			{
				$this->show_warning('money_error');
				return;
			}

			if(empty($money_change)) {
				$this->show_message('data_no_change');
				return;
			}
			
			if(!in_array($money_change, array('increase','reduce'))){
				$this->show_warning('recharge_error');
				return;
			}
			
			if($money_change=='increase') 
			{
				$balance = $account['money'] + $amount;
				empty($remark) && $remark = LANG::get('system_recharge');
			}
			else
			{
				$balance = $account['money'] - $amount;
				empty($remark) && $remark = LANG::get('system_chargeback');
			}
			
			if($balance < 0) {
				$this->show_warning('money_error');
				return;
			}

			$time = gmtime();
			$tradesn = $this->_deposit_record_mod->_gen_trade_sn();
			
			$recharge_result = true;
			
			
			if($money_change=='increase')
			{
				$data_recharge = array(
					'tradesn'		=>	$tradesn,
					'user_id'		=>	$account['user_id'],
					'amount'		=>	$amount,
					'status'		=>	'SUCCESS',
					'is_online'		=>	1,
					'extra'    	=>	serialize(array('payway' => Lang::get('system'), 'remark'=>$remark)),
					'add_time'	=>	$time,
					'pay_time'	=>	$time,
					'end_time'	=>	$time,
				);
				
				$recharge_result = $this->_deposit_recharge_mod->add($data_recharge);
			}

			if($recharge_result)
			{
				
				$data_record = array(
					'tradesn'	=>	$tradesn,
					'user_id'	=>	$account['user_id'],
					'party_id'	=>	0,
					'amount'	=>	$amount,
					'balance'	=>	$balance,
					'flow'		=>	$money_change=='increase' ? 'income' : 'outlay',
					'purpose'	=>	$money_change=='increase' ? 'recharge' : 'charge',
					'status'	=>	'SUCCESS',
					'payway'	=>	LANG::get('deposit'),
					'name'		=>	$money_change=='increase' ? LANG::get('recharge') : LANG::get('chargeback'),
					'remark'	=>	$remark,
					'add_time'	=>	$time,
					'pay_time'	=>	$time,
					'end_time'	=>	$time,
				);
				if($this->_deposit_record_mod->add($data_record))
				{
					
					$this->_deposit_account_mod->edit('user_id='.$account['user_id'], array('money'=>$balance));
					
					$this->show_message('edit_ok');
					return;
				}
			}
			$this->show_warning('edit_error');
		}		
	}
	
	function drop()
    {
        $id = (isset($_GET['id']) && $_GET['id'] !='') ? trim($_GET['id']) : '';
        
        $ids = explode(',',$id);
        if (!$id)
        {
            $this->show_warning('choose_record');
            return;
        }
        
        $conditions = " account_id " . db_create_in($ids);
        if (!$res = $this->_deposit_account_mod->drop($conditions))
        {
            $this->show_warning('drop_failed');
            return;
        }
        $this->show_message('drop_ok', 'account_list', 'index.php?app=deposit');
    }
    function edit()
    {
        $id = (isset($_GET['id']) && $_GET['id'] !='') ? intval($_GET['id']) : '';
        
        if (!$id)
        {
            $this->show_warning('choose_record');
            return;
        }

        if (!IS_POST)
        {
            $account = $this->_deposit_account_mod->get($id);
			
			/* 导入jQuery的表单验证插件 */
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js'
            ));
			
            $this->assign('account', $account);
            $this->display('deposit.account.html');
        }
        else
        {
			$password = trim($_POST['password']);
			
            $account = array(
				'account'	=>	trim($_POST['account']),
				'password'	=>	md5(trim($_POST['password'])),
				'real_name'	=>	trim($_POST['real_name']),
				'pay_status'=>	strtoupper($_POST['pay_status'])=='ON' ? 'ON' : 'OFF',
			);
			if(empty($password)) {
				unset($account['password']);
			}
			if($this->_deposit_account_mod->edit($id, $account))
			{
				$this->show_message('edit_ok');
				return;
			}
			$this->show_warning('edit_error');
        }
    }
	
	
	function drawlist()
	{
		$search_options = array(
            'tradesn'   => Lang::get('tradesn'),
            'user_name' => Lang::get('user_name'),
        );
        $conditions = $this->_get_query_conditions(array(
			array(
                'field' => 'add_time',
                'name'  => 'add_time_from',
                'equal' => '>=',
                'handler'=> 'gmstr2time',
            ),array(
                'field' => 'add_time',
                'name'  => 'add_time_to',
                'equal' => '<=',
                'handler'   => 'gmstr2time_end',
            ),array(
                'field' => 'amount',
                'name'  => 'amount_from',
                'equal' => '>=',
                'type'  => 'numeric',
            ),array(
                'field' => 'amount',
                'name'  => 'amount_to',
                'equal' => '<=',
                'type'  => 'numeric',
            ),
        ));
		
		$search_name = trim($_GET['search_name']);
		if(!empty($search_name))
		{
			if($_GET['field']=='user_name') {
				$member = $this->_member_mod->get(array('conditions'=>"user_name='".$search_name."' ",'fields'=>'user_id'));
				if($member) $conditions .= ' AND user_id='.$member['user_id']; else $conditions .= ' AND user_id=0 ';
			} elseif($_GET['field']=='tradesn') {
				$conditions .= " AND tradesn='".$search_name."' ";
			}
		}
		if($_GET['status']){
			$conditions .= " AND status='".trim($_GET['status'])."' ";
		}
		
		$page = $this->_get_page(10);
		
		$recordlist = $this->_deposit_withdraw_mod->find(array(
			'conditions' 	=>  '1=1 ' . $conditions,
			'order'			=>	' withdraw_id desc',
			'limit' 		=>  $page['limit'],
			'count'			=>  true
		));
		
		foreach($recordlist as $key=>$record)
		{
			$card_info = unserialize($record['card_info']);
			$card_info['type_label'] = LANG::get($card_info['type']);
			$recordlist[$key]['card_info']  = $card_info;
			
			$recordlist[$key]['status_label'] = Lang::get(strtolower($record['status']));
				
			$member = $this->_member_mod->get(array('conditions'=>'user_id='.$record['user_id'],'fields'=>'user_name'));
			$recordlist[$key]['user_name'] = $member['user_name'];
		}

		$page['item_count'] = $this->_deposit_withdraw_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info',$page);
		$this->assign('deposit_withdraw', $recordlist);
		
		$this->assign('status_list', array(
			'WAIT_ADMIN_VERIFY'	=>	LANG::get('wait_admin_verify'),
			'SUCCESS' => Lang::get('success'),
        ));
		$this->assign('filtered', $conditions? 1 : 0); //是否有查询条件
		$this->assign('search_options', $search_options);
		$this->assign('tradelist', $recordlist);
		
		$this->import_resource(array('script' => 'inline_edit.js,jquery.ui/jquery.ui.js,jquery.ui/i18n/' . i18n_code() . '.js',
                                      'style'=> 'jquery.ui/themes/ui-lightness/jquery.ui.css'));
		$this->display('deposit.drawlist.html');
	}
	
	
	function withdraw_verify()
	{
		$tradesn = trim($_GET['tradesn']);
		
		if(empty($tradesn)) {
			$this->json_error('edit_error');
            return;
		}
		
		$draw = $this->_deposit_withdraw_mod->get(array(
			'conditions'	=>	" tradesn='".$tradesn."' ",
			'fields'		=>	' record_id,user_id,status,amount',
		));
		
		
		
		if(!$draw || ($draw['status'] != 'WAIT_ADMIN_VERIFY'))
		{
			$this->json_error('verify_error');
            return;
		}
		
		$time = gmtime();

		if($this->_deposit_withdraw_mod->edit($tradesn, array('status'=>'SUCCESS', 'end_time'=>$time)))
		{
			
			$this->_deposit_record_mod->edit($draw['record_id'], array('status'=>'SUCCESS', 'end_time'=>$time));
			
			
			if($this->_deposit_account_mod->_update_deposit_frozen($draw['user_id'], $draw['amount'], 'reduce')){
				$this->json_result('', 'verify_ok');
            	return;
			}
			else
			{
				
					
				$this->json_error('verify_error');
            	return;
			}
		}
		$this->json_error('verify_error');
        return;
	}
	
	
	function withdraw_refuse()
	{
		$tradesn = trim($_GET['tradesn']);
		
		if(empty($tradesn)) {
			$this->show_warning('edit_error');
            return;
		}
		
		$draw = $this->_deposit_withdraw_mod->get(array(
			'conditions'	=>	" tradesn='".$tradesn."' ",
			'fields'		=>	' record_id,user_id,status,amount',
		));
		
		
		
		if(!$draw || ($draw['status'] != 'WAIT_ADMIN_VERIFY'))
		{
			$this->show_warning('verify_error');
            return;
		}
		
		if(!IS_POST)
		{
			$this->display('deposit.draw.refuse.html');
		}
		else
		{
			$remark = trim($_POST['remark']);
			
			if(empty($remark)) {
				$this->show_warning('refuse_remark_empty');
				return;
			}
			
			$time = gmtime();
			
			
			if($this->_deposit_withdraw_mod->edit($tradesn, array('status'=>'CLOSED', 'end_time'=>$time)))
			{
				
				$this->_deposit_record_mod->edit($draw['record_id'], array('status'=>'CLOSED', 'end_time'=>$time, 'remark'=> $remark));
			
				
				if($this->_deposit_account_mod->_update_deposit_frozen($draw['user_id'], $draw['amount'], 'reduce')){
					
					
					$this->_deposit_account_mod->_update_deposit_money($draw['user_id'], $draw['amount'], 'add');
					$this->show_message('refuse_draw_ok', 'back_list', 'index.php?app=deposit&act=drawlist');
					return;
				}
				else
				{
					
					$this->show_warning('verify_error');
					return;
				}
			} else {
				$this->show_warning('verify_error');
			}
		}
	}
	
	function export_draw()
	{
		$conditions = $this->_get_query_conditions(array(
			array(
                'field' => 'add_time',
                'name'  => 'add_time_from',
                'equal' => '>=',
                'handler'=> 'gmstr2time',
            ),array(
                'field' => 'add_time',
                'name'  => 'add_time_to',
                'equal' => '<=',
                'handler'   => 'gmstr2time_end',
            ),array(
                'field' => 'amount',
                'name'  => 'amount_from',
                'equal' => '>=',
                'type'  => 'numeric',
            ),array(
                'field' => 'amount',
                'name'  => 'amount_to',
                'equal' => '<=',
                'type'  => 'numeric',
            ),
        ));
		
		$search_name = trim($_GET['search_name']);
		if(!empty($search_name))
		{
			if($_GET['field']=='user_name') {
				$member = $this->_member_mod->get(array('conditions'=>"user_name='".$search_name."' ",'fields'=>'user_id'));
				if($member) $conditions .= ' AND user_id='.$member['user_id']; else $conditions .= ' AND user_id=0 ';
			} elseif($_GET['field']=='tradesn') {
				$conditions .= " AND tradesn='".$search_name."' ";
			}
		}
		if($_GET['status']){
			$conditions .= " AND status='".trim($_GET['status'])."' ";
		}
		
		$recordlist = $this->_deposit_withdraw_mod->find(array(
			'conditions' 	=>  '1=1 ' . $conditions,
			'order'			=>	' withdraw_id desc',
		));

		import('phpzip.lib');
		$zip = new PHPZip;
		
		$lang_title = array(
			'account_name'		=> '收款人姓名',
			'num' 				=> '收款人银行账号',
			'bank_name' 		=> '开户行',
			'amount'			=> '金额',
			'tradesn'			=> '商户订单号',
		);
		
		/* csv文件数组 */
		$record_value = array();
		
		/* xls文件数组 */
		$record_xls = array();

		$content = implode("\t", $lang_title) . "\n";
		$folder = 'draw_'.local_date('YmdHis', gmtime());

		foreach($recordlist as $key=>$record)
		{
			$card_info = unserialize($record['card_info']);

			$record['account_name'] = $card_info['account_name'];
			$record['num']			= $card_info['num'];
			$record['bank_name']	= $card_info['bank_name'] . $card_info['open_bank'];

			foreach($lang_title as $k=>$v){
				$record_value[$k] = $record[$k];
				$record_xls[$key][$k] = $record[$k];
			}
			
			$content .= implode("\t", $record_value) . "\n";
		}
		
		
		$this->exporttxt($record_xls, $lang_title, $folder);
	}
	
    function exportexcel($data=array(),$title=array(),$filename='report')
	{
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel"); 
        header("Content-Disposition:attachment;filename=".$filename.".txt");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
        if (!empty($title)){
            foreach ($title as $k => $v) {
                $title[$k]=iconv("UTF-8", "GB2312",$v);
            }
            $title= implode("\t", $title);
            echo "$title\n";
        }
        if (!empty($data)){
            foreach($data as $key=>$val){
                foreach ($val as $ck => $cv) {
                    $data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
                }
                $data[$key]=implode("\t", $data[$key]);
                
            }
            echo implode("\n",$data);
        }
    }
	
	function exporttxt($data=array(),$title=array(),$filename='report')
	{
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes"); 
		header("Content-type:application/ms-txt");
		header("Content-Type:text/html; charset=UTF-8");
        header("Content-Disposition:attachment;filename=".$filename.".txt");
        header("Pragma: no-cache");
        header("Expires: 0");
        
		echo "\xEF\xBB\xBF\r\n"; 
        if (!empty($title)){
            foreach ($title as $k => $v) {
                $title[$k]=$v;
            }
            $title= implode("|", $title);
            echo "$title\r\n";
        }
        if (!empty($data)){
            foreach($data as $key=>$val){
                foreach ($val as $ck => $cv) {
                    $data[$key][$ck]=$cv;
                }
                $data[$key]=implode("|", $data[$key]);
                
            }
            echo implode("\r\n",$data);
        }
		
    }

	function drop_draw()
    {
		$this->show_warning('drop_notice');
		return;
		
        $id = (isset($_GET['id']) && $_GET['id'] !='') ? trim($_GET['id']) : '';

        if (!$id){
            $this->show_warning('choose_record');
            return;
        }
		
		$ids = explode(',',$id);
		
		
		foreach($ids as $k=>$id) {
			if(!$this->_deposit_withdraw_mod->get(array('conditions'=>'tradesn='.$id.' AND status="SUCCESS" ','fields'=>'withdraw_id'))) {
				unset($ids[$k]);	
			}
		}
        
        $conditions = " tradesn " . db_create_in($ids);
        if (!$res = $this->_deposit_withdraw_mod->drop($conditions))
        {
            $this->show_warning('drop_failed');
            return;
        }
        $this->show_message('drop_ok', 'golist', 'index.php?app=deposit&act=drawlist');
    }
	
	
	function rechargelist()
	{
		$page = $this->_get_page(10);
		
		$recordlist = $this->_deposit_recharge_mod->find(array(
			'conditions'	=>	"",
			'order'			=>	' recharge_id desc',
			'limit' 		=>  $page['limit'],
			'count'			=>  true
		));

		foreach($recordlist as $key=>$record)
		{
			$recordlist[$key]['extra'] =  unserialize($record['extra']);
			$recordlist[$key]['status_label'] = Lang::get(strtolower($record['status']));
				
			$member = $this->_member_mod->get(array('conditions'=>'user_id='.$record['user_id'],'fields'=>'user_name'));
			$recordlist[$key]['user_name'] = $member['user_name'];
		}
		$page['item_count'] = $this->_deposit_recharge_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info',$page);
		$this->assign('rechargelist', $recordlist);
		$this->display('deposit.rechargelist.html');
	}
	
	
	function recharge_verify()
	{
		$tradesn = trim($_GET['tradesn']);
		
		if(empty($tradesn)) {
			$this->json_error('edit_error');
            return;
		}
		
		$recharge = $this->_deposit_recharge_mod->get(array(
			'conditions'	=>	" tradesn='".$tradesn."' ",
		));
		$recharge['extra'] =  unserialize($recharge['extra']);
		
		
		if(!$recharge || ($recharge['status'] != 'WAIT_ADMIN_VERIFY'))
		{
			$this->json_error('verify_error');
            return;
		}
		
		$done = false;
		$time = gmtime();
		if($this->_deposit_recharge_mod->edit($tradesn,array('status'=>'SUCCESS', 'pay_time'=> $time, 'end_time'=>$time)))
		{
			
			$data_record = array(
				'tradesn'	=>	$tradesn,
				'user_id'	=>	$recharge['user_id'],
				'amount'	=>	$recharge['amount'],
				'balance'	=>	$this->_deposit_account_mod->_get_deposit_balance($recharge['user_id']) + $recharge['amount'],
				'flow'		=>	'income',
				'purpose'	=>	'recharge',
				'status'	=>	'SUCCESS',
				'payway'	=>	$recharge['extra']['payway'],
				'name'		=>	LANG::get('recharge'),
				'remark'	=>	$recharge['extra']['remark'],
				'add_time'	=> 	$recharge['add_time'],
				'pay_time'	=>	$time,
				'end_time'	=>	$time,
			);
			
			if($this->_deposit_record_mod->add($data_record))
			{
				
				if($this->_deposit_account_mod->_update_deposit_money($recharge['user_id'], $recharge['amount'], 'add')) {
					$done = true;
				}
			}
		}
		if($done === true) {
			$this->json_result('','verify_ok');
        	return;
		}
		$this->json_error('verify_error');
        return;
	}
	
	function drop_recharge()
    {
		$this->show_warning('drop_notice');
		return;
		
        $id = (isset($_GET['id']) && $_GET['id'] !='') ? trim($_GET['id']) : '';

        if (!$id){
            $this->show_warning('choose_record');
            return;
        }
		
		$ids = explode(',',$id);
		
		
		foreach($ids as $k=>$id) {
			if(!$this->_deposit_recharge_mod->get(array('conditions'=>'tradesn='.$id.' AND (status="SUCCESS" OR status="PENDING") ','fields'=>'recharge_id'))) {
				unset($ids[$k]);
			}
		}
        
        $conditions = " tradesn " . db_create_in($ids);
        if (!$res = $this->_deposit_recharge_mod->drop($conditions))
        {
            $this->show_warning('drop_failed');
            return;
        }
        $this->show_message('drop_ok', 'golist', 'index.php?app=deposit&act=rechargelist');
    }
	
	
    function check_account()
    {
          $account = empty($_GET['account']) ? null : trim($_GET['account']);
		  $id 	   = intval($_GET['id']);
		  
		  
          if (!$account || !$id)
          {
              echo ecm_json_encode(false);
              return ;
          }
		  
		  $deposit_account = $this->_deposit_account_mod->get(array('conditions'=>'account_id !='.$id." AND account='".$account."' ", 'fields'=>'account_id'));
		  
		  if(!$deposit_account) {
			  echo ecm_json_encode(true);
			  return;
		  }
		  echo ecm_json_encode(false);
    }
	
	function _check_rate_number($data)
	{
		if(!is_array($data)) $data = array($data);
		
		foreach($data as $rate)
		{
			if($rate !='' && (!is_numeric($rate) || $rate>1 || $rate<0))
			{
				return false;
			}
		}
		return true;
	}
}

?>