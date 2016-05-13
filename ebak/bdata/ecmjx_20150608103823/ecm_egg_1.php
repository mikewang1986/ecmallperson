<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_egg`;");
E_C("CREATE TABLE `ecm_egg` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `noun` int(10) DEFAULT NULL COMMENT '所需积分',
  `rate` int(10) DEFAULT NULL COMMENT '中奖比例 为千分比',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_egg` values('1','金蛋','1000','10');");
E_D("replace into `ecm_egg` values('2','银蛋','500','100');");
E_D("replace into `ecm_egg` values('3','铜蛋','100','500');");

require("../../inc/footer.php");
?>