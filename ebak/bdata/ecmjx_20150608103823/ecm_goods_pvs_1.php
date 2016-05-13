<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_goods_pvs`;");
E_C("CREATE TABLE `ecm_goods_pvs` (
  `goods_id` int(11) NOT NULL,
  `pvs` text NOT NULL,
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");
E_D("replace into `ecm_goods_pvs` values('1','5:12;4:11;3:3;2:2;1:6');");
E_D("replace into `ecm_goods_pvs` values('2','');");
E_D("replace into `ecm_goods_pvs` values('3','');");
E_D("replace into `ecm_goods_pvs` values('4','');");
E_D("replace into `ecm_goods_pvs` values('5','');");
E_D("replace into `ecm_goods_pvs` values('6','');");
E_D("replace into `ecm_goods_pvs` values('7','');");
E_D("replace into `ecm_goods_pvs` values('8','');");
E_D("replace into `ecm_goods_pvs` values('19','');");
E_D("replace into `ecm_goods_pvs` values('20','');");
E_D("replace into `ecm_goods_pvs` values('21','');");
E_D("replace into `ecm_goods_pvs` values('25','');");
E_D("replace into `ecm_goods_pvs` values('26','');");
E_D("replace into `ecm_goods_pvs` values('27','');");
E_D("replace into `ecm_goods_pvs` values('99','');");

require("../../inc/footer.php");
?>