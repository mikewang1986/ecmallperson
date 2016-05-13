<?php

/**
 *    支付宝支付方式插件
 *
 *    @author    Garbin
 *    @usage    none
 */

class AlipayPayment extends BasePayment
{
    /* 支付宝网关 */
    var $_gateway   =   'https://mapi.alipay.com/gateway.do';
    var $_code      =   'alipay';

    /**
     *    获取支付表单
     *
     *    @author    Garbin
     *    @param     array $order_info  待支付的订单信息，必须包含总费用及唯一外部交易号
     *    @return    array
     */
    function get_payform($trade_info)
    {
        $service = $this->_config['alipay_service'];
		
        $params = array(

            /* 基本信息 */
            'service'           => $service,
            'partner'           => $this->_config['alipay_partner'],
            '_input_charset'    => trim(strtolower(CHARSET)),  // 必填
            'notify_url'        => $this->_create_notify_url($trade_info['tradesn']),
            'return_url'        => $this->_create_return_url($trade_info['tradesn']),
			//'show_url'			=> '',
			//'error_notify_url'	=> '', //请求出错通知地址

            /* 业务参数 */
            'subject'           => $trade_info['subject'],
            //订单ID由不属签名验证的一部分，所以有可能被客户自行修改，所以在接收网关通知时要验证指定的订单ID的外部交易号是否与网关传过来的一致
            'out_trade_no'      => $trade_info['tradesn'],
			'total_fee'         => $trade_info['total_fee'],   //应付总价
            'payment_type'      => 1,

			//'anti_phishing_key'	=> '',
			//'exter_invoke_ip'		=> '',
			//'it_b_pay'			=> '1h', //设置未付款交易的超时时间，一旦超时，该笔交易就会自动被关闭。取值范围：1m～15d。

            /* 物流参数 */
            //'logistics_type'    => 'EXPRESS',
            //'logistics_fee'     => 0,
            //'logistics_payment' => 'BUYER_PAY_AFTER_RECEIVE',

            /* 买卖双方信息 */
            'seller_email'      => $this->_config['alipay_account'],
			//'royalty_type'		=>	'', // 提成类型。目前只支持一种类型：10（卖家给第三方提成）。当传递了参数royalty_parameters时，提成类型参数不能为空。
            //'royalty_parameters'	=>	'', // 分润账号集 ：收款方Email1^金额1^备注1|收款方Email2^金额2^备注2。 更多设置看接口文档
        );
		if($trade_info['defaultbank'] && in_array($trade_info['defaultbank'],$this->_get_bank_inc())) {
			$params['paymethod'] = 'bankPay';  // 默认支付方式，可空 区分大小写（若要使用纯网关，取值必须是bankPay（网银支付）。如果不设置，默认为directPay（余额支付）
			$params['defaultbank'] = $trade_info['defaultbank']; // 默认网银 必填
		}
        $params['sign']         =   $this->_get_sign($params);
        $params['sign_type']    =   'MD5';

        return $this->_create_payform('GET', $params);
    }
	
	function _get_bank_inc()
	{
		$bank_inc = include ROOT_PATH .'/data/alipaybank.inc.php';
		
		if(!is_array($bank_inc) || count($bank_inc)<1)
		{
			return array();
		}
		return array_keys($bank_inc);
	}

