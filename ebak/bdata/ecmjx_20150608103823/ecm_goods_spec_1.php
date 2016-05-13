<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_goods_spec`;");
E_C("CREATE TABLE `ecm_goods_spec` (
  `spec_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0',
  `spec_1` varchar(60) NOT NULL DEFAULT '',
  `spec_2` varchar(60) NOT NULL DEFAULT '',
  `color_rgb` varchar(7) NOT NULL DEFAULT '',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `stock` int(11) NOT NULL DEFAULT '0',
  `sku` varchar(60) NOT NULL DEFAULT '',
  PRIMARY KEY (`spec_id`),
  KEY `goods_id` (`goods_id`),
  KEY `price` (`price`)
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_goods_spec` values('1','1','','','','8.00','100','');");
E_D("replace into `ecm_goods_spec` values('2','2','','','','100.00','100','');");
E_D("replace into `ecm_goods_spec` values('3','3','','','','68.00','100','');");
E_D("replace into `ecm_goods_spec` values('4','4','','','','69.00','100','');");
E_D("replace into `ecm_goods_spec` values('5','5','','','','10.00','100','');");
E_D("replace into `ecm_goods_spec` values('6','6','','','','32.00','100','');");
E_D("replace into `ecm_goods_spec` values('7','7','','','','65.00','100','');");
E_D("replace into `ecm_goods_spec` values('8','8','','','','38.80','100','');");
E_D("replace into `ecm_goods_spec` values('9','9','','','','50.00','100','');");
E_D("replace into `ecm_goods_spec` values('10','10','','','','108.80','100','');");
E_D("replace into `ecm_goods_spec` values('11','11','','','','25.50','100','');");
E_D("replace into `ecm_goods_spec` values('12','12','','','','28.50','100','');");
E_D("replace into `ecm_goods_spec` values('13','13','','','','108.00','100','');");
E_D("replace into `ecm_goods_spec` values('14','14','','','','21.80','100','');");
E_D("replace into `ecm_goods_spec` values('15','15','','','','30.60','99','');");
E_D("replace into `ecm_goods_spec` values('16','16','','','','92.00','100','');");
E_D("replace into `ecm_goods_spec` values('17','17','','','','110.00','100','');");
E_D("replace into `ecm_goods_spec` values('18','18','','','','32.00','99','');");
E_D("replace into `ecm_goods_spec` values('19','19','','','','52.00','100','');");
E_D("replace into `ecm_goods_spec` values('20','20','','','','95.00','100','');");
E_D("replace into `ecm_goods_spec` values('21','21','','','','72.00','100','');");
E_D("replace into `ecm_goods_spec` values('22','22','','','','36.00','100','');");
E_D("replace into `ecm_goods_spec` values('23','23','','','','128.00','100','');");
E_D("replace into `ecm_goods_spec` values('24','24','','','','62.00','100','');");
E_D("replace into `ecm_goods_spec` values('25','25','','','','350.00','100','');");
E_D("replace into `ecm_goods_spec` values('26','26','','','','100.00','0','');");
E_D("replace into `ecm_goods_spec` values('27','27','','','','666.00','100','');");
E_D("replace into `ecm_goods_spec` values('28','28','','','','108.00','100','');");
E_D("replace into `ecm_goods_spec` values('29','29','','','','3.60','100','');");
E_D("replace into `ecm_goods_spec` values('30','30','','','','59.00','100','');");
E_D("replace into `ecm_goods_spec` values('31','31','','','','6.90','100','');");
E_D("replace into `ecm_goods_spec` values('32','32','','','','10.00','100','');");
E_D("replace into `ecm_goods_spec` values('33','33','','','','16.80','100','');");
E_D("replace into `ecm_goods_spec` values('34','34','','','','12.00','100','');");
E_D("replace into `ecm_goods_spec` values('35','35','','','','12.00','100','');");
E_D("replace into `ecm_goods_spec` values('36','36','','','','22.00','100','');");
E_D("replace into `ecm_goods_spec` values('37','37','','','','20.00','100','');");
E_D("replace into `ecm_goods_spec` values('38','38','','','','21.00','100','');");
E_D("replace into `ecm_goods_spec` values('39','39','','','','80.00','100','');");
E_D("replace into `ecm_goods_spec` values('40','40','','','','2.20','100','');");
E_D("replace into `ecm_goods_spec` values('41','41','','','','2.50','100','');");
E_D("replace into `ecm_goods_spec` values('42','42','','','','2.30','100','');");
E_D("replace into `ecm_goods_spec` values('43','43','','','','7.30','100','');");
E_D("replace into `ecm_goods_spec` values('44','44','','','','4.10','100','');");
E_D("replace into `ecm_goods_spec` values('45','45','','','','14.80','100','');");
E_D("replace into `ecm_goods_spec` values('46','46','','','','5.80','100','');");
E_D("replace into `ecm_goods_spec` values('47','47','','','','5.50','100','');");
E_D("replace into `ecm_goods_spec` values('48','48','','','','2.60','100','');");
E_D("replace into `ecm_goods_spec` values('49','49','','','','2.60','100','');");
E_D("replace into `ecm_goods_spec` values('50','50','','','','74.00','100','');");
E_D("replace into `ecm_goods_spec` values('51','51','','','','14.00','100','');");
E_D("replace into `ecm_goods_spec` values('52','52','','','','144.00','100','');");
E_D("replace into `ecm_goods_spec` values('53','53','','','','17.50','100','');");
E_D("replace into `ecm_goods_spec` values('54','54','','','','354.00','100','');");
E_D("replace into `ecm_goods_spec` values('55','55','','','','679.00','100','');");
E_D("replace into `ecm_goods_spec` values('56','56','','','','606.00','100','');");
E_D("replace into `ecm_goods_spec` values('57','57','','','','374.00','100','');");
E_D("replace into `ecm_goods_spec` values('58','58','','','','774.00','100','');");
E_D("replace into `ecm_goods_spec` values('59','59','','','','12.00','100','');");
E_D("replace into `ecm_goods_spec` values('60','60','','','','35.80','100','');");
E_D("replace into `ecm_goods_spec` values('61','61','','','','24.90','0','');");
E_D("replace into `ecm_goods_spec` values('62','62','','','','46.60','100','');");
E_D("replace into `ecm_goods_spec` values('63','63','','','','215.00','100','');");
E_D("replace into `ecm_goods_spec` values('64','64','','','','202.00','100','');");
E_D("replace into `ecm_goods_spec` values('65','65','','','','158.00','100','');");
E_D("replace into `ecm_goods_spec` values('66','66','','','','2.90','100','');");
E_D("replace into `ecm_goods_spec` values('67','67','','','','23.80','100','');");
E_D("replace into `ecm_goods_spec` values('68','68','','','','5.10','100','');");
E_D("replace into `ecm_goods_spec` values('69','69','','','','45.00','100','');");
E_D("replace into `ecm_goods_spec` values('70','70','','','','850.00','100','');");
E_D("replace into `ecm_goods_spec` values('71','71','','','','750.00','100','');");
E_D("replace into `ecm_goods_spec` values('72','72','','','','690.00','100','');");
E_D("replace into `ecm_goods_spec` values('73','73','','','','850.00','100','');");
E_D("replace into `ecm_goods_spec` values('74','74','','','','2090.00','100','');");
E_D("replace into `ecm_goods_spec` values('75','75','','','','173.00','100','');");
E_D("replace into `ecm_goods_spec` values('76','76','','','','390.00','100','');");
E_D("replace into `ecm_goods_spec` values('77','77','','','','169.00','100','');");
E_D("replace into `ecm_goods_spec` values('78','78','','','','129.00','100','');");
E_D("replace into `ecm_goods_spec` values('79','79','','','','69.00','100','');");
E_D("replace into `ecm_goods_spec` values('80','80','','','','89.00','100','');");
E_D("replace into `ecm_goods_spec` values('81','81','','','','699.00','100','');");
E_D("replace into `ecm_goods_spec` values('82','82','','','','499.00','100','');");
E_D("replace into `ecm_goods_spec` values('83','83','','','','269.00','100','');");
E_D("replace into `ecm_goods_spec` values('84','84','','','','170.00','100','');");
E_D("replace into `ecm_goods_spec` values('85','85','','','','399.00','100','');");
E_D("replace into `ecm_goods_spec` values('86','86','','','','259.00','100','');");
E_D("replace into `ecm_goods_spec` values('87','87','','','','88.00','100','');");
E_D("replace into `ecm_goods_spec` values('88','88','','','','249.00','100','');");
E_D("replace into `ecm_goods_spec` values('89','89','','','','239.00','100','');");
E_D("replace into `ecm_goods_spec` values('90','90','','','','270.00','100','');");
E_D("replace into `ecm_goods_spec` values('91','91','','','','1298.00','100','');");
E_D("replace into `ecm_goods_spec` values('92','92','','','','495.00','100','');");
E_D("replace into `ecm_goods_spec` values('93','93','','','','199.00','100','');");
E_D("replace into `ecm_goods_spec` values('94','94','','','','599.00','100','');");
E_D("replace into `ecm_goods_spec` values('95','95','','','','688.00','100','');");
E_D("replace into `ecm_goods_spec` values('96','96','','','','1749.00','100','');");
E_D("replace into `ecm_goods_spec` values('97','97','','','','1549.00','100','');");
E_D("replace into `ecm_goods_spec` values('98','98','','','','1588.00','100','');");
E_D("replace into `ecm_goods_spec` values('99','99','红色','S','','0.10','1000','');");
E_D("replace into `ecm_goods_spec` values('100','99','红色','M','','0.10','1000','');");
E_D("replace into `ecm_goods_spec` values('101','99','绿色','S','','0.10','1000','');");
E_D("replace into `ecm_goods_spec` values('102','99','绿色','M','','0.10','1000','');");
E_D("replace into `ecm_goods_spec` values('103','100','','','','30.00','999','');");
E_D("replace into `ecm_goods_spec` values('104','101','','','','30.00','999','');");
E_D("replace into `ecm_goods_spec` values('105','102','','','','30.00','999','');");
E_D("replace into `ecm_goods_spec` values('106','103','','','','30.00','999','');");
E_D("replace into `ecm_goods_spec` values('107','104','','','','30.00','999','');");
E_D("replace into `ecm_goods_spec` values('108','105','','','','30.00','999','');");
E_D("replace into `ecm_goods_spec` values('109','106','','','','30.00','999','');");
E_D("replace into `ecm_goods_spec` values('110','107','','','','30.00','999','');");
E_D("replace into `ecm_goods_spec` values('111','108','','','','30.00','999','');");
E_D("replace into `ecm_goods_spec` values('112','109','','','','30.00','999','');");
E_D("replace into `ecm_goods_spec` values('113','110','','','','30.00','999','');");
E_D("replace into `ecm_goods_spec` values('114','111','','','','30.00','999','');");
E_D("replace into `ecm_goods_spec` values('115','112','','','','30.00','999','');");
E_D("replace into `ecm_goods_spec` values('116','113','','','','30.00','999','');");
E_D("replace into `ecm_goods_spec` values('117','114','','','','30.00','999','');");
E_D("replace into `ecm_goods_spec` values('118','115','','','','30.00','999','');");
E_D("replace into `ecm_goods_spec` values('119','116','','','','30.00','999','');");

require("../../inc/footer.php");
?>