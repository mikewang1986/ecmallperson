<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_ju_brand`;");
E_C("CREATE TABLE `ecm_ju_brand` (
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
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_ju_brand` values('1','森马','data/files/mall/ju_brand/1.jpg','255','1','0','1','服装服饰');");
E_D("replace into `ecm_ju_brand` values('2','OSA','data/files/mall/ju_brand/5.jpg','255','0','0','1','数码家电');");
E_D("replace into `ecm_ju_brand` values('3','名鞋库','data/files/mall/ju_brand/3.jpg','255','0','0','1','服装服饰');");
E_D("replace into `ecm_ju_brand` values('4','童年时光','data/files/mall/ju_brand/34.jpg','255','0','0','1','母婴百货');");
E_D("replace into `ecm_ju_brand` values('5','周黑鸭','data/files/mall/ju_brand/33.jpg','255','1','0','1','母婴百货');");
E_D("replace into `ecm_ju_brand` values('6','ONLY','data/files/mall/ju_brand/6.jpg','255','1','0','1','服装服饰');");
E_D("replace into `ecm_ju_brand` values('7','浪莎','data/files/mall/ju_brand/7.jpg','255','1','0','1','服装服饰');");
E_D("replace into `ecm_ju_brand` values('8','太平鸟','data/files/mall/ju_brand/8.jpg','255','1','0','1','服装服饰');");
E_D("replace into `ecm_ju_brand` values('9','OSA欧莎','data/files/mall/ju_brand/9.jpg','255','1','0','1','服装服饰');");
E_D("replace into `ecm_ju_brand` values('10','乐町','data/files/mall/ju_brand/10.jpg','255','1','0','1','服装服饰');");
E_D("replace into `ecm_ju_brand` values('11','九牧王','data/files/mall/ju_brand/11.jpg','255','1','0','1','服装服饰');");
E_D("replace into `ecm_ju_brand` values('12','骆驼男装','data/files/mall/ju_brand/12.jpg','255','1','0','1','服装服饰');");
E_D("replace into `ecm_ju_brand` values('13','秋水伊人','data/files/mall/ju_brand/13.jpg','255','1','0','1','服装服饰');");
E_D("replace into `ecm_ju_brand` values('14','马克华菲','data/files/mall/ju_brand/14.jpg','255','1','0','1','服装服饰');");
E_D("replace into `ecm_ju_brand` values('15','如熙','data/files/mall/ju_brand/15.jpg','255','1','0','1','运动鞋包');");
E_D("replace into `ecm_ju_brand` values('16','茵曼','data/files/mall/ju_brand/16.jpg','255','1','0','1','运动鞋包');");
E_D("replace into `ecm_ju_brand` values('17','李宁','data/files/mall/ju_brand/17.jpg','255','1','0','1','运动鞋包');");
E_D("replace into `ecm_ju_brand` values('18','佳钓尼','data/files/mall/ju_brand/18.jpg','255','1','0','1','运动鞋包');");
E_D("replace into `ecm_ju_brand` values('19','卓诗尼','data/files/mall/ju_brand/19.jpg','255','1','0','1','运动鞋包');");
E_D("replace into `ecm_ju_brand` values('20','奥康','data/files/mall/ju_brand/20.jpg','255','1','0','1','运动鞋包');");
E_D("replace into `ecm_ju_brand` values('21','意尔康','data/files/mall/ju_brand/21.jpg','255','0','0','1','运动鞋包');");
E_D("replace into `ecm_ju_brand` values('22','丹尼熊','data/files/mall/ju_brand/22.jpg','255','1','0','1','运动鞋包');");
E_D("replace into `ecm_ju_brand` values('23','SKG','data/files/mall/ju_brand/23.jpg','255','1','0','1','数码家电');");
E_D("replace into `ecm_ju_brand` values('24','爱斯基摩人','data/files/mall/ju_brand/24.jpg','255','1','0','1','数码家电');");
E_D("replace into `ecm_ju_brand` values('25','美的','data/files/mall/ju_brand/25.jpg','255','1','0','1','数码家电');");
E_D("replace into `ecm_ju_brand` values('26','亨氏','data/files/mall/ju_brand/26.jpg','255','0','0','1','母婴百货');");
E_D("replace into `ecm_ju_brand` values('27','贝因美','data/files/mall/ju_brand/27.jpg','255','1','0','1','母婴百货');");
E_D("replace into `ecm_ju_brand` values('28','帮宝适','data/files/mall/ju_brand/28.jpg','255','0','0','1','母婴百货');");
E_D("replace into `ecm_ju_brand` values('29','安耐驰','data/files/mall/ju_brand/29.jpg','255','1','0','1','母婴百货');");
E_D("replace into `ecm_ju_brand` values('30','宝宝金水','data/files/mall/ju_brand/30.jpg','255','1','0','1','母婴百货');");
E_D("replace into `ecm_ju_brand` values('31','山野农夫','data/files/mall/ju_brand/31.jpg','255','0','0','1','母婴百货');");
E_D("replace into `ecm_ju_brand` values('32','苏菲','data/files/mall/ju_brand/32.jpg','255','1','0','1','母婴百货');");

require("../../inc/footer.php");
?>