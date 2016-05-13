<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_wxconfig`;");
E_C("CREATE TABLE `ecm_wxconfig` (
  `w_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `appid` varchar(255) DEFAULT NULL,
  `appsecret` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`w_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_wxconfig` values('1','2','http://ecmjx.jyds95.com/index.php?app=weixin&id=2','R58XBq30','wx43655f55327990d8','af177da5c74d126faed8a338d2be36da');");
E_D("replace into `ecm_wxconfig` values('2','0','http://ecmjx.jyds95.com/index.php?app=weixin&id=0','QqwadCeN','wx8db928373bf1b2b8','6f274339c36e508e1aebb79cca0ec002');");

require("../../inc/footer.php");
?>