<?php

/* 订单 order */
class OrderModel extends BaseModel
{
    var $table  = 'order';
    var $alias  = 'order_alias';
    var $prikey = 'order_id';
    var $_name  = 'order';
    var $_relation  = array(
        // 一个订单有一个实物商品订单扩展
        'has_orderextm' => array(
            'model'         => 'orderextm',
            'type'          => HAS_ONE,
            'foreign_key'   => 'order_id',
            'dependent'     => true
        ),
		
		'has_virtuallog' => array(

            'model'         => 'virtuallog',

            'type'          => HAS_ONE,

            'foreign_key'   => 'order_id',

            'dependent'     => true

        ),
		
        // 一个订单有多个订单商品
        'has_ordergoods' => array(
            'model'         => 'ordergoods',
            'type'          => HAS_MANY,
            'foreign_key'   => 'order_id',
            'dependent'     => true
        ),
        // 一个订单有多个订单日志
        'has_orderlog' => array(
            'model'         => 'orderlog',
            'type'          => HAS_MANY,
            'foreign_key'   => 'order_id',
            'dependent'     => true
        ),
        'belongs_to_store'  => array(
            'type'          => BELONGS_TO,
            'reverse'       => 'has_order',
            'model'         => 'store',
        ),
        'belongs_to_user'  => array(
            'type'          => BELONGS_TO,
            'reverse'       => 'has_order',
            'model'         => 'member',
        ),
    );

    /**
     *    修改订单中商品的库存，可以是减少也可以是加回
     *
     *    @author    Garbin
     *    @param     string $action     [+:加回， -:减少]
     *    @param     int    $order_id   订单ID
     *    @return    bool
     */
    function change_stock($action, $order_id)
    {
        if (!in_array($action, array('+', '-')))
        {
            $this->_error('undefined_action');

            return false;
        }
        if (!$order_id)
        {
            $this->_error('no_such_order');

            return false;
        }

        /* 获取订单商品列表 */
        $model_ordergoods =& m('ordergoods');
        $order_goods = $model_ordergoods->find("order_id={$order_id}");
        if (empty($order_goods))
        {
            $this->_error('goods_empty');

            return false;
        }

        $model_goodsspec =& m('goodsspec');
        $model_goods =& m('goods');

        /* 依次改变库存 */
        foreach ($order_goods as $rec_id => $goods)
        {
            $model_goodsspec->edit($goods['spec_id'], "stock=stock {$action} {$goods['quantity']}");
            $model_goods->clear_cache($goods['goods_id']);
        }

        /* 操作成功 */
        return true;
    }
	
	//新增
function change_seckill_stock($action, $order_id){
        if (!in_array($action, array('+', '-')))
        {
            $this->_error('undefined_action');

            return false;
        }
        if (!$order_id)
        {
            $this->_error('no_such_order');

            return false;
        }

        /* 获取订单商品列表 */
        $model_ordergoods =& m('ordergoods');
        $order_goods = $model_ordergoods->find("order_id={$order_id}");
        if (empty($order_goods))
        {
            $this->_error('goods_empty');

            return false;
        }

        $model_seckill =& m('seckill');
        /*查找当前秒杀商品*/
        $seckill_info = $model_seckill->find(array(
            'conditions' => 'sec_state='.SECKILL_START,
            'fields' => 'goods_id',
        )); 
        $seckill_info = empty($seckill_info) ? array() : $seckill_info;
        foreach ($seckill_info as $sec_key => $sec_val){
        	$seckill_info[$sec_val['goods_id']] = $sec_key;
        }
        /* 依次改变库存 */
        foreach ($order_goods as $rec_id => $goods)
        {
        	if(key_exists($goods['goods_id'],$seckill_info)){
                $model_seckill->edit('goods_id='.$goods['goods_id'].' AND sec_state='.SECKILL_START, "sec_quantity=sec_quantity {$action} {$goods['quantity']}");
            }
        }
        /* 操作成功 */
        return true;
    }
	
}

?>
