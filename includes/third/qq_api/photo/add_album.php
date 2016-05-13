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
 * @brief 登录用户创建QQ空间相册.请求需经过URL编码，编码时请遵循 RFC 1738
 *
 * @param $appid
 * @param $appkey
 * @param $access_token
 * @param $access_token_secret
 * @param $openid
 */
function add_album($appid, $appkey, $access_token, $access_token_secret, $openid)
{
	//创建QQ空间相册的接口地址, 不要更改!!
    $url    = "http://openapi.qzone.qq.com/photo/add_album";
    echo do_post($url, $appid, $appkey, $access_token, $access_token_secret, $openid);
}

//接口调用示例：
add_album($_SESSION["appid"], $_SESSION["appkey"], $_SESSION["token"], $_SESSION["secret"], $_SESSION["openid"]);
?>
