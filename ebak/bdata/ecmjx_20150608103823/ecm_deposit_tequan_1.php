<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_deposit_tequan`;");
E_C("CREATE TABLE `ecm_deposit_tequan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tradesn` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `money` varchar(200) NOT NULL,
  `is_online` int(10) NOT NULL,
  `add_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>