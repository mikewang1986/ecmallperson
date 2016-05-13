<?php

/* 订单商品 ordergoods */
class OrdergoodsModel extends BaseModel
{
    var $table  = 'order_goods';
    var $prikey = 'rec_id';
    var $_name  = 'ordergoods';
    var $_relation = array(
        // 一个订单商品只能属于一个订单
        'belongs_to_order' => array(
            'model'         => 'order',
            'type'          => BELONGS_TO,
            'foreign_key'   => 'order_id',
            'reverse'       => 'has_ordergoods',
        ),
    );
	
	
	function get_order_adjust_rate($order_info)
	{
		$goods_amount_after_adjust = $order_info['goods_amount']; 
		$goods_amount_before_adjust = $adjust_fee = 0;
			
		$ordergoods = parent::find(array('conditions'=>"order_id=".$order_info['order_id'],'fields'=>'price,quantity'));
		foreach($ordergoods as $goods){
			$goods_amount_before_adjust += $goods['price'] * $goods['quantity'];
		}
		$adjust_fee = $goods_amount_before_adjust - $goods_amount_after_adjust; 

		if($adjust_fee !=0){ 
			if($goods_amount_before_adjust >0) { 
				$adjust_rate = 1 - round($adjust_fee / $goods_amount_before_adjust, 6);
			}
			else $adjust_rate = -1;
		} 
		else {
			$adjust_rate = 1;
		}
		
		return $adjust_rate;
	}
}

?>