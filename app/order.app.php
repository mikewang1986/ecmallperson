<?php

/**
 *    售货员控制器，其扮演实际交易中柜台售货员的角色，你可以这么理解她：你告诉我（售货员）要买什么东西，我会询问你你要的收货地址是什么之类的问题
 *        并根据你的回答来生成一张单子，这张单子就是“订单”
 *
 *    @author    Garbin
 *    @param    none
 *    @return    void
 */
class OrderApp extends ShoppingbaseApp
{
    //360cd.cn
    function getPaymentList($store_id)
    {
       

        $payment_type=isset($_GET['payment_type']) && !empty($_GET['payment_type'])?$_GET['payment_type']:null;

        $payment_model =& m('payment');

        $payments = $payment_model->get_enabled($store_id);

        if(!$payments)
        {
            return ;
        }

        $all_payments = array('online' => array(), 'offline' => array());
        
        foreach ($payments as $key => $payment)
        {
            if ($payment['is_online'])
            {
                $all_payments['online'][] = $payment;
            }
            else
            {
                $all_payments['offline'][] = $payment;
            }
        }
        return $all_payments;


    }

    function getRegionList()
    {
        //360cd.cn
        $region_model=&m('region');
        //$where='';
        $where=array(
            'fields'=>'region_id,region_name',           
        );
        
        $region_data=$region_model->find($where);
        if(!$region_data)
        {
            //此处填写数据不存在内容
            return;
        }
        return $region_data;
        //360cd.cn
    }
    //360cd.cn
    /**
     *    填写收货人信息，选择配送，支付方式。
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
	  function __construct()
    {
        $this->OrderApp();
    }

    function OrderApp()
    {
        parent::__construct();
		$this->mod_msg =& m('msg');
		$this->mod_msglog =& m('msglog');
    }
	 
    function index()
    {
        $goods_info = $this->_get_goods_info();
        if ($goods_info === false)
        {
            /* 购物车是空的 */
            $this->show_warning('goods_empty');

