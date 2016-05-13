<?php

class Install_sqlApp extends MallbaseApp {

    function index() {
        $mod = & m('privilege');
        
        
        
        
        
        
        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "wxconfig` (
  `w_id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `appid` varchar(255) default NULL,
  `appsecret` varchar(255) default NULL,
  PRIMARY KEY  (`w_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=" . str_replace('-', '', CHARSET) . ';';
        $mod->db->query($sql);

        
        
        
        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "wxkeyword` (
  `kid` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `kename` varchar(300) default NULL,
  `kecontent` varchar(500) default NULL,
  `type` tinyint(1) NOT NULL COMMENT '1:文本 2：图文',
  `kyword` varchar(255) default NULL,
  `titles` varchar(1000) default NULL,
  `imageinfo` varchar(1000) default NULL,
  `linkinfo` varchar(1000) default NULL,
  `ismess` tinyint(1) default NULL,
  `isfollow` tinyint(1) default NULL,
  `iskey` tinyint(1) default NULL,
  PRIMARY KEY  (`kid`)
		) ENGINE=MyISAM DEFAULT CHARSET=" . str_replace('-', '', CHARSET) . ';';
        $mod->db->query($sql);
        
        
        
        
        
        
        
        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "wxmenu` (
 `id` SMALLINT( 4 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
 `user_id` INT( 10 ) UNSIGNED NOT NULL DEFAULT  '0',
 `name` VARCHAR( 50 ) NOT NULL ,
 `tags` VARCHAR( 50 ) DEFAULT NULL ,
 `pid` SMALLINT( 4 ) UNSIGNED NOT NULL DEFAULT  '0',
 `spid` VARCHAR( 50 ) DEFAULT NULL ,
 `add_time` INT( 10 ) NOT NULL DEFAULT  '0',
 `items` INT( 10 ) UNSIGNED NOT NULL DEFAULT  '0',
 `likes` VARCHAR( 100 ) DEFAULT NULL ,
 `weixin_type` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '0:click 1:viwe',
 `ordid` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT  '255',
 `weixin_status` TINYINT( 1 ) NOT NULL DEFAULT  '0',
 `weixin_keyword` VARCHAR( 255 ) DEFAULT NULL COMMENT  '关键词',
 `weixin_key` VARCHAR( 255 ) DEFAULT NULL COMMENT  'key值',
PRIMARY KEY (  `id` )
		) ENGINE=MyISAM DEFAULT CHARSET=" . str_replace('-', '', CHARSET) . ';';
        $mod->db->query($sql);
        
        
        
        
        
        
        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "wxfile` (
 `file_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `user_id` INT( 11 ) NOT NULL ,
 `file_type` VARCHAR( 60 ) NOT NULL ,
 `file_size` INT( 10 ) NOT NULL DEFAULT  '0',
 `file_name` VARCHAR( 255 ) NOT NULL ,
 `file_path` VARCHAR( 255 ) NOT NULL ,
PRIMARY KEY (  `file_id` )
		) ENGINE=MyISAM DEFAULT CHARSET=" . str_replace('-', '', CHARSET) . ';';
        $mod->db->query($sql);
        
        
        
        
        
    }

}

?>