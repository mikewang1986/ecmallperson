<?php

/**
 * 商品分类挂件
 *
 * @return  array   $category_list
 */
class Yhd_categoryWidget extends BaseWidget
{
    var $_name = 'yhd_category';
    var $_ttl  = 86400;


    function _get_data()
    {
        $cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {
            $gcategory_mod =& bm('gcategory', array('_store_id' => 0));
            $gcategories = array();
			$brand_mod = &m('brand');
            if(empty($this->options['amount']))
            {
                $gcategories = $gcategory_mod->get_list(-1, true);
            }
            else
            {
                $gcategory = $gcategory_mod->get_list(0, true);
                $gcategories = $gcategory;
                foreach ($gcategory as $val)
                {
                    $result = $gcategory_mod->get_list($val['cate_id'], true);
                    $result = array_slice($result, 0, $this->options['amount']);
                    $gcategories = array_merge($gcategories, $result);
                }
            }
            import('tree.lib');
            $tree = new Tree();
            $tree->setTree($gcategories, 'cate_id', 'parent_id', 'cate_name');
			
			$data =  array(
			    'gcategories'  => $tree->getArrayList(0),
				'model_name'   => $this->options['model_name'],
				'brands'       => $brand_mod->find(array('conditions' => "recommended = 1 AND if_show = 1" ,'order' => 'sort_order','limit' => $this->_num)),
		    );
            $cache_server->set($key, $data, $this->_ttl);
        }
		return $data;
    }
}

?>