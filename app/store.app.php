<?php

class StoreApp extends StorebaseApp
{
    //360cd.cn    
    function setWapStore($store_id)
    {
        //360cd.cn
        $store_model=&m('store');
        $where=$store_id;       
        $store_data=$store_model->get($where);
        if(!$store_data)
        {
            //此处填写数据不存在内容
            return;
        }
        $themes=explode('|', $store_data['waptheme']);
        if($themes[0]=='zlstore')
        {
            $_SESSION['wapstore']='zlstore';
            $_SESSION['wapstore_id']=$store_id;
        }else{
			$_SESSION['wapstore']='';
            $_SESSION['wapstore_id']=$store_id;
		}
        //360cd.cn
    }

    function map()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }
        //360cd.cn
        $this->setWapStore($id);
        //360cd.cn
        $this->set_store($id);
        $store = $this->get_store_data();
        $this->assign('store', $store);
        $this->display('store.map.html');
    }

    function ajax_search()
    { 
        header("Content-type: text/html; charset=utf-8");
        /* 店铺信息 */
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }
        //360cd.cn
        $this->setWapStore($id);
        //360cd.cn
        $this->set_store($id);
        $store = $this->get_store_data();
        $this->assign('store', $store);

        /* 搜索到的商品 */
        $this->_assign_searched_goods($id);

        /* 当前位置 */
        $this->_curlocal(LANG::get('all_stores'), 'index.php?app=search&amp;act=store',
            $store['store_name'], 'index.php?app=store&amp;id=' . $store['store_id'],
            LANG::get('goods_list')
        );

        $this->_config_seo('title', Lang::get('goods_list') . ' - ' . $store['store_name']);
        $this->display('store.search.ajax.html');
    }
    //360cd.cn
    function index()
    {
        /* 店铺信息 */
        $_GET['act'] = 'index';
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }
        //360cd.cn
        $this->setWapStore($id);
        //360cd.cn
        $this->set_store($id);
        $store = $this->get_store_data();
        $this->assign('store', $store);
        
        if ($store['pic_slides_wap']) {
            $pic_slides_wap_arr = json_decode($store['pic_slides_wap'], true);
            foreach ($pic_slides_wap_arr as $key => $slides) {
                $pic_slides_wap[$key]['image_url'] = $slides['url'];
                $pic_slides_wap[$key]['image_link'] = $slides['link'];
            }
            $this->assign('goods_images', $pic_slides_wap);
        }
        

        /* 取得友情链接 */
        $this->assign('partners', $this->_get_partners($id));

        /* 取得推荐商品 */
        $this->assign('recommended_goods', $this->_get_recommended_goods($id));
        $this->assign('new_groupbuy', $this->_get_new_groupbuy($id));
        $this->assign('groupbuy_list', $this->_get_new_groupbuy($id));

        /* 取得最新商品 */
        $this->assign('new_goods', $this->_get_new_goods($id));
		  /* 加载金蛋抽奖*/
	    $this->assign('jindan', $this->_jindan($id));
		
		/* 取得热卖商品 */
		$this->assign('hot_sale_goods', $this->_get_hot_sale_goods($id));

        /* 当前位置 */
        $this->_curlocal(LANG::get('all_stores'), 'index.php?app=search&amp;act=store', $store['store_name']);

        $this->_config_seo('title', $store['store_name'] . ' - ' . Conf::get('site_title'));
        /* 配置seo信息 */
        $this->_config_seo($this->_get_seo_info($store));
		$this->assign('page_title', $store['store_name'] . ' - 配送范围：' . $store['send_address']);
        $this->display('store.index.html');
    }

    function search()
    {
        /* 店铺信息 */
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }
        //360cd.cn
        $this->setWapStore($id);
        //360cd.cn
        $this->set_store($id);
        $store = $this->get_store_data();
        $this->assign('store', $store);

        /* 搜索到的商品 */
        $this->_assign_searched_goods($id);

        /* 当前位置 */
        $this->_curlocal(LANG::get('all_stores'), 'index.php?app=search&amp;act=store',
            $store['store_name'], 'index.php?app=store&amp;id=' . $store['store_id'],
            LANG::get('goods_list')
        );

        $this->_config_seo('title', Lang::get('goods_list') . ' - ' . $store['store_name']);
        $this->display('store.search.html');
    }

    function groupbuy()
    {
        /* 店铺信息 */
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }
        //360cd.cn
        $this->setWapStore($id);
        //360cd.cn
        $this->set_store($id);
        $store = $this->get_store_data();
        $this->assign('store', $store);

        /* 搜索团购 */
        empty($_GET['state']) &&  $_GET['state'] = 'on';
        $conditions = '1=1';
        if ($_GET['state'] == 'on')
        {
            $conditions .= ' AND gb.state ='. GROUP_ON .' AND gb.end_time>' . gmtime();
            $search_name = array(
                array(
                    'text'  => Lang::get('group_on')
                ),
                array(
                    'text'  => Lang::get('all_groupbuy'),
                    'url'  => url('app=store&act=groupbuy&state=all&id=' . $id)
                ),
            );
        }
        else if ($_GET['state'] == 'all')
        {
            $conditions .= ' AND gb.state '. db_create_in(array(GROUP_ON,GROUP_END,GROUP_FINISHED));
            $search_name = array(
                array(
                    'text'  => Lang::get('all_groupbuy')
                ),
                array(
                    'text'  => Lang::get('group_on'),
                    'url'  => url('app=store&act=groupbuy&state=on&id=' . $id)
                ),
            );
        }

        $page = $this->_get_page(16);
        $groupbuy_mod = &m('groupbuy');
        $groupbuy_list = $groupbuy_mod->find(array(
            'fields'    => 'goods.default_image, gb.group_name, gb.group_id, gb.spec_price, gb.end_time, gb.state',
            'join'      => 'belong_goods',
            'conditions'=> $conditions . ' AND gb.store_id=' . $id ,
            'order'     => 'group_id DESC',
            'limit'     => $page['limit'],
            'count'     => true
        ));
        $page['item_count'] = $groupbuy_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);
        if (empty($groupbuy_list))
        {
            $groupbuy_list = array();
        }
        foreach ($groupbuy_list as $key => $_g)
        {
            empty($groupbuy_list[$key]['default_image']) && $groupbuy_list[$key]['default_image'] = Conf::get('default_goods_image');
            $tmp = current(unserialize($_g['spec_price']));
            $groupbuy_list[$key]['price'] = $tmp['price'];
            if ($_g['end_time'] < gmtime())
            {
                $groupbuy_list[$key]['group_state'] = group_state($_g['state']);
            }
            else
            {
                $groupbuy_list[$key]['lefttime'] = lefttime($_g['end_time']);
            }
        }
        /* 当前位置 */
        $this->_curlocal(LANG::get('all_stores'), 'index.php?app=search&amp;act=store',
            $store['store_name'], 'index.php?app=store&amp;id=' . $store['store_id'],
            LANG::get('groupbuy_list')
        );

        $this->assign('groupbuy_list', $groupbuy_list);
        $this->assign('search_name', $search_name);
        $this->_config_seo('title', $search_name[0]['text'] . ' - ' . $store['store_name']);
        $this->display('store.groupbuy.html');
    }
    
    function article_index()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }
        //360cd.cn
        $this->setWapStore($id);
        //360cd.cn
        $article_mod =& m('article');
        $articles = $article_mod->find(
                array(
                    'conditions'=> 'store_id=' . $id ,
                )
        );
        $this->assign('articles', $articles);
        $this->display('store.article_index.html');
    }
    
    function article()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }
        //360cd.cn
        $this->setWapStore($id);
        //360cd.cn
        $article = $this->_get_article($id);
        if (!$article)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }
        $this->assign('article', $article);

        /* 店铺信息 */
        $this->set_store($article['store_id']);
        $store = $this->get_store_data();
        $this->assign('store', $store);

        /* 当前位置 */
        $this->_curlocal(LANG::get('all_stores'), 'index.php?app=search&amp;act=store',
            $store['store_name'], 'index.php?app=store&amp;id=' . $store['store_id'],
            $article['title']
        );

        $this->_config_seo('title', $article['title'] . ' - ' . $store['store_name']);
        $this->display('store.article.html');
    }

    /* 信用评价 */
    function credit()
    {
        /* 店铺信息 */
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }
        //360cd.cn
        $this->setWapStore($id);
        //360cd.cn
        $this->set_store($id);
        $store = $this->get_store_data();
        $this->assign('store', $store);
        /* 取得评价过的商品 */
        if (!empty($_GET['eval']) && in_array($_GET['eval'], array(1,2,3)))
        {
            $conditions = "AND evaluation = '{$_GET['eval']}'";
        }
        else
        {
            $conditions = "";
            $_GET['eval'] = '';
        }
        $page = $this->_get_page(10);
        $order_goods_mod =& m('ordergoods');
        $goods_list = $order_goods_mod->find(array(
            'conditions' => "seller_id = '$id' AND evaluation_status = 1 AND is_valid = 1 " . $conditions,
            'join'       => 'belongs_to_order',
            'fields'     => 'buyer_id, buyer_name, anonymous, evaluation_time, goods_id, goods_name, specification, price, quantity, goods_image, evaluation, comment',
            'order'      => 'evaluation_time desc',
            'limit'      => $page['limit'],
            'count'      => true,
        ));
        $this->assign('goods_list', $goods_list);

        $page['item_count'] = $order_goods_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);

        /* 按时间统计 */
        $stats = array();
        for ($i = 0; $i <= 3; $i++)
        {
            $stats[$i]['in_a_week']        = 0;
            $stats[$i]['in_a_month']       = 0;
            $stats[$i]['in_six_month']     = 0;
            $stats[$i]['six_month_before'] = 0;
            $stats[$i]['total']            = 0;
        }

        $goods_list = $order_goods_mod->find(array(
            'conditions' => "seller_id = '$id' AND evaluation_status = 1 AND is_valid = 1 ",
            'join'       => 'belongs_to_order',
            'fields'     => 'evaluation_time, evaluation',
        ));
        foreach ($goods_list as $goods)
        {
            $eval = $goods['evaluation'];
            $stats[$eval]['total']++;
            $stats[0]['total']++;

            $days = (gmtime() - $goods['evaluation_time']) / (24 * 3600);
            if ($days <= 7)
            {
                $stats[$eval]['in_a_week']++;
                $stats[0]['in_a_week']++;
            }
            if ($days <= 30)
            {
                $stats[$eval]['in_a_month']++;
                $stats[0]['in_a_month']++;
            }
            if ($days <= 180)
            {
                $stats[$eval]['in_six_month']++;
                $stats[0]['in_six_month']++;
            }
            if ($days > 180)
            {
                $stats[$eval]['six_month_before']++;
                $stats[0]['six_month_before']++;
            }
        }
        $this->assign('stats', $stats);

        /* 当前位置 */
        $this->_curlocal(LANG::get('all_stores'), 'index.php?app=search&amp;act=store',
            $store['store_name'], 'index.php?app=store&amp;id=' . $store['store_id'],
            LANG::get('credit_evaluation')
        );

        $this->_config_seo('title', Lang::get('credit_evaluation') . ' - ' . $store['store_name']);
        $this->display('store.credit.html');
    }

    /* 取得友情链接 */
    function _get_partners($id)
    {
        $partner_mod =& m('partner');
        return $partner_mod->find(array(
            'conditions' => "store_id = '$id'",
            'order' => 'sort_order',
        ));
    }

    /* 取得推荐商品 */
    function _get_recommended_goods($id, $num = 12)
    {
        $goods_mod =& bm('goods', array('_store_id' => $id));
        $goods_list = $goods_mod->find(array(
            'conditions' => "closed = 0 AND if_show = 1 AND recommended = 1",
            'fields'     => 'goods_name, default_image, price',
            'limit'      => $num,
        ));
        foreach ($goods_list as $key => $goods)
        {
            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');
        }

        return $goods_list;
    }

    function _get_new_groupbuy($id, $num = 12)
    {
        $model_groupbuy =& m('groupbuy');
        $groupbuy_list = $model_groupbuy->find(array(
            'fields'    => 'goods.default_image, this.group_name, this.group_id, this.spec_price, this.end_time',
            'join'      => 'belong_goods',
            'conditions'=> $model_groupbuy->getRealFields('this.state=' . GROUP_ON . ' AND this.store_id=' . $id . ' AND end_time>'. gmtime()),
            'order'     => 'group_id DESC',
            'limit'     => $num
        ));
        if (empty($groupbuy_list))
        {
            $groupbuy_list = array();
        }
        foreach ($groupbuy_list as $key => $_g)
        {
            empty($groupbuy_list[$key]['default_image']) && $groupbuy_list[$key]['default_image'] = Conf::get('default_goods_image');
            $tmp = current(unserialize($_g['spec_price']));
            $groupbuy_list[$key]['price'] = $tmp['price'];
            $groupbuy_list[$key]['group_price'] = $tmp['price'];
            $groupbuy_list[$key]['lefttime'] = lefttime($_g['end_time']);
        }

        return $groupbuy_list;
    }

    /* 取得最新商品 */
    function _get_new_goods($id, $num = 12)
    {
        $goods_mod =& bm('goods', array('_store_id' => $id));
        $goods_list = $goods_mod->find(array(
            'conditions' => "closed = 0 AND if_show = 1",
            'fields'     => 'goods_name, default_image, price',
            'order'      => 'add_time desc',
            'limit'      => $num,
        ));
        foreach ($goods_list as $key => $goods)
        {
            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');
        }

        return $goods_list;
    }
	/* 取得热卖商品 */
	function _get_hot_sale_goods($id, $num = 16)
	{
		$goods_mod =& bm('goods', array('_store_id' => $id));
        $goods_list = $goods_mod->find(array(
            'conditions' => "closed = 0 AND if_show = 1",
			'join'		 => 'has_goodsstatistics',
            'fields'     => 'goods_name, default_image, price,sales',
            'order'      => 'sales desc,add_time desc',
            'limit'      => $num,
        ));
        foreach ($goods_list as $key => $goods)
        {
            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');
        }
        return $goods_list;
	}

    /* 搜索到的结果 */
    function _assign_searched_goods($id)
    {
        $goods_mod =& bm('goods', array('_store_id' => $id));
        $search_name = LANG::get('all_goods');

        $conditions = $this->_get_query_conditions(array(
            array(
                'field' => 'goods_name',
                'name'  => 'keyword',
                'equal' => 'like',
            ),
             array(
                'field' => 'g.recommended',
                'name'  => 'recommended',
                'equal' => '=',
                'type'  => 'numeric',
            ),
        ));

        if(isset($_GET['keyword']))//取到关键词
        {
        	$this->assign('keyword',$_GET['keyword']);
        }
        if ($conditions)
        {
            $search_name = sprintf(LANG::get('goods_include'), $_GET['keyword']);
            $sgcate_id   = 0;
        }
        else
        {
            $sgcate_id = empty($_GET['cate_id']) ? 0 : intval($_GET['cate_id']);
            $this->assign('cate_id',$sgcate_id);//类别ID
        }
    
        if ($sgcate_id > 0)
        {
            $gcategory_mod =& bm('gcategory', array('_store_id' => $id));
            $sgcate = $gcategory_mod->get_info($sgcate_id);
            $search_name = $sgcate['cate_name'];

            $sgcate_ids = $gcategory_mod->get_descendant_ids($sgcate_id);
        }
        else
        {
            $sgcate_ids = array();
        }

        /* 排序方式 */
        $orders = array(
            'add_time' => LANG::get('add_time_desc'),
            'price' => LANG::get('price_asc'),
            'price' => LANG::get('price_desc'),
            'views'=>'人气',
            'sales'=>'卖出数量',
        );
     if(isset($_GET['order']))//排序
     {
     	switch ($_GET['order'])
     	{
     		case 'add_time':$sort=1;break;
     		case 'price':$sort=2;break;
     		case 'views':$sort=3;break;
     		case 'sales':$sort=4;break;
     	}
     	$this->assign('sort',$sort);
     }
        $this->assign('orders', $orders);
        
        $page = $this->_get_page(20);
		
        $goods_list = $goods_mod->get_list(array(
            'conditions' => 'closed = 0 AND if_show = 1' . $conditions,
			'count' => true,
            'order' => empty($_GET['order'])  ? 'add_time desc' : $_GET['order'],
            'limit' => $page['limit'],
        ), $sgcate_ids);
     
        foreach ($goods_list as $key => $goods)
        {
            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');
        }
        $this->assign('searched_goods', $goods_list);

        $page['item_count'] = $goods_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);
        
        $this->assign('search_name', $search_name);
    }

    /**
     * 取得文章信息
     */
    function _get_article($id)
    {
        $article_mod =& m('article');
        return $article_mod->get_info($id);
    }
    
    function _get_seo_info($data)
    {
        $seo_info = $keywords = array();
        $seo_info['title'] = $data['store_name'] . ' - ' . Conf::get('site_title');        
        $keywords = array(
            str_replace("\t", ' ', $data['region_name']),
            $data['store_name'],
        );
        //$seo_info['keywords'] = implode(',', array_merge($keywords, $data['tags']));
        $seo_info['keywords'] = implode(',', $keywords);
        $seo_info['description'] = sub_str(strip_tags($data['description']), 10, true);
        return $seo_info;
    }
	
	//设置店铺金蛋随机显示
	 function _jindan($id)
    {
        
	   $edit_sql1 = &db();
	   $shangjia = $edit_sql1->getrow("select * from ecm_jindan_shop where shop_id=".$id);
	   $x = rand(1,1024);
	   $y = rand(1,1024);
	   
	   if($shangjia['jindan_num']){
			$abc = rand(1,100);
			if($abc<60){
			$zaba = '<div style="position:absolute; top:'.$x.'px; left:'.$y.'px; z-index:1024;"><form action="http://www.boyago.net/index.php?app=store&act=zajindan" method="post" ><input name="shop_id" value="'.$id.'"  type="hidden"/><input type="submit" name="submit" value="" class="zajindan" /></form></div>';
			}
		   return $zaba;
		   }	
    }
	
	
	 function zajindan()
    { 
	   $dandan_1 = Conf::get('dandan_1');
	   $dandan_2 = Conf::get('dandan_2');
	   $dandan_3 = Conf::get('dandan_3');
	   $dandan_4 = Conf::get('dandan_4');
	    $user_id = $this->visitor->get("user_id");  
		if(!$user_id){
		   $this->show_warning('您还没有登陆');
            return;
		   }
       if($_POST){
	  
	  $shop_id = $_POST['shop_id'];
	  $edit_sql1 = &db();	  
	  $shangjia = $edit_sql1->getrow("select * from ecm_jindan_shop where shop_id=".$shop_id);
	  $user_sql = &db();
	  $count = "select count(id) from ecm_jindan_log where user_id=".$user_id." and stime = ".strtotime(date("y-m-d",time()));
	  $user_cishu = $user_sql->getone($count); 
	  $count2 = "select count(id) from ecm_jindan_log where user_id=".$user_id." and shop_id = ".$shop_id." and stime = ".strtotime(date("y-m-d",time()));
	  $user_cishu2 = $user_sql->getone($count2); 
	  $usersql = "select * from ecm_my_money  where user_id=".$user_id;
	  $userinfo= $user_sql->getRow($usersql); 
	  //print_r($userinfo);
	  
	   $add_sql = &db();
		$gailv = rand(1,100000);
		
		
		$jiner1 = explode(',',$dandan_4);
		$jiner2 = count($jiner1);
		$jiner3 = rand(0,$jiner2);
		$jiner = $jiner1[$jiner3];
		$stime = strtotime(date("y-m-d",time()));
		 if($user_cishu > $dandan_1){
				   $this->show_warning('每个店铺每天只可以抽奖'.$dandan_1.'次，到别的店铺试试手气吧');
				   return; 
				   }
			   if($user_cishu2 > $dandan_2){
				   $this->show_warning('每个会员每天只可以抽奖'.$dandan_2.'次,明天再来试试手气吧');
				   return;  
				   }
		if($gailv < $dandan_3){		
	  	 if($shangjia['jindan_num'] > $jiner){//店铺金币足够
			  
	   		   if($jiner >0){
				$add_sql->query("insert into ecm_jindan_log(id,shop_id,user_id,jiner,stime) values('','$shop_id','$user_id','$jiner','$stime')");//增加抽奖记录
				
				$gerenzengjia = $userinfo['money']+$jiner;
				$add_sql->query("UPDATE `ecm_my_money` SET `money` = ".$gerenzengjia."  WHERE `user_id` =".$user_id);//增加会员资金
				
				$shangjiajianshao =  $shangjia['jindan_num'] - $jiner;
				$add_sql->query("UPDATE `ecm_jindan_shop` SET `jindan_num` = ".$shangjiajianshao." WHERE `shop_id` =".$shop_id);//增加抽奖记录
				$this->show_message('恭喜您得到'.$jiner.'个金币'); //中奖提示
			 
				return;
				}else{
				$add_sql->query("insert into ecm_jindan_log(id,shop_id,user_id,jiner,stime) values('','$shop_id','$user_id','0','$stime')");
				$this->show_warning('别失望，继续努力'); //没中奖提示
				return;
				}
		
		 }else{
			
			$this->show_warning('该店铺金币不足'); //没中奖提示
            return;
			}
		 }else{ //店铺金币不足
		 $add_sql->query("insert into ecm_jindan_log(id,shop_id,user_id,jiner,stime) values('','$shop_id','$user_id','0','$stime')");
		 $this->show_warning('别失望，继续努力'); //金币不足提示
          return;  
			   }
	   
	   
	   
	   }
	  $this->show_warning('不能直接访问'); //金币不足提示
    }
}

?>
