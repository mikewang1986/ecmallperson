<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_deposit_record`;");
E_C("CREATE TABLE `ecm_deposit_record` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `tradesn` varchar(30) NOT NULL,
  `order_sn` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `party_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `flow` varchar(10) NOT NULL,
  `purpose` varchar(20) NOT NULL,
  `status` varchar(30) NOT NULL,
  `payway` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `add_time` int(11) NOT NULL,
  `pay_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  PRIMARY KEY (`record_id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>