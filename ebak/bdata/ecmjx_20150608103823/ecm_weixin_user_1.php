<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_weixin_user`;");
E_C("CREATE TABLE `ecm_weixin_user` (
  `uid` int(7) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `subscribe` tinyint(1) unsigned NOT NULL,
  `wxid` char(28) NOT NULL,
  `nickname` varchar(200) NOT NULL,
  `sex` tinyint(1) unsigned NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `language` varchar(50) NOT NULL,
  `headimgurl` varchar(200) NOT NULL,
  `subscribe_time` int(10) unsigned NOT NULL,
  `localimgurl` varchar(200) NOT NULL,
  `setp` smallint(2) unsigned NOT NULL,
  `uname` varchar(50) NOT NULL,
  `coupon` varchar(30) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_weixin_user` values('91','6','0','oMVyQtyhAlXkVVatgTA-djD8FNkE','','0','','','','','','0','','3','','');");
E_D("replace into `ecm_weixin_user` values('92','7','0','ohiDjs8eA3BsAMm8lcAUT5UT-s4w','','0','','','','','','0','','3','','');");

require("../../inc/footer.php");
?>