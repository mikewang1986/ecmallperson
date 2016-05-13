<?php

/* 商品积分数据模型 */
class Goods_integralModel extends BaseModel
{
    var $table  = 'goods_integral';
    var $prikey = 'goods_id';
    var $alias  = 'gi';
    var $_name  = 'goods_integral';
	
	var $_relation  = array(
        // 一个商品积分设置只能属于一个商品
        'belongs_to_goods' => array(
            'model'         => 'goods',
            'type'          => BELONGS_TO,
            'foreign_key'   => 'goods_id',
            'reverse'       => 'has_goodsintegral',
        ),
    );
}

?>
