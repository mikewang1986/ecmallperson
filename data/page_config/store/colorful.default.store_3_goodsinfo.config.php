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
        'bgcolor' => '',
        'txtcolor' => '',
        'txtbgcolor' => '',
        'curtxtcolor' => '',
        'curtxtbgcolor' => '',
        'title' => 
        array (
          0 => '裤子',
          1 => '衣服',
        ),
        'link' => 
        array (
          0 => 'index.php?app=store&act=search&id=1',
          1 => 'index.php?app=store&act=search&id=2',
        ),
        'navs' => 
        array (
          0 => 
          array (
            'title' => '裤子',
            'link' => 'index.php?app=store&act=search&id=1',
          ),
          1 => 
          array (
            'title' => '衣服',
            'link' => 'index.php?app=store&act=search&id=2',
          ),
        ),
      ),
    ),
    '_widget_698' => 
    array (
      'name' => 'hot_sales_more_collect',
      'options' => NULL,
    ),
    '_widget_640' => 
    array (
      'name' => 'gcategory',
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
      0 => '_widget_698',
      1 => '_widget_640',
    ),
  ),
);

?>