<?php

/**
 * 这里可以放一些安装模块时需要执行的代码，比如新建表，新建目录、文件之类的
 */

/* 下面的代码不是必需的，只是作为示例 */
$filename = ROOT_PATH . '/data/datacall.inc.php';
file_put_contents($filename, "<?php return array(); ?>");
$db=&db();
$db->query("CREATE TABLE `ecm_jindan_log` (
  `id` int(10) NOT NULL auto_increment,
  `shop_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `jiner` int(10) NOT NULL,
  `stime` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");


$db->query("CREATE TABLE `ecm_jindan_shop` (
  `id` int(10) NOT NULL auto_increment,
  `shop_id` int(10) NOT NULL,
  `jindan_num` int(10) NOT NULL,
  `stime` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

//测试数据的添加，不需要可以删除
 

?>