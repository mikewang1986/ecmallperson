<?php

/**
 * 轮播图片挂件
 *
 * @return  array   $image_list
 */
class Taocz_re_imageWidget extends BaseWidget
{
    var $_name = 'taocz_re_image';
	var $_ttl  = 86400;

    function _get_data()
    {
		$cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {
			$data = array(
				'ads'   	=> $this->options['ads'],
				'model_name'=> $this->options['model_name']
			);
        }
        return $data;
    }

    function parse_config($input)
    {
        $result = array();
        $num    = 12;
        if ($num > 0)
        {
            $images = $this->_upload_image($num);
            for ($i = 0; $i < $num; $i++)
            {
                if (!empty($images[$i]))
                {
                    $input['ad_image_url'][$i] = $images[$i];
                }
    
                if (!empty($input['ad_image_url'][$i]))
                {
                    $result[] = array(
                        'ad_image_url' => $input['ad_image_url'][$i],
                        'ad_link_url'  => $input['ad_link_url'][$i],
						'ad_title_url'  => $input['ad_title_url'][$i]
                    );
                }
            }
        }
		$input['ads'] = $result;
		unset($input['ad_image_url']);
		unset($input['ad_link_url']);
		unset($input['ad_title_url']);
        return $input;
    }

    function _upload_image($num)
    {
        import('uploader.lib');

        $images = array();
        for ($i = 0; $i < $num; $i++)
        {
            $file = array();
            foreach ($_FILES['ad_image_file'] as $key => $value)
            {
                $file[$key] = $value[$i];
            }

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