<?php

class Jiuxian_floorWidget extends BaseWidget
{
    var $_name = 'jiuxian_floor';
	var $_ttl  = 1800;
	
    function _get_data()
    {
		$cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {
			if(empty($this->options['amount']))
			{
				$this->options['amount']=12;
			}
			$recom_mod =& m('recommend');
			$goods_list= $recom_mod->get_recommended_goods($this->options['img_recom_id'],$this->options['amount'], true, $this->options['img_cate_id']);
			$data = array(
				'model_id'			=> mt_rand(),
				'model_name'	 	=> $this->options['model_name'],
				'keywords'	 	    => explode(' ',$this->options['keyword']),
				'goods_list'	 	=> $goods_list,
				'ad1_image_url'  	=> $this->options['ad1_image_url'],
				'ad1_link_url'   	=> $this->options['ad1_link_url'],
				'ad2_image_url'  	=> $this->options['ad2_image_url'],
				'ad2_link_url'   	=> $this->options['ad2_link_url'],
				'ad3_image_url'  	=> $this->options['ad3_image_url'],
				'ad3_link_url'   	=> $this->options['ad3_link_url'],
				'ad4_image_url'  	=> $this->options['ad4_image_url'],
				'ad4_link_url'   	=> $this->options['ad4_link_url'],
				'ad5_image_url'  	=> $this->options['ad5_image_url'],
				'ad5_link_url'   	=> $this->options['ad5_link_url'],
				'ad6_image_url'  	=> $this->options['ad6_image_url'],
				'ad6_link_url'   	=> $this->options['ad6_link_url'],
			);
        	$cache_server->set($key, $data,$this->_ttl);
        }
        return $data;
    }

    function parse_config($input)
    {
        if ($input['img_recom_id'] >= 0)
        {
            $input['img_cate_id'] = 0;
        }
		
		$images = $this->_upload_image();
        if ($images)
        {
            foreach ($images as $key => $image)
            {
                $input['ad' . $key . '_image_url'] = $image;
            }
        }
        return $input;
    }
	
	function _upload_image()
    {
        import('uploader.lib');
        $images = array();
        for ($i = 1; $i <= 6; $i++)
        {
            $file = $_FILES['ad' . $i . '_image_file'];
            if ($file['error'] == UPLOAD_ERR_OK)
            {
                $uploader = new Uploader();
                $uploader->allowed_type(IMAGE_FILE_TYPE);
                $uploader->addFile($file);
                $uploader->root_dir(ROOT_PATH);
                $images[$i] = $uploader->save('data/files/mall/template', $uploader->random_filename());
            }
        }

        return $images;
    }
	function get_config_datasrc()
    {
         // 取得推荐类型
        $this->assign('recommends', $this->_get_recommends());

        // 取得一级商品分类
        $this->assign('gcategories', $this->_get_gcategory_options(2));
    }
}

?>