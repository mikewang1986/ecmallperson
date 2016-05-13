<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_order_integral`;");
E_C("CREATE TABLE `ecm_order_integral` (
  `order_id` int(11) NOT NULL,
  `buyer_has_integral` int(11) NOT NULL DEFAULT '0',
  `seller_has_integral` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>