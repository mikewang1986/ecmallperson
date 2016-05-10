<?php

/**
 * ͼƬ���Ҽ�
 *
 * @param   string  $image_url  ͼƬ��ַ
 * @param   string  $link_url   ���ӵ�ַ
 * @param   int     $width      ͼƬ���
 * @param   int     $height     ͼƬ�߶�
 * @return  array   $options    ����
 */
class Image_adWidget extends BaseWidget
{
    var $_name = 'image_ad';

    function _get_data()
    {
        return array(
            'ad_image_url'  => $this->options['ad_image_url'],
            'ad_link_url'   => $this->options['ad_link_url'],
        );
    }

    function parse_config($input)
    {
        $image = $this->_upload_image();
        if ($image)
        {
            $input['ad_image_url'] = $image;
        }

        return $input;
    }

    function _upload_image()
    {
        import('uploader.lib');
        $file = $_FILES['ad_image_file'];
        if ($file['error'] == UPLOAD_ERR_OK)
        {
            $uploader = new Uploader();
            $uploader->allowed_type(IMAGE_FILE_TYPE);
            $uploader->addFile($file);
            $uploader->root_dir(ROOT_PATH);
            return $uploader->save('data/files/mall/template', $uploader->random_filename());
        }

        return '';
    }
}

?>