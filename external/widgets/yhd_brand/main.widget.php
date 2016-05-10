<?php

/**
 * Ʒ�ƹҼ�
 *
 * @return  array
 */
class Yhd_brandWidget extends BaseWidget
{
    var $_name = 'yhd_brand';
    var $_ttl  = 86400;
    var $_num  = 18;

    function _get_data()
    {
        $cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
		$_num = isset($this->options['count']) ? $this->options['count']: $this->_num;
        if($data === false)
        {
            $brand_mod =& m('brand');
            $data = $brand_mod->find(array(
                'conditions' => "recommended = 1 AND if_show = 1" ,
                'order' => 'sort_order',
                'limit' => $_num,
            ));
            $cache_server->set($key, $data, $this->_ttl);
        }

        return $data;
    }
}

?>