<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_wxch_qr`;");
E_C("CREATE TABLE `ecm_wxch_qr` (
  `qid` int(7) NOT NULL AUTO_INCREMENT,
  `wxid` char(28) NOT NULL,
  `type` varchar(2) NOT NULL,
  `expire_seconds` int(4) NOT NULL,
  `action_name` varchar(30) NOT NULL,
  `scene_id` int(7) NOT NULL,
  `ticket` varchar(120) NOT NULL,
  `scene` varchar(200) NOT NULL,
  `qr_path` varchar(200) NOT NULL,
  `subscribe` int(8) unsigned NOT NULL,
  `scan` int(8) unsigned NOT NULL,
  `function` varchar(100) NOT NULL,
  `affiliate` int(8) NOT NULL,
  `endtime` int(10) NOT NULL,
  `dateline` int(10) NOT NULL,
  PRIMARY KEY (`qid`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_wxch_qr` values('20','oMVyQtyhAlXkVVatgTA-djD8FNkE','','0','QR_LIMIT_SCENE','6','gQGa7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL29reXR0NzdtbkJmbFREUngybUQxAAIEeKVzVQMEAAAAAA==','14336072954662','data/files/mall/weixin_qrcode/1433642333.jpg','1','3','','0','0','0');");

require("../../inc/footer.php");
?>