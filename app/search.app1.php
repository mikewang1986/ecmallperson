<?php

/* 定义like语句转换为in语句的条件 */
define('MAX_ID_NUM_OF_IN', 10000); // IN语句的最大ID数
define('MAX_HIT_RATE', 0.05);      // 最大命中率（满足条件的记录数除以总记录数）
define('MAX_STAT_PRICE', 10000);   // 最大统计价格
define('PRICE_INTERVAL_NUM', 5);   // 价格区间个数
define('MIN_STAT_STEP', 50);       // 价格区间最小间隔
define('NUM_PER_PAGE', 40);        // 每页显示数量
define('ENABLE_SEARCH_CACHE', true); // 启用商品搜索缓存
define('SEARCH_CACHE_TTL', 3600);  // 商品搜索缓存时间

class SearchApp extends MallbaseApp
{
    /* 搜索商品 */
    function index()
    {
		// tyioocom 过滤非法参数
		if(!$this->_check_query_param_by_props()){
			header('Location: index.php');exit;
		}
        // 查询参数
        $param = $this->_get_query_param();
		if (empty($param))
        {
            header('Location: index.php?app=category');
            exit;
        }
	
	
        if (isset($param['cate_id']) && $param['layer'] === false)
        {
            $this->show_warning('no_such_category');
            return;
        }
	
		// 验证当前请求地址，是否需要跳转到频道页  tyioocom
		$check_param_for_channel = true;
		if(isset($param['cate_id']) && $param['cate_id'] > 0){
			foreach($param as $k=>$v){
				if(!empty($v) && ($k !='cate_id' && $k != 'layer')){
					$check_param_for_channel = false;
				}
			}
			// 如果当前请求的地址，只要一个 cate_id 参数，则检验当前 cate_id 是否有对应的频道页
			if($check_param_for_channel === true)
			{
				$channel_mod = &af('channels');
				$channel_list = $channel_mod->getAll();
				if($channel_list){
					foreach($channel_list as $k=>$v){
						if($v['cate_id'] == $param['cate_id'] && $v['status']==1){
							header('Location:' . SITE_URL . '/index.php?app=channel&id='.$k);
							break;
						}
					}
				}
			}
		}
		// end tyioocom

        /* 筛选条件 */
        $this->assign('filters', $this->_get_filter($param));

        /* 按分类、品牌、地区、价格区间统计商品数量 */
        $stats = $this->_get_group_by_info($param, ENABLE_SEARCH_CACHE);

        $this->assign('categories', $stats['by_category']);
        $this->assign('category_count', count($stats['by_category']));

        $this->assign('brands', $stats['by_brand']);
        $this->assign('brand_count', count($stats['by_brand']));

        $this->assign('price_intervals', $stats['by_price']);

        $this->assign('regions', $stats['by_region']);
        $this->assign('region_count', count($stats['by_region']));
		
		// sku tyioocom 
		//print_r($stats['by_props']);exit;
		$this->assign('props',$stats['by_props']);
		$this->assign('props_selected', isset($param['props']) ? $param['props'].';' : '');
		$this->assign('props_count',count($stats['by_props']));

        /* 排序 */
        $orders = $this->_get_orders();
        $this->assign('orders', $orders);

        /* 分页信息 */
        $page = $this->_get_page(NUM_PER_PAGE);
        $page['item_count'] = $stats['total_count'];
        $this->_format_page($page);
        $this->assign('page_info', $page);

        /* 商品列表 */
        $conditions = $this->_get_goods_conditions($param);
        $goods_mod  =& m('goods');
        $default_order  = $this->_get_default_order();
        $goods_list = $goods_mod->get_list(array(
            'conditions' => $conditions,
            'order'      => isset($_GET['order']) && isset($orders[trim(str_replace('asc','',str_replace('desc','',$_GET['order'])))]) ? $_GET['order'] : $default_order,// tyioocom
			'fields'=>'s.praise_rate,s.im_qq,s.im_ww,',// tyioocom
            'limit'      => $page['limit'],
        ));
		
		if(!$goods_list)
		{
			$goods_list = $goods_mod->get_list(array(
            	'conditions' => 'if_show=1 AND closed=0 ',
            	'order'      => 'add_time desc',
				'fields'	 =>'s.praise_rate,s.im_qq,s.im_ww,',
            	'limit'      => 45,
        	));
			$this->assign('goods_list_order', 1);
		}
		
		$goods_list = $this->_format_goods_list($goods_list);
		$this->assign('goods_list', $goods_list);
        

        /* 商品展示方式 */
        $display_mode = ecm_getcookie('goodsDisplayMode');
        if (empty($display_mode) || !in_array($display_mode, array('list', 'squares')))
        {
            $display_mode = 'squares'; // 默认格子方式
        }
        $this->assign('display_mode', $display_mode);

        /* 取得导航 */
        $this->assign('navs', $this->_get_navs());

        /* 当前位置 */
        $cate_id = isset($param['cate_id']) ? $param['cate_id'] : 0;
        $this->_curlocal($this->_get_goods_curlocal($cate_id));
        
        /* 配置seo信息 */
        $this->_config_seo($this->_get_seo_info('goods', $cate_id));
		
		/* tyioocom */
		$this->assign("recommend_goods", $this->_get_list_goods($param)); 
		$this->assign("owner_rec_goods", $this->_get_list_goods($param, 'owner_rec')); 
		$this->assign('search_rec_goods', $this->_get_list_goods($param,'search_rec'));
		// end
		
		$this->assign('ultimate_store',$this->_get_ultimate_store());
		
        $this->display('search.goods.wind.html');
    }
	function _format_goods_list($goods_list)
	{
        $store_mod =& m('store');
		$sgrade_mod =& m('sgrade');
		$image_mod =& m('goodsimage');
		
		$step = intval(Conf::get('upgrade_required'));
		$step < 1 && $step = 5;
		
        $sgrades    = $sgrade_mod->get_options();
		
		foreach ($goods_list as $key => $goods)
        {
            $goods_list[$key]['credit_image'] = $this->_view->res_base . '/images/' . $store_mod->compute_credit($goods['credit_value'], $step);
            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');
            $goods_list[$key]['grade_name'] = $sgrades[$goods['sgrade']];
			
			/* 加载商品小图 tyioocom */ 
			$goods_list[$key]['_images'] = array_values($image_mod->find(array(
                'conditions' => "goods_id=".$goods['goods_id'],
                'order' => 'sort_order',
				'fields'=>'thumbnail,image_url',
				'limit'=>4
            )));
        }
		return $goods_list;
	}
	function _get_ultimate_store()
	{
		$store = array();
		$brand_name = trim($_GET['brand']);
		$cate_id 	= intval($_GET['cate_id']);
		$keyword 	= trim($_GET['keyword']);
		
		$conditions = '';
		if(!empty($brand_name))
		{
			$brand_mod = &m('brand');
			$brand = $brand_mod->get(array('conditions'=>"brand_name='".$brand_name."'",'fields'=>'brand_id,brand_logo'));
			if($brand) {
				$conditions = ' AND brand_id='.$brand['brand_id'];
			} else {
				$conditions = ' AND brand_id="" ';
			}
		}
		elseif(!empty($keyword))
		{
			$conditions = " AND keyword='".$keyword."' ";
		}
		elseif(!empty($cate_id))
		{
			$conditions = ' AND cate_id='.$cate_id;
		}
		import('init.lib');
	    $init = new Init_SearchApp();
		
		return $init->_get_ultimate_store($conditions, $brand);
	}
	/* 列表页排行，推荐商品 */
	function _get_list_goods($param,$type='recommend')
	{
		$conditions = $recommended = '';
		$goods_mod  =& m('goods');
		if(isset($param['cate_id']) && $param['cate_id']>0){
			$gcategory_mod =& bm('gcategory');
            $cate_ids = implode(",",$gcategory_mod->get_descendant_ids($param['cate_id']));
			$conditions .= " AND cate_id IN (".$cate_ids.")";
		}
		if($type=='search_rec')
		{
			$order = 'sales desc,goods_id desc';
			$limit = 5;
			$conditions .= " AND goods_name lIKE '%".$param['keyword'][0]."%' "; 
		}
		elseif($type=="owner_rec"){
			$order = 'views desc,goods_id desc';
			$limit = 5;
		}
		else
		{
			$order = 'recommended desc,goods_id desc';
			$recommended = ' AND recommended=1 ';
			$limit = 6;
		}
		$data = $goods_mod->find(array(
		   "conditions" => "if_show=1 AND closed=0 " . $recommended . $conditions,
		   "order"      => $order,
		   "join"       => "has_goodsstatistics",
		   "fields"     => "g.goods_id,default_image,price,goods_name,sales",
		   "limit"      => $limit
		));	
		
		// 如果按照商品的条件，得到的商品数为空，为了保持页面的美观，随机读取最新的商品
		if(empty($data))
		{
			$data = $goods_mod->find(array(
				'conditions'=>'if_show=1 AND closed=0 ',
				"order"      => $order,
		   		"join"       => "has_goodsstatistics",
		   		"fields"     => "g.goods_id,default_image,price,goods_name,sales",
		   		"limit"      => $limit
			));
		}
			
		return $data;
	}
	
