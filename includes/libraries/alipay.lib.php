<?php


class alipay_service {

    var $gateway;			//网关地址
    var $security_code;		//安全校验码
    var $mysign;			//加密结果（签名结果）
    var $sign_type;			//加密类型
    var $parameter;			//需要加密的参数数组
    var $_input_charset;    //字符编码格式

    /**构造函数 W
	*从配置文件及入口文件中初始化变量
	*$parameter 需要加密的参数数组
	*$security_code 安全校验码
	*$sign_type 加密类型
    */
    function alipay_service($parameter,$security_code,$sign_type) {
        $this->gateway	      = "https://www.alipay.com/cooperate/gateway.do?";
        $this->security_code  = $security_code;
        $this->sign_type      = $sign_type;
        $this->parameter      =$this->para_filter($parameter);

        //设定_input_charset的值,为空值的情况下默认为GBK
        if($parameter['_input_charset'] == '')
            $this->parameter['_input_charset'] = 'GBK';

        $this->_input_charset   = $this->parameter['_input_charset'];

        //获得签名结果
        $sort_array   = $this->arg_sort($this->parameter);    //得到从字母a到z排序后的加密参数数组
        $this->mysign =$this->build_mysign($sort_array,$this->security_code,$this->sign_type);
    }
	
	function create_linkstring($array) {
    $arg  = "";
    while (list ($key, $val) = each ($array)) {
        $arg.=$key."=".$val."&";
    }
    $arg = substr($arg,0,count($arg)-2);		     //去掉最后一个&字符
    return $arg;
}

function create_linkstring_urlencode($array) {
    $arg  = "";
    while (list ($key, $val) = each ($array)) {
		if ($key != "service" && $key != "_input_charset")
			$arg.=$key."=".urlencode($val)."&";
		else $arg.=$key."=".$val."&";
    }
    $arg = substr($arg,0,count($arg)-2);		     //去掉最后一个&字符
    return $arg;
}
function sign($prestr,$sign_type) {
    $sign='';
    if($sign_type == 'MD5') {
        $sign = md5($prestr);
    }elseif($sign_type =='DSA') {
        //DSA 签名方法待后续开发
        die("DSA 签名方法待后续开发，请先使用MD5签名方式");
    }else {
        die("支付宝暂不支持".$sign_type."类型的签名方式");
    }
    return $sign;
}
    /********************************************************************************/
function para_filter($parameter) {
    $para = array();
    while (list ($key, $val) = each ($parameter)) {
        if($key == "sign" || $key == "sign_type" || $val == "")continue;
        else	$para[$key] = $parameter[$key];
    }
    return $para;
}
    /**构造请求URL（GET方式请求）
	*return 请求url
     */
    function create_url() {
        $url         = $this->gateway;
        $sort_array  = array();
        $sort_array  =$this->arg_sort($this->parameter);
        $arg         =$this->create_linkstring_urlencode($sort_array);	//把数组所有元素，按照"参数=参数值"的模式用"&"字符拼接成字符串
        
		//把网关地址、已经拼接好的参数数组字符串、签名结果、签名类型，拼接成最终完整请求url
        $url.= $arg."&sign=" .$this->mysign ."&sign_type=".$this->sign_type;
        return $url;
    }

    /********************************************************************************/
function build_mysign($sort_array,$security_code,$sign_type = "MD5") {
    $prestr = $this->create_linkstring($sort_array);     	//把数组所有元素，按照"参数=参数值"的模式用"&"字符拼接成字符串
    $prestr = $prestr.$security_code;				//把拼接后的字符串再与安全校验码直接连接起来
    $mysgin = $this->sign($prestr,$sign_type);			    //把最终的字符串加密，获得签名结果
    return $mysgin;
}

function arg_sort($array) {
    ksort($array);
    reset($array);
    return $array;
}
    /**构造Post表单提交HTML（POST方式请求）
	*return 表单提交HTML文本
     */
    function build_postform() {

        $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".$this->gateway."_input_charset=".$this->parameter['_input_charset']."' method='post'>";

        while (list ($key, $val) = each ($this->parameter)) {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }

        $sHtml = $sHtml."<input type='hidden' name='sign' value='".$this->mysign."'/>";
        $sHtml = $sHtml."<input type='hidden' name='sign_type' value='".$this->sign_type."'/></form>";

        $sHtml = $sHtml."<input type='button' name='v_action' value='支付宝发货'>";
		$sHtml = $sHtml."<script>document.forms[\"alipaysubmit\"].submit();</script>";
        return $sHtml;
    }
    /********************************************************************************/

}



?>