<?php

/**
 *    预存款支付
 *
 *    @author   psmb
 *    @usage    none
 */
class DepositPayment extends BasePayment
{
	/* 预存款网关 */
    var $_gateway   =   '';
    var $_code 		= 	'deposit';

    /**
     *    获取支付表单
     *
     *    @author    psmb
     *    @param     array $order_info  待支付的订单信息，必须包含总费用及唯一外部交易号
     *    @return    array
     */
    function get_payform($order_info)
    {
		$params = array(
			'app'				=>	'depopay',
			'order_id'			=>	$order_info['order_id'],
        );
        return $this->_create_payform('GET', $params);
	}
}

?>