	/* 进入砸蛋界面 */
	function eggact()
	{
		/* 得到礼品列表 */
		$model_eggpresent =& m('eggpresent');
		$eggpresent_list = $model_eggpresent->findAll(array(
            'conditions'    => "",
            'fields'        => 'this.*',
            'count'         => true,
            'limit'         => 5,
            'order'         => 'id DESC',
        ));

		/* 得到兑换列表 */
		$model_eggpresentrec =& m('eggpresentrec');
		$eggpresentrec_list = $model_eggpresentrec->findAll(array(
            'conditions'    => "",
            'fields'        => 'this.*',
            'count'         => true,
			'limit'         => '6',
            'order'         => 'addtime DESC',
        ));
		$this->assign('eggpresent_list', $eggpresent_list);
		$this->assign('eggpresentrec_list', $eggpresentrec_list);
		$this->display('search.act.html');
	}

	/* 砸蛋过程 */
	function eggact_ajax()
	{
		$userid = null;
		$userid = $this->visitor->get('user_id');
		$eggid = $_GET['egg_type'];
		$msg = "";
		$db = &db();
		if(!empty($userid))//是否登录
		{
			 //$member_m = $db->getrow("select * from ecm_member where user_id=" . $userid);
		   $huiyuan = $db->getrow("select * from ecm_my_money  where user_id=".$userid);//用户信息
			$egg_m = $db->getrow("select * from ecm_egg where id=" . $eggid);//用户信息
			if($huiyuan['jifen'] >= $egg_m['noun'])//活动积分是否够砸此蛋
			{
				$surplus = $huiyuan['jifen'] - $egg_m['noun'];
				$db->query("update ecm_my_money set jifen=".$surplus." where user_id=" . $userid);//扣除积分
				if(intval($egg_m['rate'])>=rand(1,1000))//是否中奖 
				{
					$eggpresent_m = $db->getrow("select * from ecm_eggpresent where byeggid=".$eggid." order by rand() limit 1");//用户信息
					if(!empty($eggpresent_m))//是否存在奖品
					{
						$msg = "太棒了 ！你居然砸中了 ".$eggpresent_m['name']." ！";
						$sql_str = "insert into ecm_eggpresentrec  (username,presentname,eggname,addtime) values ('".$huiyuan['user_name']."','".$eggpresent_m['name']."','".$egg_m['name']."',".intval(ecm_microtime()).") ";
						$db->query($sql_str);//插入中奖记录
					}else{
						$msg = "奖品被领完了吗？居然没有奖品了，你太倒霉了 !";
					}
				}else{
					$msg = "很遗憾 ！什么也没有砸中，再接再厉吧 ！";
				}
			}else{
				$msg = "很遗憾 ！你剩余的活动积分不够砸此蛋 ！";
			}
		}else{
			$msg = "请先登录";
		}
		header('Content-Type:text/html;charset=' . CHARSET);
		echo $msg;
		return ;
	}

