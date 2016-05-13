<?php

class tmall2014_fashionWidget extends BaseWidget
{
    var $_name = 'tmall2014_fashion';

    function _get_data() {
        $data = array(
             'model_name' => $this->options['model_name'],
            'model_id' => mt_rand(),
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
        );
        return $data;
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
}

?>