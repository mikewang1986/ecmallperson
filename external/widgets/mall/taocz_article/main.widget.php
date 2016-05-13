<?php

/**
 * 文章挂件
 *
 * @return  array
 */
class Taocz_articleWidget extends BaseWidget
{
    var $_name = 'taocz_article';
    var $_ttl  = 86400;

    function _get_data()
    {
        $cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {
			$amount = (empty($this->options['amount']) || intval($this->options['amount'])<=0) ? 5 : intval($this->options['amount']);
			
            $acategory_mod =& m('acategory');
            $article_mod =& m('article');
			
			$articles = $tabs = array();
			for($i=1;$i<=3;$i++) 
			{
				import('init.lib');
				$init = new Init_Taocz_articleWidget();
				$init->options = $this->options;
				$conditions = $init->_get_data($i);
				
				$articles[] = $article_mod->find(array(
				   'conditions'=>'code = "" AND if_show=1 AND store_id=0 ' . $conditions,
				   'fields'=>'article_id, title',
				   'limit'=> $amount,
				   'order'=>'sort_order ASC, article_id DESC'
				));
				
				if(empty($this->options['tab_'.$i])){
					$tabs[] = '标题'.$i;
				} else {
					$tabs[] = $this->options['tab_'.$i];
				}
			}	    

			$data = array(
			   'model_id'	=> mt_rand(),
			   'model_name' => $this->options['model_name'],
			   'tabs'      	=> $tabs,
			   'articles'   => $articles
			);
            $cache_server->set($key, $data, $this->_ttl);
        }
        return $data;
    }
	
	function get_config_datasrc()
    {
		// 取得多级文章分类，去除系统文章
        $this->assign('acategories', $this->_get_acategory_options(2));
    }

    function parse_config($input)
    {
       return $input;
    }
	
	function _get_acategory_options($layer = 0)
	{
		$acategory_mod =& m('acategory');
        $acategories = $acategory_mod->get_list();
		foreach($acategories as $key=>$val)
		{
			if($val['code'] == ACC_SYSTEM){
				unset($acategories[$key]);
			}
		}

        import('tree.lib');
        $tree = new Tree();
        $tree->setTree($acategories, 'cate_id', 'parent_id', 'cate_name');

        return $tree->getOptions($layer);
	}  
}

?>