    /* 搜索店铺 */
    function store()
    {
        /* 取得导航 */
        $this->assign('navs', $this->_get_navs());

        /* 取得该分类及子分类cate_id */
        $cate_id = empty($_GET['cate_id']) ? 0 : intval($_GET['cate_id']);
        $cate_ids=array();
        $condition_id='';
        if ($cate_id > 0)
        {
            $scategory_mod =& m('scategory');
            $cate_ids = $scategory_mod->get_descendant($cate_id);
        }

        /* 店铺分类检索条件 */
        $condition_id=implode(',',$cate_ids);
        $condition_id && $condition_id = ' AND cate_id IN(' . $condition_id . ')';

        /* 其他检索条件 */
        $conditions = $this->_get_query_conditions(array(
            array( //店铺名称
                'field' => 'store_name',
                'equal' => 'LIKE',
                'assoc' => 'AND',
                'name'  => 'keyword',
                'type'  => 'string',
            ),
            array( //地区名称
                'field' => 'region_name',
                'equal' => 'LIKE',
                'assoc' => 'OR',
                'name'  => 'keyword',
                'type'  => 'string',
            ),
				 array( //地区xx名称
                'field' => 'address',
                'equal' => 'LIKE',
                'assoc' => 'OR',
                'name'  => 'keyword',
                'type'  => 'string',
            ),
			 array( //配送范围
                'field' => 'send_address',
                'equal' => 'LIKE',
                'assoc' => 'OR',
                'name'  => 'keyword',
                'type'  => 'string',
            ),
            array( //地区id
                'field' => 'region_id',
                'equal' => '=',
                'assoc' => 'AND',
                'name'  => 'region_id',
                'type'  => 'string',
            ),
			array( //店铺等级id
                'field' => 'sgrade',
                'equal' => '=',
                'assoc' => 'AND',
                'name'  => 'sgrade',
                'type'  => 'string',
            ),
			array( //是否推荐
                'field' => 'recommended',
                'equal' => '=',
                'assoc' => 'AND',
                'name'  => 'recommended',
                'type'  => 'string',
            ),
			array( //好评率
                'field' => 'praise_rate',
                'equal' => '>',
                'assoc' => 'AND',
                'name'  => 'praise_rate',
                'type'  => 'string',
            ),
            array( //商家用户名
                'field' => 'user_name',
                'equal' => 'LIKE',
                'assoc' => 'AND',
                'name'  => 'user_name',
                'type'  => 'string',
            ),
        ));
		
		//  tyioocom  safe care
		$orders = array(
		    'sales desc',
			'sales asc',
			'price desc',
			'price asc',
			'add_time desc',
		    'add_time asc',
			'comments desc',
			'comments asc',
		    'credit_value desc',
		    'credit_value asc',
		  	'views desc',
		   	'views asc',
		);
		$step= intval(Conf::get('upgrade_required'));
		$step < 1 && $step = 5;
		$level_1 = $step * 5;
        $level_2 = $level_1 * 6;
        $level_3 = $level_2 * 6;
		if($_GET['credit_value']){
			switch(intval($_GET['credit_value'])){
				case 1;
				$credit_condition=' AND credit_value<'.$level_1.' ';
				break;
				case 2;
				$credit_condition=' AND credit_value<'.$level_2.' AND credit_value>='.$level_1.' ';
				break;
				case 3;
				$credit_condition=' AND credit_value<'.$level_3.' AND credit_value>='.$level_2.' ';
				break;
				case 4;
				$credit_condition=' AND credit_value>='.$level_3.' ';
				break;	
			}
		}
        $model_store =& m('store');
        $regions = $model_store->list_regions();
        $page   =   $this->_get_page(10);   //获取分页信息
        $stores = $model_store->find(array(
            'conditions'  => 'state = ' . STORE_OPEN .$credit_condition.$condition_id . $conditions,
            'limit'   =>$page['limit'],
			'fields'  =>'store_name,user_name,sgrade,store_logo,praise_rate,credit_value,s.im_qq,im_ww,business_scope,region_name',
            'order'   => empty($_GET['order']) || !in_array($_GET['order'], $orders) ? 'sort_order' : $_GET['order'], //  tyioocom $orders
            'join'    => 'belongs_to_user,has_scategory',

            'count'   => true   //允许统计
        ));

        $model_goods = &m('goods');
		$order_mod=&m('order');
		$sgrade_mod=&m('sgrade');

        foreach ($stores as $key => $store)
        {
			$goods_list = $model_goods->find(array(
				'conditions'=>'store_id='. $store['store_id'],
				'order'     =>'add_time desc',
				'limit'     =>10,
				'fields'=>'goods_name,default_image,price'
			));
			
			$stores[$key]['goods_list'] = array_chunk($goods_list,5);
			
			$order=$order_mod->find(array('conditions'=>'status=40 AND seller_id='.$store['store_id'],'fields'=>'order_id'));
			$stores[$key]['store_sold']=count($order);
			
			
			$sgrade=$sgrade_mod->get(array('conditions'=>'grade_id='.$store['sgrade'],'fields'=>'grade_name'));
			$stores[$key]['sgrade_name']=$sgrade['grade_name'];
            
			//店铺logo
            empty($store['store_logo']) && $stores[$key]['store_logo'] = Conf::get('default_store_logo');

            //商品数量
            $stores[$key]['goods_count'] = $model_goods->get_count_of_store($store['store_id']);

            //等级图片
            $stores[$key]['credit_image'] = $this->_view->res_base . '/images/' . $model_store->compute_credit($store['credit_value'], $step);

        }
        $page['item_count']=$model_store->getCount();   //获取统计数据
        $this->_format_page($page);
		$this->assign('sgrades',$this->get_sgrade());
        
		/* 当前位置 */
        $this->_curlocal($this->_get_store_curlocal($cate_id));
        $scategorys = $this->_list_scategory();
        $this->assign('stores', $stores);
        $this->assign('regions', $regions);
        $this->assign('cate_id', $cate_id);
        $this->assign('scategorys', $scategorys);
        $this->assign('page_info', $page);
        
		/* 配置seo信息 */
        $this->_config_seo($this->_get_seo_info('store', $cate_id));
        $this->display('search.store.html');
    }
	/*获取店铺等级*/
	function get_sgrade()
	{
		$sgrade_mod=&m('sgrade');
		$sgrades=$sgrade_mod->find();
		$result=array();
		foreach($sgrades as $k=>$sgrade){
			$result[$sgrade['grade_id']]=$sgrade['grade_name'];	
		}
		return $result;
	}
	 // tyioocom 过滤非法参数
	function _check_query_param_by_orders()
	{
		$order = $_GET['order'];
		if(empty($order)){
			return true;
		}
		$orders = array(
		   'sales desc',
			'sales asc',
			'price desc',
			'price asc',
			'add_time desc',
		    'add_time asc',
			'comments desc',
			'comments asc',
		    'credit_value desc',
		    'credit_value asc',
		  	'views desc',
		   	'views asc',  
		);
		
		if(in_array($order, $orders)){
			return true;
		} else {
			return false;
		}	
	}

