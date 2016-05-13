<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_huibiaoli_wanted`;");
E_C("CREATE TABLE `ecm_huibiaoli_wanted` (
  `w_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cate_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `price_from` decimal(10,2) NOT NULL DEFAULT '0.00',
  `price_to` decimal(10,2) NOT NULL DEFAULT '0.00',
  `region` varchar(255) NOT NULL,
  `linkman` varchar(60) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `detail` text NOT NULL,
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`w_id`),
  KEY `user_id` (`user_id`),
  KEY `cate_id` (`cate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>