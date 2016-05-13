<?php

class DefaultApp extends MallbaseApp
{
    function index()
    {
        $this->assign('index', 1); // 标识当前页面是首页，用于设置导航状态
        $this->assign('icp_number', Conf::get('icp_number'));
		$promotions=& m("promotion");
		$nowtime=gmtime();
		$promotion_list = $promotions->find(
            array(
                'join' => 'belong_goods',
                'conditions' => "end_time >".$nowtime,
                'order' => 'pro.pro_id DESC',
            )
        );
		foreach ($promotion_list as $key => $promotion)
		{
			$promotion['spec_price'] = unserialize($promotion['spec_price']);
			if($promotion['spec_price'][$promotion['default_spec']]['is_pro']==1)
			{
				if($promotion['spec_price'][$promotion['default_spec']]['pro_type'] == 'price') // 这里是计算默认规格的价格
				{
					$promotion_list[$key]['pro_price'] = round($promotion['price'] - $promotion['spec_price'][$promotion['default_spec']]['price'],2);
				}
				else
				{
					$promotion_list[$key]['pro_price'] = round($promotion['price'] * $promotion['spec_price'][$promotion['default_spec']]['price'] / 10,2);
				}
				$promotion_list[$key]["discount"]=number_format(($promotion['price']-$promotion_list[$key]['pro_price'])/$promotion['price'],2)*10;
			}
			else{
				$promotion_list[$key]['pro_price'] = $promotion['price'];// 如果默认规格没有设置促销，则显示原价
			}
			$promotioin['default_image'] || $promotioin_list[$key]['default_image'] = Conf::get('default_goods_image');
			$promotion_list[$key]["lefttime"]=ceil((strtotime(date("Y-m-d H:i:s",$promotion_list[$key]["end_time"]))-strtotime(date("Y-m-d H:i:s",gmtime())))/86400);
		}
		
		
		if ($_GET['tuijian_id'])
		{
			$_SESSION['referid']=$_GET['tuijian_id'];
		}
      
	  	if ($_GET['tuijian_id'])
		{
			$_SESSION['tuijian_id']=$_GET['tuijian_id'];
		}

        $this->_config_seo(array(
            'title' => Conf::get('site_title'),
        ));
        $this->assign('page_description', Conf::get('site_description'));
        $this->assign('page_keywords', Conf::get('site_keywords'));
        $this->assign('promotion_list', $promotion_list);
        $this->display('index.html');
    }
    function wapview()
    {
        /* 店铺预览 */
        $this->assign('id', intval($_GET['id']));
        $this->display('index.wapview.html');
    }
    
    function version(){
        echo 'ecmall_140525_687010903011654';
    }
	
	function back_login()
	{
		$id = empty($_GET['id']) ? 0 : intval($_GET['id']);
		$key = trim($_GET['key']);
		if(!$id || empty($key))
		{
			header('Location: index.php');
			return;
		}
		$user_mod = &m('member');
		$user = $user_mod->get($id);
		$check_key = md5($user['user_id'].$user['user_name'].$user['password'].$user['last_login'].$user['last_ip']);
		if($key == $check_key)
		{
			/* 同步登陆外部系统 */
			$ms =& ms();
			 /* 通过验证，执行登陆操作 */
			$this->_do_login($id);
	
			/* 同步登陆外部系统 */
			$synlogin = $ms->user->synlogin($id);
	
			$this->show_message(Lang::get('login_successed'),
					'back_before_login', 'index.php?app=member'
				);
		}
		else
		{
			header('Location: index.php');
			return;
		}
	}
	function paimai(){
		$r_goods=&m("goods");
		$goods_list = $r_goods->find(array(
			"conditions" =>"recommended =1",
			"order"      => 'add_time desc',
		));
		foreach ($goods_list as $key => $goods)
		{
			$goods_list[$key]['cate_name'] = $r_goods->format_cate_name($goods['cate_name']);
		}
		$this->assign('goods_list', $goods_list);
		$this->display("paimai.html");
	}
	function groupbuy(){
		$groupbuy_mod = &m('groupbuy');
		$nowtime=gmtime();
		$groupbuy_list_wapfpai = $groupbuy_mod->find(array(
				'conditions'    => "gb.end_time >".$nowtime,
				'fields'        => 'gb.*,g.default_image,g.price,default_spec,s.store_name',
				'join'          => 'belong_store, belong_goods',			
				'order'         => isset($_GET['order']) && isset($orders[$_GET['order']]) ? $_GET['order'] : 'group_id desc',
		));
		if ($ids = array_keys($groupbuy_list_wapfpai))
		{
			$quantity = $groupbuy_mod->get_join_quantity($ids);
		}
		foreach ($groupbuy_list_wapfpai as $key => $groupbuy)
		{
			$groupbuy_list_wapfpai[$key]['quantity'] = empty($quantity[$key]['quantity']) ? 0 : $quantity[$key]['quantity'];
			$groupbuy['default_image'] || $groupbuy_list_wapfpai[$key]['default_image'] = Conf::get('default_goods_image');
			$groupbuy['spec_price'] = unserialize($groupbuy['spec_price']);
			$groupbuy_list_wapfpai[$key]['group_price'] = $groupbuy['spec_price'][$groupbuy['default_spec']]['price'];
			$groupbuy['state'] == GROUP_ON && $groupbuy_list_wapfpai[$key]['lefttime'] = lefttime($groupbuy['end_time']);
			if($groupbuy['price'] != 0){
				$groupbuy_list_wapfpai[$key]['discount'] = round($groupbuy['spec_price'][$groupbuy['default_spec']]['price'] / $groupbuy['price'] * 10,1);
			} else {
				$groupbuy_list_wapfpai[$key]['discount'] = 0;
			}
		}
		$this->assign("groupby",$groupbuy_list_wapfpai);
		$this->display("tuangou.html");
	}
	function stores(){
	    $model_store =& m('store');
        $regions = $model_store->list_regions();
        $stores = $model_store->find(array(
            'conditions'  => 'state = ' . STORE_OPEN,
			'fields'  =>'store_name,user_name,sgrade,store_logo,praise_rate,credit_value,s.im_qq,im_ww,business_scope,region_name,description',
            'order'   => empty($_GET['order']) || !in_array($_GET['order'], $orders) ? 'sort_order' : $_GET['order'], //  tyioocom $orders
            'join'    => 'belongs_to_user,has_scategory',

        ));

        $model_goods = &m('goods');
		$order_mod=&m('order');
		$sgrade_mod=&m('sgrade');

        foreach ($stores as $key => $store)
        {
			$goods_list = $model_goods->find(array(
				'conditions'=>'store_id='. $store['store_id'],
				'order'     =>'add_time desc',
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
        $this->assign('stores', $stores);
		$this->display("wx_stores.html");
	}
	
}

?>