    function groupbuy()
    {
		$conditions = '1=1';
		if(isset($_GET['recommend']) && $_GET['recommend']!='')
		{
			$recommend = intval($_GET['recommend']);
			$conditions .=' AND gb.recommended='.$recommend;
		}

        if ($_GET['state'] == 'on')
        {
            $conditions .= ' AND gb.state ='. GROUP_ON .' AND gb.end_time>' . gmtime();
        }
        elseif ($_GET['state'] == 'end')
        {
            $conditions .= ' AND (gb.state=' . GROUP_ON . ' OR gb.state=' . GROUP_END . ') AND gb.end_time<=' . gmtime();
        }
        else
        {
            $conditions .= $this->_get_query_conditions(array(
                array(      //按团购状态搜索
                    'field' => 'gb.state',
                    'name'  => 'state',
                    'handler' => 'groupbuy_state_translator',
                )
            ));
        }
        $conditions .= $this->_get_query_conditions(array(
            array( //活动名称
                'field' => 'group_name',
                'equal' => 'LIKE',
                'assoc' => 'AND',
                'name'  => 'keyword',
                'type'  => 'string',
            ),
        ));
        $page = $this->_get_page(NUM_PER_PAGE);   //获取分页信息
        $groupbuy_mod = &m('groupbuy');
        $groupbuy_list = $groupbuy_mod->find(array(
            'conditions'    => $conditions,
            'fields'        => 'gb.*,g.default_image,g.price,default_spec,s.store_name',
            'join'          => 'belong_store, belong_goods',
            'limit'         => $page['limit'],
            'count'         => true,   //允许统计
            'order'         => isset($_GET['order']) && isset($orders[$_GET['order']]) ? $_GET['order'] : 'group_id desc',
        ));
        if ($ids = array_keys($groupbuy_list))
        {
            $quantity = $groupbuy_mod->get_join_quantity($ids);
        }
        foreach ($groupbuy_list as $key => $groupbuy)
        {
            $groupbuy_list[$key]['quantity'] = empty($quantity[$key]['quantity']) ? 0 : $quantity[$key]['quantity'];
            $groupbuy['default_image'] || $groupbuy_list[$key]['default_image'] = Conf::get('default_goods_image');
            $groupbuy['spec_price'] = unserialize($groupbuy['spec_price']);
            $groupbuy_list[$key]['group_price'] = $groupbuy['spec_price'][$groupbuy['default_spec']]['price'];
            $groupbuy['state'] == GROUP_ON && $groupbuy_list[$key]['lefttime'] = lefttime($groupbuy['end_time']);
			if($groupbuy['price'] != 0){
				$groupbuy_list[$key]['discount'] = round($groupbuy['spec_price'][$groupbuy['default_spec']]['price'] / $groupbuy['price'] * 10,1);
			} else {
				$groupbuy_list[$key]['discount'] = 0;
			}
		}
        $this->assign('state', array(
             'on' => Lang::get('group_on'),
             'end' => Lang::get('group_end'),
             'finished' => Lang::get('group_finished'),
             'canceled' => Lang::get('group_canceled'))
        );
        $this->assign('orders', $orders);
        // 当前位置
        $this->_curlocal(array(array('text' => Lang::get('groupbuy'))));
        $this->_config_seo('title', Lang::get('groupbuy') . ' - ' . Conf::get('site_title'));
        $page['item_count'] = $groupbuy_mod->getCount();   //获取统计数据
        $this->_format_page($page);
        $this->assign('nav_groupbuy', 1); // 标识当前页面是团购列表，用于设置导航状态
       $this->assign('page_info', $page);
        $this->assign('groupbuy_list',$groupbuy_list);
        $this->assign('recommended_groupbuy', $this->_recommended_groupbuy(2));
        $this->assign('last_join_groupbuy', $this->_last_join_groupbuy(2));
        $this->display('search.groupbuy.html');
    }

