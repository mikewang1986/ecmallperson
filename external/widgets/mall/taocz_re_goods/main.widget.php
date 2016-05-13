<?php

/**
 * 轮播图片挂件
 *
 * @return  array   $image_list
 */
class Taocz_re_goodsWidget extends BaseWidget
{
    var $_name = 'taocz_re_goods';
	var $_ttl  = 1800;
	
    function _get_data()
    {
		$cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {
			$num=$this->options['num']?$this->options['num']:12;
			$recom_mod =& m('recommend');
			$goods_list= $recom_mod->get_recommended_goods($this->options['img_recom_id'],$num, true, $this->options['img_cate_id']);
			if($goods_list)
			{
				foreach($goods_list as $key=>$val){
					if($val['stock'])
					{
						$goods_list[$key]['stock_rate']=((1-$val['sales']/$val['stock'])*100).'%';
					}else{
						$goods_list[$key]['stock_rate']=0;
					}
				}
			}
			$data = array(
				'model_id'			=> mt_rand(),
				'model_name'	 	=> $this->options['model_name'],
				'goods_list'	 	=> $goods_list,
			);
        	$cache_server->set($key, $data,$this->_ttl);
        }
        return $data;
    }

    function parse_config($input)
    {
        return $input;
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