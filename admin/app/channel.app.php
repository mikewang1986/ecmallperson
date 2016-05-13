<?php

/*  channel page by tyioocm */

class ChannelApp extends BackendApp
{
	var $_channel_mod;
	var $_gcategory_mod;
	var $_tpl_filepath;
	var $_tpl_confpath;
	var $_tpl_url;

    function __construct()
    {
        $this->ChannelApp();
    }

    function ChannelApp()
    {
        parent::BackendApp();
        $this->_channel_mod 	= &af('channels');
		$this->_gcategory_mod 	= & bm('gcategory', array('_store_id' => 0));
		$this->_tpl_filepath	= ROOT_PATH . '/themes/mall/'.$this->_get_template_name() . '/';
		$this->_tpl_confpath	= ROOT_PATH . '/data/page_config/';
		$this->_tpl_url			= SITE_URL . '/themes/mall/'.$this->_get_template_name() . '/styles/' . $this->_get_style_name();
    }
	function index()
	{
		
	}
	function add()
	{
		if(!IS_POST)
		{
			// 第一级分类
        	$this->assign('gcategories', $this->_gcategory_mod->get_options(0, true));
        	//$this->import_resource(array('script' => 'mlselection.js,inline_edit.js'));
			
			$this->assign('tpl_url', $this->_tpl_url);
			
			$this->display('channel.form.html');
		}
		else 
		{
			$id = time().rand(1,9);
			$style = $_POST['style'] ? intval($_POST['style']) : 1;
			$title = $_POST['title'] ? trim($_POST['title']) : '';
			
			if(empty($title)){
				$this->show_warning('title_not_empty');
				return;
			}
			
			$channel = array(
				'title'		=> $title,
				'cate_id'   => intval($_POST['cate_id']),
				'style'     => $style,
				'status'    => intval($_POST['status']),
			);
			$this->_channel_mod->setOne($id,$channel); // 不用 $this->_channel_mod->add   add 会改变 key
			
			/* 频道页创建成功后，创建视图（即模板文件）和模板的配置文件 */
			$this->create_file($style, $id);
			
			$this->show_message('add_channel_successed');
		}
	}
	function edit()
	{
		$id = $_GET['id'] ? $this->_check_id($_GET['id']) : 0;
		
		if(!$id){
			$this->show_message('param_error');
		}
		
		$channel = $this->_channel_mod->getOne($id);

		if(!IS_POST)
		{
			// 第一级分类
        	$this->assign('gcategories', $this->_gcategory_mod->get_options(0, true));
        	//$this->import_resource(array('script' => 'mlselection.js,inline_edit.js'));
		
			$this->assign('channel', $channel);
			
			$this->assign('tpl_url', $this->_tpl_url);
			
			$this->display('channel.form.html');
		}
		else
		{
			$style = intval($_POST['style']);
			
			$new = array(
				'title' => $_POST['title'],
				'cate_id'   => intval($_POST['cate_id']),
				'style'     => $style,
				'status'    => intval($_POST['status']),
			);

			if($this->_channel_mod->setOne($id, $new))
			{	
				// 如果编辑的时候，修改了风格，则删除原频道的页面文件及配置文件，创建新风格的页面文件及配置文件，注意：先删除再创建
				if($channel['style'] != $style)
				{
					// dele old style file
					$this->drop_file($channel['style'], $id);
					
					// create new style file
					$this->create_file($style, $id);
					
				}
				$this->show_message('edit_channel_successed');	
			} else {
				$this->show_message('edit_channel_failed');	
			}
		}
		
	}
	function create_file($style, $id)
	{
		$tpl_file = 'channel.style'.$style.'_'.$id.'.html';
		$tpl_conf = $this->_get_template_name() . '.' . $id . '.config.php';
			
		/* if file is not exists ,then create */
		if(!file_exists($this->_tpl_filepath . $tpl_file))
		{
			$html =  file_get_contents($this->_get_default_tpl_html($style));
			$html = str_replace('page=channel','page='.$id,$html);
			
			if(!file_put_contents($this->_tpl_filepath . $tpl_file, $html)){
				exit('create conf error!');
			}
			
		}
		if(!file_exists($this->_tpl_confpath . $tpl_conf))
		{
			if(file_exists($this->_get_default_tpl_conf($style))){
				$html =  file_get_contents($this->_get_default_tpl_conf($style));
			} else {
				$html = "<?php return array('config' =>array(),'widgets' =>array(),);?>";
			}
			
			if(!file_put_contents($this->_tpl_confpath . $tpl_conf, $html)){
				exit('create file error!');
			}
		}
	}
	
	function drop()
	{
		$id = $_GET['id'] ? $this->_check_id($_GET['id']) : 0;
		
		if(!$id){
			$this->show_message('param_error');
		}
		
		$channel = $this->_channel_mod->getOne($id);
		
		if($this->_channel_mod->drop($id))
		{
			$this->drop_file($channel['style'], $id);	
		
			$this->show_message('drop_channel_successed');
			
		} else {
			$this->show_message('drop_channel_failed');
		}
	}
	function drop_file($style, $id)
	{
		/* delete channel.style*_***********.html and  jiaju.***********.config.php */
		
		$tpl_file = $this->_tpl_filepath . 'channel.style'.$style.'_'.$id.'.html';
		$tpl_conf = $this->_tpl_confpath . $this->_get_template_name().'.'.$id.'.config.php';
  		if(file_exists($tpl_file)) {
    		unlink($tpl_file);
  		}
		if(file_exists($tpl_conf)) {
    		unlink($tpl_conf);
  		}
	}
	function _get_default_tpl_html($style)
	{
		if(!$style){
			return '';
		}
		return $this->_tpl_filepath . 'channel.style'.$style.'.html';
	}
	function _get_default_tpl_conf($style)
	{
		if(!$style){
			return '';
		}
		return $this->_tpl_confpath . $this->_get_template_name() . '.style' . $style . '.config.php';
	}
	
	/* 构造并返回树 */
    function &_tree($gcategories)
    {
        import('tree.lib');
        $tree = new Tree();
        $tree->setTree($gcategories, 'cate_id', 'parent_id', 'cate_name');
        return $tree;
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
