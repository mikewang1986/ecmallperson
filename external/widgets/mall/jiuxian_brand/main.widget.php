<?php

/**
 * 品牌挂件
 *
 * @return  array
 */
class Jiuxian_brandWidget extends BaseWidget
{
    var $_name = 'jiuxian_brand';
    var $_ttl  = 86400;
    var $_num  = 22;

    function _get_data()
    {
        $cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {
            $brand_mod =& m('brand');
            $brand = $brand_mod->find(array(
                'conditions' => "recommended = 1",
                'order' => 'sort_order',
                'limit' =>$this->options['num']?$this->options['num']:$this->_num,
            ));
			$data=array(
				'brands'=>array_chunk($brand,11),
				'txt_brand'=>explode(' ',$this->options['txt_brand'])
			);
            $cache_server->set($key, $data, $this->_ttl);
        }

        return $data;
    }
}

?>