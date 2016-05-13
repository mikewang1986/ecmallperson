<?php

/**
 * 商品分类挂件
 *
 * @return  array   $category_list
 */
class tmall2014_gcategorysWidget extends BaseWidget {

    var $_name = 'tmall2014_gcategorys';
    var $_ttl = 86400;

    function _get_data() {
        $cache_server = & cache_server();
        $key = $this->_get_cache_id();
        
        $data = $cache_server->get($key);
        if ($data === FALSE) {
            
            
            $gcategory_mod = &bm('gcategory', array('_store_id' => 0));
            
            
            $gcategories = $gcategory_mod->get_list(-1, true);
            
            
            import('tree.lib');
            $tree = new Tree();
            $tree->setTree($gcategories, 'cate_id', 'parent_id', 'cate_name');

            $gcategories = $tree->getArrayList(0);
            
            
            
            

            $amount = (empty($this->options['amount']) || intval($this->options['amount'])<=0) ? 0 : intval($this->options['amount']);
            if($amount){
                $gcategories = array_slice($gcategories,0,$amount);
            }
            
            
            
            foreach ($gcategories as $key => $value) {
                $gcategories[$key]['iconfonts'] = $this->options['iconfonts'][$key];
            }
            
            
            
            
            
            $data = array(
                'gcategories' => $gcategories,
                'model_name' => $this->options['model_name'],
            );
            $cache_server->set($key, $data, $this->_ttl);
        }
        return $data;
    }
    
    
    function get_config_datasrc() {
        /*获取设置的图标 方便配置挂件图标*/
        $iconfonts = include(ROOT_PATH.'/data/iconfont.inc.php');
        $this->assign('iconfonts', $iconfonts);
    }
    
    
    
    
    
    
    function parse_config($input) {
        $result = array();
        for ($i = 0; $i < 16; $i++) {
            $result[] = array(
                'iconfont' => $input['iconfont'][$i]
            );
        }
        $input['iconfonts'] = $result;
        unset($input['iconfont']);
        return $input;
    }

}

?>