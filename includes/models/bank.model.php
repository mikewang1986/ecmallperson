<?php

class BankModel extends BaseModel
{
    var $table  = 'bank';
    var $prikey = 'bid';
    var $_name  = 'bank';
	
	function _check_bank_of_user($bid, $user_id=0)
	{
		if(!$user_id || !$bid) return false;
		
		if($this->get(array('conditions'=>'bid='.$bid.' AND user_id='.$user_id))){
			return true;
		}
		return false;
	}
	
	function _get_bank_name($bid)
	{
		if(!$bid) return '';
		
		$bank_info = $this->get($bid);
		
		if($bank_info) {
			return $bank_info['bank_name'];
		}
		return '';
	}

}

?>