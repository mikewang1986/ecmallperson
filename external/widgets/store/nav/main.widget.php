<?php

class NavWidget extends Store_baseWidget
{
    var $_name = 'nav';

    function _get_data()
    {
		$this->assign('site_url', site_url());
        return array(
			'model_id' => mt_rand(),
			'store_id' => $this->_store_id,
            'bgcolor'  => $this->options['bgcolor'] ? $this->options['bgcolor'] : '#B10000',
			'txtcolor' => $this->options['txtcolor'] ? $this->options['txtcolor'] : '#ffffff',
			'txtbgcolor'=> $this->options['txtbgcolor'] ? $this->options['txtbgcolor'] : '#B10000',
			'curtxtcolor' => $this->options['curtxtcolor'] ? $this->options['curtxtcolor'] : '#FFFFFF',
			'curtxtbgcolor'=>$this->options['curtxtbgcolor'] ? $this->options['curtxtbgcolor'] : '#6A0000',
			'navs'     => $this->options['navs'],
			'gcategory' => $this->get_gcategory($this->_store_id),
        );
    }
	
	function get_gcategory($store_id = 0)
	{
		if(!$store_id)
		{
			return false;
		}
		$gcategory_mod =& bm('gcategory', array('_store_id' => $store_id));
		$gcategories = $gcategory_mod->get_list(-1, true);
		import('tree.lib');
        $tree = new Tree();
        $tree->setTree($gcategories, 'cate_id', 'parent_id', 'cate_name');
		$data = $tree->getArrayList(0);
		return $data;
	}

    function parse_config($input)
    {
        $result = array();
        $num    = isset($input['link']) ? count($input['link']) : 0;
        if ($num > 0)
        {
            for ($i = 0; $i < $num; $i++)
            {
                    $result[] = array(
                        'title' => $input['title'][$i],
                        'link'  => $input['link'][$i],
                    );
            }
        }
		$input['navs'] = $result;
        return $input;
    }
}

?>