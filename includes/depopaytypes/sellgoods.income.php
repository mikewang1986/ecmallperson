<?php

/**
 
 *    @author   psmb
 *    @usage    none
 */
class SellgoodsIncome extends IncomeDepopay
{
    var $_purpose_name = 'sellgoods';
	
	
	function submit($data)
	{
	
        extract($data);
        
        $base_info = $this->_handle_trade_info($trade_info, $post);
		$order_info = $this->_handle_order_info($extra_info);
        if (!$base_info || !$order_info)
        {
            
            return false;
        }
		
		
		$tradesn = $this->_get_trade_sn($extra_info['order_sn']);
		
		
		if(!$this->_insert_record_info($tradesn, $trade_info, $extra_info)) {
			return false;
		}
		
	
		if($trade_rate = $this->_get_deposit_setting($trade_info['user_id'], 'trade_rate')) {
			parent::_sys_chargeback($tradesn, $trade_info, $trade_rate, 'trade_fee');
		}
		
		return $tradesn;
	}
	

	function _insert_record_info($tradesn, $trade_info, $extra_info)
	{
		$time = gmtime();
		$deposit_record_mod = &m('deposit_record');
		
	
		if($extra_info['change_order_status'] === true) {
			$deposit_record_mod->edit("order_sn='".$extra_info['order_sn']."' AND user_id=".$trade_info['party_id'], array('status'=>'SUCCESS','end_time'=>$time));
		}
		
		$data_record = $deposit_record_mod->get("order_sn='".$extra_info['order_sn']."' AND user_id=".$trade_info['party_id']);
		unset($data_record['record_id']);
			
		
		$data_record['user_id']	=	$trade_info['user_id']; 
		$data_record['party_id']=	$trade_info['party_id'];
		$data_record['amount']  =   $trade_info['amount'];
		$data_record['balance']	=	$this->_get_deposit_balance($trade_info['user_id'], $trade_info['amount']); 
		$data_record['flow']	=	$this->_flow_name;
		$data_record['purpose']	=	$this->_purpose_name;
		$data_record['status']  = 	'SUCCESS';
		$data_record['end_time']=   $time;
			
		
		return parent::_insert_deposit_record($data_record);
	}
	
	
	
	function _get_trade_sn($order_sn)
	{
		$deposit_record_mod  = &m('deposit_record');
		$depoist_record = $deposit_record_mod->get(array('conditions'=>"order_sn='".$order_sn."' AND status='SHIPPED' ",'fields'=>'tradesn'));
		
		return $depoist_record['tradesn'];
	}
	
	
}

?>