    /**
     *    返回通知结果
     *
     *    @author    psmb
     *    @param     array $trade_info
     *    @param     bool  $strict
     *    @return    array
     */
    function verify_notify($trade_info, $strict = false)
    {
        if (empty($trade_info))
        {
            $this->_error('trade_info_empty');

            return false;
        }

        /* 初始化所需数据 */
        $notify =   $this->_get_notify();

        /* 验证来路是否可信 */
        if ($strict)
        {
            /* 严格验证 */
            $verify_result = $this->_query_notify($notify['notify_id']);
            if(!$verify_result)
            {
                /* 来路不可信 */
                $this->_error('notify_unauthentic');

                return false;
            }
        }

        /* 验证通知是否可信 */
        $sign_result = $this->_verify_sign($notify);
		
        if (!$sign_result)
        {
            /* 若本地签名与网关签名不一致，说明签名不可信 */
            $this->_error('sign_inconsistent');

            return false;
        }

        /*----------通知验证结束----------*/

        /*----------本地验证开始----------*/
        /* 验证与本地信息是否匹配 */
        /* 这里不只是付款通知，有可能是发货通知，确认收货通知 */

        if ($trade_info['tradesn'] != $notify['out_trade_no'])
        {
            /* 通知中的订单与欲改变的订单不一致 */
            $this->_error('trade_inconsistent');

            return false;
        }
        if ($trade_info['amount'] != $notify['total_fee'])
        {
            /* 支付的金额与实际金额不一致 */
            $this->_error('price_inconsistent');

            return false;
        }
        //至此，说明通知是可信的，订单也是对应的，可信的

        /* 按通知结果返回相应的结果 */
        switch ($notify['trade_status'])
        {
            case 'WAIT_SELLER_SEND_GOODS':      //买家已付款，等待卖家发货

                $order_status = 'ACCEPTED';
            break;

            case 'WAIT_BUYER_CONFIRM_GOODS':    //卖家已发货，等待买家确认

                $order_status = 'SHIPPED';
            break;

            case 'TRADE_FINISHED':              //交易结束
			case 'TRADE_SUCCESS' :
                if ($trade_info['status'] == 'PENDING')
                {
                    /* 如果是等待付款中，则说明是即时到账交易，这时将状态改为已付款 */
                    $order_status = 'ACCEPTED';
                }
                else
                {
                    /* 说明是第三方担保交易，交易结束 */
                    $order_status = 'SUCCESS';
                }
            break;
            case 'TRADE_CLOSED':                //交易关闭
                $order_status = 'CANCLED';
            break;

            default:
                $this->_error('undefined_status');
                return false;
            break;
        }

        switch ($notify['refund_status'])
        {
            case 'REFUND_SUCCESS':              //退款成功，取消订单
                $order_status = 'CANCLED';
            break;
        }

        return array(
            'target'    =>  $order_status,
        );
    }

    /**
     *    查询通知是否有效
     *
     *    @author    Garbin
     *    @param     string $notify_id
     *    @return    string
     */
    function _query_notify($notify_id)
    {
        $query_url = "http://notify.alipay.com/trade/notify_query.do?partner={$this->_config['alipay_partner']}&notify_id={$notify_id}";

        return (ecm_fopen($query_url, 60) === 'true');
    }

    /**
     *    获取签名字符串
     *
     *    @author    Garbin
     *    @param     array $params
     *    @return    string
     */
    function _get_sign($params)
    {
        /* 去除不参与签名的数据 */
        unset($params['sign'], $params['sign_type'], $params['tradesn'], $params['app'], $params['act']);
		
        /* 排序 */
        ksort($params);
        reset($params);

        $sign  = '';
        foreach ($params AS $key => $value)
        {
            $sign  .= "{$key}={$value}&";
        }

        return md5(substr($sign, 0, -1) . $this->_config['alipay_key']);
    }

    /**
     *    验证签名是否可信
     *
     *    @author    Garbin
     *    @param     array $notify
     *    @return    bool
     */
    function _verify_sign($notify)
    {
        $local_sign = $this->_get_sign($notify);

        return ($local_sign == $notify['sign']);
    }
	
	/**
     *    获取通知地址
     *
     *    @author    psmb
     *    @param     int $store_id
     *    @param     int $order_id
     *    @return    string
     */
    function _create_notify_url($tradesn)
    {
        return SITE_URL . "/index.php?app=depopaynotify&act=notify&tradesn={$tradesn}";
    }

    /**
     *    获取返回地址
     *
     *    @author    psmb
     *    @param     int $store_id
     *    @param     int $order_id
     *    @return    string
     */
    function _create_return_url($tradesn)
    {
        return SITE_URL . "/index.php?app=depopaynotify&tradesn={$tradesn}";
    }
	
	/**
     *    将验证结果反馈给网关
     *
     *    @author    Garbin
     *    @param     bool   $result
     *    @return    void
     */
    function verify_result($result)
    {
        if ($result)
        {
            echo 'success';
        }
        else
        {
            echo 'fail';
        }
    }
}

?>