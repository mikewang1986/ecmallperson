<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_wxfile`;");
E_C("CREATE TABLE `ecm_wxfile` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `file_type` varchar(60) NOT NULL,
  `file_size` int(10) NOT NULL DEFAULT '0',
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_wxfile` values('1','2','image/jpeg','81999','slider.jpg','data/files/mall/weixin/201406260253518453.jpg');");
E_D("replace into `ecm_wxfile` values('2','2','image/jpeg','2895','icon.jpg','data/files/mall/weixin/201406260255406158.jpg');");
E_D("replace into `ecm_wxfile` values('3','2','image/jpeg','224818','pic_slides_wap_1.jpg','data/files/mall/weixin/201506070916056269.jpg');");
E_D("replace into `ecm_wxfile` values('4','0','image/jpeg','224818','pic_slides_wap_1.jpg','data/files/mall/weixin/201506071625066001.jpg');");

require("../../inc/footer.php");
?>