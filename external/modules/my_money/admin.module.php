<?php

class My_moneyModule extends AdminbaseModule
{
    function __construct()
    {
        $this->My_moneyModule();
    }

    function My_moneyModule()
    {
        parent::__construct();
		
        $this->my_money_mod =& m('my_money');
		$this->my_moneylog_mod =& m('my_moneylog');
		$this->my_mibao_mod =& m('my_mibao');
		$this->my_card_mod =& m('my_card');
		$this->my_jifen_mod =& m('my_jifen');
		$this->my_paysetup_mod =& m('my_paysetup');			
    }

 	function index()
    {
       $this->display('index_index.html');
	   return;
	}
//用户资金列表 含搜索
 	function user_money_list()
	{
	$so_user_name=$_GET["soname"];	
	$somoney=$_GET["somoney"];	
	$endmoney=$_GET["endmoney"];	
	
    $page = $this->_get_page();
	//搜索用户为空就搜索全部	
	if(empty($so_user_name))
	{
    //检测 开始金额 结束金额 都为空
    if(empty($somoney) and empty($endmoney)) 
    {
	$index=$this->my_money_mod->find(array(
	'conditions' => '',//条件
    'limit' => $page['limit'],
	'order' => "money desc",
	'count' => true));	
	//上面自然列出所有用户，按金额大到小排列
	}
	//否则搜索 用户名、开始金额-结束金额
	else
	{
	if(empty($somoney)){$somoney=0;}//开始金额为空就=0
	if(empty($endmoney)){$endmoney=9999999;}//结束金额为空就=9999999
	$index=$this->my_money_mod->find(array(
	'conditions' => "user_name LIKE '%$so_user_name%' and money>='$somoney' and money<='$endmoney'",//条件
    'limit' => $page['limit'],
	'order' => "money desc",
	'count' => true));	
	}
	}
	else
	{//否则用户名不为空
	
    //用户不为空 双时间为空
    if(empty($somoney) and empty($endmoney)) 
    {
	$index=$this->my_money_mod->find(array(
	'conditions' => "user_name LIKE '%$so_user_name%'",//条件
    'limit' => $page['limit'],
	'order' => "money desc",
	'count' => true));	
	}
	//用户不为空 双时间也不为空
	else
	{
	if(empty($somoney)){$somoney=0;}
	if(empty($endmoney)){$endmoney=999999999;}
	$index=$this->my_money_mod->find(array(
	'conditions' => "user_name LIKE '%$so_user_name%' and money>='$somoney' and money<='$endmoney'",//条件
    'limit' => $page['limit'],
	'order' => "money desc",
	'count' => true));	
	}
	}
			
		$page['item_count'] = $this->my_money_mod->getCount();
        $this->_format_page($page);
	    $this->assign('page_info', $page);
	    $this->assign('index', $index);//传递到风格里
        $this->display('user_money_list.html'); 
	    return;
	}


//增加用户资金   
 	function user_money_add()
    {
	   if($_POST)
	   {
	   $user_name= trim($_POST['user_name']);
	   $post_money= trim($_POST['post_money']);
	   $jia_or_jian= trim($_POST['jia_or_jian']);
	  // $time_edit= trim($_POST['time_edit']);
	   $log_text= trim($_POST['log_text']);	   
	   if(empty($user_name) or empty($post_money) or empty($jia_or_jian))
       {
	   		$this->show_warning('user_money_add_nizongdeshurudianshenmeba');
	   		return;
	   }
	   if (preg_match("/[^0.-9]/",$post_money))
       {
	   $this->show_warning('cuowu_nishurudebushishuzilei'); 
       return;
       }
$money_row=$this->my_money_mod->getrow("select * from ".DB_PREFIX."my_money where user_name='$user_name'");	
$user_ids=$money_row['user_id'];  
$my_money=$money_row['money'];
	   if(empty($user_ids))
       {
	   		$this->show_warning('user_money_add_cuowugaiyonghubucunzai');
	   		return;
	   }
	   if($jia_or_jian=="jia")
	   {
	   $money=$my_money+$post_money;
	   }
	   if($jia_or_jian=="jian")
	   {
	   if($my_money>=$post_money)
	   {	   
	   $money=$my_money-$post_money;
	   }
       else
	   {
	   		$this->show_warning('user_money_add_cuowugaiyonghudangqianyuebuzukouchu');
	        return;
	   }
	   } 
	   //写入LOG记录
	   $dq_time=date("Y-m-d-His",time());
	   
	   if($jia_or_jian=="jian")
	   {
	   $logs_array=array(
	   'user_id'=>$user_ids,
	   'user_name'=>$user_name,
	   'log_text'=>$log_text,
	   'leixing'=>30,
	   'add_time'=>time(),
	   'admin_name' =>$this->visitor->get('user_name'),
	   'order_sn'=>$dq_time,
	   'money_zs'=>"-".$post_money, 
	   'caozuo'=>50,
	   's_and_z'=>1,
	   );
	   }
	   else
	   {
	   $logs_array=array(
	   'user_id'=>$user_ids,
	   'user_name'=>$user_name,
	   'log_text'=>$log_text,
	   'leixing'=>30,
	   'add_time'=>time(),
	   'admin_name' =>$this->visitor->get('user_name'),
	   'order_sn'=>$dq_time,
	   'money_zs'=>$post_money, 
	   'caozuo'=>50,
	   's_and_z'=>1,
	   );
	   }
	   $this->my_moneylog_mod->add($logs_array);
	   //写入LOG记录
	   $money_array=array(
	   'money'=>$money,
	   );
	   $this->my_money_mod->edit('user_id='.$user_ids,$money_array);

	   		$this->show_message('user_money_add_zengjiayonghujinechenggong','返回列表','index.php?module=my_money&act=user_money_list');
	        return;
	   }
	   else
	   {
	   $user_id = isset($_GET['user_id']) ? trim($_GET['user_id']) : '';
	   $user_name = isset($_GET['user_name']) ? trim($_GET['user_name']) : '';
	   if(!empty($user_id))
       {
       $index=$this->my_money_mod->find('user_id='.$user_id);
	   }
	   $this->assign('index', $index);
       $this->display('user_money_add.html'); 
	   }
	   return;
	}


//查看所有增加减少资金log
 	function user_money_log()
    {
        $page = $this->_get_page();		
		$index=$this->my_moneylog_mod->find(array(
	        'conditions' => 'leixing=30 and caozuo=50',
            'limit' => $page['limit'],
			'order' => "id desc",
			'count' => true));
		$page['item_count'] = $this->my_moneylog_mod->getCount();
        $this->_format_page($page);
	    $this->assign('page_info', $page);
	    $this->assign('index', $index);//传递到风格里
        $this->display('user_money_log.html'); 
	   return;
	}

//查看收入
 	function logs_shouru()
    {
	   $this->show_warning('logs_kaifatishi');
       //$this->display('logs_shouru.html'); 
	   return;
	}
//查看支出
 	function logs_zhichu()
    {
	   $this->show_warning('logs_kaifatishi');
       //$this->display('logs_zhichu.html'); 
	   return;
	}
//查看转入
 	function logs_zhuanru()
    {
	   $this->show_warning('logs_kaifatishi');
       //$this->display('logs_zhuanru.html'); 
	   return;
	}
//查看转出
 	function logs_zhuanchu()
    {
	   $this->show_warning('logs_kaifatishi');
       //$this->display('logs_zhuanchu.html'); 
	   return;
	}
//查看充值
 	function logs_chongzhi()
    {
	   $this->show_warning('logs_kaifatishi');
       //$this->display('logs_chongzhi.html'); 
	   return;
	}
	
//查看所有审核数据
 	function tx_index_shenhe()
    {
        $page = $this->_get_page();		
		$index=$this->my_moneylog_mod->find(array(
	        'conditions' => 'leixing=40',
            'limit' => $page['limit'],
			'order' => "id desc",
			'count' => true));
		$page['item_count'] = $this->my_moneylog_mod->getCount();
        $this->_format_page($page);
	    $this->assign('page_info', $page);
	    $this->assign('index', $index);//传递到风格里
        $this->display('tx_index_shenhe.html'); 
	   return;
	}
//查看提现 未审核	
	function tx_wei_shenhe()//caozuo=60
    {
        $page = $this->_get_page();		
		$index=$this->my_moneylog_mod->find(array(
	        'conditions' => 'leixing=40 and caozuo=60',
            'limit' => $page['limit'],
			'order' => "id desc",
			'count' => true));
		$page['item_count'] = $this->my_moneylog_mod->getCount();
        $this->_format_page($page);
	    $this->assign('page_info', $page);
	    $this->assign('index', $index);//传递到风格里
        $this->display('tx_wei_shenhe.html'); 
	   return;
	}
//查看提现 已审核
	function tx_yi_shenhe()//caozuo=61
    {
        $page = $this->_get_page();		
		$index=$this->my_moneylog_mod->find(array(
	        'conditions' => 'leixing=40 and caozuo=61',
            'limit' => $page['limit'],
			'order' => "id desc",
			'count' => true));
		$page['item_count'] = $this->my_moneylog_mod->getCount();
        $this->_format_page($page);
	    $this->assign('page_info', $page);
	    $this->assign('index', $index);//传递到风格里
        $this->display('tx_yi_shenhe.html'); 
	   return;
	}
//提现搜索
	function tx_soso()
    {
	$soname=$_GET["soname"];
	$sotime=$_GET["sotime"];
	$endtime=$_GET["endtime"];

		$sotimes= strtotime("$sotime");
		$endtimes= strtotime("$endtime")+86399;//增加23小时59分59秒

		if(empty($soname) and empty($sotime) and empty($endtime))
        {
		$this->show_warning('user_money_add_nizongdeshurudianshenmeba');
	    return;
		}
		$page = $this->_get_page();	
		//三个都不为空
        if (isset($soname) and isset($sotime) and isset($endtime)) 
        { 
		$index=$this->my_moneylog_mod->find(array(
	        'conditions' => "leixing=40 and seller_name LIKE '%$soname%' and add_time>='$sotimes' and add_time<'$endtimes'",
            'limit' => $page['limit'],
			'order' => "id desc",
			'count' => true));
        }

	   	//开始时间 或 结束时间 为空，就是执行下面搜索单独用户			
	    if(empty($sotime) or empty($endtime))
        {
		$index=$this->my_moneylog_mod->find(array(
	        'conditions' => "leixing=40 and user_name LIKE '%$soname%'",
            'limit' => $page['limit'],
			'order' => "id desc",
			'count' => true));
		}
		//用户为空，就是搜索开始时间-结束时间
	    if(empty($soname))
        {
		$index=$this->my_moneylog_mod->find(array(
	        'conditions' => "leixing=40 and add_time>='$sotimes' and add_time<'$endtimes'",
            'limit' => $page['limit'],
			'order' => "id desc",
			'count' => true));
		}	

		
		$page['item_count'] = $this->my_moneylog_mod->getCount();
        $this->_format_page($page);
	    $this->assign('page_info', $page);
	    $this->assign('index', $index);//传递到风格里
        $this->display('tx_index_shenhe.html'); 
	   return;
	}
	
	
//密保搜索
	function mb_soso()//默认显示
    {
	$sombsn=$_GET["sombsn"];
	$sotime=$_GET["sotime"];
	$endtime=$_GET["endtime"];
	$ztai=$_GET["ztai"];

		$sotimes= strtotime("$sotime");
		$endtimes= strtotime("$endtime")+86399;// 增加23小时59分59秒
		if(empty($sombsn) and empty($sotime) and empty($endtime))
        {
		$this->show_warning('user_money_add_nizongdeshurudianshenmeba');
	    return;
		}		
		$page = $this->_get_page();	
		//三个都不为空
        if (isset($sombsn) and isset($sotime) and isset($endtime)) 
        { 
		$index=$this->my_mibao_mod->find(array(
	    'conditions' => "mibao_sn LIKE '%$sombsn%' and bd_time>='$sotimes' and bd_time<'$endtimes' and ztai='$ztai'",
        'limit' => $page['limit'],
		'count' => true));
        }
	   	//开始时间 或 结束时间 为空，就是搜索单独用户			
	    if(empty($sotime) or empty($endtime))
        {
		if(empty($sotimes))  $sotimes=1;
	    if(empty($endtimes)) $endtimes=1300000000;	
		$index=$this->my_mibao_mod->find(array(
	        'conditions' => "bd_time>='$sotimes' and bd_time<'$endtimes' and ztai='$ztai'",
            'limit' => $page['limit'],
			'count' => true));
		}
		//用户为空，就是搜索开始时间-结束时间
	    else
        {
		$index=$this->my_mibao_mod->find(array(
	        'conditions' => "mibao_sn LIKE '%$sombsn%' and ztai='$ztai'",
            'limit' => $page['limit'],
			'count' => true));
		}	

		$page['item_count'] = $this->my_moneylog_mod->getCount('user_name='.$soname);
        $this->_format_page($page);
	    $this->assign('page_info', $page);
	    $this->assign('index', $index);
		if(empty($ztai)) $this->display('mibao_xinka.html'); 
		if($ztai==1)$this->display('mibao_zhengchang.html'); 
		if($ztai==2)$this->display('mibao_zanting.html'); 
		if($ztai==3)$this->display('mibao_guoqi.html'); 
	    return;

	}
//点击切换caozuo 60转61
 	function caozuo_yes()
    {
	$id=$_GET['id'];
	$caozuo=$_GET['caozuo'];
	if($caozuo<>60)
    {
		$this->show_warning('feifacanshu');
	    return;
	}
	if(empty($id))
    {
		$this->show_warning('feifacanshu');
	    return;
	}
	$this->my_moneylog_mod->edit('id='.$id,'caozuo=61');
	$lailu =$_SERVER['HTTP_REFERER'];	
header("Location: $lailu");
	   return;
	}
//点击切换caozuo 61转60	
 	function caozuo_no()
    {
	$id=$_GET['id'];
	$caozuo=$_GET['caozuo'];
	if($caozuo<>61)
    {
		$this->show_warning('feifacanshu');
	    return;
	}
	if(empty($id))
    {
		$this->show_warning('feifacanshu');
	    return;
	}
	$this->my_moneylog_mod->edit('id='.$id,'caozuo=60');	
	$lailu =$_SERVER['HTTP_REFERER'];	
header("Location: $lailu");
	   return;
	}
//审核操作 编辑LOGS及扣除相应提现金额	
	function tx_shenhe_user()
    {
	$log_id=$_GET['log_id'];
	$user_id=$_GET['user_id'];
	$order_id=trim($_POST['order_id']);
	$log_text=trim($_POST['log_text']);
	$caozuo=trim($_POST['caozuo']);
	$money_djs=trim($_POST['money_djs']);
	$money_chu=trim($_POST['money_chu']);
	$admin_time = time();
	if($_POST)
	{
	$edit_moneylog=array(
			'order_id'=>$order_id,
			'log_text'=>$log_text,
			'admin_time'=>$admin_time,		
			'caozuo'=>$caozuo,																	
    );
	$this->my_moneylog_mod->edit('id='.$log_id,$edit_moneylog);

if($money_chu=="YES")
{
$money_row=$this->my_money_mod->getrow("select money_dj,jifen from ".DB_PREFIX."my_money where user_id='$user_id'");
$row_money_dj=$money_row['money_dj'];
$row_jifen=$money_row['jifen'];

if($row_money_dj<$money_djs)
{
		$this->show_warning('feifacanshu');
	    return;
}

$new_money_dj=$row_money_dj-$money_djs;
	$new_money=array(
			'money_dj'=>$new_money_dj,																	
    );
	$edit_myjifen=array(
		'jifen'=>$row_jifen-$money_djs,																	
	);
	$this->my_money_mod->edit('user_id='.$user_id,$new_money);//读取所有数据库
    $this->my_money_mod->edit('user_id='.$user_id,$edit_myjifen);
}
    $this->show_message('shenhechenggong',
    'caozuoshiwu_fanhuchongxinbianji', 'index.php?module=my_money&act=tx_shenhe_user&user_id='.$user_id.'&log_id='.$log_id,
    'fanhuiliebiao',    'index.php?module=my_money&act=tx_index_shenhe');
	}
	else
	{
	if(empty($log_id) or empty($user_id))
    {
		$this->show_warning('feifacanshu');
	    return;
	}
	    $logs_data=$this->my_moneylog_mod->find('id='.$log_id);
	    $user_data=$this->my_money_mod->find('user_id='.$user_id);
		$this->assign('log', $logs_data);
		$this->assign('user', $user_data);
        $this->display('tx_shenhe_user.html');
	    return;
	}
	}
//查看用户卖出、转入、充值
	function logs_user_shouru()
    {	
	$user_name=$_GET["user_name"];
	$sotime=$_GET["sotime"];
	$endtime=$_GET["endtime"];
	
	if (!empty($sotime) or !empty($endtime)) 
    {
	$soso="xiaohei"; 
	}
	
	if(empty($user_name))
    {
		$this->show_warning('feifacanshu');
	    return;
	}
        $page = $this->_get_page();	
	   
	   
	    if (isset($user_name) and isset($sotime) and isset($endtime)) 
        { 
		$sotimes= strtotime("$sotime");
		$endtimes= strtotime("$endtime")+86399;// 86399增加23小时59分59秒秒
	    $index=$this->my_moneylog_mod->find(array(
	    'conditions' => "user_name='$user_name' and add_time>='$sotimes' and add_time<'$endtimes' and s_and_z=1",
        'limit' => $page['limit'],
	    'order' => "money_zs desc",
	    'count' => true));
        }   
	   
        if(empty($sotime) or empty($endtime))
        {
		$sotimes= strtotime("$sotime");
		$endtimes= strtotime("$endtime");
		if(empty($sotimes))  $sotimes=1;
	    if(empty($endtimes)) $endtimes=1300000000;	
	    $index=$this->my_moneylog_mod->find(array(
	    'conditions' => "user_name='$user_name' and add_time>='$sotimes' and add_time<'$endtimes' and s_and_z=1",
        'limit' => $page['limit'],
	    'order' => "money_zs desc",
	    'count' => true));
		}

/*
	   $index=$this->my_moneylog_mod->find(array(
	   'conditions' => "user_name='$user_name' and s_and_z=1",
       'limit' => $page['limit'],
	   'order' => "money_zs desc",
	   'count' => true));
*/
	   $page['item_count'] = $this->my_moneylog_mod->getCount();
       $this->_format_page($page);
	   $this->assign('page_info', $page);
	   $this->assign('soso', $soso);
	   $this->assign('index', $index);
       $this->display('logs_user_shouru.html'); 
	   return;
    }


//批量生成 密保卡	
function mibao_sn_pi()
{
$snprefix=$_GET['snprefix'];
$ctype=$_GET['ctype'];
$mnum=$_GET['mnum'];
$pwdgr=$_GET['pwdgr'];
$pwdlen=$_GET['pwdlen'];

if(!empty($mnum))//检测是否提交
{
$begin=microtime(true);//查询 记时开始

$sql="select id from ".DB_PREFIX."my_mibao order by id desc LIMIT 1";
$res=mysql_query($sql);
$date=mysql_fetch_assoc($res);  
$mibaoid=$date['id'];
		if(empty($mibaoid))
		{
		$mibaoid=0;
        }
		$startid=$mibaoid+1001;
	
		$startid=$startid++;
	    $endid = $startid+$mnum;
		$add_time = time();

	for(;$startid<$endid;$startid++)
	{
		$cardid = $snprefix.$startid.'-';
		for($p=0;$p<$pwdgr;$p++)
		{
			for($i=0; $i < $pwdlen; $i++)
			{
				if($ctype==1)
				{
					$c = mt_rand(49,57); 
					$c = chr($c);
				}
				else
				{
					$c = mt_rand(65,90);
					if($c==79)//=O
					{
					$c = 'M';
					}
					else
					{
					$c = chr($c);
					}
				
				}
				$cardid .= $c;
			}
			if($p<$pwdgr-1)
			{
				$cardid .= '-';
			}
		}
			$mibao_sn_add=array(
			'mibao_sn'   =>$cardid,
			'add_time' =>$add_time,	
			'admin_name' =>$this->visitor->get('user_name'),
  'A1' => rand(100,999),
  'B1' => rand(100,999),
  'C1' => rand(100,999),
  'D1' => rand(100,999),
  'E1' => rand(100,999),
  'F1' => rand(100,999),
  'G1' => rand(100,999),
  'H1' => rand(100,999),
  
  'A2' => rand(100,999),
  'B2' => rand(100,999),
  'C2' => rand(100,999),
  'D2' => rand(100,999),
  'E2' => rand(100,999),
  'F2' => rand(100,999),
  'G2' => rand(100,999),
  'H2' => rand(100,999),
  
  'A3' => rand(100,999),
  'B3' => rand(100,999),
  'C3' => rand(100,999),
  'D3' => rand(100,999),
  'E3' => rand(100,999),
  'F3' => rand(100,999),
  'G3' => rand(100,999),
  'H3' => rand(100,999),
  
  'A4' => rand(100,999),
  'B4' => rand(100,999),
  'C4' => rand(100,999),
  'D4' => rand(100,999),
  'E4' => rand(100,999),
  'F4' => rand(100,999),
  'G4' => rand(100,999),
  'H4' => rand(100,999),
  
  'A5' => rand(100,999),
  'B5' => rand(100,999),
  'C5' => rand(100,999),
  'D5' => rand(100,999),
  'E5' => rand(100,999),
  'F5' => rand(100,999),
  'G5' => rand(100,999),
  'H5' => rand(100,999),
  
  'A6' => rand(100,999),
  'B6' => rand(100,999),
  'C6' => rand(100,999),
  'D6' => rand(100,999),
  'E6' => rand(100,999),
  'F6' => rand(100,999),
  'G6' => rand(100,999),
  'H6' => rand(100,999),
  
  'A7' => rand(100,999),
  'B7' => rand(100,999),
  'C7' => rand(100,999),
  'D7' => rand(100,999),
  'E7' => rand(100,999),
  'F7' => rand(100,999),
  'G7' => rand(100,999),
  'H7' => rand(100,999),
  
  'A8' => rand(100,999),
  'B8' => rand(100,999),
  'C8' => rand(100,999),
  'D8' => rand(100,999),
  'E8' => rand(100,999),
  'F8' => rand(100,999),
  'G8' => rand(100,999),
  'H8' => rand(100,999),
  
  'A9' => rand(100,999),
  'B9' => rand(100,999),
  'C9' => rand(100,999),
  'D9' => rand(100,999),
  'E9' => rand(100,999),
  'F9' => rand(100,999),
  'G9' => rand(100,999),
  'H9' => rand(100,999),																				
  );
    	$this->my_mibao_mod->add($mibao_sn_add);
		echo Lang::get('chenggongshengchengdongtaimibaoka').$cardid."<br/>";
		
				echo "&nbsp;&nbsp;&nbsp;A&nbsp;&nbsp;&nbsp;";
				echo "B&nbsp;&nbsp;&nbsp;";
				echo "C&nbsp;&nbsp;&nbsp;";
				echo "D&nbsp;&nbsp;&nbsp;";
				echo "E&nbsp;&nbsp;&nbsp;";
				echo "F&nbsp;&nbsp;&nbsp;";
				echo "G&nbsp;&nbsp;&nbsp;";
				echo "H     ";
				echo "<br>";
				
				echo "1:".$mibao_sn_add['A1'];echo " ";
				echo $mibao_sn_add['B1'];echo " ";
				echo $mibao_sn_add['C1'];echo " ";
				echo $mibao_sn_add['D1'];echo " ";
				echo $mibao_sn_add['E1'];echo " ";
				echo $mibao_sn_add['F1'];echo " ";
				echo $mibao_sn_add['G1'];echo " ";
				echo $mibao_sn_add['H1'];echo "<br>";
			
				echo "2:".$mibao_sn_add['A2'];echo " ";
				echo $mibao_sn_add['B2'];echo " ";
				echo $mibao_sn_add['C2'];echo " ";
				echo $mibao_sn_add['D2'];echo " ";
				echo $mibao_sn_add['E2'];echo " ";
				echo $mibao_sn_add['F2'];echo " ";
				echo $mibao_sn_add['G2'];echo " ";
				echo $mibao_sn_add['H2'];echo "<br>";
			

				echo "3:".$mibao_sn_add['A3'];echo " ";
				echo $mibao_sn_add['B3'];echo " ";
				echo $mibao_sn_add['C3'];echo " ";
				echo $mibao_sn_add['D3'];echo " ";
				echo $mibao_sn_add['E3'];echo " ";
				echo $mibao_sn_add['F3'];echo " ";
				echo $mibao_sn_add['G3'];echo " ";
				echo $mibao_sn_add['H3'];echo "<br>";
				
				echo "4:".$mibao_sn_add['A4'];echo " ";
				echo $mibao_sn_add['B4'];echo " ";
				echo $mibao_sn_add['C4'];echo " ";
				echo $mibao_sn_add['D4'];echo " ";
				echo $mibao_sn_add['E4'];echo " ";
				echo $mibao_sn_add['F4'];echo " ";
				echo $mibao_sn_add['G4'];echo " ";
				echo $mibao_sn_add['H4'];echo "<br>";
				
				echo "5:".$mibao_sn_add['A5'];echo " ";
				echo $mibao_sn_add['B5'];echo " ";
				echo $mibao_sn_add['C5'];echo " ";
				echo $mibao_sn_add['D5'];echo " ";
				echo $mibao_sn_add['E5'];echo " ";
				echo $mibao_sn_add['F5'];echo " ";
				echo $mibao_sn_add['G5'];echo " ";
				echo $mibao_sn_add['H5'];echo "<br>";
				
				echo "6:".$mibao_sn_add['A6'];echo " ";
				echo $mibao_sn_add['B6'];echo " ";
				echo $mibao_sn_add['C6'];echo " ";
				echo $mibao_sn_add['D6'];echo " ";
				echo $mibao_sn_add['E6'];echo " ";
				echo $mibao_sn_add['F6'];echo " ";
				echo $mibao_sn_add['G6'];echo " ";
				echo $mibao_sn_add['H6'];echo "<br>";
			
				echo "7:".$mibao_sn_add['A7'];echo " ";
				echo $mibao_sn_add['B7'];echo " ";
				echo $mibao_sn_add['C7'];echo " ";
				echo $mibao_sn_add['D7'];echo " ";
				echo $mibao_sn_add['E7'];echo " ";
				echo $mibao_sn_add['F7'];echo " ";
				echo $mibao_sn_add['G7'];echo " ";
				echo $mibao_sn_add['H7'];echo "<br>";
			
				echo "8:".$mibao_sn_add['A8'];echo " ";
				echo $mibao_sn_add['B8'];echo " ";
				echo $mibao_sn_add['C8'];echo " ";
				echo $mibao_sn_add['D8'];echo " ";
				echo $mibao_sn_add['E8'];echo " ";
				echo $mibao_sn_add['F8'];echo " ";
				echo $mibao_sn_add['G8'];echo " ";
				echo $mibao_sn_add['H8'];echo "<br>";
				
				echo "9:".$mibao_sn_add['A9'];echo " ";
				echo $mibao_sn_add['B9'];echo " ";
				echo $mibao_sn_add['C9'];echo " ";
				echo $mibao_sn_add['D9'];echo " ";
				echo $mibao_sn_add['E9'];echo " ";
				echo $mibao_sn_add['F9'];echo " ";
				echo $mibao_sn_add['G9'];echo " ";
				echo $mibao_sn_add['H9'];echo "<br>";
				
				echo "<br>";

		
	}

$stop=microtime(true); //获取程序执行结束的时间
$runtime=round(($stop-$begin),4);


	echo Lang::get('bencigongchenggongshengcheng').$mnum.Lang::get('shengcheng_zhang')."&nbsp;&nbsp;&nbsp;&nbsp;耗时".$runtime."&nbsp;s<br/><br/>";
	echo Lang::get('shengcheng_xitong')."<br/>";	
	echo Lang::get('shengcheng_byxiaohei');








}
else
{
		$this->display('mibao_shengcheng.index.html'); 
	    return;	
}
}


//批量生成 充值卡	
function card_add_pi()
{
$snprefix=$_GET['snprefix'];
$ctype=$_GET['ctype'];
$mnum=$_GET['mnum'];
$pwdgr=$_GET['pwdgr'];
$pwdlen=$_GET['pwdlen'];

$m_pwdgr=$_GET['m_pwdgr'];
$m_pwdlen=$_GET['m_pwdlen'];


$money=$_GET['money'];//卡面值

$guoqi_times=$_GET['guoqi_time'];//过期时间
$guoqi_time= strtotime("$guoqi_times");//转换过期时间格式

if(!empty($mnum))//检测是否提交
{

$sql="select id from ".DB_PREFIX."my_card order by id desc LIMIT 1";
$res=mysql_query($sql);
$date=mysql_fetch_assoc($res);  
$ids=$date['id'];
		if(empty($ids))
		{
		$ids=0;
        }
		$startid=$ids+1001;

	
		$startid=$startid++;
	    $endid = $startid+$mnum;
		$add_time = time();

	for(;$startid<$endid;$startid++)
	{
	$card_pass=$startid;//密码根据ID 4位数开始
	$cardid = $snprefix.$startid.'-';
		for($p=0;$p<$pwdgr;$p++)
		{
			for($i=0; $i < $pwdlen; $i++)
			{
				if($ctype==1)//使用数字
				{
					$c = mt_rand(49,57); 
					$c = chr($c);
				}
				else//使用数字
				{
					$c = mt_rand(65,90);
					if($c==79)//=O就换成M
					{
					$c = 'M';
					}
					else
					{
					$c = chr($c);
					}
				
				}
				$cardid .= $c;
			}
			if($p<$pwdgr-1)//最后一轮加‘-’
			{
				$cardid .= '-';
			}
	
		}
		//密码部分开始

			for($ii=0; $ii < $m_pwdlen; $ii++)
			{

					$cc = mt_rand(49,57); 
					$cc = chr($cc);


				$card_pass .= $cc;
			}



			$card_add=array(
			'card_sn' =>$cardid,
			'card_pass' =>$card_pass,
			'add_time' =>$add_time,
			'admin_name' =>$this->visitor->get('user_name'),
			'guoqi_time' =>$guoqi_time,
			'money' =>$money,
			);
    	$this->my_card_mod->add($card_add);
		echo "卡号：".$cardid."         密码：".$card_pass."         面值：".$money."元         过期时间：".$guoqi_times."<br/>";
	}
	echo "<br/>本次共生成充值卡密:".$mnum.Lang::get('shengcheng_zhang')."<br/><br/>";
}
else
{
		$this->display('card_shengcheng.index.html'); 
	    return;	
}
}

//已绑定用户和密保卡1
function mibao_zhengchang()
    {
	$xz_time = time();
    $page = $this->_get_page();
	$index=$this->my_mibao_mod->find(array(
	        'conditions' => "dq_time>$xz_time and ztai=1",//条件 如：where
            'limit' => $page['limit'],
			'count' => true,
        ));	
	$page['item_count'] = $this->my_mibao_mod->getCount();
    $this->_format_page($page);
	$this->assign('page_info', $page);
	$this->assign('index', $index);//传递到风格里
	$this->display('mibao_zhengchang.html'); 
	return;
	}
//未到期 被暂停2
function mibao_zanting()
    {
	$xz_time = time();
    $page = $this->_get_page();
	$index=$this->my_mibao_mod->find(array(
	        'conditions' =>"dq_time>$xz_time and ztai=2",//这里使用了双引号
            'limit' => $page['limit'],
			'count' => true,
        ));	
	$page['item_count'] = $this->my_mibao_mod->getCount();
    $this->_format_page($page);
	$this->assign('page_info', $page);
	$this->assign('index', $index);
	$this->display('mibao_zanting.html'); 
	return;
	}
	
	
	
//已到期 被暂停3
function mibao_guoqi()
    {
	$xz_time = time();
    $page = $this->_get_page();
	$index=$this->my_mibao_mod->find(array(
	        'conditions' => "dq_time<$xz_time and ztai=3",//这里使用了双引号
            'limit' => $page['limit'],
			'count' => true,
        ));	
	$page['item_count'] = $this->my_mibao_mod->getCount();
    $this->_format_page($page);
	$this->assign('page_info', $page);
	$this->assign('index', $index);
	$this->display('mibao_guoqi.html'); 
	return;
	}	
//密保新卡0
function mibao_xinka()
    {
    $page = $this->_get_page();
	$index=$this->my_mibao_mod->find(array(
            'conditions' => 'user_id=0 and ztai=0' ,//条件 如：where
            'limit' => $page['limit'],
			'count' => true,
        ));	
	$page['item_count'] = $this->my_mibao_mod->getCount();
    $this->_format_page($page);
	$this->assign('page_info', $page);
	$this->assign('index', $index);
	$this->display('mibao_xinka.html'); 
	return;
	}
//编辑已绑定mibao_edit_mibao
function mibao_edit_mibao()
{
    $id = isset($_GET['id']) ? trim($_GET['id']) : '';

    if (!$id)
    {
            $this->show_warning('feifacanshu');
            return;
    }
	if($_POST)//检测是否提交
	{
	$time_edit = trim($_POST['time_edit']);
	$dq_time = trim($_POST['dq_time']);
	$yes_sn_edit = trim($_POST['yes_sn_edit']);
		
	if($time_edit=="YES")
	{
	$dq_time = strtotime("$dq_time");
	if($dq_time<time())
	{
	$ztai=3;
	}
	else
	{
	$ztai=1;
	}
	$mibao_time=array(
	'dq_time'=>$dq_time,
	'ztai'=>$ztai,
	);
	$this->my_mibao_mod->edit($id,$mibao_time);	
	}
	
	
	if($yes_sn_edit=="YES")
	{
  $A1= trim($_POST['A1']);
  $B1= trim($_POST['B1']);
  $C1= trim($_POST['C1']);
  $D1= trim($_POST['D1']);
  $E1= trim($_POST['E1']);
  $F1= trim($_POST['F1']);
  $G1= trim($_POST['G1']);
  $H1= trim($_POST['H1']);

  $A2= trim($_POST['A2']);
  $B2= trim($_POST['B2']);
  $C2= trim($_POST['C2']);
  $D2= trim($_POST['D2']);
  $E2= trim($_POST['E2']);
  $F2= trim($_POST['F2']);
  $G2= trim($_POST['G2']);
  $H2= trim($_POST['H2']);

  $A3= trim($_POST['A3']);
  $B3= trim($_POST['B3']);
  $C3= trim($_POST['C3']);
  $D3= trim($_POST['D3']);
  $E3= trim($_POST['E3']);
  $F3= trim($_POST['F3']);
  $G3= trim($_POST['G3']);
  $H3= trim($_POST['H3']);

  $A4= trim($_POST['A4']);
  $B4= trim($_POST['B4']);
  $C4= trim($_POST['C4']);
  $D4= trim($_POST['D4']);
  $E4= trim($_POST['E4']);
  $F4= trim($_POST['F4']);
  $G4= trim($_POST['G4']);
  $H4= trim($_POST['H4']);

  $A5= trim($_POST['A5']);
  $B5= trim($_POST['B5']);
  $C5= trim($_POST['C5']);
  $D5= trim($_POST['D5']);
  $E5= trim($_POST['E5']);
  $F5= trim($_POST['F5']);
  $G5= trim($_POST['G5']);
  $H5= trim($_POST['H5']);

  $A6= trim($_POST['A6']);
  $B6= trim($_POST['B6']);
  $C6= trim($_POST['C6']);
  $D6= trim($_POST['D6']);
  $E6= trim($_POST['E6']);
  $F6= trim($_POST['F6']);
  $G6= trim($_POST['G6']);
  $H6= trim($_POST['H6']);

  $A7= trim($_POST['A7']);
  $B7= trim($_POST['B7']);
  $C7= trim($_POST['C7']);
  $D7= trim($_POST['D7']);
  $E7= trim($_POST['E7']);
  $F7= trim($_POST['F7']);
  $G7= trim($_POST['G7']);
  $H7= trim($_POST['H7']);

  $A8= trim($_POST['A8']);
  $B8= trim($_POST['B8']);
  $C8= trim($_POST['C8']);
  $D8= trim($_POST['D8']);
  $E8= trim($_POST['E8']);
  $F8= trim($_POST['F8']);
  $G8= trim($_POST['G8']);
  $H8= trim($_POST['H8']);

  $A9= trim($_POST['A9']);
  $B9= trim($_POST['B9']);
  $C9= trim($_POST['C9']);
  $D9= trim($_POST['D9']);
  $E9= trim($_POST['E9']);
  $F9= trim($_POST['F9']);
  $G9= trim($_POST['G9']);
  $H9= trim($_POST['H9']);

  $mibao_shuzi=array(
  'A1'=>$A1,
  'B1'=>$B1,
  'C1'=>$C1,
  'D1'=>$D1,
  'E1'=>$E1,
  'F1'=>$F1,
  'G1'=>$G1,
  'H1'=>$H1,
  
  'A2'=>$A2,
  'B2'=>$B2,
  'C2'=>$C2,
  'D2'=>$D2,
  'E2'=>$E2,
  'F2'=>$F2,
  'G2'=>$G2,
  'H2'=>$H2,
  
  'A3'=>$A3,
  'B3'=>$B3,
  'C3'=>$C3,
  'D3'=>$D3,
  'E3'=>$E3,
  'F3'=>$F3,
  'G3'=>$G3,
  'H3'=>$H3,
  
  'A4'=>$A4,
  'B4'=>$B4,
  'C4'=>$C4,
  'D4'=>$D4,
  'E4'=>$E4,
  'F4'=>$F4,
  'G4'=>$G4,
  'H4'=>$H4,
  
  'A5'=>$A5,
  'B5'=>$B5,
  'C5'=>$C5,
  'D5'=>$D5,
  'E5'=>$E5,
  'F5'=>$F5,
  'G5'=>$G5,
  'H5'=>$H5,
  
  'A6'=>$A6,
  'B6'=>$B6,
  'C6'=>$C6,
  'D6'=>$D6,
  'E6'=>$E6,
  'F6'=>$F6,
  'G6'=>$G6,
  'H6'=>$H6,
  
  'A7'=>$A7,
  'B7'=>$B7,
  'C7'=>$C7,
  'D7'=>$D7,
  'E7'=>$E7,
  'F7'=>$F7,
  'G7'=>$G7,
  'H7'=>$H7,
  
  'A8'=>$A8,
  'B8'=>$B8,
  'C8'=>$C8,
  'D8'=>$D8,
  'E8'=>$E8,
  'F8'=>$F8,
  'G8'=>$G8,
  'H8'=>$H8,
  
  'A9'=>$A9,
  'B9'=>$B9,
  'C9'=>$C9,
  'D9'=>$D9,
  'E9'=>$E9,
  'F9'=>$F9,
  'G9'=>$G9,
  'H9'=>$H9,																
    );
	$this->my_mibao_mod->edit($id,$mibao_shuzi);
	}
	$this->show_message('mibao_edit_mibao_bianjichenggong',
    'mibao_edit_mibao_fanhumibaoliebiao','index.php?module=my_money&act=mibao_zhengchang'
    );
	return;
	}
    else
    {
    $index=$this->my_mibao_mod->find($id);//读取所有数据库
    $this->assign('index', $index);//传递到风格里
    $this->display('mibao_edit_mibao.html'); 
    return;
    }	
}
//设置暂停	mibao_zantings
function mibao_zantings()
{
    $id = isset($_GET['id']) ? trim($_GET['id']) : '';
	$pi = isset($_GET['pi']) ? trim($_GET['pi']) : '';
    if (!$id)
    {
            $this->show_warning('feifacanshu');
            return;
    }
	$ztai=array(
	'ztai'=>2,
	);
    $ids = explode(',', $id);
    $this->my_mibao_mod->edit($ids,$ztai);
	if($pi=="pi")
	{
    $this->show_message('mibao_zantings_piliangcaozuozantingshiyong');
    }
	else
	{
    $this->show_message('mibao_zantings_genggaizantingshiyong');
	}
	return;
}
//恢复使用mibao_huifu
function mibao_huifu()
{
    $id = isset($_GET['id']) ? trim($_GET['id']) : '';
    if (!$id)
    {
            $this->show_warning('feifacanshu');
            return;
    }
	
$mibao_row=$this->my_mibao_mod->getrow("select dq_time from ".DB_PREFIX."my_mibao where id='$id'");
if($mibao_row['dq_time'] >time())
{
	$ztai=array(
	'ztai'=>1,
	);
}
else
{
	$ztai=array(
	'ztai'=>1,
	'dq_time'=>time()+31536000,
	);
}	
    $this->my_mibao_mod->edit($id,$ztai);
    $this->show_message('mibao_huifu_huifuzhengchangshiyong');
	return;
}
//批量删除新密保卡mibao_drop_pi
function mibao_drop_pi()
{
        $id = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$id)
        {
            $this->show_warning('feifacanshu');
            return;
        }
        
