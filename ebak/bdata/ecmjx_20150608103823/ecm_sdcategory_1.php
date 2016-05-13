<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_sdcategory`;");
E_C("CREATE TABLE `ecm_sdcategory` (
  `cate_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(100) NOT NULL DEFAULT '',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '255',
  `if_show` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_sdcategory` values('1','房屋出租','0','255','1');");
E_D("replace into `ecm_sdcategory` values('2','汽车租赁','0','255','1');");
E_D("replace into `ecm_sdcategory` values('3','跳蚤市场','0','255','1');");
E_D("replace into `ecm_sdcategory` values('4','电子产品','3','1','1');");
E_D("replace into `ecm_sdcategory` values('5','家电类','3','2','1');");

require("../../inc/footer.php");
?>