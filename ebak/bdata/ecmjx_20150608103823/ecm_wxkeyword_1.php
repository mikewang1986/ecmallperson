<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_wxkeyword`;");
E_C("CREATE TABLE `ecm_wxkeyword` (
  `kid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `kename` varchar(300) DEFAULT NULL,
  `kecontent` varchar(500) DEFAULT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1:文本 2：图文',
  `kyword` varchar(255) DEFAULT NULL,
  `titles` varchar(1000) DEFAULT NULL,
  `imageinfo` varchar(1000) DEFAULT NULL,
  `linkinfo` varchar(1000) DEFAULT NULL,
  `ismess` tinyint(1) DEFAULT NULL,
  `isfollow` tinyint(1) DEFAULT NULL,
  `iskey` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`kid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_wxkeyword` values('1','0',NULL,'','2',NULL,'a:1:{i:0;s:30:\"琪琦网购商城欢迎您！\";}','a:1:{i:0;s:69:\"http://ecmjx.jyds95.com/data/files/mall/weixin/201506071625066001.jpg\";}','a:1:{i:0;s:23:\"http://ecmjx.jyds95.com\";}',NULL,'1',NULL);");
E_D("replace into `ecm_wxkeyword` values('8','0',NULL,'','2',NULL,'a:1:{i:0;s:30:\"琪琦网购商城欢迎您！\";}','a:1:{i:0;s:69:\"http://ecmjx.jyds95.com/data/files/mall/weixin/201506071625066001.jpg\";}','a:1:{i:0;s:23:\"http://ecmjx.jyds95.com\";}',NULL,'1',NULL);");
E_D("replace into `ecm_wxkeyword` values('5','2','微店铺','','2','微店铺','a:2:{i:0;s:30:\"演示微店铺，点击进入\";i:1;s:39:\"测试商品，点击进入测试购买\";}','a:2:{i:0;s:45:\"data/files/mall/weixin/201406260253518453.jpg\";i:1;s:45:\"data/files/mall/weixin/201406260255406158.jpg\";}','a:2:{i:0;s:48:\"http://ecmjx.jyds95.com/index.php?app=store&id=2\";i:1;s:49:\"http://ecmjx.jyds95.com/index.php?app=goods&id=99\";}',NULL,NULL,'1');");
E_D("replace into `ecm_wxkeyword` values('4','2',NULL,'','2',NULL,'a:1:{i:0;s:21:\"琪琦网购欢迎您\";}','a:1:{i:0;s:45:\"data/files/mall/weixin/201506070916056269.jpg\";}','a:1:{i:0;s:23:\"http://ecmjx.jyds95.com\";}','1',NULL,NULL);");
E_D("replace into `ecm_wxkeyword` values('6','2','微商城','','2','微商城','a:1:{i:0;s:30:\"演示微商城，点击进入\";}','a:1:{i:0;s:45:\"data/files/mall/weixin/201406260253518453.jpg\";}','a:1:{i:0;s:23:\"http://ecmjx.jyds95.com\";}',NULL,NULL,'1');");
E_D("replace into `ecm_wxkeyword` values('7','2','关于我们','本演示站官方淘宝店：琪琦网购商城网站源码，淘宝旺旺：琪琦网购，客服QQ：540616918。请亲们仔细辨别，以免受骗！','1','关于我们','','','',NULL,NULL,'1');");

require("../../inc/footer.php");
?>