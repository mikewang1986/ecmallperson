<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_my_money`;");
E_C("CREATE TABLE `ecm_my_money` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `add_time` int(10) unsigned DEFAULT NULL,
  `mibao_id` int(10) NOT NULL DEFAULT '0',
  `mibao_sn` varchar(30) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(100) DEFAULT NULL,
  `bank_sn` varchar(100) DEFAULT NULL,
  `bank_name` varchar(20) DEFAULT NULL,
  `bank_username` varchar(20) DEFAULT NULL,
  `bank_add` varchar(60) DEFAULT NULL,
  `zf_pass` varchar(32) DEFAULT NULL,
  `pass_tw` varchar(60) DEFAULT NULL,
  `pass_hd` varchar(60) DEFAULT NULL,
  `jifen_z` int(10) NOT NULL DEFAULT '0',
  `jifen` int(10) NOT NULL DEFAULT '0',
  `money_dj` decimal(10,2) NOT NULL DEFAULT '0.00',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_my_money` values('1','1422910869','0',NULL,'2','seller',NULL,NULL,NULL,NULL,'e10adc3949ba59abbe56e057f20f883e',NULL,NULL,'0','0','30.60','0.00');");
E_D("replace into `ecm_my_money` values('2','1422926867','0',NULL,'3','buyer',NULL,NULL,NULL,NULL,'e10adc3949ba59abbe56e057f20f883e',NULL,NULL,'0','0','0.00','969.40');");
E_D("replace into `ecm_my_money` values('3','1422926969','0',NULL,'4','南京彩斯',NULL,NULL,NULL,NULL,'7c99039473f6d699d33018053d097207',NULL,NULL,'0','0','0.00','0.00');");

require("../../inc/footer.php");
?>