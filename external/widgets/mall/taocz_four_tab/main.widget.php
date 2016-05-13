<?php

/**
 * 公告栏挂件
 *
 * @return  array
 */
class Taocz_four_tabWidget extends BaseWidget
{
    var $_name = 'taocz_four_tab';
    var $_ttl  = 86400;

    function _get_data()
    {
        $cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {
			import('init.lib');
			$init=new Init_Taocz_four_tabWidget();
			$result=$init->_get_data($this->options,4);
			$data = array(
				'model_id' => mt_rand(),
				'model_name' => $this->options['model_name'],
			    'tabs' => $result['tabs'],
                'goods_list' => $result['goods_list'],
			);
			for($i=1;$i<=9;$i++){	
				$data['ads'][$i]['ad_image_url']=$this->options['ad'.$i.'_image_url'];
				$data['ads'][$i]['ad_link_url']=$this->options['ad'.$i.'_link_url'];
			}
			$cache_server->set($key, $data, $this->_ttl);
        }
        return $data;
    }
	
	function get_config_datasrc()
    {
         // 取得推荐类型
        $this->assign('recommends', $this->_get_recommends());

        // 取得一级商品分类
        $this->assign('gcategories', $this->_get_gcategory_options(2));
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
        for ($i = 1; $i <= 9; $i++)
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
}
?>