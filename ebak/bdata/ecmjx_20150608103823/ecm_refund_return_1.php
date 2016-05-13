<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_refund_return`;");
E_C("CREATE TABLE `ecm_refund_return` (
  `refund_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(60) NOT NULL DEFAULT '',
  `user_id` int(10) unsigned DEFAULT NULL,
  `logistics_company` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `return_mark` varchar(255) NOT NULL,
  `phone_mob` varchar(60) DEFAULT NULL,
  `shipping_name` varchar(100) DEFAULT NULL,
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice_no` varchar(255) NOT NULL,
  PRIMARY KEY (`refund_id`),
  KEY `consignee` (`user_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>