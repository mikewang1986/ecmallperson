<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_my_moneylog`;");
E_C("CREATE TABLE `ecm_my_moneylog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `user_name` varchar(50) DEFAULT '0',
  `order_id` int(10) NOT NULL DEFAULT '0',
  `order_sn` varchar(50) DEFAULT '0',
  `seller_id` int(10) unsigned DEFAULT NULL,
  `seller_name` varchar(100) DEFAULT NULL,
  `buyer_id` int(10) unsigned DEFAULT NULL,
  `buyer_name` varchar(100) DEFAULT NULL,
  `coupon_id` int(10) unsigned DEFAULT NULL,
  `coupon_sn` varchar(50) DEFAULT '0',
  `coupon_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tx_username` varchar(50) DEFAULT NULL,
  `tx_bankname` varchar(50) DEFAULT NULL,
  `tx_banksn` varchar(50) DEFAULT NULL,
  `tx_add` varchar(255) DEFAULT NULL,
  `add_time` int(10) unsigned DEFAULT NULL,
  `admin_name` varchar(100) DEFAULT NULL,
  `admin_time` int(10) unsigned DEFAULT NULL,
  `leixing` int(3) unsigned NOT NULL DEFAULT '0',
  `caozuo` int(3) unsigned NOT NULL DEFAULT '0',
  `s_and_z` int(3) unsigned DEFAULT NULL,
  `user_log_del` int(3) unsigned DEFAULT '0',
  `money_zs` decimal(10,2) NOT NULL DEFAULT '0.00',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `log_text` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_my_moneylog` values('1','3','buyer','0','2015-02-03-092814',NULL,NULL,NULL,NULL,NULL,'0','0.00',NULL,NULL,NULL,NULL,'1422926894','admin',NULL,'30','50','1','0','1000.00','0.00','admin管理员手工操作用户资金');");
E_D("replace into `ecm_my_moneylog` values('2','3','buyer','2','1503306357','2','seller','3','buyer',NULL,'0','0.00',NULL,NULL,NULL,NULL,'1422926928',NULL,NULL,'20','10','2','0','-30.60','30.60','购买商品，店主 seller');");
E_D("replace into `ecm_my_moneylog` values('3','2','seller','2','1503306357','2','seller','3','buyer',NULL,'0','0.00',NULL,NULL,NULL,NULL,'1422926928',NULL,NULL,'10','10','1','0','30.60','30.60','出售商品，买家 buyer');");

require("../../inc/footer.php");
?>