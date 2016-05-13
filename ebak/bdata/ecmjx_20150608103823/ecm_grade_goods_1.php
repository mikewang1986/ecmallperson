<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_grade_goods`;");
E_C("CREATE TABLE `ecm_grade_goods` (
  `goods_id` int(255) NOT NULL,
  `grade_id` int(20) NOT NULL,
  `grade` int(20) NOT NULL,
  `grade_discount` decimal(4,2) NOT NULL DEFAULT '1.00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>