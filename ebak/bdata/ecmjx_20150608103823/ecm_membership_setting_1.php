<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_membership_setting`;");
E_C("CREATE TABLE `ecm_membership_setting` (
  `membership_setting_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(60) NOT NULL DEFAULT '',
  `cover_image` varchar(100) NOT NULL DEFAULT '',
  `region_id` int(10) unsigned DEFAULT NULL,
  `region_name` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `card_name` varchar(60) NOT NULL DEFAULT '',
  `card_name_color` varchar(10) NOT NULL DEFAULT '',
  `bg` varchar(255) NOT NULL DEFAULT '',
  `card_bg` varchar(100) NOT NULL DEFAULT '',
  `card_num_color` varchar(10) NOT NULL DEFAULT '',
  `card_description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`membership_setting_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");
E_D("replace into `ecm_membership_setting` values('2','商城会员卡','','1','中国','北京','010-12345678','商城会员卡','FFFFFF','','themes/mall/taocz/styles/default/images/huodong/membership_card/card_bg/card_bg05.png','FFFFFF','商城官方网址http://ecmjx.jyds95.com');");

require("../../inc/footer.php");
?>