            return;
        }

        /*  检查库存 */
        $goods_beyond = $this->_check_beyond_stock($goods_info['items']);
        if ($goods_beyond)
        {
            $str_tmp = '';
            foreach ($goods_beyond as $goods)
            {
                $str_tmp .= '<br /><br />' . $goods['goods_name'] . '&nbsp;&nbsp;' . $goods['specification'] . '&nbsp;&nbsp;' . Lang::get('stock') . ':' . $goods['stock'];
            }
            $this->show_warning(sprintf(Lang::get('quantity_beyond_stock'), $str_tmp));
            return;
        }

        if (!IS_POST)
        {
            /* 根据商品类型获取对应订单类型 */
            $goods_type     =&  gt($goods_info['type']);
            $order_type     =&  ot($goods_info['otype']);

            /* 显示订单表单 */
            $form = $order_type->get_order_form($goods_info['store_id']);
            if ($form === false)
            {
                $this->show_warning($order_type->get_error());

                return;
            }
            $this->_curlocal(
                LANG::get('create_order')
            );
			//by cengnlaeng
			(($goods_info['amount'] > $goods_info['amount_for_free_fee']) && ($goods_info['amount_for_free_fee'] > 0)) && $logic1=true;
			$logic2=($goods_info['quantity'] >= $goods_info['acount_for_free_fee']) && ($goods_info['acount_for_free_fee'] > 0);
			if($logic1 || $logic2)
			{
				$logic2 && $title= sprintf(Lang::get('free_acount_ship_title'),$goods_info['acount_for_free_fee']);
				$logic1 && $title= sprintf(Lang::get('free_amount_ship_title'),$goods_info['amount_for_free_fee']);
				$this->assign('is_free_fee',true);
				$this->assign('free_fee_name',$title);
			}
			//end
            $this->_config_seo('title', Lang::get('confirm_order') . ' - ' . Conf::get('site_title'));
			
			import('init.lib');
			$this->assign('coupon_list', Init_OrderApp::get_available_coupon($goods_info['store_id']));
			
            $this->assign('goods_info', $goods_info);
            $this->assign($form['data']);
			$this->assign('integral_open',Conf::get('integral_enabled')); // by 1hao5
			$max_exchange = 0;
			$is_allow = 1;
			$goods_integral_mod =& m('goods_integral');
			foreach ($goods_info['items'] as $goods) // 因为一个订单可能包含多个商品,一个商品可能购买了M件，那么可使用的积分便是 N*M 之和
			{
				$goods_integral = $goods_integral_mod->get($goods['goods_id']);
				$max_exchange += $goods_integral['max_exchange']*$goods['quantity'];
			}
			if ($max_exchange <=0)
			{
				$is_allow = 0;
			}
			$my_money_model = & m('my_money');
			$my_money_info = $my_money_model->get("user_id=".$this->visitor->get('user_id'));
			if($my_money_info){$user_integral=$my_money_info['jifen'];} else{$user_integral=0;}
			$this->assign('user_integral',$user_integral);
			$this->assign('max_exchange',$max_exchange);
			$this->assign('is_allow',$is_allow);
			$back_url="http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
			$this->assign('ret_url', rawurlencode($back_url));
                //360cd.cn
            if(isset($_SESSION['wapstore']) && $_SESSION['wapstore']=='zlstore')
            {
                $this->assign('store',array('store_id'=>$goods_info['store_id']));
                $this->assign('payment_list',$this->getPaymentList($goods_info['store_id']));
                $this->assign('region_list',$this->getRegionList());
                $this->display('zlstore/'.$form['template']);
                return;
            }
            //360cd.cn
	    $this->display($form['template']);
        }
        else
        {
            /* 在此获取生成订单的两个基本要素：用户提交的数据（POST），商品信息（包含商品列表，商品总价，商品总数量，类型），所属店铺 */
            $store_id = isset($_GET['store_id']) ? intval($_GET['store_id']) : 0;
            if ($goods_info === false)
            {
                /* 购物车是空的 */
                $this->show_warning('goods_empty');

                return;
            }
            /* 优惠券数据处理 */
            if ($goods_info['allow_coupon'] && isset($_POST['coupon_sn']) && !empty($_POST['coupon_sn']))
            {
                $coupon_sn = trim($_POST['coupon_sn']);
                $coupon_mod =& m('couponsn');
                $coupon = $coupon_mod->get(array(
                    'fields' => 'coupon.*,couponsn.remain_times',
                    'conditions' => "coupon_sn.coupon_sn = '{$coupon_sn}' AND coupon.store_id = " . $store_id,
                    'join'  => 'belongs_to_coupon'));
                if (empty($coupon))
                {
                    $this->show_warning('involid_couponsn');
                    exit;
                }
                if ($coupon['remain_times'] < 1)
                {
                    $this->show_warning("times_full");
                    exit;
                }
                $time = gmtime();
                if ($coupon['start_time'] > $time)
                {
                    $this->show_warning("coupon_time");
                    exit;
                }

                if ($coupon['end_time'] < $time)
                {
                    $this->show_warning("coupon_expired");
                    exit;
                }
                if ($coupon['min_amount'] > $goods_info['amount'])
                {
                    $this->show_warning("amount_short");
                    exit;
                }
                unset($time);
                $goods_info['discount'] = $coupon['coupon_value'];
            }
			
			
		
			/* 使用积分购买数据处理  by 1hao5*/
			if($goods_info['allow_integral'] && isset($_POST['exchange_integral']) && !empty($_POST['exchange_integral']))
			{
				$exchange_integral = trim($_POST['exchange_integral']);
				$goods_integral_mod =& m('goods_integral');
				
				/*获取用户用友的积分*/
				//$integral_mod =& m('integral');
				//$integral = $integral_mod->get($this->visitor->get('user_id'));
				//if($integral){$user_integral=$integral['amount'];} else{$user_integral=0;}
				$my_money_model = & m('my_money');
				$my_money_info = $my_money_model->get("user_id=".$this->visitor->get('user_id'));
				if($my_money_info){$user_integral=$my_money_info['jifen'];} else{$user_integral=0;}
				
				$max_exchange = 0;
				foreach ($goods_info['items'] as $goods) // 因为一个订单可能包含多个商品,一个商品可能购买了M件，那么可使用的积分便是 N*M 之和
				{
					$goods_integral = $goods_integral_mod->get($goods['goods_id']);
					$max_exchange += $goods_integral['max_exchange']*$goods['quantity'];
				}
				if ($max_exchange <=0)
				{
					$this->show_warning("该商品不能使用积分购买");
					exit;
				}
				elseif ($max_exchange < $exchange_integral)
				{
					$this->show_warning('该商品最多可以使用 '.$max_exchange.'积分。');
					exit;
				}
				elseif($exchange_integral > $user_integral)
				{
					$this->show_warning('对不起，你没有足够的积分！你目前的积分值为：'.$user_integral);
					exit;
				}
				$goods_info['discount'] += $exchange_integral * Conf::get('exchange_rate');
			}
			
		
			/* end */
            /* 根据商品类型获取对应的订单类型 */
            $goods_type =& gt($goods_info['type']);
            $order_type =& ot($goods_info['otype']);

            /* 将这些信息传递给订单类型处理类生成订单(你根据我提供的信息生成一张订单) */
            $order_id = $order_type->submit_order(array(
                'goods_info'    =>  $goods_info,      //商品信息（包括列表，总价，总量，所属店铺，类型）,可靠的!
                'post'          =>  $_POST,           //用户填写的订单信息
            ));


            if (!$order_id)
            {
                $this->show_warning($order_type->get_error());

                return;
            }

            /*  检查是否添加收货人地址  */
            if (isset($_POST['save_address']) && (intval(trim($_POST['save_address'])) == 1))
            {
                 $data = array(
                    'user_id'       => $this->visitor->get('user_id'),
                    'consignee'     => trim($_POST['consignee']),
                    'region_id'     => $_POST['region_id'],
                    'region_name'   => $_POST['region_name'],
                    'address'       => trim($_POST['address']),
                    'zipcode'       => trim($_POST['zipcode']),
                    'phone_tel'     => trim($_POST['phone_tel']),
                    'phone_mob'     => trim($_POST['phone_mob']),
                );
                $model_address =& m('address');
                $model_address->add($data);
            }
            /* 下单完成后清理商品，如清空购物车，或将团购拍卖的状态转为已下单之类的 */
            $this->_clear_goods($order_id);

            /* 发送邮件 */
            $model_order =& m('order');

            //360cd.cn

            $payment_id=isset($_POST['payment_id'])?intval($_POST['payment_id']):0;
            
            $payment_model=&m('payment');
            $where=' payment_id='.$payment_id;
            
            $payment_data=$payment_model->get($where);            
            
            if($payment_data)
            {
                $payment_editdata=array('payment_id'=>$payment_id,'payment_code'=>$payment_data['payment_code']);
            }else{
                $payment_editdata=array('payment_id'=>$payment_id);
            }
            $model_order->edit($order_id,$payment_editdata);

            //360cd.cn

            /* 减去商品库存 */
            $model_order->change_stock('-', $order_id);

            /* 获取订单信息 */
            $order_info = $model_order->get($order_id);

            /* 发送事件 */
            $feed_images = array();
            foreach ($goods_info['items'] as $_gi)
            {
                $feed_images[] = array(
                    'url'   => SITE_URL . '/' . $_gi['goods_image'],
                    'link'  => SITE_URL . '/' . url('app=goods&id=' . $_gi['goods_id']),
                );
            }
            $this->send_feed('order_created', array(
                'user_id'   => $this->visitor->get('user_id'),
                'user_name' => addslashes($this->visitor->get('user_name')),
                'seller_id' => $order_info['seller_id'],
                'seller_name' => $order_info['seller_name'],
                'store_url' => SITE_URL . '/' . url('app=store&id=' . $order_info['seller_id']),
                'images'    => $feed_images,
            ));

            $buyer_address = $this->visitor->get('email');
            $model_member =& m('member');
            $member_info  = $model_member->get($goods_info['store_id']);
            $seller_address= $member_info['email'];
			
			/**/

        //$order_info  = $model_order->get("order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id'));
        $order_info = $model_order->get(array(
            //'fields'        => "",
            'conditions'    => "order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id'),
            'join'          => 'belongs_to_store',
            ));
			$order_detail = $order_type->get_order_detail($order_id, $order_info);
			$str_goods='';
			$str_add='';
			$str_name='';
			$str_phone='';
			$str_shipping='';
			$return_str='';
        foreach ($order_detail['data']['goods_list'] as $key => $goods)
        {
            empty($goods['goods_image']) && $order_detail['data']['goods_list'][$key]['goods_image'] = Conf::get('default_goods_image');
			$str_goods=$str_goods.'<li id=goods_name>'.$order_detail['data']['goods_list'][$key]['goods_name'].'　数量:'.$order_detail['data']['goods_list'][$key]['quantity'].'　单价:￥'.$order_detail['data']['goods_list'][$key]['price'].'</li>';
        }
		/*:'.$order_detail['data']['goods_list'][$key]['quantity'].'单价:'.$order_detail['data']['goods_list'][$key]['price'].'</li>';
		foreach ($order_detail['data']['order_extm'] as $key => $order_extm)
        {}*/
           $str_add='收货地址:'.$order_detail['data']['order_extm']['region_name'].$order_detail['data']['order_extm']['address'] ;
			$str_phone_tel='电话:'.$order_detail['data']['order_extm']['phone_tel'];
			$str_phone_mob='手机:'.$order_detail['data']['order_extm']['phone_mob'];
			$str_name='名字:'.$order_detail['data']['order_extm']['consignee'];
			$str_shipping='配送方式:'.$order_detail['data']['order_extm']['shipping_name'];
		   // $str_content='购物备注:'.$order_info['data']['postscript'];
		$return_str='顾客详细:<br>'.$str_name.'('.$str_phone_mob.$str_phone_tel.')<br>物品清单:'.$str_goods.'<br>'.$str_add.'<br>'.$str_shipping;
		
/*
 
echo $return_str;
$s1 = each($goods); 
print_r($s1);
$this->assign($order_detail['data']);*/

            /* 发送给买家下单通知 */
            $buyer_mail = get_mail('tobuyer_new_order_notify', array('order' => $order_info));
            $this->_mailto($buyer_address, addslashes($buyer_mail['subject']), addslashes($buyer_mail['message']));

          /* 发送给卖家新订单通知 */
            $seller_mail = get_mail('toseller_new_order_notify', array('order' => $order_info,'response'=>$return_str));
            $this->_mailto($seller_address, addslashes($seller_mail['subject']), addslashes($seller_mail['message']));
			$this->_mailto($mail_master, addslashes($seller_mail['subject']), addslashes($seller_mail['message']));

            /* 更新下单次数 */
            $model_goodsstatistics =& m('goodsstatistics');
            $goods_ids = array();
            foreach ($goods_info['items'] as $goods)
            {
                $goods_ids[] = $goods['goods_id'];
            }
            $model_goodsstatistics->edit($goods_ids, 'orders=orders+1');
			
			
			
			
			
			if(Conf::get('integral_enabled'))
			{
				
				
				$order_integral_mod = &m('order_integral');
				/*  计算 本次订单中购买商品后，买家可获得的积分总和 */
				$goods_integral_mod =& m('goods_integral');
			    $buyer_has_integral = 0; 
			    foreach ($goods_info['items'] as $goods) 
			    {
				    $goods_integral = $goods_integral_mod->get($goods['goods_id']);
				    $buyer_has_integral += $goods_integral['has_integral'] * $goods['quantity'];
			    }
			    /* 计算积分总和结束 */
			    
			    /*扣减操作*/
				//$integral_mod = &m('integral');
			    //$integral = $integral_mod->get($this->visitor->get('user_id'));// 对买家
			    //$amount = $integral['amount']-intval($_POST['exchange_integral']); // 对买家，减去抵价的积分，获得的积分到交易完成后再加上去
			    //$integral['amount'] = $amount;
			    //$integral_mod->edit($this->visitor->get('user_id'),$integral);
			    $my_money_model = & m('my_money');
				$my_money_info = $my_money_model->get("user_id=".$this->visitor->get('user_id'));
				$amount = $my_money_info['jifen']-intval($_POST['exchange_integral']); // 对买家，减去抵价的积分，获得的积分到交易完成后再加上去
			    $money_info['jifen'] = $amount;
			    $my_money_model->edit("user_id=".$this->visitor->get('user_id'),$money_info);
				
				$my_money_info = $my_money_model->get("user_id=".$order_info['seller_id']);
				$amount = $my_money_info['jifen']-$buyer_has_integral; // 对卖家 扣减赠送的积分，获得的积分到交易完成后再加上去
			    $money_info['jifen'] = $amount;
			    $my_money_model->edit("user_id=".$order_info['seller_id'],$money_info);
			    //$integral = $my_money_model->get("user_id=".$order_info['seller_id']); // 对卖家 扣减赠送的积分，获得的积分到交易完成后再加上去
			    //$amount = $integral['jifen']-$buyer_has_integral;
			    //$integral['jifen'] = $amount;
			    //$my_money_model->edit("user_id=".$order_info['seller_id'],$integral);
			    /*扣减结束*/
			
			    /*积分扣减完后，讲积分保存到临时表 以便交易完成后派发积分 */
			    $order_integral = array(
			       'order_id'=>$order_id,
			       'buyer_has_integral'=>$buyer_has_integral,//  买家购买改商品后获得的积分，该积分在交易完成后付给买家，从卖家账户中扣除
			       'seller_has_integral'=> isset($_POST['exchange_integral']) ? intval($_POST['exchange_integral']) : 0 // 买家购买商品用于抵价的积分，该积分会在交易完成后付给卖家，从买家账户中扣除
			    );
			    $order_integral_mod->add($order_integral);
			}
			/* end by 1hao5 */
			
		
			//积分结束
			
//发送短信给买家 by 1hao5 team
			$user_id = $order_info['seller_id'];
			$user_name = $order_info['seller_name'];
			$row_msg = $this->mod_msg->getrow("select * from ".DB_PREFIX."msg where user_id=".$user_id);
			$mobile = $row_msg['mobile']; //手机号
			$smsText ="您好".$order_info['seller_name']."您收到了来自买家".$order_info['buyer_name']."的订单，订单号为：".$order_info['order_sn']."，请及时处理！";//内容
			$time = time();
			
			$checked_functions = $functions = array();
            $functions = $this->_get_functions();
            $tmp = explode(',', $row_msg['functions']);
            if ($functions)
            {
                foreach ($functions as $func)
                {
                    $checked_functions[$func] = in_array($func, $tmp);
                }
            }
			
			if($row_msg['state']==0)
			{
				header('Location:index.php?app=cashier&order_id=' . $order_id);
				return;
			}
			if($checked_functions['buy'] != 1)
			{
				header('Location:index.php?app=cashier&order_id=' . $order_id);
				return;
			}
			if($row_msg['num']<=0)
			{
				header('Location:index.php?app=cashier&order_id=' . $order_id);
				return;
			}
			if($mobile == '')
			{
				header('Location:index.php?app=cashier&order_id=' . $order_id);
				return;
			}
			if($smsText == '')
			{
				header('Location:index.php?app=cashier&order_id=' . $order_id);
				return;
			}
			$url='http://utf8.sms.webchinese.cn/?Uid='.SMS_UID.'&Key='.SMS_KEY.'&smsMob='.$mobile.'&smsText='.$smsText; 
			$res = $this->Sms_Get($url);
			if($res == '')
			{
            	header('Location:index.php?app=cashier&order_id=' . $order_id);
				return;
			}
			else if($res>0)
			{
				$num = $row_msg['num']-1;
				$edit_msg = array(
					'num' => $num,
				);
				$add_msglog = array(
					'user_id' => $user_id,
					'user_name' => $user_name,
					'to_mobile' => $mobile,
					'content' => $smsText,
					'state' => $res,
					'time' => $time,
				);
				$this->mod_msglog->add($add_msglog);
				$this->mod_msg->edit('user_id='.$user_id,$edit_msg);
				header('Location:index.php?app=cashier&order_id=' . $order_id);
				return;
			}
			else
			{
				$add_msglog = array(
					'user_id' => $user_id,
					'user_name' => $user_name,
					'to_mobile' => $mobile,
					'content' => $content,
					'state' => $res,
					'time' => $time,
				);
				$this->mod_msglog->add($add_msglog);
				
				/* 如果商城开启积分设置，则： 扣减买家和卖家的积分，并保存该订单积分设置到临时表，到付款完成后，讲改积分设置进行分配， by  1hao5*/
				
				
			
				header('Location:index.php?app=cashier&order_id=' . $order_id);
				return;
			}
        }
    }

    /**
     *    获取外部传递过来的商品
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
    function _get_goods_info()
    {
        $return = array(
            'items'     =>  array(),    //商品列表
            'quantity'  =>  0,          //商品总量
            'amount'    =>  0,          //商品总价
            'store_id'  =>  0,          //所属店铺
            'store_name'=>  '',         //店铺名称
            'type'      =>  null,       //商品类型
            'otype'     =>  'normal',   //订单类型
            'allow_coupon'  => true,    //是否允许使用优惠券
			'allow_integral'=> Conf::get('integral_enabled') ? true : false,    // 是否允许使用积分抵扣价款   by 1hao5
        );
        switch ($_GET['goods'])
        {
            case 'groupbuy':
                /* 团购的商品 */
                $group_id = isset($_GET['group_id']) ? intval($_GET['group_id']) : 0;
                $user_id  = $this->visitor->get('user_id');
                if (!$group_id || !$user_id)
                {
                    return false;
                }
                /* 获取团购记录详细信息 */
                $model_groupbuy =& m('groupbuy');
                $groupbuy_info = $model_groupbuy->get(array(
                    'join'  => 'be_join, belong_store, belong_goods',
                    'conditions'    => $model_groupbuy->getRealFields("groupbuy_log.user_id={$user_id} AND groupbuy_log.group_id={$group_id} AND groupbuy_log.order_id=0 AND this.state=" . GROUP_FINISHED),
                    'fields'    => 'store.store_id, store.store_name, goods.goods_id, goods.goods_name, goods.default_image, groupbuy_log.quantity, groupbuy_log.spec_quantity, this.spec_price',
                ));

                if (empty($groupbuy_info))
                {
                    return false;
                }

                /* 库存信息 */
                $model_goodsspec = &m('goodsspec');
                $goodsspec = $model_goodsspec->find('goods_id='. $groupbuy_info['goods_id']);

                /* 获取商品信息 */
                $spec_quantity = unserialize($groupbuy_info['spec_quantity']);
                $spec_price    = unserialize($groupbuy_info['spec_price']);
                $amount = 0;
                $groupbuy_items = array();
                $goods_image = empty($groupbuy_info['default_image']) ? Conf::get('default_goods_image') : $groupbuy_info['default_image'];
                foreach ($spec_quantity as $spec_id => $spec_info)
                {
                    $the_price = $spec_price[$spec_id]['price'];
                    $subtotal = $spec_info['qty'] * $the_price;
                    $groupbuy_items[] = array(
                        'goods_id'  => $groupbuy_info['goods_id'],
                        'goods_name'  => $groupbuy_info['goods_name'],
                        'spec_id'  => $spec_id,
                        'specification'  => $spec_info['spec'],
                        'price'  => $the_price,
                        'quantity'  => $spec_info['qty'],
                        'goods_image'  => $goods_image,
                        'subtotal'  => $subtotal,
                        'stock' => $goodsspec[$spec_id]['stock'],
                    );
                    $amount += $subtotal;
                }

                $return['items']        =   $groupbuy_items;
                $return['quantity']     =   $groupbuy_info['quantity'];
                $return['amount']       =   $amount;
                $return['store_id']     =   $groupbuy_info['store_id'];
                $return['store_name']   =   $groupbuy_info['store_name'];
                $return['type']         =   'material';
                $return['otype']        =   'groupbuy';
                $return['allow_coupon'] =   false;
            break;
            default:
                /* 从购物车中取商品 */
                $_GET['store_id'] = isset($_GET['store_id']) ? intval($_GET['store_id']) : 0;
                $store_id = $_GET['store_id'];
                if (!$store_id)
                {
                    return false;
                }


                $cart_model =& m('cart');

                $cart_items      =  $cart_model->find(array(
                    'conditions' => "user_id = " . $this->visitor->get('user_id') . " AND store_id = {$store_id} AND session_id='" . SESS_ID . "'",
                    'join'       => 'belongs_to_goodsspec',
					'fields'     =>'this.*,gs.spec_1,gs.spec_2,gs.stock,gs.sku,cart.price'//读取购物车表的价格 by cengnlaeng
                ));
                if (empty($cart_items))
                {
                    return false;
                }


                $store_model =& m('store');
                $store_info = $store_model->get($store_id);

                foreach ($cart_items as $rec_id => $goods)
                {
                    $return['quantity'] += $goods['quantity'];                      //商品总量
                    $return['amount']   += $goods['quantity'] * $goods['price'];    //商品总价
                    $cart_items[$rec_id]['subtotal']    =   $goods['quantity'] * $goods['price'];   //小计
                    empty($goods['goods_image']) && $cart_items[$rec_id]['goods_image']=Conf::get('default_goods_image');
                }

                $return['items']        =   $cart_items;
                $return['store_id']     =   $store_id;
                $return['store_name']   =   $store_info['store_name'];
				$return['store_im_qq']  =   $store_info['im_qq']; // tyioocom 
				//by cengnlaeng
				$return['amount_for_free_fee']= $store_info['amount_for_free_fee'];
				$return['acount_for_free_fee']= $store_info['acount_for_free_fee'];
				//end
                $return['type']         =   'material';
                $return['otype']        =   'normal';
            break;
        }

        return $return;
	}


    /**
     *    下单完成后清理商品
     *
     *    @author    Garbin
     *    @return    void
     */
    function _clear_goods($order_id)
    {
        switch ($_GET['goods'])
        {
            case 'groupbuy':
                /* 团购的商品 */
                $model_groupbuy =& m('groupbuy');
                $model_groupbuy->updateRelation('be_join', intval($_GET['group_id']), $this->visitor->get('user_id'), array(
                    'order_id'  => $order_id,
                ));
            break;
            default://购物车中的商品
                /* 订单下完后清空指定购物车 */
                $_GET['store_id'] = isset($_GET['store_id']) ? intval($_GET['store_id']) : 0;
                $store_id = $_GET['store_id'];
                if (!$store_id)
                {
                    return false;
                }
                $model_cart =& m('cart');
                $model_cart->drop("store_id = {$store_id} AND session_id='" . SESS_ID . "'");
                //优惠券信息处理
                if (isset($_POST['coupon_sn']) && !empty($_POST['coupon_sn']))
                {
                    $sn = trim($_POST['coupon_sn']);
                    $couponsn_mod =& m('couponsn');
                    $couponsn = $couponsn_mod->get("coupon_sn = '{$sn}'");
                    if ($couponsn['remain_times'] > 0)
                    {
                        $couponsn_mod->edit("coupon_sn = '{$sn}'", "remain_times= remain_times - 1");
                    }
                }
            break;
        }
    }
    /**
     * 检查优惠券有效性
     */
    function check_coupon()
    {
        $coupon_sn = $_GET['coupon_sn'];
        $store_id = is_numeric($_GET['store_id']) ? $_GET['store_id'] : 0;
        if (empty($coupon_sn))
        {
            $this->js_result(false);
        }
        $coupon_mod =& m('couponsn');
        $coupon = $coupon_mod->get(array(
            'fields' => 'coupon.*,couponsn.remain_times',
            'conditions' => "coupon_sn.coupon_sn = '{$coupon_sn}' AND coupon.store_id = " . $store_id,
            'join'  => 'belongs_to_coupon'));
        if (empty($coupon))
        {
            $this->json_result(false);
            exit;
        }
        if ($coupon['remain_times'] < 1)
        {
            $this->json_result(false);
            exit;
        }
        $time = gmtime();
        if ($coupon['start_time'] > $time)
        {
            $this->json_result(false);
            exit;
        }


        if ($coupon['end_time'] < $time)
        {
            $this->json_result(false);
            exit;
        }

        // 检查商品价格与优惠券要求的价格

        $model_cart =& m('cart');
        $item_info  = $model_cart->find("store_id={$store_id} AND session_id='" . SESS_ID . "'");
        $price = 0;
        foreach ($item_info as $val)
        {
            $price = $price + $val['price'] * $val['quantity'];
        }
        if ($price < $coupon['min_amount'])
        {
            $this->json_result(false);
            exit;
        }
        $this->json_result(array('res' => true, 'price' => $coupon['coupon_value']));
        exit;

    }

    function _check_beyond_stock($goods_items)
    {
        $goods_beyond_stock = array();
        foreach ($goods_items as $rec_id => $goods)
        {
            if ($goods['quantity'] > $goods['stock'])
            {
                $goods_beyond_stock[$goods['spec_id']] = $goods;
            }
        }
        return $goods_beyond_stock;
    }
	
	//添加筛选短信筛选函数 by andcpp
	function _get_functions()
    {
        $arr = array();        
        $arr[] = 'buy'; //来自买家下单通知   
        $arr[] = 'send'; //卖家发货通知买家   
		$arr[] = 'check';//来自买家确认通知   
        return $arr;
    }
	//end
}
?>
