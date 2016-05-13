<?php

/**
 *    支付宝手机支付方式插件
 *
 *    @author    QQ:82943566
 *    
 */

class AlipaywapPayment extends BasePayment
{
	public $_gateway = 'http://wappaygw.alipay.com/service/rest.htm?_input_charset=utf-8';
	
	function get_payform($order_info)
	{
		
		require_once(dirname(__FILE__)."/alipay_wap/lib/alipay_submit.class.php");
		$charset = 'utf-8';
		$alipay_config['partner']		= $this->_config['alipay_partner'];
        $alipay_config['key']			= $this->_config['alipay_key'];
        $alipay_config['sign_type']    = 'MD5';
        $alipay_config['input_charset']= $charset;

		$alipay_config['cacert']    = ROOT_PATH.'/data/key/'.$order_info['seller_id'].'/cacert.pem';
        $alipay_config['transport']    = 'http';
        $format = "xml";
        $v = "2.0";
        $req_id = date('Ymdhis').mt_rand(10000,90000);
        $notify_url = str_replace('&','&amp;',$this->_create_notify_url($order_info['order_id']));
        $call_back_url = str_replace('&','&amp;',$this->_create_return_url($order_info['order_id']));
        $merchant_url = SITE_URL.'/index.php';
        $seller_email = $this->_config['alipay_account'];
        $out_trade_no = $this->_get_trade_sn($order_info);
        $subject = $out_trade_no;
        $total_fee = $order_info['order_amount'];
        $req_data = '<direct_trade_create_req><notify_url>' . $notify_url . '</notify_url><call_back_url>' . $call_back_url . '</call_back_url><seller_account_name>' . $seller_email . '</seller_account_name><out_trade_no>' . $out_trade_no . '</out_trade_no><subject>' . $subject . '</subject><total_fee>' . $total_fee . '</total_fee><merchant_url>' . $merchant_url . '</merchant_url></direct_trade_create_req>';
		

        $para_token = array(
			"service" => "alipay.wap.trade.create.direct",
			"partner" => trim($alipay_config['partner']),
			"sec_id" => trim($alipay_config['sign_type']),
			"format"	=> $format,
			"v"	=> $v,
			"req_id"	=> $req_id,
			"req_data"	=> $req_data,
			"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);



		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestHttp($para_token);
		$html_text = urldecode($html_text);
	

		$para_html_text = $alipaySubmit->parseResponse($html_text);
		
		$request_token = $para_html_text['request_token'];
		$req_data = '<auth_and_execute_req><request_token>' . $request_token . '</request_token></auth_and_execute_req>';
		$parameter = array(
			"service" => "alipay.wap.auth.authAndExecute",
			"partner" => trim($alipay_config['partner']),
			"sec_id" => trim($alipay_config['sign_type']),
			"format"	=> $format,
			"v"	=> $v,
			"req_id"	=> $req_id,
			"req_data"	=> $req_data,
			"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);
		$para = $alipaySubmit->buildRequestPara($parameter);
		return $this->_create_payform('GET', $para);
	}


	function verify_notify($order_info, $strict = false)
	{
		if (empty($order_info))
        {
            $this->_error('order_info_empty');

            return false;
        }

		require_once(dirname(__FILE__)."/alipay_wap/lib/alipay_notify.class.php");

		$alipay_config['partner']		= $this->_config['alipay_partner'];
        $alipay_config['key']			= $this->_config['alipay_key'];
        
        $alipay_config['sign_type']    = 'MD5';
        $alipay_config['input_charset']= 'utf-8';
        $alipay_config['cacert']    = getcwd().'\\cacert.pem';
        $alipay_config['transport']    = 'http';

		$alipayNotify = new AlipayNotify($alipay_config);

		$verify_result = $alipayNotify->verifyNotify();

		if($verify_result)
		{
			if(!empty($_POST))
			{
				$doc = new DOMDocument();
				$doc->loadXML($_POST['notify_data']);
				if( ! empty($doc->getElementsByTagName( "notify" )->item(0)->nodeValue) )
				{
					$notify['out_trade_no'] = $doc->getElementsByTagName( "out_trade_no" )->item(0)->nodeValue;
					$notify['subject'] = $doc->getElementsByTagName( "subject" )->item(0)->nodeValue;
					$notify['total_fee'] = $doc->getElementsByTagName( "total_fee" )->item(0)->nodeValue;
					$notify['trade_status'] = $doc->getElementsByTagName( "trade_status" )->item(0)->nodeValue;
				}
			}
			else
			{
				return false;
			}

			if ($order_info['out_trade_sn'] != $notify['out_trade_no'])
			{
				/* 通知中的订单与欲改变的订单不一致 */
				$this->_error('order_inconsistent');

				return false;
			}

			if ($order_info['order_amount'] != $notify['total_fee'])
			{
				/* 支付的金额与实际金额不一致 */
				$this->_error('price_inconsistent');

				return false;
			}

			/* 按通知结果返回相应的结果 */
			switch ($notify['trade_status'])
			{
				case 'TRADE_SUCCESS':              //交易结束
					
					$order_status = ORDER_ACCEPTED;
					
				break;

				case 'TRADE_FINISHED':              //交易结束
					
					$order_status = ORDER_ACCEPTED;
					
				break;
				

				default:
					$order_status = ORDER_CANCLED;
				break;
			}

			return array(
				'target'    =>  $order_status,
			);
		}
		else
		{
			return array(
				'target'    =>  ORDER_CANCLED,
			);
		}

	}
}

?>