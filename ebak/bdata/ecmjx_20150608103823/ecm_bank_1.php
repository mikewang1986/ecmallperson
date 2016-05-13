<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_bank`;");
E_C("CREATE TABLE `ecm_bank` (
  `bid` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `short_name` varchar(20) NOT NULL,
  `account_name` varchar(20) NOT NULL,
  `open_bank` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL,
  `num` varchar(50) NOT NULL,
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>