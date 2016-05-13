<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_ju_cate`;");
E_C("CREATE TABLE `ecm_ju_cate` (
  `cate_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(20) NOT NULL,
  `parent_id` int(10) unsigned NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '255',
  `if_show` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `channel` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_ju_cate` values('1','商品团','0','1','1','1');");
E_D("replace into `ecm_ju_cate` values('2','生活汇','0','11','1','5');");
E_D("replace into `ecm_ju_cate` values('3','休闲','2','255','1','0');");
E_D("replace into `ecm_ju_cate` values('4','服饰','1','44','1',NULL);");
E_D("replace into `ecm_ju_cate` values('5','配饰','1','255','1',NULL);");
E_D("replace into `ecm_ju_cate` values('6','美食','2','255','1',NULL);");
E_D("replace into `ecm_ju_cate` values('7','电影','2','255','1',NULL);");
E_D("replace into `ecm_ju_cate` values('8','超市','2','255','1',NULL);");
E_D("replace into `ecm_ju_cate` values('9','摄影','2','255','1',NULL);");
E_D("replace into `ecm_ju_cate` values('10','门票','2','255','1',NULL);");
E_D("replace into `ecm_ju_cate` values('12','鞋包','1','255','1',NULL);");
E_D("replace into `ecm_ju_cate` values('13','运动','1','255','1',NULL);");
E_D("replace into `ecm_ju_cate` values('16','服饰鞋包','15','255','1',NULL);");
E_D("replace into `ecm_ju_cate` values('17','美容百货','15','255','1',NULL);");
E_D("replace into `ecm_ju_cate` values('18','母婴孕产','15','255','1',NULL);");
E_D("replace into `ecm_ju_cate` values('19','家装家纺','15','255','1',NULL);");
E_D("replace into `ecm_ju_cate` values('20','聚名品','0','255','1','3');");
E_D("replace into `ecm_ju_cate` values('21','童装专场','20','255','1','0');");
E_D("replace into `ecm_ju_cate` values('22','饰品专场','20','255','1','0');");
E_D("replace into `ecm_ju_cate` values('23','家电专场','20','255','1','0');");
E_D("replace into `ecm_ju_cate` values('24','拉歌蒂尼','20','255','1','0');");
E_D("replace into `ecm_ju_cate` values('25','聚家装','0','255','1','4');");
E_D("replace into `ecm_ju_cate` values('26','建材','25','255','1','0');");
E_D("replace into `ecm_ju_cate` values('27','家具','25','255','1','0');");
E_D("replace into `ecm_ju_cate` values('28','家纺','25','255','1','0');");
E_D("replace into `ecm_ju_cate` values('29','家电','25','255','1','0');");
E_D("replace into `ecm_ju_cate` values('30','旅游团','0','255','1','6');");
E_D("replace into `ecm_ju_cate` values('31','境内游','30','255','1','0');");
E_D("replace into `ecm_ju_cate` values('32','境外游','30','255','1','0');");
E_D("replace into `ecm_ju_cate` values('33','周边游','30','255','1','0');");
E_D("replace into `ecm_ju_cate` values('34','美妆','1','255','1','0');");
E_D("replace into `ecm_ju_cate` values('35','食品','1','255','1','0');");
E_D("replace into `ecm_ju_cate` values('36','母婴','1','255','1','0');");
E_D("replace into `ecm_ju_cate` values('37','家居','1','255','1','0');");
E_D("replace into `ecm_ju_cate` values('38','家电','1','255','1','0');");
E_D("replace into `ecm_ju_cate` values('39','百货','1','255','1','0');");
E_D("replace into `ecm_ju_cate` values('40','车品','1','255','1','0');");
E_D("replace into `ecm_ju_cate` values('41','内衣','1','255','1','0');");

require("../../inc/footer.php");
?>