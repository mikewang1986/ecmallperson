<?php

/**
 *    买家的订单管理控制器
 *
 *    @author    Garbin
 *    @usage    none
 */
class Buyer_orderApp extends MemberbaseApp
{
	var $_deposit_recharge_mod;
	var $_deposit_record_mod;
	 function __construct()
    {
        $this->Buyer_orderApp();
    }

    function Buyer_orderApp()
    {
		
		
        parent::__construct();
	
		$this->_deposit_record_mod   = &m('deposit_record');
		$this->_deposit_recharge_mod = &m('deposit_recharge');
    }
	
    function index()
    {
        /* 获取订单列表 */
        $this->_get_orders();

        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                         LANG::get('my_order'), 'index.php?app=buyer_order',
                         LANG::get('order_list'));

        /* 当前用户中心菜单 */
        $this->_curitem('my_order');
        $this->_curmenu('order_list');
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('my_order'));
        $this->import_resource(array(
            'script' => array(
                array(
                    'path' => 'dialog/dialog.js',
                    'attr' => 'id="dialog_js"',
                ),
                array(
                    'path' => 'jquery.ui/jquery.ui.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.ui/i18n/' . i18n_code() . '.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.plugins/jquery.validate.js',
                    'attr' => '',
                ),
            ),
            'style' =>  'jquery.ui/themes/ui-lightness/jquery.ui.css',
        ));


        /* 显示订单列表 */
        $this->display('buyer_order.index.html');
    }
    /**
     *    查看订单详情
     *
     *    @author    Garbin
     *    @return    void
     */
    function view()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        $model_order =& m('order');
        //$order_info  = $model_order->get("order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id'));
        $order_info = $model_order->get(array(
            'fields'        => "*, order.add_time as order_add_time",
            'conditions'    => "order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id'),
            'join'          => 'belongs_to_store',
            ));
        if (!$order_info)
        {
            $this->show_warning('no_such_order');

            return;
        }

        /* 团购信息 */
        if ($order_info['extension'] == 'groupbuy')
        {
            $groupbuy_mod = &m('groupbuy');
            $group = $groupbuy_mod->get(array(
                'join' => 'be_join',
                'conditions' => 'order_id=' . $order_id,
                'fields' => 'gb.group_id',
            ));
            $this->assign('group_id',$group['group_id']);
        }

        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                         LANG::get('my_order'), 'index.php?app=buyer_order',
                         LANG::get('view_order'));

        /* 当前用户中心菜单 */
        $this->_curitem('my_order');

        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('order_detail'));

        /* 调用相应的订单类型，获取整个订单详情数据 */
        $order_type =& ot($order_info['extension']);
        $order_detail = $order_type->get_order_detail($order_id, $order_info);
        foreach ($order_detail['data']['goods_list'] as $key => $goods)
        {
            empty($goods['goods_image']) && $order_detail['data']['goods_list'][$key]['goods_image'] = Conf::get('default_goods_image');
        }
        $this->assign('order', $order_info);
        $this->assign($order_detail['data']);
        $this->display('buyer_order.view.html');
    }

    /**
     *    取消订单
     *
     *    @author    Garbin
     *    @return    void
     */
    function cancel_order()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (!$order_id)
        {
            echo Lang::get('no_such_order');

            return;
        }
        $model_order    =&  m('order');
        /* 只有待付款的订单可以取消 */
        $order_info     = $model_order->get("order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id') . " AND status " . db_create_in(array(ORDER_PENDING, ORDER_SUBMITTED)));
        if (empty($order_info))
        {
            echo Lang::get('no_such_order');

            return;
        }
        if (!IS_POST)
        {
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->assign('order', $order_info);
            $this->display('buyer_order.cancel.html');
        }
        else
        {
            $model_order->edit($order_id, array('status' => ORDER_CANCELED));
            if ($model_order->has_error())
            {
                $this->pop_warning($model_order->get_error());

                return;
            }

            /* 加回商品库存 */
            $model_order->change_stock('+', $order_id);
            $cancel_reason = (!empty($_POST['remark'])) ? $_POST['remark'] : $_POST['cancel_reason'];
            /* 记录订单操作日志 */
            $order_log =& m('orderlog');
            $order_log->add(array(
                'order_id'  => $order_id,
                'operator'  => addslashes($this->visitor->get('user_name')),
                'order_status' => order_status($order_info['status']),
                'changed_status' => order_status(ORDER_CANCELED),
                'remark'    => $cancel_reason,
                'log_time'  => gmtime(),
            ));

            /* 发送给卖家订单取消通知 */
            $model_member =& m('member');
            $seller_info   = $model_member->get($order_info['seller_id']);
            $mail = get_mail('toseller_cancel_order_notify', array('order' => $order_info, 'reason' => $_POST['remark']));
            $this->_mailto($seller_info['email'], addslashes($mail['subject']), addslashes($mail['message']));

            $new_data = array(
                'status'    => Lang::get('order_canceled'),
                'actions'   => array(), //取消订单后就不能做任何操作了
            );

            $this->pop_warning('ok');
        }

    }

    /**
     *    确认订单
     *
     *    @author    Garbin
     *    @return    void
     */
    function confirm_order()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (!$order_id)
        {
            echo Lang::get('no_such_order');

            return;
        }
        $model_order    =&  m('order');
        /* 只有已发货的订单可以确认 */
        $order_info     = $model_order->get("order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id') . " AND status=" . ORDER_SHIPPED);
        if (empty($order_info))
        {
            echo Lang::get('no_such_order');

            return;
        }
        if (!IS_POST)
        {
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->assign('order', $order_info);
            $this->display('buyer_order.confirm.html');
        }
        else
        {
			$change_order_status = true;
				
			
			$refund_mod 	= &m('refund');
			$refund = $refund_mod->find(array('conditions'=>"order_id=".$order_id." and (status !='SUCCESS' and status !='CLOSED') ",'fields'=>'refund_id,status'));
				
			
			if(!empty($refund) && count($refund) > 0) {
				$change_order_status = false;
			}
			
	
			if($change_order_status === true)
			{
				/* 更新订单状态 */
         	$model_order->edit($order_id, array('status' => ORDER_FINISHED, 'finished_time' => gmtime()));
            	if ($model_order->has_error())
            	{
                	$this->pop_warning($model_order->get_error());

                	return;
            	}

            	/* 记录订单操作日志 */
           	 	$order_log =& m('orderlog');
           	 	$order_log->add(array(
                	'order_id'  => $order_id,
                	'operator'  => addslashes($this->visitor->get('user_name')),
                	'order_status' => order_status($order_info['status']),
                	'changed_status' => order_status(ORDER_FINISHED),
                	'remark'    => Lang::get('buyer_confirm'),
                	'log_time'  => gmtime(),
            	));

            	/* 发送给卖家买家确认收货邮件，交易完成 */
           	 	$model_member =& m('member');
            	$seller_info   = $model_member->get($order_info['seller_id']);
            	$mail = get_mail('toseller_finish_notify', array('order' => $order_info));
            	$this->_mailto($seller_info['email'], addslashes($mail['subject']), addslashes($mail['message']));
				
				//发送短信给买家 by andcpp
				$filename = ROOT_PATH . '/data/msg.inc.php';
				if (file_exists($filename))
				{
					$mod_msg = &m('msg');
					$user_id = $order_info['seller_id'];
					$row_msg = $mod_msg->get(array(
						'conditions' => 'msg.user_id='.$user_id,
						'join' => 'belongs_to_user',
						'fields' => 'this.*,phone_mob'
					));
					$mobile = $row_msg['phone_mob']; //手机号
					$smsText = sprintf(Lang::get('sms_check'),$order_info['order_sn'],$order_info['buyer_name']);
					$checked_functions = $functions = array();
					$functions = $this->_get_msg_functions();
					$tmp = explode(',', $row_msg['functions']);
					if ($functions)
					{
						foreach ($functions as $func)
						{
							$checked_functions[$func] = in_array($func, $tmp);
						}
					}
					if($row_msg['state'] == 1 && $checked_functions['check'] == 1 && $row_msg['num']>0 && !empty($mobile) && !empty($smsText))
					{
						$this->Sms_Get('SMS_Send',$mobile,$smsText,$user_id);
					}
				}
				//end by psmb
				
            	$new_data = array(
                	'status'    => Lang::get('order_finished'),
                	'actions'   => array('evaluate'),
            	);
			}
			
			$ordergoods_mod =& m('ordergoods');
            $order_goods = $ordergoods_mod->find("order_id={$order_id}");
			
			$order_amount = $order_info['order_amount'];
			$confirm_ordergoods = $order_goods;
				
			
			$adjust_rate = $ordergoods_mod->get_order_adjust_rate($order_info);
			
			
			$goods_can_confirm = $refund_mod->get_order_can_confirm_goods($order_info, $adjust_rate);
			$order_amount = $goods_can_confirm['confirm_order_amount']; 
			$confirm_ordergoods = $goods_can_confirm['confirm_ordergoods'];
			
			
			//三级分成
			
			$deposit_account = &m('deposit_account');
			$user_mod =& m('member');
			$userinfo = $user_mod->get("user_id=".$order_info['buyer_id']);
		    $store_mod =& m('store');
			
            $storeinfo = $store_mod->get_info($order_info['seller_id']);
		 if($storeinfo['is_affter'])
	 {
		
    $fengc = & m('fengc');
	$fenglist= $fengc->find(array(
	      'conditions' => "1=1 and store_id=".$order_info['seller_id'],
			 
		   )); 	
	
			if(is_array($fenglist))
		{
		
		  foreach($fenglist as $val)
			 {
				 
				$row[]= $val;
			 }
			
	    }   
		
		
	
		for($i=0;$i<3;$i++)
		{
		
		
		 $affiliate[$i]['pasen'] = (float)$row[$i]['pasen'];
		 
		      if ($affiliate[$i]['pasen'])
                {
                     $affiliate[$i]['pasen'] /= 100;
                }
        
	


		$setmoney = round($order_info['order_amount'] * Conf::get('pasen_'.$i)/100, 2);
		if(!empty($userinfo['tuijian_id']))
		{
			
			
	 $userinfo = $user_mod->get($userinfo['tuijian_id']);
	  $up_uid = $userinfo['user_id'];
		}else{
			 break;
			}


	
		
			
		   if (empty($up_uid) || empty($userinfo['user_name'])  )
           {
                    break;
           }	
	
	   if($setmoney)
	   {
		   
		
		   
	  $this->fengc($up_uid,$userinfo['user_name'],$order_info['buyer_id'],$order_info['buyer_name'],$order_info['seller_id'], $order_info['seller_name'], $setmoney,$order_info['order_sn'],'推荐注册分成');   
		}

		
		
		
		
	  }	
		
	
	
	
	
	 foreach ($order_goods as $goods)
            {
			if($goods['recom'] && $goods['name'] && $goods['name']!=$order_info['seller_id'])
			{
				
				$setmoney=$goods['recom'];
				 $tinfo = $user_mod->get("user_id=".$goods['name']);
				  $this->fengc($tinfo['user_id'],$tinfo['user_name'],$order_info['buyer_id'],$order_info['buyer_name'],$order_info['seller_id'], $order_info['seller_name'], $setmoney,$order_info['order_sn'],'推荐商品分成,'.$goods['goods_name']); 
			
			}	
				
				
			
			}
	
	
	
		}
			
			
			
			//end
			if(empty($confirm_ordergoods)) {
				$this->pop_warning('no_confirm_goods');
				return;
			}
			
			
			if($order_info['payment_code']=='deposit')
			{
				
				$depopay_type    =&  dpt('income', 'sellgoods');
				$tradesn 		= $depopay_type->submit(array(
					'trade_info' =>  array('user_id'=>$order_info['seller_id'], 'party_id'=>$order_info['buyer_id'], 'amount'=>$order_amount),
					'extra_info' =>  $order_info + array('change_order_status' => $change_order_status),
					'post'		 =>	 $_POST,
				));
				if(!$tradesn)
				{
					$this->pop_warning('error');
					return;
				}
			}
			/* 如果还有其他的虚拟货币支付方式，则需单独进行处理资金情况 */
			/* 
				TODO
			*/
			
			
			
            $model_goodsstatistics =& m('goodsstatistics');
            	
            foreach ($confirm_ordergoods as $key=>$goods)
            {
				$model_goodsstatistics->edit($goods['goods_id'], "sales=sales+{$goods['quantity']}");
				$ordergoods_mod->edit($goods['rec_id'], array('status'=>'SUCCESS'));
            }
			
			if($change_order_status === true) {
				$ret_url = 'index.php?app=buyer_order&act=evaluate&order_id='.$order_id;
			} else $ret_url = 'index.php?app=buyer_order';
			
            $this->pop_warning('ok','',$ret_url);
        }

    }


