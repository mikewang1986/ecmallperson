<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_order_extm`;");
E_C("CREATE TABLE `ecm_order_extm` (
  `order_id` int(10) unsigned NOT NULL DEFAULT '0',
  `consignee` varchar(60) NOT NULL DEFAULT '',
  `region_id` int(10) unsigned DEFAULT NULL,
  `region_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `zipcode` varchar(20) DEFAULT NULL,
  `phone_tel` varchar(60) DEFAULT NULL,
  `phone_mob` varchar(60) DEFAULT NULL,
  `shipping_id` int(10) unsigned DEFAULT NULL,
  `shipping_name` varchar(100) DEFAULT NULL,
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`order_id`),
  KEY `consignee` (`consignee`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");
E_D("replace into `ecm_order_extm` values('1','超级买家','1','中国','请如实填写收货人详细地址','','','8888888','1','快递','0.10');");
E_D("replace into `ecm_order_extm` values('2','超级买家','1','中国','请如实填写收货人详细地址','','','8888888','1','包邮','0.00');");

require("../../inc/footer.php");
?>