    // 推荐团购活动
    function _recommended_groupbuy($_num)
    {
        $model_groupbuy =& m('groupbuy');
        $data = $model_groupbuy->find(array(
            'join'          => 'belong_goods,belong_store', // tyioocom 
            'conditions'    => 'gb.recommended=1 AND gb.state=' . GROUP_ON . ' AND gb.end_time>' . gmtime(),
            'fields'        => 'group_id, goods.default_image, group_name, gb.end_time, spec_price,gb.min_quantity,gb.store_id,s.store_name,gb.group_image',// tyioocm 
            'order'         => 'group_id DESC',
            'limit'         => $_num,
        ));
		
		// tyioocom 
		if ($ids = array_keys($data))
        {
            $quantity = $model_groupbuy->get_join_quantity($ids);
		}
		// end 
		
        foreach ($data as $gb_id => $gb_info)
        {
			$data[$gb_id]['quantity'] = empty($quantity[$gb_id]['quantity']) ? 0 : $quantity[$gb_id]['quantity']; //  tyioocom
            $price = current(unserialize($gb_info['spec_price']));
            empty($gb_info['default_image']) && $data[$gb_id]['default_image'] = Conf::get('default_goods_image');
            $data[$gb_id]['lefttime']   = lefttime($gb_info['end_time']);
            $data[$gb_id]['price']      = $price['price'];
        }
        return $data;
    }

    // 最新参加的团购
    function _last_join_groupbuy($_num)
    {
        $model_groupbuy =& m('groupbuy');
        $data = $model_groupbuy->find(array(
            'join' => 'be_join,belong_goods,belong_store',
            'fields' =>'gb.group_id,gb.group_name,gb.group_id,groupbuy_log.add_time,gb.spec_price,goods.default_image,gb.end_time,gb.min_quantity,gb.store_id,s.store_name,gb.group_image',
			// tyioocm 
            'conditions' => 'groupbuy_log.user_id > 0',
            'order' => 'groupbuy_log.add_time DESC',
            'limit' => $_num,
        ));
		// tyioocom 
		if ($ids = array_keys($data))
        {
            $quantity = $model_groupbuy->get_join_quantity($ids);
		}
		// end 
		
        foreach ($data as $gb_id => $gb_info)
        {
			$data[$gb_id]['quantity'] = empty($quantity[$gb_id]['quantity']) ? 0 : $quantity[$gb_id]['quantity']; //  tyioocom
            $price = current(unserialize($gb_info['spec_price']));
            empty($gb_info['default_image']) && $data[$gb_id]['default_image'] = Conf::get('default_goods_image');
			$data[$gb_id]['lefttime']   = lefttime($gb_info['end_time']); //  tyioocom
            $data[$gb_id]['price']      = $price['price'];
        }
        return $data;
    }

    /* 取得店铺分类 */
    function _list_scategory()
    {
        $scategory_mod =& m('scategory');
        $scategories = $scategory_mod->get_list(-1,true);

        import('tree.lib');
        $tree = new Tree();
        $tree->setTree($scategories, 'cate_id', 'parent_id', 'cate_name');
        return $tree->getArrayList(0);
    }

    function _get_goods_curlocal($cate_id)
    {
        $parents = array();
        if ($cate_id)
        {
            $gcategory_mod =& bm('gcategory');
            $parents = $gcategory_mod->get_ancestor($cate_id, true);
        }

        $curlocal = array(
            array('text' => LANG::get('all_categories'), 'url' => "javascript:dropParam('cate_id')"),
        );
        foreach ($parents as $category)
        {
            $curlocal[] = array('text' => $category['cate_name'], 'url' => "javascript:replaceParam('cate_id', '" . $category['cate_id'] . "')");
        }
        unset($curlocal[count($curlocal) - 1]['url']);

        return $curlocal;
    }

    function _get_store_curlocal($cate_id)
    {
        $parents = array();
        if ($cate_id)
        {
            $scategory_mod =& m('scategory');
            $scategory_mod->get_parents($parents, $cate_id);
        }

        $curlocal = array(
            array('text' => LANG::get('all_categories'), 'url' => url('app=category&act=store')),
        );
        foreach ($parents as $category)
        {
            $curlocal[] = array('text' => $category['cate_name'], 'url' => url('app=search&act=store&cate_id=' . $category['cate_id']));
        }
        unset($curlocal[count($curlocal) - 1]['url']);
        return $curlocal;
    }

    /**
     * 取得查询参数（有值才返回）
     *
     * @return  array(
     *              'keyword'   => array('aa', 'bb'),
     *              'cate_id'   => 2,
     *              'layer'     => 2, // 分类层级
     *              'brand'     => 'ibm',
     *              'region_id' => 23,
     *              'price'     => array('min' => 10, 'max' => 100),
     *          )
     */
    function _get_query_param()
    {
        static $res = null;
        if ($res === null)
        {
            $res = array();
    
            // keyword
            $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
            if ($keyword != '')
            {
                //$keyword = preg_split("/[\s," . Lang::get('comma') . Lang::get('whitespace') . "]+/", $keyword);
                $tmp = str_replace(array(Lang::get('comma'),Lang::get('whitespace'),' '),',', $keyword);
                $keyword = explode(',',$tmp);
                sort($keyword);
                $res['keyword'] = $keyword;
            }
    
            // cate_id
            if (isset($_GET['cate_id']) && intval($_GET['cate_id']) > 0)
            {
                $res['cate_id'] = $cate_id = intval($_GET['cate_id']);
                $gcategory_mod  =& bm('gcategory');
                $res['layer']   = $gcategory_mod->get_layer($cate_id, true);
            }
    
            // brand
            if (isset($_GET['brand']))
            {
                $brand = trim($_GET['brand']);
                $res['brand'] = $brand;
            }
    
            // region_id
            if (isset($_GET['region_id']) && intval($_GET['region_id']) > 0)
            {
                $res['region_id'] = intval($_GET['region_id']);
            }
    
            // price
            if (isset($_GET['price']))
            {
                $arr = explode('-', $_GET['price']);
                $min = abs(floatval($arr[0]));
                $max = abs(floatval($arr[1]));
                if ($min * $max > 0 && $min > $max)
                {
                    list($min, $max) = array($max, $min);
                }
    
                $res['price'] = array(
                    'min' => $min,
                    'max' => $max
                );
            }
			// tyioocom 获取属性参数
			if (isset($_GET['props']))
			{
				if($this->_check_query_param_by_props()){
					$res['props'] = trim($_GET['props']);
				}
			}
        }

        return $res;
    }
	// tyioocom  进行安全过滤
	function _check_query_param_by_props()
	{
		$pvs = $_GET['props'];
		if(!empty($pvs)){
			$pvs_arr = explode(';',$pvs);
			foreach($pvs_arr as $pv){
				$pv_arr = explode(':', $pv);
				if(is_array($pv_arr)){
					if(!is_numeric($pv_arr[0]) || !is_numeric($pv_arr[1])){
						return false;
					}
				} else {
					return false;
				}
			}
		}
		return true;		
	}	

