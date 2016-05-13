<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_ju_template`;");
E_C("CREATE TABLE `ecm_ju_template` (
  `template_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_name` varchar(50) NOT NULL,
  `start_time` int(10) unsigned NOT NULL,
  `join_end_time` int(10) unsigned NOT NULL,
  `end_time` int(10) unsigned NOT NULL,
  `state` tinyint(1) unsigned NOT NULL,
  `channel` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`template_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_ju_template` values('4','双12促销','1413577363','1414009363','1414700563','2','1');");
E_D("replace into `ecm_ju_template` values('5','新年团购','1418716800','1421395200','1450252800','1','1');");

require("../../inc/footer.php");
?>