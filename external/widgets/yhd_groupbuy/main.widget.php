<?php

/**
 * 推荐团购挂件
 *
 * @return  array
 */
class Yhd_groupbuyWidget extends BaseWidget
{
    var $_name = 'yhd_groupbuy';
    var $_ttl  = 1800;

    function _get_data()
    {
        $cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
		
        if($data === false)
        {
			if ((empty($this->options['amount']) || intval($this->options['amount'])<=0)){$this->options['amount']=1;}
            $model_groupbuy =& m('groupbuy');
			$goods_spec_mod =& m('goods_spec');
            $groupbuy_list = $model_groupbuy->find(array(
                'join'  => 'belong_goods',
                'conditions'    => $model_groupbuy->getRealFields(' this.recommended=1 AND this.state=' . GROUP_ON . ' AND this.end_time>' . gmtime()),
                'fields'    => 'group_id,goods.price, goods.default_image, group_name, end_time, spec_price,min_quantity',
                'order' => 'group_id DESC',
                'limit' => intval($this->options['amount']),
            ));
			if ($ids = array_keys($groupbuy_list))
			{
				$quantity = $model_groupbuy->get_join_quantity($ids);
			}
            if ($groupbuy_list)
            {
                foreach ($groupbuy_list as $gb_id => $gb_info)
                {
					$groupbuy_list[$gb_id]['quantity'] = empty($quantity[$gb_id]['quantity']) ? 0 : $quantity[$gb_id]['quantity'];
                    $price = current(unserialize($gb_info['spec_price']));
                    empty($gb_info['default_image']) && $groupbuy_list[$gb_id]['default_image'] = Conf::get('default_goods_image');
                    $groupbuy_list[$gb_id]['lefttime']   = lefttime($gb_info['end_time']);
                    $groupbuy_list[$gb_id]['group_price']      = $price['price'];
					
					/*节省的价格 by tyioocom */
					$groupbuy_list[$gb_id]['price_save'] = round($groupbuy_list[$gb_id]['price'] - $groupbuy_list[$gb_id]['group_price'],2);
					/* 计算折扣 by tyioocom */
					$groupbuy_list[$gb_id]['discount'] = round($groupbuy_list[$gb_id]['group_price']/$groupbuy_list[$gb_id]['price'] * 10,1); 
					
					/*计算库存商品数及还可团购数  modify by tyioocom*/
					$goods_spec = $goods_spec_mod->find(array('conditions'=>'goods_id='.$gb_id,'fields'=>'goods_id,stock'));
					$goods_total = 0;
					foreach($goods_spec as $val)
					{
						$goods_total += intval($val['stock']); 
					}
					$groupbuy_list[$gb_id]['remain'] = $goods_total - $groupbuy_list[$gb_id]['quantity'];
					/*end*/
                }
            }
			$data = array(
			   'model_name'    => $this->options['model_name'],
			   'groupbuy_list' => $groupbuy_list
			);			
            $cache_server->set($key, $data, $this->_ttl);
        }
        return $data;
    }
}

?>