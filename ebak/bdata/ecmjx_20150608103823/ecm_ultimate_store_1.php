<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_ultimate_store`;");
E_C("CREATE TABLE `ecm_ultimate_store` (
  `ultimate_id` int(255) NOT NULL AUTO_INCREMENT,
  `brand_id` int(50) NOT NULL,
  `keyword` varchar(20) NOT NULL,
  `cate_id` int(50) NOT NULL,
  `store_id` int(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ultimate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>