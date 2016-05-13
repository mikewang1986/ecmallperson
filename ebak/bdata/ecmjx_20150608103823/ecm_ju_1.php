<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_ju`;");
E_C("CREATE TABLE `ecm_ju` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(10) unsigned DEFAULT NULL,
  `cate_id` int(10) unsigned DEFAULT NULL,
  `group_name` varchar(255) NOT NULL,
  `group_desc` text,
  `goods_id` int(10) unsigned NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `spec_price` text NOT NULL,
  `max_per_user` smallint(5) unsigned DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `status_desc` varchar(50) NOT NULL,
  `recommend` tinyint(3) unsigned NOT NULL,
  `views` int(10) unsigned NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `channel` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `brand_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`group_id`),
  KEY `goods_id` (`goods_id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>