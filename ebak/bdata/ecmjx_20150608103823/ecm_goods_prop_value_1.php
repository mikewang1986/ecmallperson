<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_goods_prop_value`;");
E_C("CREATE TABLE `ecm_goods_prop_value` (
  `vid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `prop_value` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`vid`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_goods_prop_value` values('1','1','红富士','1','255');");
E_D("replace into `ecm_goods_prop_value` values('2','2','苹果','1','255');");
E_D("replace into `ecm_goods_prop_value` values('3','3','礼盒装','1','255');");
E_D("replace into `ecm_goods_prop_value` values('4','4','国产','1','255');");
E_D("replace into `ecm_goods_prop_value` values('5','5','0-50','1','255');");
E_D("replace into `ecm_goods_prop_value` values('6','1','杰记水果','1','255');");
E_D("replace into `ecm_goods_prop_value` values('7','2','梨子','1','255');");
E_D("replace into `ecm_goods_prop_value` values('8','2','葡萄','1','255');");
E_D("replace into `ecm_goods_prop_value` values('9','2','红提','1','255');");
E_D("replace into `ecm_goods_prop_value` values('10','3','礼袋装','1','255');");
E_D("replace into `ecm_goods_prop_value` values('11','4','进口','1','255');");
E_D("replace into `ecm_goods_prop_value` values('12','5','50-100','1','255');");
E_D("replace into `ecm_goods_prop_value` values('13','5','100-200','1','255');");
E_D("replace into `ecm_goods_prop_value` values('14','5','200-500','1','255');");

require("../../inc/footer.php");
?>