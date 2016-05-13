<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_deposit_recharge`;");
E_C("CREATE TABLE `ecm_deposit_recharge` (
  `recharge_id` int(11) NOT NULL AUTO_INCREMENT,
  `tradesn` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(30) NOT NULL,
  `is_online` int(1) NOT NULL,
  `extra` text NOT NULL,
  `add_time` int(11) NOT NULL,
  `pay_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `order_id` int(10) NOT NULL,
  PRIMARY KEY (`recharge_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>