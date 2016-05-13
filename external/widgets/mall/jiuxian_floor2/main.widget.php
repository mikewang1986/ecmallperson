<?php

/**
 * 轮播图片挂件
 *
 * @return  array   $image_list
 */
class Jiuxian_floor2Widget extends BaseWidget
{
    var $_name = 'jiuxian_floor2';
	var $_ttl  = 1800;
	
    function _get_data()
    {
		$cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {
			$amount = empty($this->optioins['amount']) ?  10 : intval($this->options['amount']);
			$promotion_mod =& m('promotion');
			if($this->options['cate_id']){
				$gcategory_mod = &bm('gcategory');
				$cate_ids = implode(",",$gcategory_mod->get_descendant_ids($this->options['cate_id']));
				if($this->options['cate_id'] > 0){
					$conditions = " AND cate_id IN (".$cate_ids.")";
				} else {
					$conditions = '';
				}
			}
            $promotion=  $promotion_mod->find(array(
				'conditions'=>'start_time  < '.gmtime().' AND end_time > '.gmtime() . $conditions,
				'join'      =>'belong_goods',
				'fields'    =>'this.*,g.default_image,g.price,g.default_spec,g.goods_name,g.default_spec',
				'limit'     =>$amount
			));
			
			$promotion = Psmb_init()->Jiuxian_floor2Widget_format_promotion($promotion);
			
			$ads_1=array();
			$ads_2=array();
			for($i=1;$i<4;$i++)
			{
				$ads_1[]=array('ad_image_url'=> $this->options['ad'.$i.'_image_url'],'ad_link_url'=> $this->options['ad'.$i.'_link_url']);
			}
			for($i=4;$i<7;$i++)
			{
				$ads_2[]=array('ad_image_url'=> $this->options['ad'.$i.'_image_url'],'ad_link_url'=> $this->options['ad'.$i.'_link_url']);
			}
			$data = array(
				'model_id'			=> mt_rand(),
				'model_name'	 	=> $this->options['model_name'],
				'ads_1'             =>$ads_1,
				'ads_2'             =>$ads_2,
				'promotions'        =>$promotion,
				'brands'			=> explode(' ',$this->options['brands']),	
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
        // 取得一级商品分类
        $this->assign('gcategories', $this->_get_gcategory_options(2));
		
		//模块风格
		$this->assign('styles',$this->styles);
    }
}

?>