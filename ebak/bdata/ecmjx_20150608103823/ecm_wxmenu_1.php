<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_wxmenu`;");
E_C("CREATE TABLE `ecm_wxmenu` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `tags` varchar(50) DEFAULT NULL,
  `pid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `spid` varchar(50) DEFAULT NULL,
  `add_time` int(10) NOT NULL DEFAULT '0',
  `items` int(10) unsigned NOT NULL DEFAULT '0',
  `likes` varchar(100) DEFAULT NULL,
  `weixin_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0:click 1:viwe',
  `ordid` tinyint(3) unsigned NOT NULL DEFAULT '255',
  `weixin_status` tinyint(1) NOT NULL DEFAULT '0',
  `weixin_keyword` varchar(255) DEFAULT NULL COMMENT '关键词',
  `weixin_key` varchar(255) DEFAULT NULL COMMENT 'key值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_wxmenu` values('8','2','会员中心',' ','0','0','1433611264','0','','0','255','1','member','fsafdsa');");
E_D("replace into `ecm_wxmenu` values('9','0','微商城',' ','0','0','1433635276','0','','0','255','1','微商城','wsc111');");
E_D("replace into `ecm_wxmenu` values('10','0','进入商城',' ','9','9|','1433635314','0','http://ecmjx.jyds95.com','1','255','1','','');");
E_D("replace into `ecm_wxmenu` values('5','2','演示店铺',' ','3','3|','1422889337','0',' ','0','255','1','微店铺','ysdp123');");
E_D("replace into `ecm_wxmenu` values('11','0','微店铺',' ','0','0','1433635340','0','','0','255','1','微店铺','wdp222');");
E_D("replace into `ecm_wxmenu` values('12','0','进入店铺',' ','11','11|','1433635382','0','http://ecmjx.jyds95.com/index.php?app=store&id=2','1','255','1','','');");
E_D("replace into `ecm_wxmenu` values('13','0','会员中心',' ','0','0','1433635420','0','','0','255','1','会员','hyzx333');");
E_D("replace into `ecm_wxmenu` values('14','0','绑定会员',' ','13','13|','1433635524','0','','0','255','1','cxbd','cxbd');");
E_D("replace into `ecm_wxmenu` values('15','0','查询积分',' ','13','13|','1433635588','0','','0','255','1','cxye','cxye');");
E_D("replace into `ecm_wxmenu` values('18','0','快递查询',' ','13','13|','1433635950','0','','0','255','1','kdcx','kdcx');");
E_D("replace into `ecm_wxmenu` values('19','0','进入会员中心',' ','13','13|','1433635993','0','','0','255','1','member','member');");

require("../../inc/footer.php");
?>