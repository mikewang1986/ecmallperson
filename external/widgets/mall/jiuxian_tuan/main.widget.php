<?php

/**
 * 推荐团购挂件
 *
 * @return  array
 */
class Jiuxian_tuanWidget extends BaseWidget
{
    var $_name = 'jiuxian_tuan';
    var $_ttl  = 1800;

    function _get_data()
    {
		// notice: don't set cache
		$amount = (empty($this->options['amount']) || intval($this->options['amount'])<=0) ? 1 : intval($this->options['amount']);
			
		$conditions = '';
		if(intval($this->options['recommend'])!=2){
			$conditions = " AND this.recommended=".intval($this->options['recommend']);
		}
			
		$model_groupbuy =& m('groupbuy');
		$groupbuy_list = $model_groupbuy->find(array(
			'join'  => 'belong_goods',
			'conditions'    => $model_groupbuy->getRealFields('this.state=' . GROUP_ON . ' AND this.end_time>' . gmtime() . $conditions),
			'fields'    => 'group_id, goods.default_image, group_name, group_image,end_time, spec_price,goods.price',
			'order' => 'group_id DESC',
			'limit' => $amount,
		));
		
		$groupbuy_list = Psmb_init()->Jiuxian_tuanWidget_format_groupbuy_list($groupbuy_list);

		$data = array(
			'model_id'      =>mt_rand(),
			'model_name'    => !empty($this->options['model_name']) ? $this->options['model_name'] : '团购',
			'groupbuy_list' => $groupbuy_list
		);	
        return $data;
    }
	function parse_config($input)
    {
        return $input;
    }
}

?>