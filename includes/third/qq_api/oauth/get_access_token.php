<?php
/**
 * PHP SDK for QQ登录 OpenAPI
 *
 * @version 1.5
 * @author connect@qq.com
 * @copyright © 2011, Tencent Corporation. All rights reserved.
 */

require_once("../comm/utils.php");

/**
 * @brief 获取access_token。请求需经过URL编码，编码时请遵循 RFC 1738
 *
 * @param $appid
 * @param $appkey
 * @param $request_token
 * @param $request_token_secret
 * @param $vericode
 *
 * @return 返回字符串格式为：oauth_token=xxx&oauth_token_secret=xxx&openid=xxx&oauth_signature=xxx&oauth_vericode=xxx&timestamp=xxx
 */

function get_access_token($appid, $appkey, $request_token, $request_token_secret, $vericode)
{
    global $global_arg;
    //请求具有Qzone访问权限的access_token的接口地址, 不要更改!!
    $url    = "http://openapi.qzone.qq.com/oauth/qzoneoauth_access_token?";
   
    //生成oauth_signature签名值。签名值生成方法详见（http://wiki.opensns.qq.com/wiki/【QQ登录】签名参数oauth_signature的说明）
    //（1） 构造生成签名值的源串（HTTP请求方式 & urlencode(uri) & urlencode(a=x&b=y&...)）
	$sigstr = "GET"."&".QQConnect_urlencode("http://openapi.qzone.qq.com/oauth/qzoneoauth_access_token")."&";

    //必要参数，不要随便更改!!
    $params = array();
    $params["oauth_version"]          = "1.0";
    $params["oauth_signature_method"] = "HMAC-SHA1";
    $params["oauth_timestamp"]        = time();
    $params["oauth_nonce"]            = mt_rand();
    $params["oauth_consumer_key"]     = $appid;
    $params["oauth_token"]            = $request_token;
    $params["oauth_vericode"]         = $vericode;

    //对参数按照字母升序做序列化
    $normalized_str = get_normalized_string($params);
    $sigstr        .= QQConnect_urlencode($normalized_str);

    //echo "sigstr = $sigstr";

	//（2）构造密钥
    $key = $appkey."&".$request_token_secret;

	//（3）生成oauth_signature签名值。这里需要确保PHP版本支持hash_hmac函数
    $signature = get_signature($sigstr, $key);
    
	
	//构造请求url
    $url      .= $normalized_str."&"."oauth_signature=".QQConnect_urlencode($signature);

    $global_arg = $url;
    return file_get_contents($url);
}


/**
 * Tips：
 * QQ互联登录，授权成功后会回调注册的callback地址
 * 必须要用授权的request token换取access token
 * 访问QQ互联的任何资源都需要access token
 * 目前access token是长期有效的，除非用户解除与第三方绑定
 * 如果第三方发现access token失效，请引导用户重新登录QQ互联，授权，获取access token
 */

global $global_arg;
if($_REQUEST["appid"]&&$_REQUEST["appkey"])
{
	$_SESSION["appid"]=$_REQUEST["appid"];
	$_SESSION["appkey"]=$_REQUEST["appkey"];
}

//用户使用QQ登录，并授权成功后，会返回用户的openid。此时需要检查返回的openid是否是合法id
//我们不建议开发者使用该openid，而是使用获取access token之后返回的openid。
if (!is_valid_openid($_REQUEST["openid"], $_REQUEST["timestamp"], $_REQUEST["oauth_signature"]))
{
    //demo对错误简单处理
    echo '<html lang="zh-cn">';
    echo '<head>';
    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
    echo '</head>';
    echo '<body>';
    echo "<h3>invalid openid</h3>";
    print_r($_REQUEST);
    echo "<h3>错误签名:</h3>".$_REQUEST["oauth_signature"];
    echo "<h3>正确签名:</h3>$global_arg"; 
    echo '</body>';
    echo '</html>';
    exit;
}

//tips
//这里已经获取到了openid，可以处理第三方账户与openid的绑定逻辑。
//但是我们建议第三方等到获取access token之后在做绑定逻辑

