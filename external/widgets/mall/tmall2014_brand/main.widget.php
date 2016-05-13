<?php

class tmall2014_brandWidget extends BaseWidget {

    var $_name = 'tmall2014_brand';
    var $_ttl = 86400;

    function _get_data() {



        $cache_server = & cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if ($data === false) {

            $data = array(
                'model_name' => $this->options['model_name'],
                'model_id' => mt_rand(),
                'ad1_image_url' => $this->options['ad1_image_url'],
                'ad1_link_url' => $this->options['ad1_link_url'],
                'ad1_image_title' => $this->options['ad1_image_title'],
                'ad2_image_url' => $this->options['ad2_image_url'],
                'ad2_link_url' => $this->options['ad2_link_url'],
                'ad2_image_title' => $this->options['ad2_image_title'],
                'tag1' => $this->options['tag1'],
                'brands1' => $this->_get_brands_by_tag($this->options['tag1']),
                'tag2' => $this->options['tag2'],
                'brands2' => $this->_get_brands_by_tag($this->options['tag2']),
                'tag3' => $this->options['tag3'],
                'brands3' => $this->_get_brands_by_tag($this->options['tag3']),
            );
            $cache_server->set($key, $data, $this->_ttl);
        }
        return $data;
    }

    function get_config_datasrc() {
        $this->assign('tags', $this->_get_brand_tags());
    }

    /*获取品牌分类*/
    function _get_brand_tags() {
        $brand_mod = & m('brand');
        $sql = "SELECT distinct tag FROM " . DB_PREFIX . "brand";
        return $brand_mod->getAll($sql);
    }

    /*根据品牌分类获取品牌*/
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
        for ($i = 1; $i <= 2; $i++) {
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