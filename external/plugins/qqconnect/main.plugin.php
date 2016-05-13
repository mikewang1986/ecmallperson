<?php

/**
 * qqconnect
 *
 */

class QqconnectPlugin extends BasePlugin
{
    var $_config = array();
    
    function __construct($data, $plugin_info)
    {
        $this->QqconnectPlugin($data, $plugin_info);
    }
    function QqconnectPlugin($data, $plugin_info)
    {
        $this->_config = $plugin_info;
        parent::__construct($data, $plugin_info);
    }
    function execute()
    {
		if(defined('IN_BACKEND') && IN_BACKEND === true) // 后台无需执行
		{
			return;
		}
		else
		{
			$data = array(
				'appid' 		=> $this->_config['appid'],
				'appkey'   	=> $this->_config['appkey'],
				'callback' 	=> urlencode(SITE_URL.'/index.php?app=qqconnect&act=callback'),
			);
			return $data;
		}  
    }	
}

?>