    /**
     * 取得过滤条件
     */
    function _get_filter($param)
    {
        static $filters = null;
        if ($filters === null)
        {
            $filters = array();
            if (isset($param['keyword']))
            {
                $keyword = join(' ', $param['keyword']);
                $filters['keyword'] = array('key' => 'keyword', 'name' => LANG::get('keyword'), 'value' => $keyword);
            }
            isset($param['brand']) && $filters['brand'] = array('key' => 'brand', 'name' => LANG::get('brand'), 'value' => $param['brand']);
            if (isset($param['region_id']))
            {
                // todo 从地区缓存中取
                $region_mod =& m('region');
                $row = $region_mod->get(array(
                    'conditions' => $param['region_id'],
                    'fields' => 'region_name'
                ));
                $filters['region_id'] = array('key' => 'region_id', 'name' => LANG::get('region'), 'value' => $row['region_name']);
            }
            if (isset($param['price']))
            {
                $min = $param['price']['min'];
                $max = $param['price']['max'];
                if ($min <= 0)
                {
                    $filters['price'] = array('key' => 'price', 'name' => LANG::get('price'), 'value' => LANG::get('le') . ' ' . price_format($max));
                }
                elseif ($max <= 0)
                {
                    $filters['price'] = array('key' => 'price', 'name' => LANG::get('price'), 'value' => LANG::get('ge') . ' ' . price_format($min));
                }
                else
                {
                    $filters['price'] = array('key' => 'price', 'name' => LANG::get('price'), 'value' => price_format($min) . ' - ' . price_format($max));
                }
            }
			// sku tyioocom 
			if (isset($param['props']))
			{
				$props_mod = &m('props');
				$prop_value_mod = &m('prop_value');
				foreach(explode(';',$param['props']) as  $pv)
				{
					$pv_arr = explode(':',$pv);
					if(is_numeric($pv_arr[0]) && is_numeric($pv_arr[1])){// 安全监测，防止 sql 注入
						$props = $props_mod->get($pv_arr[0]);
						$prop_value = $prop_value_mod->get($pv_arr[1]);
						$filters['props'.$props['pid']] = array('key' => $pv, 'name' => $props['name'], 'value'=> $prop_value['prop_value']);
					}
				}
				
			}
        }
        return $filters;
    }

    /**
     * 取得查询条件语句
     *
     * @param   array   $param  查询参数（参加函数_get_query_param的返回值说明）
     * @return  string  where语句
     */
    function _get_goods_conditions($param)
    {
        /* 组成查询条件 */
        $conditions = " g.if_show = 1 AND g.closed = 0 AND s.state = 1"; // 上架且没有被禁售，店铺是开启状态,
        if (isset($param['keyword']))
        {
            $conditions .= $this->_get_conditions_by_keyword($param['keyword'], ENABLE_SEARCH_CACHE);
        }
        if (isset($param['cate_id']))
        {
            $conditions .= " AND g.cate_id_{$param['layer']} = '" . $param['cate_id'] . "'";
        }
        if (isset($param['brand']))
        {
            $conditions .= " AND g.brand = '" . $param['brand'] . "'";
        }
        if (isset($param['region_id']))
        {
            $conditions .= " AND s.region_id = '" . $param['region_id'] . "'";
        }
        if (isset($param['price']))
        {
            $min = $param['price']['min'];
            $max = $param['price']['max'];
            $min > 0 && $conditions .= " AND g.price >= '$min'";
            $max > 0 && $conditions .= " AND g.price <= '$max'";
        }
		// sku tyioocom 
		if (isset($param['props']))
		{
			$pv_arr = explode(';',$param['props']);
			foreach($pv_arr as $pv)
			{
				if(is_numeric(str_replace(':','',$pv))){ //安全监测，防止sql注入，去掉分号后，监测是否全为数字。
					$conditions .= " AND instr(gp.pvs,'".$pv."')>0 ";
				}
			}
		}

        return $conditions;
    }

