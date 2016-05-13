<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_eggpresentrec`;");
E_C("CREATE TABLE `ecm_eggpresentrec` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL COMMENT '用户名称',
  `presentname` varchar(50) DEFAULT NULL COMMENT '礼品名称',
  `eggname` varchar(50) DEFAULT NULL COMMENT '砸的蛋的名称  如金蛋',
  `addtime` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>