<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_goods_prop`;");
E_C("CREATE TABLE `ecm_goods_prop` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_goods_prop` values('1','品牌','1','255');");
E_D("replace into `ecm_goods_prop` values('2','类别','1','255');");
E_D("replace into `ecm_goods_prop` values('3','规格','1','255');");
E_D("replace into `ecm_goods_prop` values('4','产地','1','255');");
E_D("replace into `ecm_goods_prop` values('5','价格区间','1','255');");

require("../../inc/footer.php");
?>