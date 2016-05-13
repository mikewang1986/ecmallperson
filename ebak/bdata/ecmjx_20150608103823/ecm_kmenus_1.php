<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_kmenus`;");
E_C("CREATE TABLE `ecm_kmenus` (
  `kmenus_id` int(10) unsigned NOT NULL,
  `stypeinfo` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `stype` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`kmenus_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");
E_D("replace into `ecm_kmenus` values('2','4','0','1');");

require("../../inc/footer.php");
?>