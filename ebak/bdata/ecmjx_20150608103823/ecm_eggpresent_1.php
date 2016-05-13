<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_eggpresent`;");
E_C("CREATE TABLE `ecm_eggpresent` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `eggpresent_logo` varchar(255) DEFAULT NULL COMMENT '缩略图',
  `byeggid` int(10) DEFAULT NULL COMMENT '所属的蛋的id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>