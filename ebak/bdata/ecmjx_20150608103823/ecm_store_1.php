<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_store`;");
E_C("CREATE TABLE `ecm_store` (
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `store_name` varchar(100) NOT NULL DEFAULT '',
  `owner_name` varchar(60) NOT NULL DEFAULT '',
  `owner_card` varchar(60) NOT NULL DEFAULT '',
  `region_id` int(10) unsigned DEFAULT NULL,
  `region_name` varchar(100) DEFAULT NULL,
  `address` varchar(255) NOT NULL DEFAULT '',
  `zipcode` varchar(20) NOT NULL DEFAULT '',
  `tel` varchar(60) NOT NULL DEFAULT '',
  `sgrade` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `apply_remark` varchar(255) NOT NULL DEFAULT '',
  `credit_value` int(10) NOT NULL DEFAULT '0',
  `praise_rate` decimal(5,2) unsigned NOT NULL DEFAULT '0.00',
  `domain` varchar(60) DEFAULT NULL,
  `state` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `close_reason` varchar(255) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned DEFAULT NULL,
  `end_time` int(10) unsigned NOT NULL DEFAULT '0',
  `certification` varchar(255) DEFAULT NULL,
  `sort_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  `recommended` tinyint(4) NOT NULL DEFAULT '0',
  `theme` varchar(60) NOT NULL DEFAULT '',
  `store_banner` varchar(255) DEFAULT NULL,
  `store_logo` varchar(255) DEFAULT NULL,
  `description` text,
  `image_1` varchar(255) NOT NULL DEFAULT '',
  `image_2` varchar(255) NOT NULL DEFAULT '',
  `image_3` varchar(255) NOT NULL DEFAULT '',
  `im_qq` varchar(60) NOT NULL DEFAULT '',
  `im_ww` varchar(60) NOT NULL DEFAULT '',
  `im_msn` varchar(60) NOT NULL DEFAULT '',
  `hot_search` varchar(255) NOT NULL,
  `business_scope` varchar(50) NOT NULL,
  `online_service` varchar(255) NOT NULL,
  `hotline` varchar(255) NOT NULL,
  `pic_slides` text NOT NULL,
  `pic_slides_wap` text NOT NULL,
  `enable_groupbuy` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `enable_radar` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `waptheme` varchar(60) NOT NULL DEFAULT '',
  `amount_for_free_fee` int(255) DEFAULT NULL,
  `acount_for_free_fee` int(255) DEFAULT NULL,
  `send_address` varchar(255) NOT NULL,
  `operate_time` varchar(255) NOT NULL,
  `is_open_pay` tinyint(3) NOT NULL DEFAULT '1',
  `store_code` varchar(250) NOT NULL,
  `appkey` varchar(9) NOT NULL,
  `secretKey` varchar(32) NOT NULL,
  `lng` decimal(12,8) NOT NULL,
  `zoom` int(3) NOT NULL,
  `lat` decimal(12,8) NOT NULL,
  `is_open_storemap` tinyint(3) NOT NULL DEFAULT '0',
  `store_wei` varchar(255) DEFAULT NULL,
  `enable_slides` tinyint(3) unsigned NOT NULL,
  `is_affter` tinyint(3) unsigned NOT NULL,
  `reg_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `tuij_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`store_id`),
  KEY `store_name` (`store_name`),
  KEY `owner_name` (`owner_name`),
  KEY `region_id` (`region_id`),
  KEY `domain` (`domain`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");
E_D("replace into `ecm_store` values('2','超级店铺','超级店家','','0','','','','88888888','2','','0','0.00','','1','','1388031275','0','autonym,material','1','1','moolau|default',NULL,NULL,'','','','','54061698','琪琦网购','','琪琦网购源码,微信商城','','','','','{\"1\":{\"url\":\"data/files/store_2/pic_slides_wap/pic_slides_wap_1.jpg\",\"link\":\"#\"},\"2\":{\"url\":\"data/files/store_2/pic_slides_wap/pic_slides_wap_2.jpg\",\"link\":\"#\"},\"3\":{\"url\":\"data/files/store_2/pic_slides_wap/pic_slides_wap_3.jpg\",\"link\":\"#\"}}','1','1','default03|default','0','0','全国','09:00-23:00','1','','','','0.00000000','0','0.00000000','0',NULL,'0','0','0.00','0.00');");

require("../../inc/footer.php");
?>