    /**
     * 根据查询条件取得分组统计信息
     *
     * @param   array   $param  查询参数（参加函数_get_query_param的返回值说明）
     * @param   bool    $cached 是否缓存
     * @return  array(
     *              'total_count' => 10,
     *              'by_category' => array(id => array('cate_id' => 1, 'cate_name' => 'haha', 'count' => 10))
     *              'by_brand'    => array(array('brand' => brand, 'count' => count))
     *              'by_region'   => array(array('region_id' => region_id, 'region_name' => region_name, 'count' => count))
     *              'by_price'    => array(array('min' => 10, 'max' => 50, 'count' => 10))
     *          )
     */
    function _get_group_by_info($param, $cached)
    {
        $data = false;

        if ($cached)
        {
            $cache_server =& cache_server();
            $key = 'group_by_info_' . var_export($param, true);
            $data = $cache_server->get($key);
        }

        if ($data === false)
        {
            $data = array(
                'total_count' => 0,
                'by_category' => array(),
                'by_brand'    => array(),
                'by_region'   => array(),
                'by_price'    => array()
            );

            $goods_mod =& m('goods');
            $store_mod =& m('store');
			// sku tyioocom
			$goods_pvs_mod =& m('goods_pvs'); 
			$props_mod = &m('props');
			$prop_value_mod = &m('prop_value');
            $table = " {$goods_mod->table} g LEFT JOIN {$store_mod->table} s ON g.store_id = s.store_id LEFT JOIN {$goods_pvs_mod->table} gp ON gp.goods_id=g.goods_id "; 
			// end sku
            $conditions = $this->_get_goods_conditions($param);
            $sql = "SELECT COUNT(*) FROM {$table} WHERE" . $conditions;
            $total_count = $goods_mod->getOne($sql);
            if ($total_count > 0)
            {
                $data['total_count'] = $total_count;
                /* 按分类统计 */
                $cate_id = isset($param['cate_id']) ? $param['cate_id'] : 0;
                $sql = "";
                if ($cate_id > 0)
                {
                    $layer = $param['layer'];
                    if ($layer < 4)
                    {
                        $sql = "SELECT g.cate_id_" . ($layer + 1) . " AS id, COUNT(*) AS count FROM {$table} WHERE" . $conditions . " AND g.cate_id_" . ($layer + 1) . " > 0 GROUP BY g.cate_id_" . ($layer + 1) . " ORDER BY count DESC";
                    }
                }
                else
                {
                    $sql = "SELECT g.cate_id_1 AS id, COUNT(*) AS count FROM {$table} WHERE" . $conditions . " AND g.cate_id_1 > 0 GROUP BY g.cate_id_1 ORDER BY count DESC";
                }

                if ($sql)
                {
                    $category_mod =& bm('gcategory');
                    $children = $category_mod->get_children($cate_id, true);
                    $res = $goods_mod->db->query($sql);
                    while ($row = $goods_mod->db->fetchRow($res))
                    {
                        $data['by_category'][$row['id']] = array(
                            'cate_id'   => $row['id'],
                            'cate_name' => $children[$row['id']]['cate_name'],
                            'count'     => $row['count']
                        );
                    }
                }

                /* 按品牌统计 */
                $sql = "SELECT g.brand, COUNT(*) AS count FROM {$table} WHERE" . $conditions . " AND g.brand > '' GROUP BY g.brand ORDER BY count DESC";
                $by_brands = $goods_mod->db->getAllWithIndex($sql, 'brand');
                
                /* 滤去未通过商城审核的品牌 */
                if ($by_brands)
                {
                    $m_brand = &m('brand');
                    $brand_conditions = db_create_in(addslashes_deep(array_keys($by_brands)), 'brand_name');
                    $brands_verified = $m_brand->getCol("SELECT brand_name FROM {$m_brand->table} WHERE " . $brand_conditions . ' AND if_show=1');
                    foreach ($by_brands as $k => $v)
                    {
                        if (!in_array($k, $brands_verified))
                        {
                            unset($by_brands[$k]);
                        }
                    }
                }
				
				import('init.lib');
				$by_brands = Init_SearchApp::_get_group_by_info_by_brands($by_brands,$param);
				
                $data['by_brand'] = $by_brands;
                
                
                /* 按地区统计 */
                $sql = "SELECT s.region_id, s.region_name, COUNT(*) AS count FROM {$table} WHERE" . $conditions . " AND s.region_id > 0 GROUP BY s.region_id ORDER BY count DESC";
				
				$by_regions = Init_SearchApp::_get_group_by_info_by_region($sql,$param);
                $data['by_region'] = $by_regions;
				/*  end  */
				

                /* 按价格统计 */
                if ($total_count > NUM_PER_PAGE)
                {
                    $sql = "SELECT MIN(g.price) AS min, MAX(g.price) AS max FROM {$table} WHERE" . $conditions;
                    $row = $goods_mod->getRow($sql);
                    $min = $row['min'];
                    $max = min($row['max'], MAX_STAT_PRICE);
                    $step = max(ceil(($max - $min) / PRICE_INTERVAL_NUM), MIN_STAT_STEP);
                    $sql = "SELECT FLOOR((g.price - '$min') / '$step') AS i, count(*) AS count FROM {$table} WHERE " . $conditions . " GROUP BY i ORDER BY i";
                    $res = $goods_mod->db->query($sql);
                    while ($row = $goods_mod->db->fetchRow($res))
                    {
                        $data['by_price'][] = array(
                            'count' => $row['count'],
                            'min'   => $min + $row['i'] * $step,
                            'max'   => $min + ($row['i'] + 1) * $step,
                        );
                    }
                }
				
				// sku tyioocom  按 属性统计 
				$sql = "SELECT gp.* FROM {$table} WHERE " . $conditions . " AND gp.pvs > '' ";
				$prop_list = $goods_mod->getAll($sql);
				$pvs = '';
				foreach($prop_list as $key => $prop) {
					$pvs .=';' . $prop['pvs'];
				}
				$pvs = substr($pvs,1);// 去掉前面的";"
				$props_data = array();
				if(!empty($pvs))
				{
				   $pv_arr = array_unique(explode(';',$pvs));// 去除重复值，形成新的数组
				   $pid = 0;
				   $prop_value = array();
				
				   //  先排序
				   foreach ($pv_arr as $key => $row) {
					  $volume[$key]  = $row[0];
				   }
				   array_multisort($volume,SORT_DESC,$pv_arr); // 排序后才能做以下 $pid!=$item[0] 的判断
				   
				   /* 检查属性名和属性值是否存在，有可能是之前有，但后面删除了 */
				   foreach($pv_arr as $key=>$pv)
				   {
					   if($pv)
					   {
					   		$item = explode(':',$pv);
					   		$check_prop = $props_mod->get(array('conditions'=>'pid='.$item[0].' AND status=1','fields'=>'pid'));
					   
					   		// 如果属性名存在，则检查该属性名下的当前属性值是否存在
					   		if($check_prop)
					   		{
						   		$check_prop_value = $prop_value_mod->get(array('conditions'=>'pid='.$item[0].' AND vid='.$item[1].' and status=1','fields'=>'vid'));
						   		if(!$check_prop_value){
							   		unset($pv_arr[$key]);
						   		}
					   		} else {
						   		unset($pv_arr[$key]);
					  		}
					   }
				   }
				
				   //  将当前的筛选数据除掉
				   $p = array();
				   if(!empty($_GET['props']))
				   {
					   foreach(explode(';',$_GET['props']) as $pv)
					   {
						   $pv = explode(':',$pv);
						   $p[] = $pv[0];
					   }
					   $p = array_unique($p);
				   }
				   //  end 当前的筛选数据除掉
				   
				   
				   foreach($pv_arr as $key=>$pv)
				   {
					   $item = explode(':',$pv);
					   if(!empty($item[1]) && !in_array($item[0],$p)) //  如果参数已经筛选过了，那么就屏蔽掉。
					   { 

					      $props = $props_mod->get(array('conditions'=>'status=1 and pid='.$item[0],'fields'=>'name,pid'));
					      $props_data[$item[0]] = $props;
					      if ($pid!=$item[0]) { // 不是同一个 pid 的属性值，不做累加
					         $prop_value = array();
					         $pid = $item[0];
				          }
					      $prop_value[] = $prop_value_mod->get(array('conditions'=>'status=1 and pid='.$item[0].' and vid='.$item[1],'fields'=>'prop_value,vid,pid'));

				          $props_data[$item[0]] += array('value'=>$prop_value);
					   }
				   }
				}
				$data['by_props'] = $props_data;
				
            }

            if ($cached)
            {
                $cache_server->set($key, $data, SEARCH_CACHE_TTL);
            }
        }

        return $data;
    }
  function _get_default_order(){
      $fields = array('sales','price','add_time','comments','credit_value','views');
      $field = array_rand($fields);
      $field =$fields[$field];
      $rand = rand(1,100);
      if($rand%2 == 0){
          $field .= " ASC";
      }else{
          $field .= " DESC";
      }
  return $field;
  }
  


