<?php

/* Ӧ�ø�Ŀ¼ */
define('APP_ROOT', dirname(__FILE__));
define('ROOT_PATH', dirname(APP_ROOT));
include(ROOT_PATH . '/eccore/ecmall.php');

/* ����������Ϣ */
ecm_define(ROOT_PATH . '/data/config.inc.php');

/* ����ECMall */
ECMall::startup(array(
    'default_app'   =>  'default',
    'default_act'   =>  'index',
    'app_root'      =>  APP_ROOT . '/app',
    'external_libs' =>  array(
        ROOT_PATH . '/includes/global.lib.php',
        ROOT_PATH . '/includes/libraries/time.lib.php',
    ),
));

?>