<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_acategory`;");
E_C("CREATE TABLE `ecm_acategory` (
  `cate_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(100) NOT NULL DEFAULT '',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '255',
  `code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_acategory` values('1','商城帮助','0','0','help');");
E_D("replace into `ecm_acategory` values('2','商城公告','0','0','notice');");
E_D("replace into `ecm_acategory` values('3','内置文章','0','0','system');");
E_D("replace into `ecm_acategory` values('4','帮助中心','1','1',NULL);");
E_D("replace into `ecm_acategory` values('5','支付帮助','1','2',NULL);");
E_D("replace into `ecm_acategory` values('6','消费保障','1','3',NULL);");
E_D("replace into `ecm_acategory` values('7','服务条款','1','4',NULL);");
E_D("replace into `ecm_acategory` values('8','特色服务','1','5',NULL);");
E_D("replace into `ecm_acategory` values('9','商家服务','1','6',NULL);");

require("../../inc/footer.php");
?>