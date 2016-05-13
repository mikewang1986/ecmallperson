<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_promotion`;");
E_C("CREATE TABLE `ecm_promotion` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL,
  `pro_name` varchar(50) NOT NULL,
  `pro_desc` varchar(255) NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `spec_price` text NOT NULL,
  PRIMARY KEY (`pro_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_promotion` values('1','1','测试促销商品','测试促销商品描述','1418630400','1420099199','3','a:1:{i:1;a:3:{s:5:\"price\";s:4:\"0.05\";s:8:\"pro_type\";s:5:\"price\";s:6:\"is_pro\";i:1;}}');");

require("../../inc/footer.php");
?>