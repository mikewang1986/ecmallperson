<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_my_card`;");
E_C("CREATE TABLE `ecm_my_card` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(100) DEFAULT NULL,
  `add_time` int(10) unsigned DEFAULT NULL,
  `cz_time` int(10) unsigned DEFAULT NULL,
  `guoqi_time` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(100) DEFAULT NULL,
  `card_sn` varchar(30) DEFAULT NULL,
  `card_pass` varchar(30) DEFAULT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>