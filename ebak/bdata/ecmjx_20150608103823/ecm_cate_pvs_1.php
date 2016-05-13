<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_cate_pvs`;");
E_C("CREATE TABLE `ecm_cate_pvs` (
  `cate_id` int(11) NOT NULL,
  `pvs` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8");
E_D("replace into `ecm_cate_pvs` values('19','1:1;1:6;2:2;2:7;2:8;2:9;3:3;3:10;4:4;4:11;5:5;5:12;5:13;5:14');");
E_D("replace into `ecm_cate_pvs` values('20','1:1;1:6;2:2;2:7;2:8;2:9;3:3;3:10;4:4;4:11;5:5;5:12;5:13;5:14');");
E_D("replace into `ecm_cate_pvs` values('97','1:1;1:6;2:2;2:7;2:8;2:9;3:3;3:10;4:4;4:11;5:5;5:12;5:13;5:14');");

require("../../inc/footer.php");
?>