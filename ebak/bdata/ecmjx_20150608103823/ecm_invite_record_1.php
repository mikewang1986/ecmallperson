<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_invite_record`;");
E_C("CREATE TABLE `ecm_invite_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `user_name` varchar(120) NOT NULL DEFAULT '0',
  `invite_id` int(10) NOT NULL DEFAULT '0',
  `invite_name` varchar(120) NOT NULL DEFAULT '0',
  `user_ip` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `start_time` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_invite_record` values('1','14','xiaozhi10','6','德可士','125.89.50.209','1417825761');");

require("../../inc/footer.php");
?>