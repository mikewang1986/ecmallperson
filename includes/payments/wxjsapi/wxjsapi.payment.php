<?php
/**
 *    微信支付插件
 *
 *    @author    ecmjx.jyds95.com
 *    
 */
class WxjsapiPayment extends BasePayment
{
	

	function get_payform($order_info)
	{
		if(!defined('WXAPPID'))
        {
            define("WXAPPID", $this->_config['appid']);
            define("WXMCHID", $this->_config['mchid']);
            define("WXKEY", $this->_config['key']);
            define("WXAPPSECRET", $this->_config['appsecret']);
            define("WXCURL_TIMEOUT", 30);
            define('WXNOTIFY_URL',$this->_create_notify_url($order_info['order_id']));
            define('WXJS_API_CALL_URL',$this->_create_notify_url($order_info['order_id']));
            define('WXSSLCERT_PATH',ROOT_PATH.'/data/cacert/'.$order_info['seller_id'].'/apiclient_cert.pem');
            define('WXSSLKEY_PATH',ROOT_PATH.'/data/cacert/'.$order_info['seller_id'].'/apiclient_key.pem');
        }
        require_once(dirname(__FILE__)."/WxPayPubHelper/WxPayPubHelper.php");

		$jsApi = new JsApi_pub();
		$out_trade_no = $this->_get_trade_sn($order_info);
		if (!isset($_GET['code']))
        {
            $redirect = urlencode(SITE_URL.'/index.php?app=cashier&act=wxjsapi&order_id='.$order_info['order_id']);
            $url = $jsApi->createOauthUrlForCode($redirect);
            Header("Location: $url"); 
        }else
        {
            
            
            $code = $_GET['code'];
            
            $jsApi->setCode($code);
            $openid = $jsApi->getOpenId();
        }
         
        
       
        if($openid)
        {
            $unifiedOrder = new UnifiedOrder_pub();

            $unifiedOrder->setParameter("openid","$openid");//商品描述
            $unifiedOrder->setParameter("body",$out_trade_no);//商品描述
            $unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号 
            $unifiedOrder->setParameter("attach",strval($order_info['order_id']));//商户支付日志
            $unifiedOrder->setParameter("total_fee",strval(intval($order_info['order_amount']*100)));//总金额
            $unifiedOrder->setParameter("notify_url",WXNOTIFY_URL);//通知地址 
            $unifiedOrder->setParameter("trade_type","JSAPI");//交易类型


            $prepay_id = $unifiedOrder->getPrepayId();

            $jsApi->setPrepayId($prepay_id);

            $jsApiParameters = $jsApi->getParameters();


            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $allow_use_wxPay = true;

            if(strpos($user_agent, 'MicroMessenger') === false)
            {
                $allow_use_wxPay = false;
            }
            else
            {
                preg_match('/.*?(MicroMessenger\/([0-9.]+))\s*/', $user_agent, $matches);
                if($matches[2] < 5.0)
                {
                    $allow_use_wxPay = false;
                }
            }
            $html .= '<script language="javascript">';
            //if(true)
            if($allow_use_wxPay)
            {
                $html .= "function jsApiCall(){";
                $html .= "WeixinJSBridge.invoke(";
                $html .= "'getBrandWCPayRequest',";
                $html .= $jsApiParameters.",";
                $html .= "function(res){";
                $html .= "WeixinJSBridge.log(res.err_msg);";
                $html .= "}";
                $html .= ");";
                $html .= "}";
                $html .= "function callpay(){";
                $html .= 'if (typeof WeixinJSBridge == "undefined"){';
                $html .= "if( document.addEventListener ){";
                $html .= "document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);";
                $html .= "}else if (document.attachEvent){";
                $html .= "document.attachEvent('WeixinJSBridgeReady', jsApiCall); ";
                $html .= "document.attachEvent('onWeixinJSBridgeReady', jsApiCall);";
                $html .= "}";
                $html .= "}else{";
                $html .= "jsApiCall();";
                $html .= "}}";
            }
            else
            {
                $html .= 'function callpay(){';
                $html .= 'alert("您的微信不支持支付功能,请更新您的微信版本")';
                $html .= "}";

            }

            $html .= '</script>';
            $html .= '<input style=" width:150px; height:30px;line-height:30px;text-align:center;background-color:#903; color:#fff; font-size:14px;" type="button" onclick="callpay()" value="点击微信支付" />';
            //$html .= '<button class="red_btn" type="button" onclick="callpay()">微信支付</button>';

            

        }
        else
        {
            $html .= '<script language="javascript">';
            $html .= 'function callpay(){';
            $html .= 'alert("您的微信不支持支付功能,请更新您的微信到最新版本")';
            $html .= "}";
            $html .= '</script>';
            $html .= '<input style=" width:150px; height:30px;line-height:30px;text-align:center;background-color:#903; color:#fff; font-size:14px;" type="button" onclick="callpay()" value="点击微信支付" />';
            //$html .= '<button class="red_btn" type="button" onclick="callpay()">微信支付</button>';

           
        }
        
        return $html;

	}

    function _create_notify_url($order_id)
    {
        return SITE_URL . "/wx_callback.php";
    }

	function verify_notify($order_info, $strict = false)
    {
        
        if(!defined('WXAPPID'))
        {
            define("WXAPPID", $this->_config['appid']);
            define("WXMCHID", $this->_config['mchid']);
            define("WXKEY", $this->_config['key']);
            define("WXAPPSECRET", $this->_config['appsecret']);
            define("WXCURL_TIMEOUT", 30);
            define('WXNOTIFY_URL',$this->_create_notify_url($order_info['order_id']));
            define('WXJS_API_CALL_URL',$this->_create_notify_url($order_info['order_id']));
            define('WXSSLCERT_PATH',ROOT_PATH.'/data/cacert/'.$order_info['seller_id'].'/apiclient_cert.pem');
            define('WXSSLKEY_PATH',ROOT_PATH.'/data/cacert/'.$order_info['seller_id'].'/apiclient_key.pem');
        }
        require_once(dirname(__FILE__)."/WxPayPubHelper/WxPayPubHelper.php");
        $notify = new Notify_pub();
        $xml = $order_info['xml'];
        $notify->saveData($xml);
        if($notify->checkSign() == true)
        {
            if ($notify->data["return_code"] == "FAIL")
            {
                return false;
            }
            else
            {
                $total_fee = $notify->data["total_fee"];
                $out_trade_no  = $notify->data["out_trade_no"];
                if ($order_info['out_trade_sn'] != $out_trade_no)
                {
                    /* 通知中的订单与欲改变的订单不一致 */
                    $this->_error('order_inconsistent');
                    return false;
                }
                if ($order_info['order_amount']*100 != $total_fee)
                {
                    /* 支付的金额与实际金额不一致 */
                    $this->_error('price_inconsistent');
                    return false;
                }
                return array(
                    'target'    =>  ORDER_ACCEPTED,
                );
            }

        }
        else
        {
            $this->_error('sign_inconsistent');
            return false;
        }

    }

}
?>