<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_refund`;");
E_C("CREATE TABLE `ecm_refund` (
  `refund_id` int(11) NOT NULL AUTO_INCREMENT,
  `refund_sn` varchar(50) NOT NULL,
  `order_id` int(10) NOT NULL,
  `goods_id` int(10) NOT NULL,
  `spec_id` int(10) NOT NULL,
  `refund_reason` varchar(50) NOT NULL,
  `refund_desc` varchar(255) NOT NULL,
  `total_fee` decimal(10,2) NOT NULL,
  `goods_fee` decimal(10,2) NOT NULL,
  `shipping_fee` decimal(10,2) NOT NULL,
  `refund_goods_fee` decimal(10,2) NOT NULL,
  `refund_shipping_fee` decimal(10,2) NOT NULL,
  `buyer_id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT '',
  `shipped` int(11) NOT NULL,
  `ask_customer` int(1) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  PRIMARY KEY (`refund_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>