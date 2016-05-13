<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_navigation`;");
E_C("CREATE TABLE `ecm_navigation` (
  `nav_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL DEFAULT '',
  `title` varchar(60) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '255',
  `open_new` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hot` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nav_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_navigation` values('2','middle','外卖订餐','wm/','0','1','0');");
E_D("replace into `ecm_navigation` values('3','middle','聚划算','index.php?app=ju','1','1','0');");
E_D("replace into `ecm_navigation` values('4','middle','团购','index.php?app=search&act=groupbuy','2','1','0');");
E_D("replace into `ecm_navigation` values('6','middle','积分商城','index.php?app=integral','3','1','0');");
E_D("replace into `ecm_navigation` values('7','middle','幸运大转盘','index.php?app=dazhuanpan','4','1','0');");
E_D("replace into `ecm_navigation` values('8','middle','积分砸蛋','index.php?app=search&act=eggact','5','1','0');");
E_D("replace into `ecm_navigation` values('9','middle','打折促销','index.php?app=promotion','6','1','0');");
E_D("replace into `ecm_navigation` values('10','middle','供求信息','index.php?app=sdemand','7','1','0');");
E_D("replace into `ecm_navigation` values('11','middle','附近商家','/index.php?app=nearstore&act=baidumap','255','0','0');");

require("../../inc/footer.php");
?>