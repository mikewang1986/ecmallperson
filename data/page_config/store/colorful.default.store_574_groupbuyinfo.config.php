<?php

return array (
  'widgets' => 
  array (
  '_widget_944' => 
    array (
      'name' => 'banner',
      'options' => 
      array (
        'ad_image_url' => 'data/files/store/template/201310230247132921.jpg',
		'ad_link' => '#',
        'ad_height' => '118',
      ),
    ),
    '_widget_628' => 
    array (
      'name' => 'nav',
      'options' => 
      array (
        'color' => '#8e94a4',
        'title' => 
        array (
          0 => '所有宝贝',
          1 => '裤子',
          2 => '衣服',
        ),
        'link' => 
        array (
          0 => 'index.php?app=store&act=search&id=1',
          1 => 'http://ecmjx.jyds95.com',
          2 => 'index.php?app=store&act=search&id=1',
        ),
        'navs' => 
        array (
          0 => 
          array (
            'title' => '所有宝贝',
            'link' => 'index.php?app=store&act=search&id=1',
          ),
          1 => 
          array (
            'title' => '裤子',
            'link' => 'http://ecmjx.jyds95.com',
          ),
          2 => 
          array (
            'title' => '衣服',
            'link' => 'index.php?app=store&act=search&id=1',
          ),
        ),
      ),
    ),
    '_widget_229' => 
    array (
      'name' => 'gcategory',
      'options' => NULL,
    ),
    '_widget_352' => 
    array (
      'name' => 'hot_sales_more_collect',
      'options' => NULL,
    ),
  ),
  'config' => 
  array (
  'top_ad_area' => 
    array (
      0 => '_widget_944',
      1 => '_widget_628',
   ),
    'store_left' => 
    array (
      0 => '_widget_229',
      1 => '_widget_352',
    ),
  ),
);

?>