function fengc($tid,$tname,$buyer_id,$buyer_name,$bid,$seller_name,$uere_amount,$order_sn,$leixing='推荐分成' ,$diaid='')
{

				$deposit_account = &m('deposit_account');
			$user_mod =& m('member');
					  
		$deposit_account->edit('user_id='.$tid, "money=money+$uere_amount");
		$deposit_account->edit('user_id='.$bid, "money=money-$uere_amount");
					   
					   /*推荐者名称*/
					  
		 $real_name =$deposit_account->get("user_id =".$tid);
					   
					   /*店铺 */
		 $real_name2 =$deposit_account->get("user_id =".$bid);
					   
					   
		  $time = gmtime();
		  $tradesn = $this->_deposit_record_mod->_gen_trade_sn();
  
		  $balance   = $real_name['money']+$uere_amount;
		  $balance2 = $real_name2['money']-$uere_amount;
		
		
          $data_record = array(
					'tradesn'	=>	$tradesn,
					'user_id'	=>	$bid,
					'party_id'	=>	0,
					'amount'	=>	$uere_amount,
					'balance'	=>	$balance2,
					'flow'		=>	'outlay',
					'purpose'	=>	'recharge',
					'status'	=>	'SUCCESS',
					'payway'	=>	$real_name['real_name'],
					'name'		=>	$leixing,
					'remark'	=>	"",
					'add_time'	=>	$time,
					'pay_time'	=>	$time,
					'end_time'	=>	$time,
				);		
				
				
			 $data_record2 = array(
					'tradesn'	=>	$tradesn,
					'user_id'	=>	$tid,
					'party_id'	=>	0,
					'amount'	=>	$uere_amount,
					'balance'	=>	$balance,
					'flow'		=>	'income',
					'purpose'	=>	'recharge',
					'status'	=>	'SUCCESS',
					'payway'	=>	$real_name2['real_name'],
					'name'		=>	$leixing,
					'remark'	=>	"",
					'add_time'	=>	$time,
					'pay_time'	=>	$time,
					'end_time'	=>	$time,
				);	
							 
					
				 $this->_deposit_record_mod->add($data_record);	
				 $this->_deposit_record_mod->add($data_record2);		
					 
					  $affiliate =& m('affiliate');
					  $affiliate_date=array(
					  'order_id'=>$order_sn,
					  'time'=>$time,
					  'user_id'=>$tid,
					  'tname'=>$tname,
					  'buyer_id'=>$buyer_id,
					  'user_name '=>$buyer_name,
					  'store'=>$bid,
					  'store_name'=>$seller_name,
					  'money '=>$uere_amount,
					  'leixing'=>$leixing,
					   'daiid'=>$diaid,
					 );
					   
				 
					 $affiliate->add($affiliate_date);
				 /*    $order_amount=$order_amount-$uere_amount;*/

	 
}


    /**
     *    给卖家评价
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
    function evaluate()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (!$order_id)
        {
            $this->show_warning('no_such_order');

            return;
        }

        /* 验证订单有效性 */
        $model_order =& m('order');
        $order_info  = $model_order->get("order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id'));
        if (!$order_info)
        {
            $this->show_warning('no_such_order');

            return;
        }
        if ($order_info['status'] != ORDER_FINISHED)
        {
            /* 不是已完成的订单，无法评价 */
            $this->show_warning('cant_evaluate');

            return;
        }
        if ($order_info['evaluation_status'] != 0)
        {
            /* 已评价的订单 */
            $this->show_warning('already_evaluate');

            return;
        }
        $model_ordergoods =& m('ordergoods');

        if (!IS_POST)
        {
            /* 显示评价表单 */
            /* 获取订单商品 */
            $goods_list = $model_ordergoods->find("order_id={$order_id}");
            foreach ($goods_list as $key => $goods)
            {
                empty($goods['goods_image']) && $goods_list[$key]['goods_image'] = Conf::get('default_goods_image');
            }
            $this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                             LANG::get('my_order'), 'index.php?app=buyer_order',
                             LANG::get('evaluate'));
            $this->assign('goods_list', $goods_list);
            $this->assign('order', $order_info);

            $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('credit_evaluate'));
            $this->display('buyer_order.evaluate.html');
        }
        else
        {
            $evaluations = array();
            /* 写入评价 */
            foreach ($_POST['evaluations'] as $rec_id => $evaluation)
            {
                if ($evaluation['evaluation'] <= 0 || $evaluation['evaluation'] > 3)
                {
                    $this->show_warning('evaluation_error');

                    return;
                }
                switch ($evaluation['evaluation'])
                {
                    case 3:
                        $credit_value = 1;
                    break;
                    case 1:
                        $credit_value = -1;
                    break;
                    default:
                        $credit_value = 0;
                    break;
                }
                $evaluations[intval($rec_id)] = array(
                    'evaluation'    => $evaluation['evaluation'],
                    'comment'       => addslashes($evaluation['comment']),
                    'credit_value'  => $credit_value
                );
            }
            $goods_list = $model_ordergoods->find("order_id={$order_id}");
            foreach ($evaluations as $rec_id => $evaluation)
            {
                $model_ordergoods->edit("rec_id={$rec_id} AND order_id={$order_id}", $evaluation);
                $goods_url = SITE_URL . '/' . url('app=goods&id=' . $goods_list[$rec_id]['goods_id']);
                $goods_name = $goods_list[$rec_id]['goods_name'];
                $this->send_feed('goods_evaluated', array(
                    'user_id'   => $this->visitor->get('user_id'),
                    'user_name'   => $this->visitor->get('user_name'),
                    'goods_url'   => $goods_url,
                    'goods_name'   => $goods_name,
                    'evaluation'   => Lang::get('order_eval.' . $evaluation['evaluation']),
                    'comment'   => $evaluation['comment'],
                    'images'    => array(
                        array(
                            'url' => SITE_URL . '/' . $goods_list[$rec_id]['goods_image'],
                            'link' => $goods_url,
                        ),
                    ),
                ));
            }

            /* 更新订单评价状态 */
            $model_order->edit($order_id, array(
                'evaluation_status' => 1,
                'evaluation_time'   => gmtime()
            ));

            /* 更新卖家信用度及好评率 */
            $model_store =& m('store');
            $model_store->edit($order_info['seller_id'], array(
                'credit_value'  =>  $model_store->recount_credit_value($order_info['seller_id']),
                'praise_rate'   =>  $model_store->recount_praise_rate($order_info['seller_id'])
            ));

            /* 更新商品评价数 */
            $model_goodsstatistics =& m('goodsstatistics');
            $goods_ids = array();
            foreach ($goods_list as $goods)
            {
                $goods_ids[] = $goods['goods_id'];
            }
            $model_goodsstatistics->edit($goods_ids, 'comments=comments+1');


            $this->show_message('evaluate_successed',
                'back_list', 'index.php?app=buyer_order');
        }
    }

    /**
     *    获取订单列表
     *
     *    @author    Garbin
     *    @return    void
     */
    function _get_orders()
    {
        $page = $this->_get_page(10);
        $model_order =& m('order');
        !$_GET['type'] && $_GET['type'] = 'all_orders';
        $con = array(
            array(      //按订单状态搜索
                'field' => 'status',
                'name'  => 'type',
                'handler' => 'order_status_translator',
            ),
            array(      //按店铺名称搜索
                'field' => 'seller_name',
                'equal' => 'LIKE',
            ),
            array(      //按下单时间搜索,起始时间
                'field' => 'add_time',
                'name'  => 'add_time_from',
                'equal' => '>=',
                'handler'=> 'gmstr2time',
            ),
            array(      //按下单时间搜索,结束时间
                'field' => 'add_time',
                'name'  => 'add_time_to',
                'equal' => '<=',
                'handler'=> 'gmstr2time_end',
            ),
            array(      //按订单号
                'field' => 'order_sn',
            ),
        );
        $conditions = $this->_get_query_conditions($con);
        /* 查找订单 */
        $orders = $model_order->findAll(array(
            'conditions'    => "buyer_id=" . $this->visitor->get('user_id') . "{$conditions}",
            'fields'        => 'this.*',
            'count'         => true,
            'limit'         => $page['limit'],
            'order'         => 'add_time DESC',
            'include'       =>  array(
                'has_ordergoods',       //取出商品
            ),
        ));
		
		$refund_mod = &m('refund');
        foreach ($orders as $key1 => $order)
        {
            foreach ($order['order_goods'] as $key2 => $goods)
            {
                empty($goods['goods_image']) && $orders[$key1]['order_goods'][$key2]['goods_image'] = Conf::get('default_goods_image');
				
				/* 是否申请过退款 */
				$refund = $refund_mod->get(array('conditions'=>'order_id='.$goods['order_id'].' and goods_id='.$goods['goods_id'].' and spec_id='.$goods['spec_id'],'fields'=>'status,order_id'));
				if($refund) {
					$orders[$key1]['order_goods'][$key2]['refund_status'] = $refund['status'];
					$orders[$key1]['order_goods'][$key2]['refund_id'] = $refund['refund_id'];
				}
            }
        }
		
        $page['item_count'] = $model_order->getCount();
        $this->assign('types', array('all'     => Lang::get('all_orders'),
                                     'pending' => Lang::get('pending_orders'),
                                     'submitted' => Lang::get('submitted_orders'),
                                     'accepted' => Lang::get('accepted_orders'),
                                     'shipped' => Lang::get('shipped_orders'),
                                     'finished' => Lang::get('finished_orders'),
                                     'canceled' => Lang::get('canceled_orders')));
        $this->assign('type', $_GET['type']);
        $this->assign('orders', $orders);
        $this->_format_page($page);
        $this->assign('page_info', $page);
    }

    function _get_member_submenu()
    {
        $menus = array(
            array(
                'name'  => 'order_list',
                'url'   => 'index.php?app=buyer_order',
            ),
        );
        return $menus;
    }

}

?>
