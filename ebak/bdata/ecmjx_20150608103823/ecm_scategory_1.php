<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_scategory`;");
E_C("CREATE TABLE `ecm_scategory` (
  `cate_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(100) NOT NULL DEFAULT '',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '255',
  PRIMARY KEY (`cate_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_scategory` values('1','个人穿戴','0','0');");
E_D("replace into `ecm_scategory` values('2','个人护理','0','1');");
E_D("replace into `ecm_scategory` values('3','数码设备','0','2');");
E_D("replace into `ecm_scategory` values('4','家用产品','0','3');");
E_D("replace into `ecm_scategory` values('5','吃喝保健','0','4');");
E_D("replace into `ecm_scategory` values('6','汽摩产品','0','5');");
E_D("replace into `ecm_scategory` values('7','宠物用品','0','6');");
E_D("replace into `ecm_scategory` values('8','礼品玩具','0','7');");
E_D("replace into `ecm_scategory` values('9','日用商品','0','8');");
E_D("replace into `ecm_scategory` values('10','收藏/爱好','0','255');");
E_D("replace into `ecm_scategory` values('11','游戏/话费','0','255');");
E_D("replace into `ecm_scategory` values('12','服务类别','0','255');");
E_D("replace into `ecm_scategory` values('13','其他类别','0','255');");

require("../../inc/footer.php");
?>