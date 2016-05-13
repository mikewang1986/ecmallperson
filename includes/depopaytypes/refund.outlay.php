<?php

/**
 
 *    @author   psmb
 *    @usage    none
 */
class RefundOutlay extends OutlayDepopay
{
    var $_purpose_name = 'refund';
	
	
	function submit($data)
	{
		
        extract($data);
        
        $base_info = $this->_handle_trade_info($trade_info, $post, $this->_purpose_name);
		
        if (!$base_info)
        {
            
            return false;
        }
		
		$tradesn = $this->_gen_trade_sn();
		
		
		if(!$this->_insert_record_info($tradesn, $trade_info, $extra_info, $post)) {
			return false;
		}
		
		
		if(!$this->_update_refund_status($tradesn, $trade_info, $extra_info, $post)) {
			return false;
		}
		
		if(!$this->_handle_order_status($tradesn, $trade_info, $extra_info)) {
			return false;
		}
		
		return $tradesn;
	}
	
	
	function _insert_record_info($tradesn, $trade_info, $extra_info, $post)
	{
		$refund_mod = &m('refund');
		$refund = $refund_mod->get($extra_info['refund_id']);
		
		$order_id = $extra_info['order_id'];
		$intro = $this->_get_intro_by_refund($extra_info['refund_id']);
		
	
		$time = gmtime();
		$data_record = array(
			'tradesn'	=>	$tradesn,
			'order_sn'	=>	$extra_info['order_sn'],
			'user_id'	=>	$trade_info['party_id'], 
			'party_id'	=>	0,
			'amount'	=>	$trade_info['amount'],
			'balance'	=>	$this->_get_deposit_balance($trade_info['party_id']) + $trade_info['amount'], 
			'flow'		=>	'income',
			'purpose'	=>	$this->_purpose_name,
			'status'	=>	'SUCCESS',
			'payway'	=>	LANG::get('deposit'),
			'name'		=>	LANG::get('refundin') . ' - ' . $intro,
			'remark'	=>	'',
			'add_time'	=>	$time,
			'pay_time'	=>	$time,
			'end_time'  =>  $time,
		);
		parent::_insert_deposit_record($data_record);
		
		
		$chajia = $refund['total_fee'] - $trade_info['amount'];
		if($chajia > 0)
		{
			$time = gmtime();
			$data_record = array(
				'tradesn'	=>	$tradesn,
				'order_sn'	=>	$extra_info['order_sn'],
				'user_id'	=>	$trade_info['user_id'], // 卖家
				'party_id'	=>	0,
				'amount'	=>	$chajia,
				'balance'	=>	$this->_get_deposit_balance($trade_info['user_id']) + $chajia, // 增加后的余额
				'flow'		=>	'income',
				'purpose'	=>	'refunddiff', // 退款差价
				'status'	=>	'SUCCESS',
				'payway'	=>	LANG::get('deposit'),
				'name'		=>	LANG::get('refunddiff') . ' - ' . $intro,
				'remark'	=>	'',
				'add_time'	=>	$time,
				'pay_time'	=>	$time,
				'end_time'  =>  $time,
			);
			parent::_insert_deposit_record($data_record);
		}
		return true;
	}
	

	function _update_refund_status($tradesn, $trade_info, $extra_info, $post)
	{
		$refund_id = $extra_info['refund_id'];
		$refund_mod = &m('refund');
		$refund_message_mod = &m('refund_message');
		
		$refund_mod->edit($refund_id, array('status'=>'SUCCESS', 'end_time' => gmtime()));
		
		
		if(isset($extra_info['operator']) && $extra_info['operator'] == 'admin') {
			$content = sprintf(Lang::get('admin_agree_refund_content_change'),Lang::get('system_customer'), $post['refund_goods_fee'], $post['refund_shipping_fee'], $post['content']);
			
			
			$refund_shipping_fee = $post['refund_shipping_fee'] ? $post['refund_shipping_fee'] : 0;
			$refund_mod->edit($refund_id, array('refund_goods_fee'=>$post['refund_goods_fee'], 'refund_shipping_fee'=>$refund_shipping_fee, 'ask_customer'=>1));
			
		} else $content = sprintf(Lang::get('seller_agree_refund_content_change'), $extra_info['seller_name']);
		
		
		$data = array(
			'owner_id'	=> $extra_info['seller_id'],
			'owner_role'=> 'seller',
			'refund_id'	=> $refund_id,
			'content'	=> $content,
			'created'	=> gmtime()				
		);
		return $refund_message_mod->add($data);
	}
	
	
	function _handle_order_status($tradesn, $trade_info, $extra_info)
	{
		$order_mod = &m('order');
		$order_log_mod = &m('orderlog');
		$refund_id = $extra_info['refund_id'];
		$refund_mod = &m('refund');
		$ordergoods_mod = &m('ordergoods');
		
		
		
		$check_refund = $refund_mod->get(array('conditions'=>"order_id=".$extra_info['order_id']." and  status !='SUCCESS' "));
		$check_ordergoods = $ordergoods_mod->find(array('conditions'=>"order_id=".$extra_info['order_id']." and status !='SUCCESS' "));
			
		$bool_check_ordergoods = false;
		if($check_ordergoods){
			foreach($check_ordergoods as $goods){
				$check_refund_second = $refund_mod->get(array('conditions'=>"order_id=".$goods['order_id']." and goods_id=".$goods['goods_id']." and spec_id=".$goods['spec_id'],'fields'=>'status'));
				if(!$check_refund_second || ($check_refund_second['status'] != 'SUCCESS')){
					$bool_check_ordergoods = true;
					break;
				}
			}
		}
		
		
		if(!$check_refund && !$bool_check_ordergoods) {
			$order_mod->edit($extra_info['order_id'], array('status' => ORDER_FINISHED, 'finished_time' => gmtime()));
            
		
			if(isset($extra_info['operator']) && $extra_info['operator'] == 'admin') {
				$remark = Lang::get('admin_agree_refund_order_status_change');
			} else $remark = Lang::get('seller_agree_refund_order_status_change');
			
			
            $order_log_mod->add(array(
                'order_id'  		=> $extra_info['order_id'],
                'operator'  		=> 0,
                'order_status' 		=> order_status($extra_info['status']),
                'changed_status' 	=> order_status(ORDER_FINISHED),
                'remark'    		=> $remark,
                'log_time'  		=> gmtime(),
            ));
		}
		return true;
	}
	
	function _get_intro_by_refund($refund_id)
	{
		$intro = '';
		if(!$refund_id) return $intro;
		
		$ordergoods_mod  = &m('ordergoods');
		$refund_mod = &m('refund');
		$refund = $refund_mod->get(array('conditions'=>'refund_id='.$refund_id,'fields'=>'order_id,goods_id,spec_id'));
		
		$ordergoods = $ordergoods_mod->get(array('conditions'=>'order_id='.$refund['order_id'].' AND goods_id='.$refund['goods_id'],'fields'=>'goods_name'));
		if($ordergoods) {
			$intro = $ordergoods['goods_name'];
		}
		
		return $intro;
	}
	
}

?>
