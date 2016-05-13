<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_sgrade`;");
E_C("CREATE TABLE `ecm_sgrade` (
  `grade_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `grade_name` varchar(60) NOT NULL DEFAULT '',
  `goods_limit` int(10) unsigned NOT NULL DEFAULT '0',
  `space_limit` int(10) unsigned NOT NULL DEFAULT '0',
  `skin_limit` int(10) unsigned NOT NULL DEFAULT '0',
  `charge` varchar(100) NOT NULL DEFAULT '',
  `need_confirm` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `description` varchar(255) NOT NULL DEFAULT '',
  `functions` varchar(255) DEFAULT NULL,
  `skins` text NOT NULL,
  `sort_order` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `wapskin_limit` int(10) unsigned NOT NULL DEFAULT '0',
  `wapskins` text NOT NULL,
  PRIMARY KEY (`grade_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_sgrade` values('1','普通店铺','0','0','13','','1','测试用户请选择“普通店铺”，可以立即开通。','editor_multimedia,coupon,groupbuy,enable_radar,enable_free_fee,template','colorful|default,default|default,default|style1,default|style2,default|style3,default|style4,default|style5,default|style6,default|style7,default|style8,jdlv|default,moolau|default,xiaomistore|default','255','26','default01|default,default02|default,default03|default,default04|default,default05|default,default06|default,default07|default,default08|default,default09|default,default10|default,default11|default,default12|default,default13|default,default14|default,default15|default,default16|default,default17|default,default18|default,default19|default,default20|default,default21|default,default22|default,default23|default,default24|default,default25|default,waimai|default');");
E_D("replace into `ecm_sgrade` values('2','旗舰店铺','0','0','13','100元/年','1','','editor_multimedia,coupon,groupbuy,enable_radar,enable_free_fee,template','colorful|default,default|default,default|style1,default|style2,default|style3,default|style4,default|style5,default|style6,default|style7,default|style8,jdlv|default,moolau|default,xiaomistore|default','255','26','default01|default,default02|default,default03|default,default04|default,default05|default,default06|default,default07|default,default08|default,default09|default,default10|default,default11|default,default12|default,default13|default,default14|default,default15|default,default16|default,default17|default,default18|default,default19|default,default20|default,default21|default,default22|default,default23|default,default24|default,default25|default,waimai|default');");

require("../../inc/footer.php");
?>