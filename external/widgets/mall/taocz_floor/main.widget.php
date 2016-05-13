<?php

/**
 * 轮播图片挂件
 *
 * @return  array   $image_list
 */
class Taocz_floorWidget extends BaseWidget
{
    var $_name = 'taocz_floor';
	var $_ttl  = 1800;
    function _get_data()
    {
		$cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {
			import('init.lib');
			$init=new Init_Taocz_floorWidget();
			$data = array(
				'model_id'			=> mt_rand(),
				'model_name'	 	=> $this->options['model_name'],
				'keywords'	 	=> explode(' ',$this->options['keyword']),
				'title'	 	=> $this->options['title'],
				'link'	 	=> $this->options['link'],
				'goods_list'	 	=> $init->_get_data($this->options),
			);
			for($i=1;$i<=5;$i++){	
				$data['ad'.$i.'_image_url']=$this->options['ad'.$i.'_image_url'];
				$data['ad'.$i.'_link_url']=$this->options['ad'.$i.'_link_url'];
			}
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
        for ($i = 1; $i <= 5; $i++)
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