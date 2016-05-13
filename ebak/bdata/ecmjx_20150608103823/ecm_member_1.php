<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_member`;");
E_C("CREATE TABLE `ecm_member` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(60) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `real_name` varchar(60) DEFAULT NULL,
  `gender` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `birthday` date DEFAULT NULL,
  `phone_tel` varchar(60) DEFAULT NULL,
  `phone_mob` varchar(60) DEFAULT NULL,
  `im_qq` varchar(60) DEFAULT NULL,
  `im_msn` varchar(60) DEFAULT NULL,
  `im_skype` varchar(60) DEFAULT NULL,
  `im_yahoo` varchar(60) DEFAULT NULL,
  `im_aliww` varchar(60) DEFAULT NULL,
  `reg_time` int(10) unsigned DEFAULT '0',
  `last_login` int(10) unsigned DEFAULT NULL,
  `last_ip` varchar(15) DEFAULT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `ugrade` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `portrait` varchar(255) DEFAULT NULL,
  `outer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `activation` varchar(60) DEFAULT NULL,
  `feed_config` text NOT NULL,
  `growth` int(20) NOT NULL DEFAULT '0',
  `quan` int(100) NOT NULL,
  `region_id` int(10) NOT NULL,
  `lng` decimal(12,8) NOT NULL,
  `zoom` int(3) NOT NULL,
  `lat` decimal(12,8) NOT NULL,
  `sid` int(11) NOT NULL,
  `sname` varchar(150) NOT NULL,
  `is_qr` int(11) NOT NULL,
  `tuijian_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_name` (`user_name`),
  KEY `email` (`email`),
  KEY `outer_id` (`outer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_member` values('1','admin','admin@qq.com','7fef6171469e80d32c0559f88b377245','','0',NULL,NULL,NULL,'','',NULL,NULL,NULL,'1388016632','1433635028','182.137.33.216','47','1','','0',NULL,'','0','0','0','0.00000000','0','0.00000000','0','','0','0');");
E_D("replace into `ecm_member` values('2','seller','123456@qq.com','e10adc3949ba59abbe56e057f20f883e',NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1388031020','1433637437','180.116.202.169','33','1',NULL,'0',NULL,'','0','0','0','0.00000000','0','0.00000000','0','','0','0');");
E_D("replace into `ecm_member` values('3','buyer','123456@qq.com','e10adc3949ba59abbe56e057f20f883e',NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1388031042','1422898067','121.205.82.58','3','1',NULL,'0',NULL,'','0','0','0','0.00000000','0','0.00000000','0','','0','0');");
E_D("replace into `ecm_member` values('6','14336072954662','1433607295@qq.com','670b14728ad9902aecba32e22fa4f6bd',NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1433578495','1433614378','180.153.163.189','9','1','','0',NULL,'','0','0','0','0.00000000','0','0.00000000','2','超级店铺','0','0');");
E_D("replace into `ecm_member` values('7','14336649019062','1433664901@qq.com','670b14728ad9902aecba32e22fa4f6bd',NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1433636101','1433702110','180.153.205.253','4','1','','0',NULL,'','0','0','0','0.00000000','0','0.00000000','0','','0','0');");

require("../../inc/footer.php");
?>