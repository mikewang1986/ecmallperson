<?php

return array(
    'id' => 'alipayconnect',
    'hook' => 'on_alipay_login',
    'name' => '支付宝快捷登录',
    'desc' => '支付宝快捷登录',
    'author' => 'ecmjx.jyds95.com',
    'version' => '2.0',
    'config' => array(
        'partner' => array(
            'type' => 'text',
            'text' => 'partner'
        ),
        'key' => array(
            'type' => 'text',
            'text' => 'key'
        )
    )
);

?>