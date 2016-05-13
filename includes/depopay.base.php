<?php

!defined('ROOT_PATH') && exit('Forbidden');

/**
 *    预付款支付类型基类
 *
 *    @author   psmb
 *    @usage    none
 */
class BaseDepopay extends Object
{
	var $_deposit_account_mod;
	
	var $_deposit_record_mod;
	var $_deposit_withdraw_mod;
	var $_deposit_setting_mod;
	
    function __construct($params)
    {
        $this->BaseDepopay($params);
    }
    function BaseDepopay($params)
    {
        if (!empty($params))
        {
            foreach ($params as $key => $value)
            {
                $this->$key = $value;
            }
        }
		
		$this->_deposit_account_mod		= &m('deposit_account');
		
		$this->_deposit_record_mod 		= &m('deposit_record');
		$this->_deposit_withdraw_mod 	= &m('deposit_withdraw');
		$this->_deposit_setting_mod		= &m('deposit_setting');
		
    }
	
	
	function _check_enough_money($money, $user_id)
	{
		$deposit_account_mod = &m('deposit_account');
		
		return $deposit_account_mod->_check_enough_money($money, $user_id);
	}
	
	
	function _get_deposit_balance($user_id, $fields = 'money')
	{
		$deposit_account_mod = &m('deposit_account');
		
		return $deposit_account_mod->_get_deposit_balance($user_id, $fields);
	}
	
	
	function _insert_deposit_record($data, $change_balance=true)
	{
		$deposit_record_mod = &m('deposit_record');
		$deposit_account_mod = &m('deposit_account');
		
		if($record_id = $deposit_record_mod->add($data))
		{
			
			if($change_balance)
			{
				if($deposit_account_mod->edit('user_id='.$data['user_id'], array('money'=>$data['balance']))) {
					return $record_id;
				}
				else
				{
				
					$deposit_record_mod->drop('record_id='.$record_id);
				
					return false;
				}
			}
		}
		return false;
	}
	
	
	function _sys_chargeback($tradesn, $trade_info, $rate, $type='trade_fee')
	{
		$fee  = round($trade_info['amount'] * $rate, 2);
		
		$time = gmtime();
		
		if(is_array($type) || empty($type)) {
			$remark	= LANG::get('trade_fee').'['.$tradesn.']';
		} else $remark = LANG::get($type).'['.$tradesn.']';
		
		$data_record = array(
			'tradesn'	=>	$this->_gen_trade_sn(),
			'user_id'	=>	$trade_info['user_id'],
			'party_id'	=>	0,
			'amount'	=>	$fee,
			'balance'	=>	$this->_get_deposit_balance($trade_info['user_id']) - $fee,
			'flow'		=>	'outlay',
			'purpose'	=>	'charge',
			'status'	=>	'SUCCESS',
			'payway'	=>	LANG::get('deposit'),
			'name'		=>	LANG::get('chargeback'),
			'remark'	=>	$remark,
			'add_time'	=>	$time,
			'pay_time'	=>	$time,
			'end_time'	=>	$time,
		);
		
		return $this->_insert_deposit_record($data_record);
	}
	
	
	function _update_deposit_frozen($user_id, $amount, $change='add')
	{
		if(!$user_id || $amount < 0) return false;
		
		$deposit_account_mod = &m('deposit_account');
		
		return $deposit_account_mod->_update_deposit_frozen($user_id, $amount, $change);
	}
	
	
	function _update_order_status($order_id, $data)
	{
		if(!$order_id) return;

		$order_mod = &m('order');
		return $order_mod->edit($order_id, $data);
	}
	
	function _get_record_info($record_id)
	{
		if(!$record_id) return false;
		
		$deposit_record_mod = &m('deposit_record');
		
		return $deposit_record_mod->get('record_id='.$record_id);
	}
	
	function _get_bank_info($bid)
	{
		if(!$bid)  return;
		
		$bank_mod = &m('bank');
		
		return $bank_mod->get($bid);
		
	}
	
	function _get_deposit_setting($user_id=0, $fields='')
	{
		$result = $this->_deposit_setting_mod->_get_deposit_setting($user_id,$fields);
		
		if(empty($fields)) return $result;
		
		if($result <0 || $result>1) return 0;
		
		return $result;
	}
	
	function _get_intro_by_order($order_id)
	{
		$intro = '';
		if(!$order_id) return $intro;
		
		$ordergoods_mod = &m('ordergoods');
		$order_goods = $ordergoods_mod->find(array('conditions'=>"order_id={$order_id}",'fields'=>'goods_name'));
			
		$first_goods = current($order_goods);
		if(count($order_goods) > 1) {
			$intro = $first_goods['goods_name'] . LANG::get('and_more');
		} else {
			$intro = $first_goods['goods_name'];
		}
		return $intro;
	}

    /**
     *    生成交易号
     *
     *    @author    psmb
     *    @return    string
     */
    function _gen_trade_sn()
    {
        $deposit_record_mod =& m('deposit_record');
		
        return  $deposit_record_mod->_gen_trade_sn();
    }

}

?>