        $ids = explode(',', $id);
       
        $this->my_mibao_mod->drop($ids);
		
        $this->show_message('mibao_drop_pi_piliangshanchumibaokachenggong');

        return;
    }		

    function mibao_edit_xinka()
    {
	$id = isset($_GET['id']) ? trim($_GET['id']) : '';
    if (!$id)
    {
            $this->show_warning('feifacanshu');
            return;
    }
	if($_POST)//检测是否提交
	{	
  $A1= trim($_POST['A1']);
  $B1= trim($_POST['B1']);
  $C1= trim($_POST['C1']);
  $D1= trim($_POST['D1']);
  $E1= trim($_POST['E1']);
  $F1= trim($_POST['F1']);
  $G1= trim($_POST['G1']);
  $H1= trim($_POST['H1']);

  $A2= trim($_POST['A2']);
  $B2= trim($_POST['B2']);
  $C2= trim($_POST['C2']);
  $D2= trim($_POST['D2']);
  $E2= trim($_POST['E2']);
  $F2= trim($_POST['F2']);
  $G2= trim($_POST['G2']);
  $H2= trim($_POST['H2']);

  $A3= trim($_POST['A3']);
  $B3= trim($_POST['B3']);
  $C3= trim($_POST['C3']);
  $D3= trim($_POST['D3']);
  $E3= trim($_POST['E3']);
  $F3= trim($_POST['F3']);
  $G3= trim($_POST['G3']);
  $H3= trim($_POST['H3']);

  $A4= trim($_POST['A4']);
  $B4= trim($_POST['B4']);
  $C4= trim($_POST['C4']);
  $D4= trim($_POST['D4']);
  $E4= trim($_POST['E4']);
  $F4= trim($_POST['F4']);
  $G4= trim($_POST['G4']);
  $H4= trim($_POST['H4']);

  $A5= trim($_POST['A5']);
  $B5= trim($_POST['B5']);
  $C5= trim($_POST['C5']);
  $D5= trim($_POST['D5']);
  $E5= trim($_POST['E5']);
  $F5= trim($_POST['F5']);
  $G5= trim($_POST['G5']);
  $H5= trim($_POST['H5']);

  $A6= trim($_POST['A6']);
  $B6= trim($_POST['B6']);
  $C6= trim($_POST['C6']);
  $D6= trim($_POST['D6']);
  $E6= trim($_POST['E6']);
  $F6= trim($_POST['F6']);
  $G6= trim($_POST['G6']);
  $H6= trim($_POST['H6']);

  $A7= trim($_POST['A7']);
  $B7= trim($_POST['B7']);
  $C7= trim($_POST['C7']);
  $D7= trim($_POST['D7']);
  $E7= trim($_POST['E7']);
  $F7= trim($_POST['F7']);
  $G7= trim($_POST['G7']);
  $H7= trim($_POST['H7']);

  $A8= trim($_POST['A8']);
  $B8= trim($_POST['B8']);
  $C8= trim($_POST['C8']);
  $D8= trim($_POST['D8']);
  $E8= trim($_POST['E8']);
  $F8= trim($_POST['F8']);
  $G8= trim($_POST['G8']);
  $H8= trim($_POST['H8']);

  $A9= trim($_POST['A9']);
  $B9= trim($_POST['B9']);
  $C9= trim($_POST['C9']);
  $D9= trim($_POST['D9']);
  $E9= trim($_POST['E9']);
  $F9= trim($_POST['F9']);
  $G9= trim($_POST['G9']);
  $H9= trim($_POST['H9']);

  $edit_xinka=array(
  'A1'=>$A1,
  'B1'=>$B1,
  'C1'=>$C1,
  'D1'=>$D1,
  'E1'=>$E1,
  'F1'=>$F1,
  'G1'=>$G1,
  'H1'=>$H1,
  
  'A2'=>$A2,
  'B2'=>$B2,
  'C2'=>$C2,
  'D2'=>$D2,
  'E2'=>$E2,
  'F2'=>$F2,
  'G2'=>$G2,
  'H2'=>$H2,
  
  'A3'=>$A3,
  'B3'=>$B3,
  'C3'=>$C3,
  'D3'=>$D3,
  'E3'=>$E3,
  'F3'=>$F3,
  'G3'=>$G3,
  'H3'=>$H3,
  
  'A4'=>$A4,
  'B4'=>$B4,
  'C4'=>$C4,
  'D4'=>$D4,
  'E4'=>$E4,
  'F4'=>$F4,
  'G4'=>$G4,
  'H4'=>$H4,
  
  'A5'=>$A5,
  'B5'=>$B5,
  'C5'=>$C5,
  'D5'=>$D5,
  'E5'=>$E5,
  'F5'=>$F5,
  'G5'=>$G5,
  'H5'=>$H5,
  
  'A6'=>$A6,
  'B6'=>$B6,
  'C6'=>$C6,
  'D6'=>$D6,
  'E6'=>$E6,
  'F6'=>$F6,
  'G6'=>$G6,
  'H6'=>$H6,
  
  'A7'=>$A7,
  'B7'=>$B7,
  'C7'=>$C7,
  'D7'=>$D7,
  'E7'=>$E7,
  'F7'=>$F7,
  'G7'=>$G7,
  'H7'=>$H7,
  
  'A8'=>$A8,
  'B8'=>$B8,
  'C8'=>$C8,
  'D8'=>$D8,
  'E8'=>$E8,
  'F8'=>$F8,
  'G8'=>$G8,
  'H8'=>$H8,
  
  'A9'=>$A9,
  'B9'=>$B9,
  'C9'=>$C9,
  'D9'=>$D9,
  'E9'=>$E9,
  'F9'=>$F9,
  'G9'=>$G9,
  'H9'=>$H9,																
    );
  $this->my_mibao_mod->edit($id,$edit_xinka);
 
  $this->show_message('mibao_edit_xinka_bianjixinmibaokachenggong',
  'mibao_edit_xinka_fanhuxinkaliebiao','index.php?module=my_money&act=mibao_xinka',
  'caozuoshiwu_fanhuchongxinbianji','index.php?module=my_money&act=mibao_edit_xinka&id='.$id
  );
  return;  
  }
  else
  {
  $index=$this->my_mibao_mod->find($id);//读取所有数据库
  $this->assign('index', $index);//传递到风格里
  $this->display('mibao_edit_xinka.html'); 
  return;
  }
}

