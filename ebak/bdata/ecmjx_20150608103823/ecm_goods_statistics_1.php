<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_goods_statistics`;");
E_C("CREATE TABLE `ecm_goods_statistics` (
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `collects` int(10) unsigned NOT NULL DEFAULT '0',
  `carts` int(10) unsigned NOT NULL DEFAULT '0',
  `orders` int(10) unsigned NOT NULL DEFAULT '0',
  `sales` int(10) unsigned NOT NULL DEFAULT '0',
  `comments` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");
E_D("replace into `ecm_goods_statistics` values('1','1','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('2','1','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('3','1','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('4','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('5','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('6','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('7','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('8','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('9','2','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('10','1','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('11','9','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('12','3','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('13','5','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('14','1','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('15','6','0','1','1','0','0');");
E_D("replace into `ecm_goods_statistics` values('16','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('17','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('18','1','0','1','1','0','0');");
E_D("replace into `ecm_goods_statistics` values('19','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('20','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('21','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('22','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('23','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('24','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('25','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('26','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('27','2','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('28','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('29','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('30','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('31','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('32','1','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('33','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('34','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('35','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('36','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('37','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('38','1','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('39','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('40','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('41','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('42','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('43','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('44','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('45','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('46','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('47','2','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('48','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('49','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('50','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('51','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('52','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('53','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('54','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('55','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('56','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('57','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('58','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('59','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('60','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('61','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('62','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('63','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('64','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('65','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('66','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('67','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('68','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('69','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('70','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('71','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('72','1','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('73','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('74','1','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('75','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('76','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('77','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('78','1','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('79','1','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('80','3','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('81','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('82','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('83','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('84','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('85','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('86','1','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('87','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('88','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('89','1','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('90','4','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('91','2','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('92','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('93','3','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('94','4','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('95','1','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('96','3','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('97','3','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('98','4','0','1','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('99','25','0','2','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('100','1','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('101','3','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('102','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('103','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('104','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('105','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('106','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('107','2','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('108','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('109','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('110','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('111','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('112','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('113','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('114','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('115','0','0','0','0','0','0');");
E_D("replace into `ecm_goods_statistics` values('116','0','0','0','0','0','0');");

require("../../inc/footer.php");
?>