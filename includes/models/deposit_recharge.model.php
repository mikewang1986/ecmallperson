<?php

class Deposit_rechargeModel extends BaseModel
{
    var $table  = 'deposit_recharge';
    var $prikey = 'tradesn';
    var $_name  = 'deposit_recharge';
	
	var $_relation = array(
	
		'belongs_to_record' => array(
            'model'         => 'deposit_record',
            'type'          => HAS_ONE,
            'foreign_key'   => 'tradesn',
            'dependent'     => true
        ),
	);
} 

?>