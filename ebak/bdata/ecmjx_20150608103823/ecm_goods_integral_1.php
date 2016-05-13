<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_goods_integral`;");
E_C("CREATE TABLE `ecm_goods_integral` (
  `goods_id` int(11) NOT NULL,
  `has_integral` int(11) NOT NULL DEFAULT '0',
  `max_exchange` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");
E_D("replace into `ecm_goods_integral` values('1','0','0');");
E_D("replace into `ecm_goods_integral` values('2','0','0');");
E_D("replace into `ecm_goods_integral` values('3','0','0');");
E_D("replace into `ecm_goods_integral` values('4','0','0');");
E_D("replace into `ecm_goods_integral` values('5','0','0');");
E_D("replace into `ecm_goods_integral` values('6','0','0');");
E_D("replace into `ecm_goods_integral` values('7','0','0');");
E_D("replace into `ecm_goods_integral` values('8','0','0');");
E_D("replace into `ecm_goods_integral` values('9','0','0');");
E_D("replace into `ecm_goods_integral` values('10','0','0');");
E_D("replace into `ecm_goods_integral` values('11','0','0');");
E_D("replace into `ecm_goods_integral` values('12','0','0');");
E_D("replace into `ecm_goods_integral` values('13','0','0');");
E_D("replace into `ecm_goods_integral` values('14','0','0');");
E_D("replace into `ecm_goods_integral` values('15','10','10');");
E_D("replace into `ecm_goods_integral` values('16','10','10');");
E_D("replace into `ecm_goods_integral` values('17','10','10');");
E_D("replace into `ecm_goods_integral` values('18','10','10');");
E_D("replace into `ecm_goods_integral` values('19','10','10');");
E_D("replace into `ecm_goods_integral` values('99','0','0');");

require("../../inc/footer.php");
?>