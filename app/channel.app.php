<?php

/*  channel page by tyioocm */

class ChannelApp extends MallbaseApp
{
	var $_channel_mod;
	var $_gcategory_mod;
	
	function __construct()
    {
        $this->ChannelApp();
    }

    function ChannelApp()
    {
		parent::__construct();     
		$this->_channel_mod = &af('channels');
		$this->_gcategory_mod = & bm('gcategory', array('_store_id' => 0));
    }
	
    function index()
    {
		$id = $_GET['id'] ? $this->_check_id($_GET['id']) : 0;
		
		if(!$id){
			return;
		}
		
		/* get info of channel */
		$channel = $this->_channel_mod->getOne($id);
		
		if(!$channel){
			return;
		}
		
		if($channel['status']==0) {
			$this->show_warning('page_not_exist');
			return;
		}
		
		$this->headtag('<link href="{res file=css/channel.style'.$channel['style'].'.css}" rel="stylesheet" type="text/css" />');
		
		/* 当前位置 */
        $this->_curlocal($this->_get_channel_curlocal($channel));
        
        /* 配置seo信息 */
        $this->_config_seo($this->_get_seo_info($channel));
		$file = 'channel.style'.$channel['style'].'_'.$id.'.html';
		$this->display($file);
    }
	function _get_channel_curlocal($channel)
    {
		$curlocal = array(
            array('text' => LANG::get('all_categories'), 'url' => url('app=category')),
        );
		if(isset($channel['cate_id']) && intval($channel['cate_id'])>0){
			$parents = $this->_gcategory_mod->get_ancestor($channel['cate_id'], true);
			foreach ($parents as $category){
				$curlocal[] = array('text' => $category['cate_name'], 'url' => url('app=search&act=store&cate_id=' . $category['cate_id']));
			}
		}
		unset($curlocal[count($curlocal) - 1]);
		$curlocal[] = array('text' => $channel['title'], 'url' => '');
        return $curlocal;
    }
	function _get_seo_info($channel)
    {
		$cate_id = $channel['cate_id'];
        $seo_info = array(
            'title'       => '',
            'keywords'    => '',
            'description' => ''
        );
        $parents = array(); // 所有父级分类包括本身
		if ($cate_id)
		{
			$parents = $this->_gcategory_mod->get_ancestor($cate_id, true);
			$parents = array_reverse($parents);
		}
		
        foreach ($parents as $key => $cate)
        {
            //$seo_info['title'] .= $cate['cate_name'] . ' - ';
            $seo_info['keywords'] .= $cate['cate_name']  . ',';
            if ($cate_id == $cate['cate_id'])
            {
                $seo_info['description'] = $cate['cate_name'] . ' ';
            }
        }
        $seo_info['title'] = $channel['title'] .' - ' . Conf::get('site_title');
        $seo_info['keywords'] .= $channel['title'] . ',' . Conf::get('site_title');
        $seo_info['description'] .= $channel['title'] . ' ' . Conf::get('site_title');
        return $seo_info;
    }
	function _check_id($id)
	{
		if(!$id) return 0;
		
		if(is_numeric($id) && strlen($id)<=12){
			return $id;
		} else {
			return 0;
		}
	}
		
}

?>