<?php

/* 商品 */
class GoodsApp extends StorebaseApp
{
    var $_goods_mod;
	var $_gradegoods_mod;//by cengnlaeng
		var $_ju_mod;
    function __construct()
    {
        $this->GoodsApp();
    }
    function GoodsApp()
    {
        parent::__construct();
        $this->_goods_mod =& m('goods');
		$this->_gradegoods_mod=&m('gradegoods');//by cengnlaeng
		$this->_ju_mod = &m('ju');
    }

    function index()
    {
		
		if($this->visitor->get('user_id') && !$_GET['name'])
		{
			
			
		
		header("Location: index.php?app=goods&id=$_GET[id]&name=".$this->visitor->get('user_id'));

		}
		
		
		 if($_GET['name'] !=$this->visitor->get('user_id'))
		{
	
		$_SESSION['name']=$_GET['name'];
		$_SESSION[goods_id]=$_GET['id'];
		}else{
			
	   if($_SESSION[goods_id]!=$_GET['id'])
	   {
		 
		$_SESSION[name]='';  
	   }		
		
			
	  }
	  
	
		
        /* 参数 id */
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }

        /* 可缓存数据 */
        $data = $this->_get_common_info($id);
        if ($data === false)
        {
            return;
        }
        else
        {
            $this->_assign_common_info($data);
        }
        
        if(ECMALL_WAP == 1){
            $data = $this->_get_goods_comment($id, 10);
            $this->_assign_goods_comment($data);
        }

        /* 更新浏览次数 */
        $this->_update_views($id);
		
		$ju = $this->_ju_mod->get(array(
			'join' => 'belong_template',
			'conditions' => 'goods_id='.$id,
			'fields' => 'this.group_id,this.status,jt.state',
		));
		$this->assign('ju',$ju);

        //是否开启验证码
        if (Conf::get('captcha_status.goodsqa'))
        {
            $this->assign('captcha', 1);
        }
		
		// sku tyioocom 
		$goods_pvs_mod = &m('goods_pvs');
		$props_mod = &m('props');
		$prop_value_mod = &m('prop_value');
		$goods_pvs = $goods_pvs_mod->get($id);// 取出该商品的属性字符串
		$goods_pvs_str = $goods_pvs['pvs'];
		$props = array();
		if(!empty($goods_pvs_str))
		{
			$goods_pvs_arr = explode(';',$goods_pvs_str);//  分割成数组
			foreach($goods_pvs_arr as $pv)
			{
				if($pv)
				{
					$pv_arr = explode(':',$pv);
					$prop = $props_mod->get(array('conditions'=>'pid='.$pv_arr[0].' AND status=1'));
					if($prop)
					{
						$prop_value = $prop_value_mod->get(array('conditions'=>'pid='.$pv_arr[0].' AND vid='.$pv_arr[1].' AND status=1'));
						if($prop_value){
							$props[] = array('name'=>$prop['name'],'value'=>$prop_value['prop_value']);
						}
					}
				}
			}
		}
		$this->assign('props',$props);
		// end sku
		
		  /* 如果开启积分功能，则：读取商品积分设置 add by 1hao5 team */
		if(Conf::get('integral_enabled'))
		{
			$goods_integral_mod =& m('goods_integral');
			$goods_integral = $goods_integral_mod->get($id);
			$this->assign('goods_integral', $goods_integral);
		}

		/*end by 1hao5 team*/
		

