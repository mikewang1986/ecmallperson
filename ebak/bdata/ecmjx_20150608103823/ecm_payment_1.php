<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_payment`;");
E_C("CREATE TABLE `ecm_payment` (
  `payment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `payment_code` varchar(20) NOT NULL DEFAULT '',
  `payment_name` varchar(100) NOT NULL DEFAULT '',
  `payment_desc` varchar(255) DEFAULT NULL,
  `config` text,
  `is_online` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '255',
  PRIMARY KEY (`payment_id`),
  KEY `store_id` (`store_id`),
  KEY `payment_code` (`payment_code`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_payment` values('3','2','cod','货到付款','','','0','1','0');");
E_D("replace into `ecm_payment` values('2','2','bank','银行汇款','','','0','1','0');");
E_D("replace into `ecm_payment` values('4','2','alipayfree','支付宝免签接口','','a:2:{s:18:\"alipayfree_account\";s:14:\"hxdicr@163.com\";s:5:\"pcode\";s:0:\"\";}','1','1','0');");
E_D("replace into `ecm_payment` values('5','2','cos','到店付款','','','0','1','0');");
E_D("replace into `ecm_payment` values('6','2','wxnative','微信扫码支付','','a:5:{s:5:\"appid\";s:18:\"wxd58a555551eb4b0c\";s:5:\"mchid\";s:10:\"1220360701\";s:3:\"key\";s:32:\"7b54d71fa0db7f1f58925a26a421b7ea\";s:9:\"appsecret\";s:32:\"ef9bb711068b5060677e99a8667b6b3e\";s:5:\"pcode\";s:0:\"\";}','1','1','0');");
E_D("replace into `ecm_payment` values('7','2','wxjsapi','微信jsapi支付','','a:5:{s:5:\"appid\";s:18:\"wxd58a555551eb4b0c\";s:5:\"mchid\";s:10:\"1220360701\";s:3:\"key\";s:32:\"7b54d71fa0db7f1f58925a26a421b7ea\";s:9:\"appsecret\";s:32:\"ef9bb711068b5060677e99a8667b6b3e\";s:5:\"pcode\";s:0:\"\";}','1','1','0');");
E_D("replace into `ecm_payment` values('8','2','sft','站内宝','','','0','1','0');");
E_D("replace into `ecm_payment` values('9','2','alipay_bank','支付宝网银','','a:5:{s:14:\"alipay_account\";s:15:\"yuhui.f@163.com\";s:10:\"alipay_key\";s:3:\"111\";s:14:\"alipay_partner\";s:3:\"222\";s:14:\"alipay_service\";s:25:\"create_direct_pay_by_user\";s:5:\"pcode\";s:0:\"\";}','1','1','0');");
E_D("replace into `ecm_payment` values('10','2','alipaywap','支付宝手机支付','','a:4:{s:14:\"alipay_account\";s:15:\"yuhui.f@163.com\";s:10:\"alipay_key\";s:3:\"111\";s:14:\"alipay_partner\";s:3:\"222\";s:5:\"pcode\";s:0:\"\";}','1','1','0');");
E_D("replace into `ecm_payment` values('11','2','alipay','支付宝','','a:5:{s:14:\"alipay_account\";s:14:\"hxdicr@163.com\";s:10:\"alipay_key\";s:32:\"i0zz0nszmicbvu5e13n7cuh6z7iid1j1\";s:14:\"alipay_partner\";s:16:\"2088002955346615\";s:14:\"alipay_service\";s:29:\"create_partner_trade_by_buyer\";s:5:\"pcode\";s:0:\"\";}','1','1','0');");
E_D("replace into `ecm_payment` values('12','0','alipay','支付宝','','a:5:{s:14:\"alipay_account\";s:14:\"hxdicr@163.com\";s:10:\"alipay_key\";s:32:\"i0zz0nszmicbvu5e13n7cuh6z7iid1j1\";s:14:\"alipay_partner\";s:16:\"2088002955346615\";s:14:\"alipay_service\";s:29:\"create_partner_trade_by_buyer\";s:5:\"pcode\";s:0:\"\";}','1','1','0');");

require("../../inc/footer.php");
?>