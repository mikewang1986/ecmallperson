<?php

/**
 * 公告栏挂件
 *
 * @return  array
 */
class Jiuxian_tab_goodsWidget extends BaseWidget
{
    var $_name = 'jiuxian_tab_goods';
    var $_ttl  = 86400;

    function _get_data()
    {
        $cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {
           	$amount = (empty($this->options['amount']) || intval($this->options['amount'])<=0) ? 5 : intval($this->options['amount']);
			
			$recom_mod =& m('recommend');
			$goods_list = $tabs = array();
			for($i=1;$i<=5;$i++){
				$goods_list[]=$recom_mod->get_recommended_goods($this->options['img_recom_id_'.$i], $amount, true, $this->options['img_cate_id_'.$i],array(),$this->options['sort_by_'.$i]);
				$tabs[]=$this->options['tab_'.$i];
			}

			$data = array(
				'model_id' => mt_rand(),
				'model_name' => $this->options['model_name'],
			    'tabs' => $tabs,
                'goods_list' => $goods_list,
			);
			
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
       return $input;
    }  
}
?>