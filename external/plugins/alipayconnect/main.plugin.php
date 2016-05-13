<?php

/**
 * alipayconnect
 *
 */

class AlipayconnectPlugin extends BasePlugin
{
    var $_config = array();
    
    function __construct($data, $plugin_info)
    {
        $this->AlipayconnectPlugin($data, $plugin_info);
    }
    function AlipayconnectPlugin($data, $plugin_info)
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
				'partner'	=> $this->_config['partner'],
				'key'		=> $this->_config['key'],
				'sign_type' => strtoupper('MD5'),
				'input_charset'=>strtolower(CHARSET),
				'transport'	=> 'http',
				'cacert'    => getcwd().'\\cacert.pem',
				'return_url'=> SITE_URL . "/index.php?app=alipayconnect&act=callback",
			);
			return $data;
		}  
    }	
}

?>