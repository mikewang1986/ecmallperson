<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_sessions_data`;");
E_C("CREATE TABLE `ecm_sessions_data` (
  `sesskey` varchar(32) NOT NULL DEFAULT '',
  `expiry` int(11) NOT NULL DEFAULT '0',
  `data` longtext NOT NULL,
  PRIMARY KEY (`sesskey`),
  KEY `expiry` (`expiry`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");
E_D("replace into `ecm_sessions_data` values('d69a83c34aacba8631d7e2b6bb1fde7f','1433703549','user_info|a:6:{s:7:\"user_id\";s:1:\"7\";s:9:\"user_name\";s:14:\"14336649019062\";s:8:\"reg_time\";s:10:\"1433636101\";s:10:\"last_login\";s:10:\"1433699780\";s:7:\"last_ip\";s:13:\"182.136.62.91\";s:8:\"store_id\";N;}referid|s:1:\"7\";tuijian_id|s:1:\"7\";');");
E_D("replace into `ecm_sessions_data` values('e392eb5428ce5e4f8458808b6cf91512','1433639984','user_info|a:6:{s:7:\"user_id\";s:1:\"2\";s:9:\"user_name\";s:6:\"seller\";s:8:\"reg_time\";s:10:\"1388031020\";s:10:\"last_login\";s:10:\"1433611310\";s:7:\"last_ip\";s:14:\"182.137.33.216\";s:8:\"store_id\";s:1:\"2\";}admin_info|a:5:{s:7:\"user_id\";s:1:\"1\";s:9:\"user_name\";s:5:\"admin\";s:8:\"reg_time\";s:10:\"1388016632\";s:10:\"last_login\";s:10:\"1433630636\";s:7:\"last_ip\";s:14:\"182.137.33.216\";}name|s:0:\"\";wapstore|s:0:\"\";wapstore_id|i:2;');");

require("../../inc/footer.php");
?>