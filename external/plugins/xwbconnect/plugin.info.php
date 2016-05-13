<?php

return array(
    'id' => 'xwbconnect',
    'hook' => 'on_xwb_login',
    'name' => '新浪微博登录',
    'desc' => '新浪微博登录',
    'author' => 'ecmjx.jyds95.com',
    'version' => '2.0',
    'config' => array(
        'WB_AKEY' => array(
            'type' => 'text',
            'text' => 'WB_AKEY'
        ),
        'WB_SKEY' => array(
            'type' => 'text',
            'text' => 'WB_SKEY'
        )
    )
);

?>