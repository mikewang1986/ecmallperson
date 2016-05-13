<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_wxrelation`;");
E_C("CREATE TABLE `ecm_wxrelation` (
  `relation_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `user_openid` varchar(65) NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `store_openid` varchar(65) NOT NULL,
  `creat_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`relation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_wxrelation` values('1','2','oXivit1csCJgBR3o4pvQNbywJgYg','2','gh_5d597e369768','0','0');");

require("../../inc/footer.php");
?>