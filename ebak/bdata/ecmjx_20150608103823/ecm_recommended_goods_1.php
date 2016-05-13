<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_recommended_goods`;");
E_C("CREATE TABLE `ecm_recommended_goods` (
  `recom_id` int(10) unsigned NOT NULL DEFAULT '0',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '255',
  PRIMARY KEY (`recom_id`,`goods_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");
E_D("replace into `ecm_recommended_goods` values('2','27','255');");
E_D("replace into `ecm_recommended_goods` values('2','26','255');");
E_D("replace into `ecm_recommended_goods` values('2','25','255');");
E_D("replace into `ecm_recommended_goods` values('2','24','255');");
E_D("replace into `ecm_recommended_goods` values('2','23','255');");
E_D("replace into `ecm_recommended_goods` values('2','22','255');");
E_D("replace into `ecm_recommended_goods` values('2','21','255');");
E_D("replace into `ecm_recommended_goods` values('2','20','255');");
E_D("replace into `ecm_recommended_goods` values('2','19','255');");
E_D("replace into `ecm_recommended_goods` values('2','18','255');");
E_D("replace into `ecm_recommended_goods` values('2','17','255');");
E_D("replace into `ecm_recommended_goods` values('2','16','255');");
E_D("replace into `ecm_recommended_goods` values('1','15','255');");
E_D("replace into `ecm_recommended_goods` values('1','14','255');");
E_D("replace into `ecm_recommended_goods` values('1','13','255');");
E_D("replace into `ecm_recommended_goods` values('1','12','255');");
E_D("replace into `ecm_recommended_goods` values('1','11','255');");
E_D("replace into `ecm_recommended_goods` values('1','10','255');");
E_D("replace into `ecm_recommended_goods` values('1','9','255');");
E_D("replace into `ecm_recommended_goods` values('1','8','255');");
E_D("replace into `ecm_recommended_goods` values('1','7','255');");
E_D("replace into `ecm_recommended_goods` values('1','6','255');");
E_D("replace into `ecm_recommended_goods` values('1','5','255');");
E_D("replace into `ecm_recommended_goods` values('1','4','255');");
E_D("replace into `ecm_recommended_goods` values('1','3','255');");
E_D("replace into `ecm_recommended_goods` values('1','2','255');");
E_D("replace into `ecm_recommended_goods` values('1','1','255');");

require("../../inc/footer.php");
?>