    /**
     * 根据关键词取得查询条件（可能是like，也可能是in）
     *
     * @param   array       $keyword    关键词
     * @param   bool        $cached     是否缓存
     * @return  string      " AND (0)"
     *                      " AND (goods_name LIKE '%a%' AND goods_name LIKE '%b%')"
     *                      " AND (goods_id IN (1,2,3))"
     */
    function _get_conditions_by_keyword($keyword, $cached)
    {
        $conditions = false;

        if ($cached)
        {
            $cache_server =& cache_server();
            $key1 = 'query_conditions_of_keyword_' . join("\t", $keyword);
            $conditions = $cache_server->get($key1);
        }

        if ($conditions === false)
        {
            /* 组成查询条件 */
            $conditions = array();
            foreach ($keyword as $word)
            {
                $conditions[] = "g.goods_name LIKE '%{$word}%'";
            }
            $conditions = join(' AND ', $conditions);

            /* 取得满足条件的商品数 */
            $goods_mod =& m('goods');
            $sql = "SELECT COUNT(*) FROM {$goods_mod->table} g WHERE " . $conditions;
            $current_count = $goods_mod->getOne($sql);
            if ($current_count > 0)
            {
                if ($current_count < MAX_ID_NUM_OF_IN)
                {
                    /* 取得商品表记录总数 */
                    $cache_server =& cache_server();
                    $key2 = 'record_count_of_goods';
                    $total_count = $cache_server->get($key2);
                    if ($total_count === false)
                    {
                        $sql = "SELECT COUNT(*) FROM {$goods_mod->table}";
                        $total_count = $goods_mod->getOne($sql);
                        $cache_server->set($key2, $total_count, SEARCH_CACHE_TTL);
                    }

                    /* 不满足条件，返回like */
                    if (($current_count / $total_count) < MAX_HIT_RATE)
                    {
                        /* 取得满足条件的商品id */
                        $sql = "SELECT goods_id FROM {$goods_mod->table} g WHERE " . $conditions;
                        $ids = $goods_mod->getCol($sql);
                        $conditions = 'g.goods_id' . db_create_in($ids);
                    }
                }
            }
            else
            {
                /* 没有满足条件的记录，返回0 */
                $conditions = "0";
            }

            if ($cached)
            {
                $cache_server->set($key1, $conditions, SEARCH_CACHE_TTL);
            }
        }

        return ' AND (' . $conditions . ')';
    }

    /* 商品排序方式  edit  tyioocom  */
    function _get_orders()
    {
        return array(
            ''             => Lang::get('default_order'),
            'sales'        => Lang::get('sales_desc'),
			'price'        => Lang::get('price'),
			'add_time'     => Lang::get('add_time'),
			'comments'     => Lang::get('comment'),
            'credit_value' => Lang::get('credit_value'),
            'views'        => Lang::get('views')
        );
    }
    
    function _get_seo_info($type, $cate_id)
    {
        $seo_info = array(
            'title'       => '',
            'keywords'    => '',
            'description' => ''
        );
        $parents = array(); // 所有父级分类包括本身
        switch ($type)
        {
            case 'goods':                
                if ($cate_id)
                {
                    $gcategory_mod =& bm('gcategory');
                    $parents = $gcategory_mod->get_ancestor($cate_id, true);
                    $parents = array_reverse($parents);
                }
                $filters = $this->_get_filter($this->_get_query_param());
                foreach ($filters as $k => $v)
                {
                    $seo_info['keywords'] .= $v['value']  . ',';
                }
                break;
            case 'store':
                if ($cate_id)
                {
                    $scategory_mod =& m('scategory');
                    $scategory_mod->get_parents($parents, $cate_id);
                    $parents = array_reverse($parents);
                }
        }
        
        foreach ($parents as $key => $cate)
        {
            $seo_info['title'] .= $cate['cate_name'] . ' - ';
            $seo_info['keywords'] .= $cate['cate_name']  . ',';
            if ($cate_id == $cate['cate_id'])
            {
                $seo_info['description'] = $cate['cate_name'] . ' ';
            }
        }
        $seo_info['title'] .= Lang::get('searched_'. $type) . ' - ' .Conf::get('site_title');
        $seo_info['keywords'] .= Conf::get('site_title');
        $seo_info['description'] .= Conf::get('site_title');
        return $seo_info;
    }
}

?>