//绑定新用户mibao_bangding

    function mibao_bangding()
    {
	$id = isset($_GET['id']) ? trim($_GET['id']) : '';
    if (!$id)
    {
            $this->show_warning('feifacanshu');
            return;
    }
	if($_POST)//检测是否提交
	{
	$mibao_sn = trim($_POST['mibao_sn']);
	$user_name = trim($_POST['user_name']);
	$time_edit = trim($_POST['time_edit']);

	if(empty($user_name))
    {
		$this->show_warning('mibao_bangding_bangdingyonghumingbunengweikong');
	    return;
	}
    $money_row=$this->my_money_mod->getrow("select user_id,mibao_id from ".DB_PREFIX."my_money where user_name='$user_name'");
    if($money_row['mibao_id'] <>0)
    {
        $this->show_warning('mibao_bangding_gaiyonghuyijingbangdinglemibao');
        return;
    }

	if($time_edit=="YES")
	{
	$dq_time = strtotime("$dq_time");
	}
	else
	{
	$dq_time = time()+63072000;
	}

	$bd_mibao=array(
	'user_id'=>$money_row['user_id'],
	'user_name'=>$user_name,
	'bd_time'=>time(),
	'dq_time'=>$dq_time,
	'ztai'=>1, 
	);
	$bd_money=array(
	'mibao_id'=>$id,
	'mibao_sn'=>$mibao_sn,
	);
	$this->my_mibao_mod->edit($id,$bd_mibao);//更新密保表
	$this->my_money_mod->edit('user_id='.$money_row['user_id'],$bd_money);//更新密保表
	$this->show_message('mibao_bangding_bangdingchenggong',
	'mibao_bangding_fanhuixinkaliebiao','index.php?module=my_money&act=mibao_xinka');
	}
	else
	{
	$index=$this->my_mibao_mod->find($id);//读取所有数据库
    $this->assign('index', $index);//传递到风格里
    $this->display('mibao_bangding.html'); 
    return;
	}
	}	
	
	//解除密保卡mibao_sn_del
    function mibao_sn_del()
    {
	$id = isset($_GET['id']) ? trim($_GET['id']) : '';
    if (!$id)
    {
            $this->show_warning('feifacanshu');
            return;
    }
	$mobai_edit=array(
	'user_id'=>0,
	'user_name'=>"",
    'bd_time'=>"",
	'dq_time'=>"",
	'ztai'=>0,
    );
	$user_edit=array(
    'mibao_id'=>0,
	'mibao_sn'=>"",
    );
	$this->my_mibao_mod->edit($id,$mobai_edit);//更新密保表
	$this->my_money_mod->edit('mibao_id='.$id,$user_edit);//更新密保表
    $this->show_message('mibao_sn_del_jiechuchenggong');
	}
	
	
