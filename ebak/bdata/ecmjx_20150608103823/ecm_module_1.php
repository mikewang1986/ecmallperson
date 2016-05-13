<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_module`;");
E_C("CREATE TABLE `ecm_module` (
  `module_id` varchar(30) NOT NULL DEFAULT '',
  `module_name` varchar(100) NOT NULL DEFAULT '',
  `module_version` varchar(5) NOT NULL DEFAULT '',
  `module_desc` text NOT NULL,
  `module_config` text NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`module_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");
E_D("replace into `ecm_module` values('datacall','数据调用','1.0','可以在商城以外调用商城的数据','','1');");
E_D("replace into `ecm_module` values('dazhuanpan','幸运大转盘','1.0','转啊转啊大转盘 ','','1');");
E_D("replace into `ecm_module` values('jindan','店铺砸金蛋','1.0','砸个砸个大金蛋','','1');");
E_D("replace into `ecm_module` values('msg','手机短信','1.0','安装以后，用户可以使用手机短信收发功能','','1');");
E_D("replace into `ecm_module` values('my_money','站内宝2.2','2.2','安装以后，用户可以使用站内资金功能（卸载时请注意）','','1');");

require("../../inc/footer.php");
?>