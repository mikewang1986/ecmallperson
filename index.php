<?php
error_reporting(E_ALL & ~E_NOTICE);
define('ROOT_PATH', dirname(__FILE__));

/**
 * 安装判断
 */
if (!file_exists(ROOT_PATH . "/data/install.lock") && is_dir(ROOT_PATH . "/install")){
	@header("location: install");
	exit;
}

include(ROOT_PATH . '/eccore/ecmall.php');

/* 定义配置信息 */
ecm_define(ROOT_PATH . '/data/config.inc.php');

$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
$uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile|android)/i";

if((preg_match($uachar, $ua)))
{
    define('ECMALL_WAP', 1);
}
if ($_GET['Debug'] == 'Wap') {
    define('ECMALL_WAP', 1);
}
//define('ECMALL_WAP', 1);
/* 启动ECMall */
ECMall::startup(array(
    'default_app'   =>  'default',
    'default_act'   =>  'index',
    'app_root'      =>  ROOT_PATH . '/app',
    'external_libs' =>  array(
        ROOT_PATH . '/includes/global.lib.php',
        ROOT_PATH . '/includes/libraries/time.lib.php',
        ROOT_PATH . '/includes/ecapp.base.php',
        ROOT_PATH . '/includes/plugin.base.php',
        ROOT_PATH . '/app/frontend.base.php',
        ROOT_PATH . '/includes/subdomain.inc.php',
    ),
));
?>
