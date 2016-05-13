<?php

/**
 
 *    @author   psmb
 *    @usage    none
 */
class RechargeIncome extends IncomeDepopay
{
    var $_purpose_name = 'recharge';
	
	
	function submit($data)
	{
	
        extract($data);
        
        $base_info = $this->_handle_trade_info($trade_info, $post);
		if (!$base_info)
        {
            
            return false;
        }
		
		
		
		if($extra_info['is_online']==1)
		{
			$tradesn = $trade_info['tradesn'];
		}
		
		
		else
		{
			$bank_info = $this->_handle_bank_info($post['bid'], $trade_info['user_id']);
        	if (!$bank_info)
        	{
            	
            	return false;
        	}
			
			$tradesn = $this->_gen_trade_sn();
		}
		
		
		$this->_insert_recharge_info($tradesn, $trade_info, $extra_info, $post);
					
		return $tradesn;
	}
	

	function _insert_recharge_info($tradesn, $trade_info, $extra_info, $post)
	{
		$deposit_recharge_mod = &m('deposit_recharge');
		
		if($extra_info['is_online']==1) {
			$extra 	= serialize(array('payway' => Lang::get($extra_info['payment_code']), 'payment_code' => $extra_info['payment_code'], 'remark'=>$post['remark']));
			$status = 'PENDING'; 
		}
		else
		{
			$bank = $this->_get_bank_info(intval($post['bid']));
			unset($bank['bid'],$bank['user_id']);

			$extra = serialize(array_merge(array('payway'=>$bank['bank_name'], 'remark'=>$post['remark']),$bank));
			
			$status = 'WAIT_ADMIN_VERIFY';
		}
		
		$time = gmtime();
		$data_recharge = array(
			'tradesn'		=>	$tradesn,
			'user_id'		=>	$trade_info['user_id'],
			'amount'		=>	$trade_info['amount'],
			'status'		=>	$status,
			'is_online'		=>	$extra_info['is_online'] ? intval($extra_info['is_online']) : 0,
			'extra'         =>  $extra, 
			'add_time'		=>	$time,
		);

		return $deposit_recharge_mod->add($data_recharge);
	}
	
	function _handle_bank_info($bid, $user_id)
	{
		$bank_mod = &m('bank');
		
		return $bank_mod->_check_bank_of_user($bid, $user_id);
	}
	

	function respond_notify($tradesn, $notify_result)
	{
		$deposit_account_mod = &m('deposit_account');
		$deposit_record_mod = &m('deposit_record');
		$deposit_recharge_mod = &m('deposit_recharge');
		$where = "tradesn = {$tradesn}";
		
		
		if(($notify_result['target'] == 'SUCCESS') || ($notify_result['target'] == 'ACCEPTED'))
		{
			$where .= ' AND status="PENDING" ';
			$time   = gmtime();
			if($trade_info = $deposit_recharge_mod->get($where)) {
				
				$deposit_recharge_mod->edit($where, array('status'=>'SUCCESS', 'pay_time'=>$time, 'end_time'=> $time));
				
				$extra = unserialize($trade_info['extra']);
				
				$balance = $this->_get_deposit_balance($trade_info['user_id'], $trade_info['amount']); // 增加后的余额
				
				
				$data_record = array(
					'tradesn'  => $tradesn,
					'user_id'  => $trade_info['user_id'],
					'party_id' => 0,
					'amount'   => $trade_info['amount'],
					'balance'  => $balance,
					'flow'     => $this->_flow_name,
					'purpose'  => $this->_purpose_name,
					'status'   => 'SUCCESS',
					'payway'   => Lang::get($extra['payment_code']),
					'name'     => Lang::get('recharge') . ' - ' . Lang::get($extra['payment_code']) . Lang::get('online_recharge'),
					'remark'   => $extra['remark'],
					'add_time' => $trade_info['add_time'],
					'pay_time' => $time,
					'end_time' => $time,
				);
				if($deposit_record_mod->add($data_record))
				{
					
					$deposit_account_mod->edit('user_id='.$trade_info['user_id'], array('money'=>$balance));
				}
			}
		}
	}
}

?>
