<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_ugrade`;");
E_C("CREATE TABLE `ecm_ugrade` (
  `grade_id` int(255) NOT NULL AUTO_INCREMENT,
  `grade_name` varchar(255) NOT NULL,
  `grade` tinyint(3) NOT NULL,
  `grade_icon` varchar(255) DEFAULT NULL,
  `growth_needed` int(20) NOT NULL,
  `top_growth` int(20) DEFAULT NULL,
  `floor_growth` int(20) NOT NULL,
  `add_time` int(20) DEFAULT NULL,
  PRIMARY KEY (`grade_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_ugrade` values('1','普通会员','1',NULL,'0','1000','0','1395866446');");
E_D("replace into `ecm_ugrade` values('2','VIP等级','2',NULL,'1000',NULL,'1000','1422883598');");

require("../../inc/footer.php");
?>