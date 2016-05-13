<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_brand`;");
E_C("CREATE TABLE `ecm_brand` (
  `brand_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(100) NOT NULL DEFAULT '',
  `brand_logo` varchar(255) DEFAULT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '255',
  `recommended` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `if_show` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `tag` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`brand_id`),
  KEY `tag` (`tag`)
) ENGINE=MyISAM AUTO_INCREMENT=158 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_brand` values('147','米其林','data/files/mall/brand/147.jpg','1','1','11','1','轮胎');");
E_D("replace into `ecm_brand` values('148','固特异','data/files/mall/brand/148.jpg','2','1','11','1','轮胎');");
E_D("replace into `ecm_brand` values('149','普利司通','data/files/mall/brand/149.jpg','3','1','11','1','轮胎');");
E_D("replace into `ecm_brand` values('150','邓禄普','data/files/mall/brand/150.jpg','4','1','11','1','轮胎');");
E_D("replace into `ecm_brand` values('151','前进','data/files/mall/brand/151.jpg','5','1','11','1','轮胎');");
E_D("replace into `ecm_brand` values('152','朝阳','data/files/mall/brand/152.jpg','6','1','11','1','轮胎');");
E_D("replace into `ecm_brand` values('153','双钱','data/files/mall/brand/153.jpg','7','1','11','1','轮胎');");
E_D("replace into `ecm_brand` values('154','回力','data/files/mall/brand/154.jpg','8','1','11','1','轮胎');");
E_D("replace into `ecm_brand` values('155','风神','data/files/mall/brand/155.jpg','9','1','11','1','轮胎');");
E_D("replace into `ecm_brand` values('156','多力通','data/files/mall/brand/156.jpg','10','1','11','1','轮胎');");
E_D("replace into `ecm_brand` values('157','东洋','data/files/mall/brand/157.jpg','11','1','11','1','轮胎');");
E_D("replace into `ecm_brand` values('82','宝马','data/files/mall/brand/82.jpg','255','1','0','1','汽车');");
E_D("replace into `ecm_brand` values('83','奥迪','data/files/mall/brand/83.jpg','1','1','0','1','汽车');");
E_D("replace into `ecm_brand` values('84','奔驰','data/files/mall/brand/84.jpg','255','1','0','1','汽车');");
E_D("replace into `ecm_brand` values('85','本田','data/files/mall/brand/85.jpg','255','1','0','1','汽车');");
E_D("replace into `ecm_brand` values('86','雪佛兰','data/files/mall/brand/86.jpg','255','1','0','1','汽车');");
E_D("replace into `ecm_brand` values('87','大众','data/files/mall/brand/87.jpg','255','1','0','1','汽车');");
E_D("replace into `ecm_brand` values('88','雷克萨斯','data/files/mall/brand/88.jpg','255','1','0','1','汽车');");
E_D("replace into `ecm_brand` values('89','别克','data/files/mall/brand/89.jpg','255','1','0','1','汽车');");
E_D("replace into `ecm_brand` values('90','长安','data/files/mall/brand/90.jpg','255','1','0','1','汽车');");
E_D("replace into `ecm_brand` values('91','福特','data/files/mall/brand/91.jpg','255','1','0','1','汽车');");
E_D("replace into `ecm_brand` values('92','起亚','data/files/mall/brand/92.gif','255','1','0','1','汽车');");
E_D("replace into `ecm_brand` values('93','宝骏','data/files/mall/brand/93.jpg','255','1','0','1','汽车');");
E_D("replace into `ecm_brand` values('94','福田','data/files/mall/brand/94.jpg','255','1','0','1','汽车');");
E_D("replace into `ecm_brand` values('95','奇瑞','data/files/mall/brand/95.jpg','255','1','0','1','汽车');");
E_D("replace into `ecm_brand` values('96','MG','data/files/mall/brand/96.jpg','255','1','0','1','汽车');");
E_D("replace into `ecm_brand` values('97','雪铁龙','data/files/mall/brand/97.jpg','255','1','0','1','汽车');");
E_D("replace into `ecm_brand` values('98','日产','data/files/mall/brand/98.jpg','255','1','0','1','汽车');");
E_D("replace into `ecm_brand` values('99','一汽','data/files/mall/brand/99.jpg','255','1','0','1','汽车');");
E_D("replace into `ecm_brand` values('100','现代','data/files/mall/brand/100.jpg','255','1','0','1','汽车');");
E_D("replace into `ecm_brand` values('101','比亚迪','data/files/mall/brand/101.gif','255','1','0','1','汽车');");
E_D("replace into `ecm_brand` values('102','丰田','data/files/mall/brand/102.jpg','255','1','0','1','汽车');");

require("../../inc/footer.php");
?>