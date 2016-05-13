<?php

/**
 * 3个广告图片
 *
 * @return  array   $image_list
 */
class Taocz_three_adsWidget extends BaseWidget
{
    var $_name = 'taocz_three_ads';
	var $_ttl  = 86400;

    function _get_data()
    {
		$cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {
			$data = array(
		    	'model_name'	=>	$this->options['model_name'],
				'ads'   		=> $this->_get_ads(),
			);
        }
        return $data;
    }
	
	function _get_ads()
	{
		$ads = array();
		for ($i = 1; $i <= 3; $i++)
		{
			$ads[] = array(
				'image_url'  => $this->options['ad'.$i.'_image_url'],
            	'link_url'   => $this->options['ad'.$i.'_link_url'],
				'image_title'=>	$this->options['ad'.$i.'_image_title'],
			);
		}
		return $ads;
	}

    function parse_config($input)
    {
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
        for ($i = 1; $i <= 3; $i++)
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