/*充值开始----------------------------------------------------------充值开始*/
    //已充值列表
    function card_yichongzhi()
    {
	
	
	$cardname = trim($_GET['cardname']);
	$conditions ='and user_id>0';
	$by="id";
	$sc="desc";
    $page = $this->_get_page();
	$index=$this->my_card_mod->find(array(
            'conditions' => '1=1 '.$conditions ,//条件 如：where
            'limit' => $page['limit'],
			'order' => "$by $sc",
			'count' => true,
        ));	
	/*
	$index=$this->my_card_mod->find(array(
            'conditions' => 'user_id>0' ,//条件 如：where
            'limit' => $page['limit'],
			'count' => true,
        ));	
	*/	
	$page['item_count'] = $this->my_card_mod->getCount();
    $this->_format_page($page);
	$this->assign('page_info', $page);
	$this->assign('index', $index);
	$this->display('card_yichongzhi.html'); 
	return;
	}
    //已过期列表
    function card_guoqi()
    {
	$xz_time=time();
    $page = $this->_get_page();
	$index=$this->my_card_mod->find(array(
            'conditions' => "user_id=0 and guoqi_time<'$xz_time'" ,//条件 如：where
            'limit' => $page['limit'],
			'count' => true,
        ));	
	$page['item_count'] = $this->my_card_mod->getCount();
    $this->_format_page($page);
	$this->assign('page_info', $page);
	$this->assign('index', $index);
	$this->display('card_guoqi.html'); 
	return;
	}
    //未充值列表
    function card_weichongzhi()
    {
	$xz_time=time();
    $page = $this->_get_page();
	$index=$this->my_card_mod->find(array(
            'conditions' => "user_id=0 and guoqi_time>'$xz_time'",//条件 如：where
            'limit' => $page['limit'],
			'count' => true,
        ));	
	$page['item_count'] = $this->my_card_mod->getCount();
    $this->_format_page($page);
	$this->assign('page_info', $page);
	$this->assign('index', $index);
	$this->display('card_weiguoqi.html'); 
	return;
	}							
    //批量删除充值卡
    function card_drop()
    {
        $id = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$id)
        {
            $this->show_warning('feifacanshu');
            return;
        }
        
        $ids = explode(',', $id);
       
        $this->my_card_mod->drop($ids);
		
        $this->show_message('card_drop_pi_piliangshanchuchongzhikachenggong');
        return;
    }	
    //删除充值卡
    function card_del()
    {
        $id = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$id)
        {
            $this->show_warning('feifacanshu');
            return;
        }
        $this->my_card_mod->drop($id);
		
        $this->show_message('card_drop_shanchuchongzhikachenggong');
        return;
    }		
	
    //密保搜索
	function card_soso()//默认显示
    {
	$sombsn=$_GET["sombsn"];
	$sotime=$_GET["sotime"];
	$endtime=$_GET["endtime"];
	$ztai=$_GET["ztai"];
		if(empty($ztai)) $ztai=1;
		$sotimes= strtotime("$sotime");
		$endtimes= strtotime("$endtime")+86399;// 增加23小时59分59秒
		if(empty($sombsn) and empty($sotime) and empty($endtime))
        {
		$this->show_warning('user_money_add_nizongdeshurudianshenmeba');
	    return;
		}		
		$page = $this->_get_page();	
		//三个都不为空
        if (isset($sombsn) and isset($sotime) and isset($endtime)) 
        { 
		$index=$this->my_mibao_mod->find(array(
	    'conditions' => "mibao_sn LIKE '%$sombsn%' and bd_time>='$sotimes' and bd_time<'$endtimes' and ztai='$ztai'",
        'limit' => $page['limit'],
		'count' => true));
        }
	   	//开始时间 或 结束时间 为空，就是搜索单独用户			
	    if(empty($sotime) or empty($endtime))
        {
		if(empty($sotimes))  $sotimes=1;
	    if(empty($endtimes)) $endtimes=1300000000;	
		$index=$this->my_mibao_mod->find(array(
	        'conditions' => "bd_time>='$sotimes' and bd_time<'$endtimes' and ztai='$ztai'",
            'limit' => $page['limit'],
			'count' => true));
		}
		//用户为空，就是搜索开始时间-结束时间
	    else
        {
		$index=$this->my_mibao_mod->find(array(
	        'conditions' => "mibao_sn LIKE '%$sombsn%' and ztai='$ztai'",
            'limit' => $page['limit'],
			'count' => true));
		}	

		$page['item_count'] = $this->my_moneylog_mod->getCount('user_name='.$soname);
        $this->_format_page($page);
	    $this->assign('page_info', $page);
	    $this->assign('index', $index);
		if($ztai==1)$this->display('mibao_zhengchang.html'); 
		if($ztai==2)$this->display('mibao_zanting.html'); 
		if($ztai==3)$this->display('mibao_guoqi.html'); 
	    return;

	}
	
	function setup()//系统设置
    {
	   if($_POST)
	   {
	   $chinabank_key = trim($_POST['chinabank_key']);
	   $chinabank_mid = trim($_POST['chinabank_mid']);
	   $chinabank_url = trim($_POST['chinabank_url']);
 
	   if(empty($chinabank_key) or empty($chinabank_mid) or empty($chinabank_url))
       {
	   		$this->show_warning('user_money_add_nizongdeshurudianshenmeba');
	   		return;
	   }
	   if (preg_match("/[^0.-9]/",$chinabank_mid))
       {
	   $this->show_warning('网银MID必须为数字'); 
       return;
       }

	   //写入LOG记录
	   //$dq_time=date("Y-m-d-His",time());
	   $setup_array=array(
	   'chinabank_key'=>$chinabank_key,
	   'chinabank_mid'=>$chinabank_mid,
	   'chinabank_url'=>$chinabank_url,
	   );
	   /*
	   $user_id = $this->visitor->get('user_id');
            if (!empty($_FILES['chinabank_url']))
            {
                $chinabank_url = $this->_upload_jifen_img($user_id);
                if ($chinabank_url === false)
                {
                    return;
                }
                $data['chinabank_url'] = $chinabank_url;
            }	   
	   */
	   $this->my_paysetup_mod->edit('id=1',$setup_array);

	   $this->show_message('成功保存设置!','返回导航','index.php?module=my_money&act=index');
	        return;
	   }
	   else
	   {
       $index=$this->my_paysetup_mod->find('id=1');
	   $this->assign('index', $index);
       $this->display('paysetup.html'); 
	   }
	   return;
	}

    function jifen_chaxun1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111()
    {
    $page = $this->_get_page();
	$index=$this->my_money_mod->find(array(
            'conditions' => '',//条件 如：where
            'limit' => $page['limit'],
			'order' => "jifen desc",
			'count' => true,
        ));	
	$page['item_count'] = $this->my_jifen_mod->getCount();
    $this->_format_page($page);
	$this->assign('page_info', $page);
	$this->assign('index', $index);
	$this->display('jifen_chaxun.html');  
	return;
	}

    function jifen_chaxun()
    {
	$soname=$_GET["soname"];	
	$sojifen=$_GET["sojifen"];	
	$endjifen=$_GET["endjifen"];	
	
    $page = $this->_get_page();
	//搜索用户为空就搜索全部	
	if(empty($soname))
	{
    //检测 开始金额 结束金额 都为空
    if(empty($sojifen) and empty($endjifen)) 
    {
	$index=$this->my_money_mod->find(array(
	'conditions' => '',//条件
    'limit' => $page['limit'],
	'order' => "jifen desc",
	'count' => true));	
	//上面自然列出所有用户，按金额大到小排列
	}
	//否则搜索 用户名、开始金额-结束金额
	else
	{
	if(empty($sojifen)){$sojifen=0;}//开始金额为空就=0
	if(empty($endjifen)){$endjifen=9999999;}//结束金额为空就=9999999
	$index=$this->my_money_mod->find(array(
	'conditions' => "user_name LIKE '%$soname%' and jifen>='$sojifen' and jifen<='$endjifen'",//条件
    'limit' => $page['limit'],
	'order' => "jifen desc",
	'count' => true));	
	}
	}
	else
	{//否则用户名不为空
	
    //用户不为空 双时间为空
    if(empty($sojifen) and empty($endjifen)) 
    {
	$index=$this->my_money_mod->find(array(
	'conditions' => "user_name LIKE '%$soname%'",//条件
    'limit' => $page['limit'],
	'order' => "jifen desc",
	'count' => true));	
	}
	//用户不为空 双时间也不为空
	else
	{
	if(empty($sojifen)){$sojifen=0;}
	if(empty($endjifen)){$endjifen=999999999;}
	$index=$this->my_money_mod->find(array(
	'conditions' => "user_name LIKE '%$soname%' and jifen>='$sojifen' and jifen<='$endjifen'",//条件
    'limit' => $page['limit'],
	'order' => "jifen desc",
	'count' => true));	
	}
	}
			
		$page['item_count'] = $this->my_money_mod->getCount();
        $this->_format_page($page);
	    $this->assign('page_info', $page);
	    $this->assign('index', $index);//传递到风格里
        $this->display('jifen_chaxun.html');
	    return;
	}	
	
    function jifen_shezhi()
    {
    $page = $this->_get_page();
	$index=$this->my_jifen_mod->find(array(
            'conditions' => 'yes_no=1',//条件 如：where
            'limit' => $page['limit'],
			'order' => "ids desc",
			'count' => true,
        ));	
	$page['item_count'] = $this->my_jifen_mod->getCount();
    $this->_format_page($page);
	$this->assign('page_info', $page);
	$this->assign('index', $index);
	$this->display('jifen_shezhi.html');  
	return;
	}
			
	function jifen_add()//积分添加 ORDER BY `ecm_my_jifen`.`id` ASC 
    {
	   if($_POST)
	   {
	   $yes_no = 1;
	   $ids = trim($_POST['ids']);
	   $jifen = trim($_POST['jifen']);

       $add_time = time();
	   $wupin_name = trim($_POST['wupin_name']);
	   $wupin_img = trim($_POST['wupin_img']);
	   $jiazhi = trim($_POST['jiazhi']);
	   $shuliang = trim($_POST['shuliang']);
	   $yiduihuan = trim($_POST['yiduihuan']);
	   $log_text = trim($_POST['log_text']);
	   if(empty($ids))
       {
	   		$ids=255;
	   }
       if($ids >255)
	   {
	   		$ids=255;	   
	   }
	   if(empty($wupin_name) or empty($jifen) or empty($shuliang))
       {
	   		$this->show_warning('user_money_add_nizongdeshurudianshenmeba');
	   		return;
	   }
	   if (preg_match("/[^0.-9]/",$shuliang))
       {
	   $this->show_warning('数量必须为数字'); 
       return;
       }

	   $setup_array =array(
	   'yes_no'  =>    $yes_no,
	   'ids'     =>    $ids,
	   'add_time' =>   $add_time,
	   'jifen'    =>   $jifen,
	   'wupin_name' => $wupin_name,
	   'wupin_img'  => $wupin_img,
	   'jiazhi'     => $jiazhi,
	   'shuliang'   => $shuliang,
	   'yiduihuan'  => $yiduihuan,
	   'log_text'   => $log_text,
       );

	   $ida=$this->my_jifen_mod->getrow("select * from ".DB_PREFIX."my_jifen ORDER BY id desc limit 1");
	   $idb=++$ida['id'];
            if (!empty($_FILES['wupin_img']))
            {
                $wupin_img = $this->_upload_jifen_img($idb);
                if ($wupin_img === false)
                {
                    return;
                }
                $setup_array['wupin_img'] = $wupin_img;
            }	   

	   $this->my_jifen_mod->add($setup_array);

	   $this->show_message('物品设置成功!','返回列表','index.php?module=my_money&act=jifen_shezhi');
	        return;
	   }
	   else
	   {
       $this->display('jifen_add.html'); 
	   }
	   return;
	}
	