        $this->assign('guest_comment_enable', Conf::get('guest_comment'));
        $this->display('goods.index.html');
    }

    /* 商品评论 */
    function comments()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }

        $data = $this->_get_common_info($id);
        if ($data === false)
        {
            return;
        }
        else
        {
            $this->_assign_common_info($data);
        }

        /* 赋值商品评论 */
        $data = $this->_get_goods_comment($id, 10);
        $this->_assign_goods_comment($data);

        $this->display('goods.comments.html');
    }

    /* 销售记录 */
    function saleslog()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }

        $data = $this->_get_common_info($id);
        if ($data === false)
        {
            return;
        }
        else
        {
            $this->_assign_common_info($data);
        }

        /* 赋值销售记录 */
        $data = $this->_get_sales_log($id, 10);
        $this->_assign_sales_log($data);

        $this->display('goods.saleslog.html');
    }
    function qa()
    {
        $goods_qa =& m('goodsqa');
         $id = intval($_GET['id']);
         if (!$id)
         {
            $this->show_warning('Hacking Attempt');
            return;
         }
        if(!IS_POST)
        {
            $data = $this->_get_common_info($id);
            if ($data === false)
            {
                return;
            }
            else
            {
                $this->_assign_common_info($data);
            }
            $data = $this->_get_goods_qa($id, 10);
            $this->_assign_goods_qa($data);

            //是否开启验证码
            if (Conf::get('captcha_status.goodsqa'))
            {
                $this->assign('captcha', 1);
            }
            $this->assign('guest_comment_enable', Conf::get('guest_comment'));
            /*赋值产品咨询*/
            $this->display('goods.qa.html');
        }
        else
        {
            /* 不允许游客评论 */
            if (!Conf::get('guest_comment') && !$this->visitor->has_login)
            {
                $this->show_warning('guest_comment_disabled');

                return;
            }
            $content = (isset($_POST['content'])) ? trim($_POST['content']) : '';
            //$type = (isset($_POST['type'])) ? trim($_POST['type']) : '';
            $email = (isset($_POST['email'])) ? trim($_POST['email']) : '';
            $hide_name = (isset($_POST['hide_name'])) ? trim($_POST['hide_name']) : '';
            if (empty($content))
            {
                $this->show_warning('content_not_null');
                return;
            }
            //对验证码和邮件进行判断

            if (Conf::get('captcha_status.goodsqa'))
            {
                if (base64_decode($_SESSION['captcha']) != strtolower($_POST['captcha']))
                {
                    $this->show_warning('captcha_failed');
                    return;
                }
            }
            if (!empty($email) && !is_email($email))
            {
                $this->show_warning('email_not_correct');
                return;
            }
            $user_id = empty($hide_name) ? $_SESSION['user_info']['user_id'] : 0;
            $conditions = 'g.goods_id ='.$id;
            $goods_mod = & m('goods');
            $ids = $goods_mod->get(array(
                'fields' => 'store_id,goods_name',
                'conditions' => $conditions
            ));
            extract($ids);
            $data = array(
                'question_content' => $content,
                'type' => 'goods',
                'item_id' => $id,
                'item_name' => addslashes($goods_name),
                'store_id' => $store_id,
                'email' => $email,
                'user_id' => $user_id,
                'time_post' => gmtime(),
            );
            if ($goods_qa->add($data))
            {
                header("Location: index.php?app=goods&act=qa&id={$id}#module\n");
                exit;
            }
            else
            {
                $this->show_warning('post_fail');
                exit;
            }
        }
    }


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
    //360cd.cn

    /**
     * 取得公共信息
     *
     * @param   int     $id
     * @return  false   失败
     *          array   成功
     */
    function _get_common_info($id)
    {
        $cache_server =& cache_server();
        $key = 'page_of_goods_' . $id;
        $data = $cache_server->get($key);
        $cached = true;
        if ($data === false)
        {
            $cached = false;
            $data = array('id' => $id);

            /* 商品信息 */
            $goods = $this->_goods_mod->get_info($id);
            if (!$goods || $goods['if_show'] == 0 || $goods['closed'] == 1 || $goods['state'] != 1)
            {
                $this->show_warning('goods_not_exist');
                return false;
            }
            $goods['tags'] = $goods['tags'] ? explode(',', trim($goods['tags'], ',')) : array();
			
			
			/*减价打折促销 价格设置 add tyioocom */
			
			$promotion_mod = & m('promotion');
			
			if($promotion_mod->goods_has_promotion($goods['goods_id']))
			{
				$promotion = $promotion_mod->get(array('conditions'=>"start_time<=".gmtime()." AND end_time>=".gmtime()." AND goods_id=".$goods['goods_id']));

				$i=$is_pro=0;
				foreach($goods['_specs'] as $spec)
				{
					$spec_price = unserialize($promotion['spec_price']);
					if(isset($spec_price[$spec['spec_id']]['pro_type'])) 
					{
						if($spec_price[$spec['spec_id']]['pro_type'] == 'price') 
						{
							if($spec['price']>$spec_price[$spec['spec_id']]['price'])
							{
								$pro_price = round($spec['price'] - $spec_price[$spec['spec_id']]['price'],2);
								$is_pro=1;
							}
							else
							{
								$pro_price = NULL; // 考虑设置了促销后，再给该商品添加规格的情况，那么一律给新增的规格设置促销价为NULL
								$is_pro=0;
							}
						}
						else 
						{
							$pro_price = round($spec['price'] * $spec_price[$spec['spec_id']]['price'] / 10,2);
							$is_pro=1;
						}
					}
					else{
						$pro_price = NULL; // 考虑设置了促销后，再给该商品添加规格的情况，那么一律给新增的规格设置促销价为NULL
						$is_pro=0;
					}
					$goods['_specs'][$i++] += array('pro_price' => $pro_price,'is_pro'=>$is_pro);
				}
				$goods += $promotion;
				$goods['pro_type'] = 'promo';
			}
			
			else
			{
				//开启会员价格并且用户登陆，则显示会员价格 by cengnlaeng
				if($goods['if_open'])
				{
					$member_mod=&m('member');
					$member=$member_mod->get_grade_info($this->visitor->get('user_id'));
					$goods['pro_name']=$member['grade_name'];
					$discount=$this->_gradegoods_mod->get_user_discount($this->visitor->get('user_id'),$id);
					foreach($goods['_specs'] as $key => $val)
					{
						$goods['_specs'][$key]['pro_price']= $val['price']*$discount;
						$goods['_specs'][$key]['is_pro'] = 1 ;
					}
					$goods['pro_type'] = 'ugrade';
				}
			}



            $data['goods'] = $goods;
			$goods_integral_mod = & m('goods_integral');
			$data['goods_integral_info'] = $goods_integral_mod->get('goods_id='.$id);

            /* 店铺信息 */
            if (!$goods['store_id'])
            {
                $this->show_warning('store of goods is empty');
                return false;
            }
            $this->set_store($goods['store_id']);
            $data['store_data'] = $this->get_store_data();

            /* 当前位置 */
            $data['cur_local'] = $this->_get_curlocal($goods['cate_id']);
            $data['goods']['related_info'] = $this->_get_related_objects($data['goods']['tags']);
            /* 分享链接 */
            $data['share'] = $this->_get_share($goods);

            $cache_server->set($key, $data, 1800);
        }
        if ($cached)
        {
            $this->set_store($data['goods']['store_id']);
        }
        return $data;
    }

    function _get_related_objects($tags)
    {
        if (empty($tags))
        {
            return array();
        }
        $tag = $tags[array_rand($tags)];
        $ms =& ms();

        return $ms->tag_get($tag);
    }

    function generateQRfromGoogle($goods_id, $widhtHeight = '100', $EC_level = 'L', $margin = '0') {
        $url = SITE_URL.'/index.php?app=goods&id='.$goods_id;
        $url = urlencode($url);
        return '<img src="http://qr.liantu.com/api.php?bg=ffffff&fg=000000&gc=000000&el=l&w=150&m=10&text=' . $url . '" alt="QR code" widhtHeight="' . $widhtHeight . '" widhtHeight="' . $widhtHeight . '"/>';
    }
    
    /* 赋值公共信息 */
    function _assign_common_info($data)
    {
        /* 商品信息 */
        $goods = $data['goods'];
        $goods['scan_code'] = $this->generateQRfromGoogle($goods['goods_id']);
        $this->assign('goods', $goods);
		$this->assign('goods_integral_info',$data['goods_integral_info']);
        $this->assign('sales_info', sprintf(LANG::get('sales'), $goods['sales'] ? $goods['sales'] : 0));
        $this->assign('comments', sprintf(LANG::get('comments'), $goods['comments'] ? $goods['comments'] : 0));
        //360cd.cn
        $this->setWapStore($goods['store_id']);
        //360cd.cn
        /* 店铺信息 */
        $this->assign('store', $data['store_data']);

        /* 浏览历史 */
        $this->assign('goods_history', $this->_get_goods_history($data['id']));

        /* 默认图片 */
        $this->assign('default_image', Conf::get('default_goods_image'));

        /* 当前位置 */
        $this->_curlocal($data['cur_local']);

        /* 配置seo信息 */
        $this->_config_seo($this->_get_seo_info($data['goods']));
		 
		//会员折扣
		$this->assign('discount',$this->_gradegoods_mod->get_user_discount($this->visitor->get('user_id'),$data['goods']['goods_id']));
		// 会员等级名称
		$member_mod=&m('member');
		$user_grade_info=$member_mod->get_grade_info($this->visitor->get('user_id'));
		$this->assign('ugrade_name',!empty($user_grade_info)?$user_grade_info['grade_name'].'价':'会员价');
        /* 商品分享 */
        $this->assign('share', $data['share']);

        $this->import_resource(array(
            'script' => 'jquery.jqzoom.js',
            'style' => 'res:jqzoom.css'
        ));
    }

    /* 取得浏览历史 */
    function _get_goods_history($id, $num = 9)
    {
        $goods_list = array();
        $goods_ids  = ecm_getcookie('goodsBrowseHistory');
        $goods_ids  = $goods_ids ? explode(',', $goods_ids) : array();
        if ($goods_ids)
        {
            $rows = $this->_goods_mod->find(array(
                'conditions' => $goods_ids,
                'fields'     => 'goods_name,default_image',
            ));
            foreach ($goods_ids as $goods_id)
            {
                if (isset($rows[$goods_id]))
                {
                    empty($rows[$goods_id]['default_image']) && $rows[$goods_id]['default_image'] = Conf::get('default_goods_image');
                    $goods_list[] = $rows[$goods_id];
                }
            }
        }
        $goods_ids[] = $id;
        if (count($goods_ids) > $num)
        {
            unset($goods_ids[0]);
        }
        ecm_setcookie('goodsBrowseHistory', join(',', array_unique($goods_ids)));

        return $goods_list;
    }

    /* 取得销售记录 */
    function _get_sales_log($goods_id, $num_per_page)
    {
        $data = array();

        $page = $this->_get_page($num_per_page);
        $order_goods_mod =& m('ordergoods');
        $sales_list = $order_goods_mod->find(array(
            'conditions' => "goods_id = '$goods_id' AND order_alias.status = '" . ORDER_FINISHED . "'",
            'join'  => 'belongs_to_order',
            'fields'=> 'buyer_id, buyer_name, add_time, anonymous, goods_id, specification, price, quantity, evaluation',
            'count' => true,
            'order' => 'add_time desc',
            'limit' => $page['limit'],
        ));
        $data['sales_list'] = $sales_list;

        $page['item_count'] = $order_goods_mod->getCount();
        $this->_format_page($page);
        $data['page_info'] = $page;
        $data['more_sales'] = $page['item_count'] > $num_per_page;

        return $data;
    }

    /* 赋值销售记录 */
    function _assign_sales_log($data)
    {
        $this->assign('sales_list', $data['sales_list']);
        $this->assign('page_info',  $data['page_info']);
        $this->assign('more_sales', $data['more_sales']);
    }

    /* 取得商品评论 */
    function _get_goods_comment($goods_id, $num_per_page)
    {
        $data = array();

        $page = $this->_get_page($num_per_page);
        $order_goods_mod =& m('ordergoods');
        $comments = $order_goods_mod->find(array(
            'conditions' => "goods_id = '$goods_id' AND evaluation_status = '1'",
            'join'  => 'belongs_to_order',
            'fields'=> 'buyer_id, buyer_name, anonymous, evaluation_time, comment, evaluation',
            'count' => true,
            'order' => 'evaluation_time desc',
            'limit' => $page['limit'],
        ));
        $data['comments'] = $comments;

        $page['item_count'] = $order_goods_mod->getCount();
        $this->_format_page($page);
        $data['page_info'] = $page;
        $data['more_comments'] = $page['item_count'] > $num_per_page;

        return $data;
    }

    /* 赋值商品评论 */
    function _assign_goods_comment($data)
    {
        $this->assign('goods_comments', $data['comments']);
        $this->assign('page_info',      $data['page_info']);
        $this->assign('more_comments',  $data['more_comments']);
    }

    /* 取得商品咨询 */
    function _get_goods_qa($goods_id,$num_per_page)
    {
        $page = $this->_get_page($num_per_page);
        $goods_qa = & m('goodsqa');
        $qa_info = $goods_qa->find(array(
            'join' => 'belongs_to_user',
            'fields' => 'member.user_name,question_content,reply_content,time_post,time_reply',
            'conditions' => '1 = 1 AND item_id = '.$goods_id . " AND type = 'goods'",
            'limit' => $page['limit'],
            'order' =>'time_post desc',
            'count' => true
        ));
        $page['item_count'] = $goods_qa->getCount();
        $this->_format_page($page);

        //如果登陆，则查出email
        if (!empty($_SESSION['user_info']))
        {
            $user_mod = & m('member');
            $user_info = $user_mod->get(array(
                'fields' => 'email',
                'conditions' => '1=1 AND user_id = '.$_SESSION['user_info']['user_id']
            ));
            extract($user_info);
        }

        return array(
            'email' => $email,
            'page_info' => $page,
            'qa_info' => $qa_info,
        );
    }

    /* 赋值商品咨询 */
    function _assign_goods_qa($data)
    {
        $this->assign('email',      $data['email']);
        $this->assign('page_info',  $data['page_info']);
        $this->assign('qa_info',    $data['qa_info']);
    }

    /* 更新浏览次数 */
    function _update_views($id)
    {
        $goodsstat_mod =& m('goodsstatistics');
        $goodsstat_mod->edit($id, "views = views + 1");
    }

    /**
     * 取得当前位置
     *
     * @param int $cate_id 分类id
     */
    function _get_curlocal($cate_id)
    {
        $parents = array();
        if ($cate_id)
        {
            $gcategory_mod =& bm('gcategory');
            $parents = $gcategory_mod->get_ancestor($cate_id, true);
        }

        $curlocal = array(
            array('text' => LANG::get('all_categories'), 'url' => url('app=category')),
        );
        foreach ($parents as $category)
        {
            $curlocal[] = array('text' => $category['cate_name'], 'url' => url('app=search&cate_id=' . $category['cate_id']));
        }
        $curlocal[] = array('text' => LANG::get('goods_detail'));

        return $curlocal;
    }

    function _get_share($goods)
    {
        $m_share = &af('share');
        $shares = $m_share->getAll();
        $shares = array_msort($shares, array('sort_order' => SORT_ASC));
        $goods_name = ecm_iconv(CHARSET, 'utf-8', $goods['goods_name']);
        $goods_url = urlencode(SITE_URL . '/' . str_replace('&amp;', '&', url('app=goods&id=' . $goods['goods_id'])));
        $site_title = ecm_iconv(CHARSET, 'utf-8', Conf::get('site_title'));
        $share_title = urlencode($goods_name . '-' . $site_title);
        foreach ($shares as $share_id => $share)
        {
            $shares[$share_id]['link'] = str_replace(
                array('{$link}', '{$title}'),
                array($goods_url, $share_title),
                $share['link']);
        }
        return $shares;
    }
    
    function _get_seo_info($data)
    {
        $seo_info = $keywords = array();
        $seo_info['title'] = $data['goods_name'] . ' - ' . Conf::get('site_title');        
        $keywords = array(
            $data['brand'],
            $data['goods_name'],
            $data['cate_name']
        );
        $seo_info['keywords'] = implode(',', array_merge($keywords, $data['tags']));        
        $seo_info['description'] = sub_str(strip_tags($data['description']), 10, true);
        return $seo_info;
    }
}

?>
