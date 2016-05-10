<?php

/**
 * ��Ʒģ��Ҽ�
 *
 * @param   string  $module_name    ģ������
 * @param   array   $keyword_list   ���Źؼ����б�
 * @param   string  $ad_image_url   ���ͼƬ��ַ
 * @param   string  $ad_link_url    ������ӵ�ַ
 * @param   int     $img_recom_id   ͼ���Ƽ�id
 * @param   string  $sub_module_name��ģ������
 * @param   int     $txt_recom_id   �����Ƽ�id
 * @return  array
 */
class Goods_module_2Widget extends BaseWidget
{
    var $_name = 'goods_module_2';
    var $_ttl  = 1800;

    function _get_data()
    {
        $cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {
            $recom_mod =& m('recommend');
            $img_goods_list = $recom_mod->get_recommended_goods($this->options['img_recom_id'], 6, true, $this->options['img_cate_id']);
            $txt_goods_list = $recom_mod->get_recommended_goods($this->options['txt_recom_id'], 10, true, $this->options['txt_cate_id']);
            $cache_server->set($key, array(
                'img_goods_list' => $img_goods_list,
                'txt_goods_list' => $txt_goods_list,
            ), $this->_ttl);
        }

        return array(
            'module_name'       => $this->options['module_name'],
            'bgcolor'           => $this->options['bgcolor'],
            'keyword_list'      => explode(' ', $this->options['keyword_list']),
            'ad_image_url'      => $this->options['ad_image_url'],
            'ad_link_url'       => $this->options['ad_link_url'],
            'img_goods_list'    => $data['img_goods_list'],
            'sub_module_name'   => $this->options['sub_module_name'],
            'txt_goods_list'    => $data['txt_goods_list'],
        );
    }

    function get_config_datasrc()
    {
        // ȡ���Ƽ�����
        $this->assign('recommends', $this->_get_recommends());

        // ȡ��һ����Ʒ����
        $this->assign('gcategories', $this->_get_gcategory_options(1));
    }

    function parse_config($input)
    {
        $filename = $this->_upload_image();
        if ($filename)
        {
            $input['ad_image_url'] = $filename;
        }

        if ($input['img_recom_id'] >= 0)
        {
            $input['img_cate_id'] = 0;
        }
        if ($input['txt_recom_id'] >= 0)
        {
            $input['txt_cate_id'] = 0;
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