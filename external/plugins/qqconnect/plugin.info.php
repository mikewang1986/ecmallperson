<?php

return array(
    'id' => 'qqconnect',
    'hook' => 'on_qq_login',
    'name' => '腾讯QQ登录',
    'desc' => '腾讯QQ登录',
    'author' => 'ecmjx.jyds95.com',
    'version' => '1.0',
    'config' => array(
        'appid' => array(
            'type' => 'text',
            'text' => 'Appid'
        ),
        'appkey' => array(
            'type' => 'text',
            'text' => 'AppKey'
        ),
    )
);

?>