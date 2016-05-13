<?php

/**
 
 *
 *    @author   psmb
 *    @usage    none
 */
class OutlayDepopay extends BaseDepopay
{
    var $_flow_name = 'outlay';
	
	
	function _handle_trade_info($trade_info, $post, $purpose_name='')
	{
		
		if($purpose_name == 'refund'){
			return true;
		}
		
		
		if(isset($trade_info['amount'])) {
			
			$money = $trade_info['amount'];
			if($money < 0) return false;
			
			
			if(isset($trade_info['fee'])) {
				if($trade_info['fee'] < 0) return false;
				
				$money += $trade_info['fee'];
			}
			
			return parent::_check_enough_money($money, $trade_info['user_id']);
		}
		
		return true;
	}
	
	
	function _get_deposit_balance($user_id, $amount=0)
	{
		$money = parent::_get_deposit_balance($user_id);
		
		
		if(!$amount) return $money;
		
		return $money - $amount;
	}
	
	
}

?>
