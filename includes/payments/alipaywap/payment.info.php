<?php

return array(
    'code'      => 'alipaywap',
    'name'      => Lang::get('alipay_wap'),
    'desc'      => Lang::get('alipay_wap_desc'),
    'is_online' => '1',
    'author'    => 'ecmjx.jyds95.com',
    'website'   => 'http://www.alipay.com',
    'version'   => '1.0',
    'currency'  => Lang::get('alipay_currency'),
    'config'    => array(
        'alipay_account'   => array(        //账号
            'text'  => Lang::get('alipay_account'),
            'desc'  => Lang::get('alipay_account_desc'),
            'type'  => 'text',
        ),
        'alipay_key'       => array(        //密钥
            'text'  => Lang::get('alipay_key'),
            'desc'  => Lang::get('alipay_key_desc'),
            'type'  => 'text',
        ),
        'alipay_partner'   => array(        //合作者身份ID
            'text'  => Lang::get('alipay_partner'),
            'type'  => 'text',
        ),
    ),
);

?>