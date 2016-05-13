<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_my_jifen`;");
E_C("CREATE TABLE `ecm_my_jifen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `yes_no` int(10) NOT NULL DEFAULT '0',
  `ids` int(10) NOT NULL DEFAULT '0',
  `add_time` int(10) unsigned DEFAULT NULL,
  `jifen` int(10) NOT NULL DEFAULT '0',
  `wupin_name` varchar(60) DEFAULT NULL,
  `wupin_imgs` varchar(255) DEFAULT NULL,
  `wupin_img` varchar(255) DEFAULT NULL,
  `jiazhi` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shuliang` int(10) unsigned NOT NULL DEFAULT '0',
  `yiduihuan` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(100) DEFAULT NULL,
  `my_name` varchar(100) DEFAULT NULL,
  `my_add` varchar(255) DEFAULT NULL,
  `my_tel` varchar(255) DEFAULT NULL,
  `my_mobile` varchar(255) DEFAULT NULL,
  `log_text` text,
  `shenhe` int(10) NOT NULL DEFAULT '0',
  `wuliu_name` varchar(100) DEFAULT NULL,
  `wuliu_danhao` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_my_jifen` values('1','1','255','1422924371','1','测试积分商品',NULL,'data/files/mall/jifen_img/1.jpg','1.00','1000','0','0',NULL,NULL,NULL,NULL,NULL,'','0',NULL,NULL);");

require("../../inc/footer.php");
?>