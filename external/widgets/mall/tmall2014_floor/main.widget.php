<?php

class tmall2014_floorWidget extends BaseWidget {

    var $_name = 'tmall2014_floor';

    function _get_data() {



        $cache_server = & cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if ($data === false) {

            
            $gcategory_mod = &bm('gcategory', array('_store_id' => 0));
            $gcategories = $gcategory_mod->get_list($this->options['cate_id'], true);
            
            
            
            $data = array(
                'model_id' => mt_rand(),
                'brands' => $this->_get_brands_by_tag($this->options['tag1']),
                'floor_id'=>$this->options['floor_id'],
                
                
                'iconfont1'=>$this->options['iconfont1'],
                'cate_name1'=>$this->options['cate_name1'],
                'cate_url1'=>$this->options['cate_url1'],
                'iconfont2'=>$this->options['iconfont2'],
                'cate_name2'=>$this->options['cate_name2'],
                'cate_url2'=>$this->options['cate_url2'],
                
                'gcategories'=>$gcategories,
                
                
                //图片
                'ad1_image_url' => $this->options['ad1_image_url'],
                'ad1_link_url' => $this->options['ad1_link_url'],
                'ad2_image_url' => $this->options['ad2_image_url'],
                'ad2_link_url' => $this->options['ad2_link_url'],
                'ad3_image_url' => $this->options['ad3_image_url'],
                'ad3_link_url' => $this->options['ad3_link_url'],
                'ad4_image_url' => $this->options['ad4_image_url'],
                'ad4_link_url' => $this->options['ad4_link_url'],
                'ad5_image_url' => $this->options['ad5_image_url'],
                'ad5_link_url' => $this->options['ad5_link_url'],
                'ad6_image_url' => $this->options['ad6_image_url'],
                'ad6_link_url' => $this->options['ad6_link_url'],
                'ad7_image_url' => $this->options['ad7_image_url'],
                'ad7_link_url' => $this->options['ad7_link_url'],
            );
            $cache_server->set($key, $data, $this->_ttl);
        }
        return $data;
    }
    
    
    
    
    
    
    

    function get_config_datasrc() {
        /*获取设置的图标 方便配置挂件图标*/
        $iconfonts = include(ROOT_PATH.'/data/iconfont.inc.php');
        $this->assign('iconfonts', $iconfonts);
        
        
        // 取得一级商品分类
        $this->assign('gcategories', $this->_get_gcategory_options(2));
        // 获取品牌分类
        $this->assign('tags', $this->_get_brand_tags());

        //让客户可以自动选择楼层，因为需使用样式
        $this->assign('floors', $this->_get_floors());
    }

    //让客户可以自动选择楼层，因为需使用样式
    function _get_floors() {
        $data = array();
        for ($i = 1; $i <= 11; $i++) {
            $data[$i] = '楼层' . $i;
        }
        return $data;
    }

    /* 获取品牌分类 */
    function _get_brand_tags() {
        $brand_mod = & m('brand');
        $sql = "SELECT distinct tag FROM " . DB_PREFIX . "brand";
        return $brand_mod->getAll($sql);
    }

    /* 根据品牌分类获取品牌 */
    function _get_brands_by_tag($tag) {
        $brand_mod = & m('brand');
        $conditions = "brand_logo is not null ";
        if ($tag) {
            $conditions .= " and tag ='" . $tag . "'";
        }
        $brands = $brand_mod->find(array(
            'conditions' => $conditions,
            'order' => "sort_order asc",
            'limit' => '0,24'
        ));
        return $brands;
    }

    function parse_config($input) {
        $images = $this->_upload_image();
        if ($images) {
            foreach ($images as $key => $image) {
                $input['ad' . $key . '_image_url'] = $image;
            }
        }

        return $input;
    }

    function _upload_image() {
        import('uploader.lib');
        $images = array();
        for ($i = 1; $i <= 7; $i++) {
            $file = $_FILES['ad' . $i . '_image_file'];
            if ($file['error'] == UPLOAD_ERR_OK) {
                $uploader = new Uploader();
                $uploader->allowed_type(IMAGE_FILE_TYPE);
                $uploader->addFile($file);
                $uploader->root_dir(ROOT_PATH);
                $images[$i] = $uploader->save('data/files/mall/template', $uploader->random_filename());
            }
        }

        return $images;
    }

}
?>