//用授权的request token换取access token

$access_str = get_access_token($_SESSION["appid"], $_SESSION["appkey"], $_REQUEST["oauth_token"], $_SESSION["secret"], $_REQUEST["oauth_vericode"]);

//错误处理
if (strpos($access_str, "error_code") !== false)
{
    echo '<html lang="zh-cn">';
    echo '<head>';
    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
    echo '</head>';
    echo '<body>';
    echo "<h3>请求url:</h3>$global_arg</br>";
    echo "<h3>返回值:</h3>$access_str</br>";
    echo '<h3>请参考</h3><a href="http://wiki.opensns.qq.com/wiki/%E3%80%90QQ%E7%99%BB%E5%BD%95%E3%80%91%E5%85%AC%E5%85%B1%E8%BF%94%E5%9B%9E%E7%A0%81%E8%AF%B4%E6%98%8E" target="_blank">错误码说明</a>与<a href="http://open.qzone.qq.com/oauth_tool/oauth_url_check.htm">调试工具</a>';
    echo '</body>';
    echo '</html>';
    exit;
}

//解析返回参数
$result = array();
parse_str($access_str, $result);


//将access token，openid保存起来！！！
//在demo演示中，直接保存在全局变量中.
//为避免网站存在多个子域名或同一个主域名不同服务器造成的session无法共享问题
//请开发者按照本SDK中comm/session.php中的注释对session.php进行必要的修改，以解决上述2个问题，
$_SESSION["qq_token"]   = $result["oauth_token"];
$_SESSION["qq_token_secret"]  = $result["oauth_token_secret"]; 
$_SESSION["qq_openid"]  = $result["openid"];

date_default_timezone_set("PRC"); 
$url    = "http://openapi.qzone.qq.com/user/get_user_info";
$info   = do_get($url, $_SESSION["appid"], $_SESSION["appkey"], $_SESSION["qq_token"], $_SESSION["qq_token_secret"], $_SESSION["qq_openid"]);
$arr = array();
$arr = json_decode($info, true);
if($arr && $arr["nickname"])
{

	$_SESSION["qq_nickname"]=$arr["nickname"];
	$go_url="/index.php?app=third_login&act=qq_callback&qq_token=".$_SESSION["qq_token"]."&qq_token_secret=".$_SESSION["qq_token_secret"]."&qq_openid=".$_SESSION["qq_openid"]."&qq_nickname=".urlencode($_SESSION["qq_nickname"]);
	header("location:$go_url");
	exit();
}
else 
{
	exit("can't get user info.");
}


/*echo '<html lang="zh-cn">';
echo '<head>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
echo '</head>';
echo '<body>';
echo "<p>现在您已经获取到了用户的关键数据</p>";
echo "<p><h3>openid:</h3>".$result['openid']."</br>用户唯一标识</p>";
echo "<p><h3>token:</h3>".$result['oauth_token']."</br>具有访问权限的token</p>";
echo "<p><h3>secret:</h3>".$result['oauth_token_secret']."</br>token的密钥</p>";
echo "<p>以上三个参数您应该保存下来，用于访问QQ互联的其他接口,比如:</p>";
echo "<p>点击<a href=\"../user/get_user_info.php\"    target=\"_blank\">获取用户信息</a></p>";
echo "<p>接下来您需要处理自己网站的登录逻辑，祝您使用QQ登录愉快</p>";
echo '<p>您可以参考<a href="http://wiki.opensns.qq.com/wiki/%E3%80%90QQ%E7%99%BB%E5%BD%95%E3%80%91%E5%BC%80%E5%8F%91%E6%94%BB%E7%95%A5" target="_blank">开发攻略</a>与<a href="http://code.qq.com/bbs/forum.php" target="_blank">开发者论坛</a>寻求帮助</p';
echo '</body>';
echo '</html>';
*/
//第三方处理用户绑定逻辑
//将openid与第三方的帐号做关联
//bind_to_openid();
?>
