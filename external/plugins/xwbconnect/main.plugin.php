<?php

/**
 * xwbconnect
 *
 */

class XwbconnectPlugin extends BasePlugin
{
    var $_config = array();
    
    function __construct($data, $plugin_info)
    {
        $this->XwbconnectPlugin($data, $plugin_info);
    }
    function XwbconnectPlugin($data, $plugin_info)
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
				'WB_AKEY'    		=> $this->_config['WB_AKEY'],
				'WB_SKEY'   		=> $this->_config['WB_SKEY'],
				'WB_CALLBACK_URL' 	=> SITE_URL . "/index.php?app=xwbconnect&act=callback",
			);
			return $data;
		}  
    }	
}

?>