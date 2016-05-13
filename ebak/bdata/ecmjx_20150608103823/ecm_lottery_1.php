<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecm_lottery`;");
E_C("CREATE TABLE `ecm_lottery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL DEFAULT '' COMMENT '活动名称',
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `statdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
  `enddate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `startinfo` varchar(255) NOT NULL DEFAULT '' COMMENT '活动规则',
  `info` varchar(255) NOT NULL DEFAULT '' COMMENT '活动说明',
  `startpicurl` varchar(255) NOT NULL DEFAULT '' COMMENT '开始图片',
  `endinfo` varchar(255) NOT NULL DEFAULT '' COMMENT '结束说明',
  `endpicurl` varchar(255) NOT NULL DEFAULT '' COMMENT '结束图片',
  `fist` varchar(255) NOT NULL DEFAULT '',
  `fistnums` int(10) unsigned NOT NULL DEFAULT '0',
  `second` varchar(255) NOT NULL DEFAULT '',
  `secondnums` int(10) unsigned NOT NULL DEFAULT '0',
  `third` varchar(255) NOT NULL DEFAULT '',
  `thirdnums` int(10) unsigned NOT NULL DEFAULT '0',
  `dayflag` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '抽奖方式',
  `allpeople` varchar(255) NOT NULL DEFAULT '' COMMENT '中奖概率',
  `joinnum` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '加入人数',
  `checkpwd` varchar(255) NOT NULL DEFAULT '' COMMENT '兑奖密码',
  `displayjpnums` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示奖品数量',
  `click` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击数量',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8");
E_D("replace into `ecm_lottery` values('4','大转盘活动','2','1400025600','1400544000','123123','亲，请点击进入大转盘活123动页面，祝您好运哦！','','亲，活动已经结束，请继续关注我们的后续活动哦。','','1','2','1','2','1','2','1','1','2','','0','0','1');");
E_D("replace into `ecm_lottery` values('3','1212','2','1400112000','1401494400','活动规则','1','data/files/store_2/lottery/201405211419571075.png','2','data/files/store_2/lottery/201405211419576308.png','1','1','2','2','3','3','1','1','2','123456','0','0','0');");

require("../../inc/footer.php");
?>