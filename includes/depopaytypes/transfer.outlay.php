<?php

/**
 
 *
 *    @author   psmb
 *    @usage    none
 */
class TransferOutlay extends OutlayDepopay
{
    var $_purpose_name = 'transfer';
	
	
	function submit($data)
	{
		
        extract($data);
        
        $base_info = $this->_handle_trade_info($trade_info, $post);
        if (!$base_info)
        {
            
            return false;
        }
		
		$tradesn = $this->_gen_trade_sn();
		
		
		if(!$this->_insert_record_info($tradesn, $trade_info)) {
			return false;
		}
		
		
		if($transfer_rate = $this->_get_deposit_setting($trade_info['user_id'], 'transfer_rate')) {
			parent::$this->_sys_chargeback($tradesn, $trade_info, $transfer_rate, 'transfer_fee');
		}
					
		return $tradesn;
	}
	
	
	function _insert_record_info($tradesn, $trade_info)
	{
		$time = gmtime();
		
		
		$data_record = array(
			'tradesn'	=>	$tradesn,
			'user_id'	=>	$trade_info['user_id'],
			'party_id'	=>	$trade_info['party_id'],
			'amount'	=>	$trade_info['amount'],
			'balance'	=>	$this->_get_deposit_balance($trade_info['user_id'], $trade_info['amount']), // 扣除后的余额
			'flow'		=>	$this->_flow_name,
			'purpose'	=>	$this->_purpose_name,
			'status'	=>	'SUCCESS',
			'payway'	=>	LANG::get('deposit'),
			'name'		=>	LANG::get(strtolower($this->_purpose_name)),
			'remark'	=>	'',
			'add_time'	=>	$time,
			'pay_time'	=>	$time,
			'end_time'	=>	$time,
		);
		parent::_insert_deposit_record($data_record);
		
		
		$data_record['user_id']		= 	$trade_info['party_id'];
		$data_record['party_id'] 	=	$trade_info['user_id'];
		$data_record['balance']		=	$this->_get_deposit_balance($trade_info['party_id']) + $trade_info['amount']; // 增加后的余额
		$data_record['flow']		=	'income';

		return parent::_insert_deposit_record($data_record);
	}
}

?>
