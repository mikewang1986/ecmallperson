<?php

return array(
    'code'      => 'alipay_bank',
    'name'      => Lang::get('alipay_bank'),
    'desc'      => Lang::get('alipay_bank_desc'),
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
        'alipay_service'  => array(         //服务类型
            'text'      =>Lang::get('alipay_service'),
            'desc'  => Lang::get('alipay_service_desc'),
            'type'      => 'select',
            'items'     => array(
                'create_direct_pay_by_user'   => Lang::get('create_direct_pay_by_user'),
            ),
        ),
    ),
);

?>