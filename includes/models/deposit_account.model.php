<?php

class Deposit_accountModel extends BaseModel
{
    var $table  = 'deposit_account';
    var $prikey = 'account_id';
    var $_name  = 'deposit_account';
	
	function _check_account($account, $user_id)
	{
		if(empty($account)) {
			return false;
		}
		if($this->get(array('conditions'=>"account='".$account."' AND user_id !=".$user_id,'fields'=>'account_id'))){
			return false;
		}
		return true;
	}
	
	function _get_account_info($user_id)
	{
		if(!$user_id) return;
		
		return $this->get('user_id='.$user_id);
	}
	
	function _check_enough_money($money, $user_id=0)
	{
		if(empty($money) || !$user_id) return false;
		
		$deposit_account = $this->get(array('conditions'=>'user_id='.$user_id,'fields'=>'money'));
		if(!$deposit_account) return false;
		
		$total_money = $deposit_account['money'];
		
		return $total_money >= $money;
	}
	
	
	function _check_account_password($password, $ext=0)
	{
		if(empty($password) || !$ext) return false;
		
		if(is_numeric($ext)) {
			$conditions = 'user_id='.$ext;
		} else {
			$conditions = "account='".$ext."'";
		}
		if($this->get(array('conditions'=>$conditions." AND password='".md5($password)."'",'fields'=>'account_id'))){
			return true;
		}
		return false;

	}
	
	
	function _get_deposit_balance($user_id, $fields = 'money')
	{
		if(!$user_id) return;
		
		if(!in_array($fields, array('money','frozen'))) $fields = 'money';
		
		$deposit_account = $this->get(array('conditions'=>'user_id='.$user_id,'fields'=>'money,frozen'));
		
		return $deposit_account[$fields];
	}
	
	
	function _update_deposit_money($user_id, $amount, $change='add')
	{
		if(!$user_id || $amount < 0) return false;
		
		$money = $this->_get_deposit_balance($user_id);
		
		if($change=='add') {
			$money += $amount;
		}
		else 
		{
			if($money < $amount) return false;
			
			$money = $money - $amount;
		}
		
		return parent::edit('user_id='.$user_id, array('money'=>$money));
	}
	
	
	function _update_deposit_frozen($user_id, $amount, $change='add')
	{
		if(!$user_id || $amount < 0) return false;
		
		$frozen = $this->_get_deposit_balance($user_id, 'frozen');
		if($change=='add') {
			$frozen += $amount;
		} else $frozen = $frozen - $amount;
		
		return parent::edit('user_id='.$user_id, array('frozen'=>$frozen));
	}
	
	
	function _check_pay_status($user_id = 0)
	{
		if(!$user_id) return false;
		
		$deposit_account = parent::get(array('conditions'=>'user_id='.$user_id,'fields'=>'pay_status'));
		if($deposit_account && strtoupper($deposit_account['pay_status']) == 'ON') {
			return true;
		}
		return false;
	}
} 

?>