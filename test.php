<?php
$str = <<<EOT
<xml><appid><![CDATA[wxce23f1ece9547b57]]></appid>
<bank_type><![CDATA[CMB_DEBIT]]></bank_type>
<fee_type><![CDATA[CNY]]></fee_type>
<is_subscribe><![CDATA[Y]]></is_subscribe>
<mch_id><![CDATA[10027472]]></mch_id>
<nonce_str><![CDATA[729nwkrnnywjplhom3nk6wgtckd791tg]]></nonce_str>
<openid><![CDATA[o6wjnjrP9ZhTWa7g5RGdWzN2s-_M]]></openid>
<order_id><![CDATA[40]]></order_id>
<out_trade_no><![CDATA[1433443199]]></out_trade_no>
<result_code><![CDATA[SUCCESS]]></result_code>
<return_code><![CDATA[SUCCESS]]></return_code>
<sign><![CDATA[B4C1448B7B4FCDB742A0CD0230925212]]></sign>
<time_end><![CDATA[20141201162131]]></time_end>
<total_fee>1</total_fee>
<trade_type><![CDATA[NATIVE]]></trade_type>
<transaction_id><![CDATA[1005240464201412010006375626]]></transaction_id>
</xml>
EOT;

$xmlobj = simplexml_load_string($str);
echo $xmlobj->order_id;