<?php

class JindanModule extends AdminbaseModule
{
 

    function __construct()
    {
        $this->JindanModule();
    }
 
    function JindanModule()
    {
        parent::__construct();
		
        	
    } 
 
    function index()
    {   
		$model_setting = &af('settings');
        $setting = $model_setting->getAll(); //载入系统设置数据
        if (!IS_POST)
        {
            $this->assign('setting', $setting);
           
            //$this->assign('yes_or_no', array(Lang::get('no'), Lang::get('yes')));
            $this->display('jindan_setting.html');
        }
        else
        {
            /* 初始化 */
             $data['dandan_1']  = empty($_POST['dandan_1']) ? '' : trim($_POST['dandan_1']);
             $data['dandan_2']  = empty($_POST['dandan_2'])   ? '' : trim($_POST['dandan_2']);
             $data['dandan_3']  = empty($_POST['dandan_3'])  ? '' : trim($_POST['dandan_3']);
             $data['dandan_4']  = empty($_POST['dandan_4'])   ? '' : trim($_POST['dandan_4']);

            /* Config */
            $config_file = ROOT_PATH . '/data/datacall.inc.php';
            $config = include($config_file);
            $new_config = var_export($config, true);
           
            /* 写入 */
            $model_setting->setAll($data);
            file_put_contents($config_file, "<?php\r\n\r\nreturn {$new_config};\r\n\r\n?>");

            $this->show_message('edit_dandan_setting_successed');
        }
    }
	
	function jindan_shangjia()
    {   
		$db = &db();
		$count = 'select count(id) from ecm_jindan_shop';
		
		$num = $db->getone($count);
		$page = $this->_get_page(10);//内置分页方法，将每页显示条数传入分页
		$page['item_count'] = $num;
		$this->_format_page($page);
		
		$sql = "select A.*,B.store_name from ecm_jindan_shop A left join ecm_store B on A.shop_id = B.store_id order by stime desc limit ".$page['limit'];
		$shangjia_lis = $db -> query($sql);
		$i = 0;
		while($row = $db-> fetchrow($shangjia_lis))
		{	$shangjia_list[$i]['store_name']=$row['store_name'];
			$shangjia_list[$i]['stime']=$row['stime'];
			$shangjia_list[$i]['jindan_num']=$row['jindan_num'];
			$shangjia_list[$i]['id']=$row['id'];
			$shangjia_list[$i]['shop_id']=$row['shop_id'];
			$i++;
		}
		 //print_r($shangjia_list);
		
		$this->assign('page_info', $page);          //将分页信息传递给视图，用于形成分页条 
 		$this->assign('shangjia_list', $shangjia_list);
        $this->display('jindan_shangjia.html');
		 
    }
	
	 function add()
    {   
		if($_POST){
		$shop_id = trim($_POST['shop_id']);
	    $jindan_num = $_POST['jindan_num'];
	 	$stime =  strtotime(date("y-m-d h:i:s",time()));//当前时间戳
		$add_sql = &db();
		$add_sql->query("insert into ecm_jindan_shop(id,shop_id,jindan_num,stime) values('','$shop_id','$jindan_num','$stime')");
      	 
		$this->show_message('添加成功','返回列表','index.php?module=jindan&act=jindan_shangjia');
	        return;
		 }
		 
        $this->display('dandan.form.html');  
    }
	function edit()
    {   
	
		$id = trim($_GET['id']);
		
		 if(empty($id)){
			$this->show_message('编辑失败','返回列表','index.php?module=jindan&act=jindan_shangjia');
	        return;			 
			 }
		if (!IS_POST){	
		 $edit_sql1 = &db();
		$shangjia = $edit_sql1->getrow("select * from ecm_jindan_shop where id=".$id);		
		//$this->assign('data', $data);
		$this->assign('shangjia', $shangjia);	
        $this->display('dandan.edit.html');
		}else{
		$id = trim($_POST['id']);	
		$shop_id = trim($_POST['shop_id']);
	    $jindan_num = $_POST['jindan_num'];
	 	$stime =  strtotime(date("y-m-d h:i:s",time()));//当前时间戳
		$edit_sql = &db();
		$edit_sql->query("UPDATE `ecm_jindan_shop` SET `jindan_num` = $jindan_num,`stime` = $stime WHERE `id` =".$id);
		$this->show_message('编辑成功','返回列表','index.php?module=jindan&act=jindan_shangjia');
	        return;	
		 }
		 
	 
    }
	function drop()
    {   
			 $pingpaitemai_id = trim($_GET['id']);
			 $Ids = explode(",",$pingpaitemai_id);
			 	
				 $drop_sql=&db();
				 for ($n=0;$n<count($Ids);$n++) {	
				 $drop_sql->query("delete from ecm_jindan_shop where id = ".$Ids[$n]);
				 }
				 $this->show_message('删除成功','返回列表','index.php?module=jindan&act=jindan_shangjia');
	        	 return;
    }
	
	function drop_log()
    {   
			 $pingpaitemai_id = trim($_GET['id']);
			 $Ids = explode(",",$pingpaitemai_id);
			 	
				 $drop_sql=&db();
				 for ($n=0;$n<count($Ids);$n++) {	
				 $drop_sql->query("delete from ecm_jindan_log where id = ".$Ids[$n]);
				 }
				 $this->show_message('删除成功','返回列表','index.php?module=jindan&act=jindan_log');
	        	 return;
    }
	
	function jindan_log()
    {   
		$db = &db();
		$count = 'select count(id) from ecm_jindan_log where jiner > 0';
		
		$num = $db->getone($count);
		$page = $this->_get_page(10);//内置分页方法，将每页显示条数传入分页
		$page['item_count'] = $num;
		$this->_format_page($page);
		
		$sql = "select A.*,B.user_name from ecm_jindan_log A left join ecm_member B on A.user_id = B.user_id where A.jiner > 0 order by stime desc limit ".$page['limit'];
		$shangjia_lis = $db -> query($sql);
		$i = 0;
		while($row = $db-> fetchrow($shangjia_lis))
		{	$shangjia_list[$i]['shop_id']=$row['shop_id'];
			$shangjia_list[$i]['user_id']=$row['user_id'];
			$shangjia_list[$i]['jiner']=$row['jiner'];
			$shangjia_list[$i]['id']=$row['id'];
			$shangjia_list[$i]['stime']=$row['stime'];
			$shangjia_list[$i]['user_name']=$row['user_name'];
			$i++;
		}
		 //print_r($shangjia_list);
		
		$this->assign('page_info', $page);          //将分页信息传递给视图，用于形成分页条 
 		$this->assign('shangjia_list', $shangjia_list);
        $this->display('jindan_log.html');
		 
    }
   
}

?>