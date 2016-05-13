<?php

/**
 * 商品分类挂件
 *
 * @return  array   $category_list
 */
class Taocz_gcategory_listWidget extends BaseWidget
{
    var $_name = 'taocz_gcategory_list';
    var $_ttl  = 86400;


    function _get_data()
    {
        $cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {
			$amount = (empty($this->options['amount']) || intval($this->options['amount'])<=0) ? 0 : intval($this->options['amount']);
			
			import('init.lib');
			$init = new Init_FrontendApp();
	
			/* position: 给弹出层设置高度，使得页面效果美观 */
			$position = array('0px','-37px','-50px','-80px','-100px','-100px','-100px','-100px','-170px','-70px','-70px','-70px','-70px');
			$data = $init->_get_header_gcategories($amount,$position,1);// 参数说明（二级分类显示数量,弹出层位置,品牌是否为推荐）
			if($data['gcategories'])
			{
				if($this->options['img']){
					$img=explode('||',$this->options['img']);
				}
				if($this->options['img_link']){
					$img_link=explode('||',$this->options['img_link']);
				}
				if($this->options['store_name']){
					$names=explode('||',$this->options['store_name']);
					foreach($names as $key=>$val){
						$store_name[$key]=explode(' ',$val);
					}
					$ids=explode('||',$this->options['store_id']);
					foreach($ids as $key=>$val){
						$store_id[$key]=explode(' ',$val);
					}
					$store=array();
					if($store_name)
					{
						foreach($store_name as $key => $val)
						{	
							if($val)
							{
								foreach($val as $k=>$v){
									$store[$key][$k]=array('store_name'=>$v,'store_id'=>$store_id[$key][$k]);
								}
							}
						}
					}
				}
				foreach($data['gcategories'] as $key=>$val){
					$data['gcategories'][$key]['image']=array('image'=>$img[$key],'link'=>$img_link[$key]);
					$data['gcategories'][$key]['store']=$store[$key];
				}
			}
			$cache_server->set($key, $data, $this->_ttl);
        }
        return $data;
    }
	function parse_config($input)
    {
        return $input;
    }

}

?>