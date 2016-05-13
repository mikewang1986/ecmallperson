<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_affiliate`;");
E_C("CREATE TABLE `ecm_affiliate` (
  `log_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(250) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `tname` varchar(255) NOT NULL,
  `leixing` varchar(100) NOT NULL,
  `time` int(10) NOT NULL,
  `user_id` mediumint(8) NOT NULL,
  `user_name` varchar(60) DEFAULT NULL,
  `store` int(20) NOT NULL,
  `store_name` varchar(100) NOT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `point` int(10) NOT NULL DEFAULT '0',
  `separate_type` tinyint(1) NOT NULL DEFAULT '0',
  `daiid` int(11) NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_affiliate` values('1','1502032898','91','105','注册分成','1421814463','90','106','21','测试www','65.40','0','0','0');");
E_D("replace into `ecm_affiliate` values('2','1502032898','91','104','注册分成','1421814463','89','106','21','测试www','54.50','0','0','0');");
E_D("replace into `ecm_affiliate` values('3','1502032898','91','101','注册分成','1421814463','21','106','21','测试www','43.60','0','0','0');");
E_D("replace into `ecm_affiliate` values('4','1502096266','91','105','注册分成','1421821032','90','106','21','测试www','65.40','0','0','0');");
E_D("replace into `ecm_affiliate` values('5','1502096266','91','104','注册分成','1421821032','89','106','21','测试www','54.50','0','0','0');");
E_D("replace into `ecm_affiliate` values('6','1502096266','91','101','注册分成','1421821032','21','106','21','测试www','43.60','0','0','0');");
E_D("replace into `ecm_affiliate` values('7','1502955221','96','101','代理商分成','1422672373','21','115','95','测试代理商','1.80','0','0','1038');");
E_D("replace into `ecm_affiliate` values('8','1502955221','96','sam123','代理商分成','1422672373','2','115','95','测试代理商','2.40','0','0','1047');");

require("../../inc/footer.php");
?>