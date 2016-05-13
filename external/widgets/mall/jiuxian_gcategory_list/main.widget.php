<?php

/**
 * 商品分类挂件
 *
 * @return  array   $category_list
 */
class Jiuxian_gcategory_listWidget extends BaseWidget
{
    var $_name = 'jiuxian_gcategory_list';
    var $_ttl  = 86400;


    function _get_data()
    {
		$cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {
			$amount = (empty($this->options['amount']) || intval($this->options['amount'])<=0) ? 0 : intval($this->options['amount']);
			$data = Psmb_init()->get_header_gcategories($amount,$this->options['position']);
			$cache_server->set($key, $data, $this->_ttl);
        }
        return $data;
    }
	function parse_config($input)
    {
        return $input;
    }

}

?>