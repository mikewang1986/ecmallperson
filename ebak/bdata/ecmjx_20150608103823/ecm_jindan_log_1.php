<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_jindan_log`;");
E_C("CREATE TABLE `ecm_jindan_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `jiner` int(10) NOT NULL,
  `stime` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_jindan_log` values('1','10','10','2','1406563200');");
E_D("replace into `ecm_jindan_log` values('2','10','555','0','1406563200');");
E_D("replace into `ecm_jindan_log` values('3','10','10','2','1408723200');");

require("../../inc/footer.php");
?>