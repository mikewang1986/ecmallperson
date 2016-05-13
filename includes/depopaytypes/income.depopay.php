<?php

/**
 
 *    @author   psmb
 *    @usage    none
 */
class IncomeDepopay extends BaseDepopay
{
    var $_flow_name = 'income';
	
	
	function _handle_trade_info($trade_info, $post)
	{
		
		if(isset($trade_info['amount'])) {
			
			$money = $trade_info['amount'];
			
		
			if(isset($trade_info['fee'])) {
				$fee = $trade_info['fee'];
				if($fee < 0 || ($money < $fee)) return false;
			}
			
			if($money < 0) return false;
		}

		return true;
	}
	
	function _handle_order_info($extra_info)
	{
		
		if(!isset($extra_info['order_sn']) || empty($extra_info['order_sn'])) {
			return false;
		}
		return true;
	}
	
	
	function _get_deposit_balance($user_id, $amount=0)
	{
		$money = parent::_get_deposit_balance($user_id);
		
		
		if(!$amount) return $money;
		
		return $money + $amount;
	}
	
	
}

?>