//批量删除积分物品jifen_drop_pi
function jifen_drop_pi()
{
        $id = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$id)
        {
            $this->show_warning('feifacanshu');
            return;
        }
        
        $ids = explode(',', $id);
       
        $this->my_jifen_mod->drop($ids);
		
        $this->show_message('删除积分物品成功！');

        return;
    }		
	
	function jifen_yiduihuan()//积分已兑换
    {
    $page = $this->_get_page();
	$index=$this->my_jifen_mod->find(array(
            'conditions' => 'yes_no=0',//条件 如：where
            'limit' => $page['limit'],
			'order' => "shenhe asc",
			'count' => true,
        ));	
	$page['item_count'] = $this->my_jifen_mod->getCount();
    $this->_format_page($page);
	$this->assign('page_info', $page);
	$this->assign('index', $index);
	$this->display('jifen_yiduihuan.html');  
	return;
	}
	
	function jifen_id()//积分已兑换
    {
	$id = isset($_GET['id']) ? trim($_GET['id']) : '';
	if($_POST)
	{
	   $setup_array =array(
	   'wuliu_name'   => trim($_POST['wuliu_name']),
	   'wuliu_danhao'   => trim($_POST['wuliu_danhao']),
	   'shenhe'   => trim($_POST['shenhe']),
       );
	$this->my_jifen_mod->edit($id,$setup_array);
	$this->show_message('审核成功!','返回列表','index.php?module=my_money&act=jifen_yiduihuan');
	        return;	
	}
	else
	{
	$index=$this->my_jifen_mod->find($id);//读取所有数据库
    $this->assign('index', $index);//传递到风格里
    $this->display('jifen_id.html'); 
    return;
    }
	}
    /**
     * 上传积分图象
     *
     * @param int $user_id
     * @return mix false表示上传失败,空串表示没有上传,string表示上传文件地址
     */
    function _upload_jifen_img($idb)
    {
        $file = $_FILES['wupin_img'];
        if ($file['error'] != UPLOAD_ERR_OK)
        {
            return '';
        }
        import('uploader.lib');
        $uploader = new Uploader();
        $uploader->allowed_type(IMAGE_FILE_TYPE);
        $uploader->addFile($file);
        if ($uploader->file_info() === false)
        {
            $this->show_warning($uploader->get_error(), 'go_back', 'index.php?module=my_money&act=setup');
            return false;
        }
        $uploader->root_dir(ROOT_PATH);
        return $uploader->save('data/files/mall/jifen_img', $idb);
		
    }	
}
?>