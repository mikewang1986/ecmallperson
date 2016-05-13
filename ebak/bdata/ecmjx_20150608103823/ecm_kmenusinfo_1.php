<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_kmenusinfo`;");
E_C("CREATE TABLE `ecm_kmenusinfo` (
  `kmenusinfo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kmenus_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(60) NOT NULL DEFAULT '',
  `color` varchar(20) NOT NULL DEFAULT '',
  `loadurl` varchar(255) NOT NULL DEFAULT '',
  `imgurl` varchar(255) NOT NULL DEFAULT '',
  `nums` tinyint(3) unsigned NOT NULL DEFAULT '255',
  PRIMARY KEY (`kmenusinfo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_kmenusinfo` values('1','2','','FFB92E','tel:12345678','http://ecmjx.jyds95.com/mall/kmenus/plugmenu1.png','1');");
E_D("replace into `ecm_kmenusinfo` values('2','2','客服QQ','088CFF','http://wpa.qq.com/msgrd?v=3&uin=540616918&site=qq&menu=yes','http://ecmjx.jyds95.com/mall/kmenus/plugmenu20.png','2');");
E_D("replace into `ecm_kmenusinfo` values('3','2','购物','FF47E0','http://ecmjx.jyds95.com/index.php?app=cart','http://ecmjx.jyds95.com/mall/kmenus/plugmenu9.png','3');");

require("../../inc/footer.php");
?>