<?php

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


//define('ECMALL_WAP', 1);
/* 启动ECMall */
ECMall::startup(array(
    'default_app'   =>  'paynotify',
    'default_act'   =>  'wxnotify',
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
