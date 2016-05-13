<?php

/**
 *
 *    @author   psmb
 *    @usage    none
 */
class BuygoodsOutlay extends OutlayDepopay
{
    var $_purpose_name = 'buygoods';
	
	
	function submit($data)
	{
		
        extract($data);
        
        $base_info = $this->_handle_trade_info($trade_info, $post);
		
        if (!$base_info)
        {
            
            return false;
        }
		
		$tradesn = $this->_gen_trade_sn();
		
		
		if(!$this->_insert_record_info($tradesn, $trade_info, $extra_info)) {
			return false;
		}
		
	
		$this->_update_order_status($extra_info['order_id'], array('status'=> ORDER_ACCEPTED));
					
		return $tradesn;
	}
	
	
	function _insert_record_info($tradesn, $trade_info, $extra_info)
	{
		$order_id = $extra_info['order_id'];
		
		if($order_id){
			$intro = $this->_get_intro_by_order($order_id);
		} else $intro = '';
		
		$time = gmtime();
		$data_record = array(
			'tradesn'	=>	$tradesn,
			'order_sn'	=>	$extra_info['order_sn'],
			'user_id'	=>	$trade_info['user_id'],
			'party_id'	=>	$trade_info['party_id'],
			'amount'	=>	$trade_info['amount'],
			'balance'	=>	$this->_get_deposit_balance($trade_info['user_id'], $trade_info['amount']), // 扣除后的余额
			'flow'		=>	$this->_flow_name,
			'purpose'	=>	$this->_purpose_name,
			'status'	=>	'ACCEPTED',
			'payway'	=>	LANG::get('deposit'),
			'name'		=>	LANG::get('defray') . ' - ' . $intro,
			'remark'	=>	'',
			'add_time'	=>	$time,
			'pay_time'	=>	$time,
		);
		return parent::_insert_deposit_record($data_record);
	}
	
}

?>
