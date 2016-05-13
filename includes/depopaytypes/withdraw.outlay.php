<?php

/**
 
 *    @author   psmb
 *    @usage    none
 */
class WithdrawOutlay extends OutlayDepopay
{
    var $_purpose_name = 'withdraw';
	
	
	function submit($data)
	{
	
        extract($data);
        
        $base_info = $this->_handle_trade_info($trade_info, $post);
		$bank_info = $this->_handle_bank_info($post['bid'], $trade_info['user_id']);
        if (!$base_info || !$bank_info)
        {
            
            return false;
        }
		
		$tradesn = $this->_gen_trade_sn();
		
	
		if(!$record_id = $this->_insert_record_info($tradesn, $trade_info, $post)) {
			return false;
		}
		
	
		if(!$this->_update_deposit_frozen($trade_info['user_id'], $trade_info['amount'], 'add')) {
			return false;
		}
		
		
		$this->_insert_withdraw_info($tradesn, $trade_info, $post, $record_id);
					
		return $tradesn;
	}
	
	
	function _insert_record_info($tradesn, $trade_info, $post)
	{
		$bank = $this->_get_bank_info(intval($post['bid']));
		
		$time = gmtime();
		$data_record = array(
			'tradesn'	=>	$tradesn,
			'order_sn'	=>	'',
			'user_id'	=>	$trade_info['user_id'],
			'party_id'	=>	0,
			'amount'	=>	$trade_info['amount'],
			'balance'	=>	$this->_get_deposit_balance($trade_info['user_id'], $trade_info['amount']), 
			'flow'		=>	$this->_flow_name,
			'purpose'	=>	$this->_purpose_name,
			'status'	=>	'WAIT_ADMIN_VERIFY',
			'payway'	=>	$bank['bank_name'],
			'name'		=>	LANG::get(strtolower($this->_purpose_name)),
			'remark'	=>	'',
			'add_time'	=>	$time,
			'pay_time'	=>	$time,
		);
		return parent::_insert_deposit_record($data_record);
	}
	
	function _insert_withdraw_info($tradesn, $trade_info, $post, $record_id)
	{
		$deposit_withdraw_mod = &m('deposit_withdraw');
		
		$bank = $this->_get_bank_info(intval($post['bid']));
		unset($bank['bid'],$bank['user_id']);
		
		$record = $this->_get_record_info($record_id);
		$data_draw = array(
			'record_id'	=>	$record['record_id'],
			'tradesn'	=>	$tradesn,
			'user_id'	=>	$trade_info['user_id'],
			'amount'	=>	$trade_info['amount'],
			'status'	=>	$record['status'],
			'card_info'	=>	serialize($bank),
			'add_time'	=>	$record['add_time'],
			'pay_time'	=>	$record['pay_time'],
		);
		
		return $deposit_withdraw_mod->add($data_draw);
	}
	
	function _handle_bank_info($bid, $user_id)
	{
		$bank_mod = &m('bank');
		
		return $bank_mod->_check_bank_of_user($bid, $user_id);
	}
}

?>
