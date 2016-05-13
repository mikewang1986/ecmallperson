<?php

class Deposit_settingModel extends BaseModel
{
    var $table  = 'deposit_setting';
    var $prikey = 'setting_id';
    var $_name  = 'deposit_setting';
	
	function _get_system_setting()
	{
		if($setting = $this->get(array('conditioins'=>'user_id=0'))){
			return $setting;
		}
		
		return array();
	}
	
	function _get_deposit_setting($user_id = 0, $fields='')
	{
		if(!$user_id) 
		{
			$setting = $this->_get_system_setting();
		}
		else
		{
			$setting = $this->get(array('conditions'=>'user_id='.$user_id));
			
			if(!$setting) {
				$setting = $this->_get_system_setting();
			}
		}
		
		if(empty($fields))
		{
			return $setting;
		}
		
		$result = $setting[$fields];
		
		if($result <0 || $result>1) return 0;
		
		return $result;
	}
} 

?>