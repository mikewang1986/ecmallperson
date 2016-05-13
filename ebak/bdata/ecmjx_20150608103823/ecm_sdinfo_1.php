<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_sdinfo`;");
E_C("CREATE TABLE `ecm_sdinfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `cate_id` int(10) NOT NULL,
  `cate_name` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '255',
  `verify` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(60) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `add_time` int(10) unsigned NOT NULL,
  `price_from` decimal(10,2) NOT NULL,
  `price_to` decimal(10,2) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `images` varchar(255) NOT NULL,
  `verify_desc` varchar(100) NOT NULL,
  `region_id` int(10) unsigned NOT NULL,
  `region_name` varchar(100) NOT NULL,
  `views` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_sdinfo` values('1','573','1','房屋出租','3室一厅','<p>示范11111</p>','255','1','1111','18888888','1000.00','1404240660','0.00','0.00','1','','','11','厦门市','31');");
E_D("replace into `ecm_sdinfo` values('2','3','1','房屋出租','2古埯城城','<p>霏霏地</p>','255','1','随便坐就','18585067260','150.00','1418628410','0.00','0.00','1','','','486','中国	北京	北京','1');");

require("../../inc/footer.php");
?>