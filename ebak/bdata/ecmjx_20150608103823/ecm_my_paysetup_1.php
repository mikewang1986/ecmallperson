<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_my_paysetup`;");
E_C("CREATE TABLE `ecm_my_paysetup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chinabank_key` varchar(255) DEFAULT NULL,
  `chinabank_mid` int(32) unsigned DEFAULT NULL,
  `chinabank_url` varchar(255) DEFAULT NULL,
  `chinabank_remark1` varchar(255) DEFAULT NULL,
  `chinabank_remark2` varchar(255) DEFAULT NULL,
  `yeepay_key` varchar(255) DEFAULT NULL,
  `yeepay_mid` int(32) unsigned DEFAULT NULL,
  `yeepay_url` varchar(255) DEFAULT NULL,
  `yeepay_ext1` varchar(255) DEFAULT NULL,
  `yeepay_ext2` varchar(255) DEFAULT NULL,
  `yeepay_bank` int(8) unsigned NOT NULL DEFAULT '100',
  `yeepay_junnet` int(8) unsigned NOT NULL DEFAULT '100',
  `yeepay_sndacard` int(8) unsigned NOT NULL DEFAULT '100',
  `yeepay_szx` int(8) unsigned NOT NULL DEFAULT '100',
  `yeepay_zhengtu` int(8) unsigned NOT NULL DEFAULT '100',
  `yeepay_qqcard` int(8) unsigned NOT NULL DEFAULT '100',
  `yeepay_unicom` int(8) unsigned NOT NULL DEFAULT '100',
  `yeepay_jiuyou` int(8) unsigned NOT NULL DEFAULT '100',
  `yeepay_ypcard` int(8) unsigned NOT NULL DEFAULT '100',
  `yeepay_lianhuaokcard` int(8) unsigned NOT NULL DEFAULT '100',
  `yeepay_netease` int(8) unsigned NOT NULL DEFAULT '100',
  `yeepay_wanmei` int(8) unsigned NOT NULL DEFAULT '100',
  `yeepay_sohu` int(8) unsigned NOT NULL DEFAULT '100',
  `alipay_id` varchar(255) DEFAULT NULL,
  `alipay_key` varchar(255) DEFAULT NULL,
  `alipay_jiekou` varchar(255) DEFAULT NULL,
  `alipay_qubiema` varchar(255) DEFAULT NULL,
  `tenpay_id` varchar(255) DEFAULT NULL,
  `tenpay_key` varchar(255) DEFAULT NULL,
  `tenpay_qianmeng` varchar(255) DEFAULT NULL,
  `tenpay_qubiema` varchar(255) DEFAULT NULL,
  `tenpay2_id` varchar(255) DEFAULT NULL,
  `tenpay2_key` varchar(255) DEFAULT NULL,
  `tenpay2_leixing` varchar(255) DEFAULT NULL,
  `tenpay2_qubiema` varchar(255) DEFAULT NULL,
  `bank_icbc_id` varchar(255) DEFAULT NULL,
  `bank_icbc_name` varchar(255) DEFAULT NULL,
  `bank_icbc_add` varchar(255) DEFAULT NULL,
  `bank_ccb_id` varchar(255) DEFAULT NULL,
  `bank_ccb_name` varchar(255) DEFAULT NULL,
  `bank_ccb_add` varchar(255) DEFAULT NULL,
  `bank_abb_id` varchar(255) DEFAULT NULL,
  `bank_abb_name` varchar(255) DEFAULT NULL,
  `bank_abb_add` varchar(255) DEFAULT NULL,
  `bank_cib_id` varchar(255) DEFAULT NULL,
  `bank_cib_name` varchar(255) DEFAULT NULL,
  `bank_cib_add` varchar(255) DEFAULT NULL,
  `bank_bc_id` varchar(255) DEFAULT NULL,
  `bank_bc_name` varchar(255) DEFAULT NULL,
  `bank_bc_add` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_my_paysetup` values('1','350500198704145018','21391940','index.php?app=my_money&act=chinabank_pay',NULL,NULL,'','0','','','','100','100','100','100','100','100','100','100','100','100','100','100','100',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);");

require("../../inc/footer.php");
?>