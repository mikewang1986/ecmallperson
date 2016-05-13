<?php

/**
 *    买家的订单管理控制器
 *
 *    @author    Garbin
 *    @usage    none
 */
class Seller_orderApp extends StoreadminbaseApp
{
	function __construct()
    {
        $this->Seller_orderApp();
    }

    function Seller_orderApp()
    {
        parent::__construct();
	        $this->mod_msg =& m('msg');
		$this->mod_msglog =& m('msglog');
    }
	
    function index()
    {
        /* 获取订单列表 */
        $this->_get_orders();

        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),    'index.php?app=member',
                         LANG::get('order_manage'), 'index.php?app=seller_order',
                         LANG::get('order_list'));

        /* 当前用户中心菜单 */
        $type = (isset($_GET['type']) && $_GET['type'] != '') ? trim($_GET['type']) : 'all_orders';
        $this->_curitem('order_manage');
        $this->_curmenu($type);
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('order_manage'));
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
        $this->display('seller_order.index.html');
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
        $order_info  = $model_order->findAll(array(
            'conditions'    => "order_alias.order_id={$order_id} AND seller_id=" . $this->visitor->get('manage_store'),
            'join'          => 'has_orderextm',
        ));
        $order_info = current($order_info);
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
        $this->_curlocal(LANG::get('member_center'),    'index.php?app=member',
                         LANG::get('order_manage'), 'index.php?app=seller_order',
                         LANG::get('view_order'));

        /* 当前用户中心菜单 */
        $this->_curitem('order_manage');
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('detail'));

        /* 调用相应的订单类型，获取整个订单详情数据 */
        $order_type =& ot($order_info['extension']);
        $order_detail = $order_type->get_order_detail($order_id, $order_info);
        $spec_ids = array();
        foreach ($order_detail['data']['goods_list'] as $key => $goods)
        {
            empty($goods['goods_image']) && $order_detail['data']['goods_list'][$key]['goods_image'] = Conf::get('default_goods_image');
            $spec_ids[] = $goods['spec_id'];

        }

        /* 查出最新的相应的货号 */
        $model_spec =& m('goodsspec');
        $spec_info = $model_spec->find(array(
            'conditions'    => $spec_ids,
            'fields'        => 'sku',
        ));
        foreach ($order_detail['data']['goods_list'] as $key => $goods)
        {
            $order_detail['data']['goods_list'][$key]['sku'] = $spec_info[$goods['spec_id']]['sku'];
        }
// 从订单ID查询快递公司和快递单号
		$data =  $this->_hook('on_query_express',array('com'=>$order_info['express_company'],'nu'=>$order_info['invoice_no']));
		
		
		$this->assign('kuaidi_info', $data);
        $this->assign('order', $order_info);
        $this->assign($order_detail['data']);
        $this->display('seller_order.view.html');
    }
    /**
     *    收到货款
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
    function received_pay()
    {
        list($order_id, $order_info)    = $this->_get_valid_order_info(ORDER_PENDING);
        if (!$order_id)
        {
            echo Lang::get('no_such_order');

            return;
        }
        if (!IS_POST)
        {
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->assign('order', $order_info);
            $this->display('seller_order.received_pay.html');
        }
        else
        {
            $model_order    =&  m('order');
            $model_order->edit(intval($order_id), array('status' => ORDER_ACCEPTED, 'pay_time' => gmtime()));
            if ($model_order->has_error())
            {
                $this->pop_warning($model_order->get_error());

                return;
            }

            #TODO 发邮件通知
            /* 记录订单操作日志 */
            $order_log =& m('orderlog');
            $order_log->add(array(
                'order_id'  => $order_id,
                'operator'  => addslashes($this->visitor->get('user_name')),
                'order_status' => order_status($order_info['status']),
                'changed_status' => order_status(ORDER_ACCEPTED),
                'remark'    => $_POST['remark'],
                'log_time'  => gmtime(),
            ));

            /* 发送给买家邮件，提示等待安排发货 */
            $model_member =& m('member');
            $buyer_info   = $model_member->get($order_info['buyer_id']);
            $mail = get_mail('tobuyer_offline_pay_success_notify', array('order' => $order_info));
            $this->_mailto($buyer_info['email'], addslashes($mail['subject']), addslashes($mail['message']));

            $new_data = array(
                'status'    => Lang::get('order_accepted'),
                'actions'   => array(
                    'cancel',
                    'shipped'
                ), //可以取消可以发货
            );

            $this->pop_warning('ok');
        }

    }

    /**
     *    货到付款的订单的确认操作
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
    function confirm_order()
    {
        list($order_id, $order_info)    = $this->_get_valid_order_info(ORDER_SUBMITTED);
        if (!$order_id)
        {
            echo Lang::get('no_such_order');

            return;
        }
        if (!IS_POST)
        {
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->assign('order', $order_info);
            $this->display('seller_order.confirm.html');
        }
        else
        {
            $model_order    =&  m('order');
            $model_order->edit($order_id, array('status' => ORDER_ACCEPTED));
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
                'changed_status' => order_status(ORDER_ACCEPTED),
                'remark'    => $_POST['remark'],
                'log_time'  => gmtime(),
            ));

            /* 发送给买家邮件，订单已确认，等待安排发货 */
            $model_member =& m('member');
            $buyer_info   = $model_member->get($order_info['buyer_id']);
            $mail = get_mail('tobuyer_confirm_cod_order_notify', array('order' => $order_info));
            $this->_mailto($buyer_info['email'], addslashes($mail['subject']), addslashes($mail['message']));

            $new_data = array(
                'status'    => Lang::get('order_accepted'),
                'actions'   => array(
                    'cancel',
                    'shipped'
                ), //可以取消可以发货
            );
			
			$user_mod=&m('member');
			$user_mod->edit_growth($order_info['buyer_id'],'bought',$order_info['goods_amount']);
			
            $this->pop_warning('ok');;
        }
    }

    /**
     *    调整费用
     *
     *    @author    Garbin
     *    @return    void
     */
    function adjust_fee()
    {
        list($order_id, $order_info)    = $this->_get_valid_order_info(array(ORDER_SUBMITTED, ORDER_PENDING));
        if (!$order_id)
        {
            echo Lang::get('no_such_order');

            return;
        }
        $model_order    =&  m('order');
        $model_orderextm =& m('orderextm');
        $shipping_info   = $model_orderextm->get($order_id);
        if (!IS_POST)
        {
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->assign('order', $order_info);
            $this->assign('shipping', $shipping_info);
            $this->display('seller_order.adjust_fee.html');
        }
        else
        {
            /* 配送费用 */
            $shipping_fee = isset($_POST['shipping_fee']) ? abs(floatval($_POST['shipping_fee'])) : 0;
            /* 折扣金额 */
            $goods_amount     = isset($_POST['goods_amount'])     ? abs(floatval($_POST['goods_amount'])) : 0;
            /* 订单实际总金额 */
            $order_amount = round($goods_amount + $shipping_fee, 2);
            if ($order_amount <= 0)
            {
                /* 若商品总价＋配送费用扣队折扣小于等于0，则不是一个有效的数据 */
                $this->pop_warning('invalid_fee');

                return;
            }
            $data = array(
                'goods_amount'  => $goods_amount,    //修改商品总价
                'order_amount'  => $order_amount,     //修改订单实际总金额
                'pay_alter' => 1    //支付变更
            );

            if ($shipping_fee != $shipping_info['shipping_fee'])
            {
                /* 若运费有变，则修改运费 */

                $model_extm =& m('orderextm');
                $model_extm->edit($order_id, array('shipping_fee' => $shipping_fee));
            }
            $model_order->edit($order_id, $data);

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
                'changed_status' => order_status($order_info['status']),
                'remark'    => Lang::get('adjust_fee'),
                'log_time'  => gmtime(),
            ));

            /* 发送给买家邮件通知，订单金额已改变，等待付款 */
            $model_member =& m('member');
            $buyer_info   = $model_member->get($order_info['buyer_id']);
            $mail = get_mail('tobuyer_adjust_fee_notify', array('order' => $order_info));
            $this->_mailto($buyer_info['email'], addslashes($mail['subject']), addslashes($mail['message']));

            $new_data = array(
                'order_amount'  => price_format($order_amount),
            );

            $this->pop_warning('ok');
        }
    }

    /**
     *    待发货的订单发货
     *
     *    @author    Garbin
     *    @return    void
     */
    function shipped()
    {
        list($order_id, $order_info)    = $this->_get_valid_order_info(array(ORDER_ACCEPTED, ORDER_SHIPPED));
        if (!$order_id)
        {
            echo Lang::get('no_such_order');

            return;
        }
        $model_order    =&  m('order');
        if (!IS_POST)
		
		
        {
            /* 显示发货表单 */
            header('Content-Type:text/html;charset=' . CHARSET);
			if($this->_check_express_plugin()){
				$this->assign('express_company',include(ROOT_PATH . '/data/express_company.inc.php'));
			}
            $this->assign('order', $order_info);
            $this->display('seller_order.shipped.html');
        }
        else
        {
            if (!$_POST['invoice_no'])
            {
                $this->pop_warning('invoice_no_empty');

                return;
            }
			
			
			
            $edit_data = array('status' => ORDER_SHIPPED, 'invoice_no' => $_POST['invoice_no']);
			
			if($this->_check_express_plugin()){
				$edit_data['express_company'] = trim($_POST['express_company']);
			}
			
			
            $is_edit = true;
            if (empty($order_info['invoice_no']))
            {
			/*站内宝v2.2.1 更新站内宝定单状态 开始*/
			if($order_info['payment_code']=='sft' || $order_info['payment_code']=='chinabank' || $order_info['payment_code']=='alipay' || $order_info['payment_code']=='tenpay' || $order_info['payment_code']=='tenpay2')
			{
				$my_moneylog=& m('my_moneylog')->edit('order_id='.$order_id,array('caozuo'=>20));
			}
			/*站内宝v2.2.1  更新站内宝定单状态 结束*/
			
                /* 不是修改发货单号 */
                $edit_data['ship_time'] = gmtime();
                $is_edit = false;
            }
            $model_order->edit(intval($order_id), $edit_data);
            if ($model_order->has_error())
            {
                $this->pop_warning($model_order->get_error());

                return;
            }
			
			
			if($order_info['payment_code'] == "deposit")
			{
				$deposit_record_mod = &m('deposit_record');
				$deposit_record_mod->edit("order_sn='".$order_info['order_sn']."' AND party_id=".$this->visitor->get('user_id'), array('status' =>'SHIPPED'));
			}

            #TODO 发邮件通知
            /* 记录订单操作日志 */
            $order_log =& m('orderlog');
            $order_log->add(array(
                'order_id'  => $order_id,
                'operator'  => addslashes($this->visitor->get('user_name')),
                'order_status' => order_status($order_info['status']),
                'changed_status' => order_status(ORDER_SHIPPED),
                'remark'    => $_POST['remark'],
                'log_time'  => gmtime(),
            ));


            /* 发送给买家订单已发货通知 */
            $model_member =& m('member');
            $buyer_info   = $model_member->get($order_info['buyer_id']);
            $order_info['invoice_no'] = $edit_data['invoice_no'];
            $mail = get_mail('tobuyer_shipped_notify', array('order' => $order_info));
            $this->_mailto($buyer_info['email'], addslashes($mail['subject']), addslashes($mail['message']));
				//发送短信给买家 by andcpp
			$mod_order_extm =& m('orderextm');
			$row_order_extm = $mod_order_extm->getrow("select * from ".DB_PREFIX."order_extm where order_id=".$order_id);
			
			$user_id = $order_info['seller_id'];
			$user_name = $order_info['seller_name'];
			$row_msg = $this->mod_msg->getrow("select * from ".DB_PREFIX."msg where user_id=".$user_id);
			$mobile = $row_order_extm['phone_mob']; //在订单中取买家手机号
			$smsText = "您的订单：".$order_info['order_sn'].",卖家：".$order_info['seller_name']."已经发货，请及时查收！";//内容
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
				$this->pop_warning('ok');
				return;
			}
			if($checked_functions['send'] != 1)
			{
				$this->pop_warning('ok');
				return;
			}
			if($row_msg['num']<=0)
			{
				$this->pop_warning('ok');
				return;
			}
			if($mobile == '')
			{
				$this->pop_warning('ok');
				return;
			}
			if($smsText == '')
			{
				$this->pop_warning('ok');
				return;
			}
			$url='http://utf8.sms.webchinese.cn/?Uid='.SMS_UID.'&Key='.SMS_KEY.'&smsMob='.$mobile.'&smsText='.$smsText; 
			$res = $this->Sms_Get($url);
			if($res == '')
			{
				$this->pop_warning('ok');
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
				$this->pop_warning('ok');
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
				$this->pop_warning('ok');
				return;
			}
			// end

            $new_data = array(
                'status'    => Lang::get('order_shipped'),
                'actions'   => array(
                    'cancel',
                    'edit_invoice_no'
                ), //可以取消可以发货
            );
            if ($order_info['payment_code'] == 'cod')
            {
                $new_data['actions'][] = 'finish';
            }

            $this->pop_warning('ok');
        }
    }

    /**
     *    取消订单
     *
     *    @author    Garbin
     *    @return    void
     */
    function cancel_order()
    {
        /* 取消的和完成的订单不能再取消 */
        //list($order_id, $order_info)    = $this->_get_valid_order_info(array(ORDER_SUBMITTED, ORDER_PENDING, ORDER_ACCEPTED, ORDER_SHIPPED));
        $order_id = isset($_GET['order_id']) ? trim($_GET['order_id']) : '';
        if (!$order_id)
        {
            echo Lang::get('no_such_order');
        }
        $status = array(ORDER_SUBMITTED, ORDER_PENDING, ORDER_ACCEPTED, ORDER_SHIPPED);
        $order_ids = explode(',', $order_id);
        if ($ext)
        {
            $ext = ' AND ' . $ext;
        }

        $model_order    =&  m('order');
        /* 只有已发货的货到付款订单可以收货 */
        $order_info     = $model_order->find(array(
            'conditions'    => "order_id" . db_create_in($order_ids) . " AND seller_id=" . $this->visitor->get('manage_store') . " AND status " . db_create_in($status) . $ext,
        ));
        $ids = array_keys($order_info);
        if (!$order_info)
        {
            echo Lang::get('no_such_order');

            return;
        }
        if (!IS_POST)
        {
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->assign('orders', $order_info);
            $this->assign('order_id', count($ids) == 1 ? current($ids) : implode(',', $ids));
            $this->display('seller_order.cancel.html');
        }
        else
        {
            $model_order    =&  m('order');
            foreach ($ids as $val)
            {
                $id = intval($val);
                $model_order->edit($id, array('status' => ORDER_CANCELED));
                if ($model_order->has_error())
                {
                    //$_erros = $model_order->get_error();
                    //$error = current($_errors);
                    //$this->json_error(Lang::get($error['msg']));
                    //return;
                    continue;
                }

				/*站内宝v2.2.1  更新站内宝定单状态 开始*/
				$my_money_mod =& m('my_money');
				$my_moneylog_mod =& m('my_moneylog');
				$my_moneylog_row=$my_moneylog_mod->getrow("select * from ".DB_PREFIX."my_moneylog where order_id='$id' and (caozuo='10' or caozuo='20') and s_and_z=1");
				$money=$my_moneylog_row['money'];//定单价格
				$buy_user_id=$my_moneylog_row['buyer_id'];//买家ID
				$sell_user_id=$my_moneylog_row['seller_id'];//卖家ID
				if($my_moneylog_row['order_id']==$id)
				{
					$buy_money_row=$my_money_mod->getrow("select * from ".DB_PREFIX."my_money where user_id='$buy_user_id'");
					$buy_money=$buy_money_row['money'];//买家的钱
					
					$sell_money_row=$my_money_mod->getrow("select * from ".DB_PREFIX."my_money where user_id='$sell_user_id'");
					$sell_money=$sell_money_row['money_dj'];//卖家的冻结资金
					
					$new_buy_money = $buy_money+$money;
					$new_sell_money = $sell_money-$money;
					//更新数据
					$my_money_mod->edit('user_id='.$buy_user_id,array('money'=>$new_buy_money));
					$my_money_mod->edit('user_id='.$sell_user_id,array('money_dj'=>$new_sell_money));
					//更新站内宝log为 定单已取消
					$my_moneylog_mod->edit('order_id='.$id,array('caozuo'=>30));
				}
				/*站内宝v2.2.1  更新站内宝定单状态 结束*/


                /* 加回订单商品库存 */
                $model_order->change_stock('+', $id);
                $cancel_reason = (!empty($_POST['remark'])) ? $_POST['remark'] : $_POST['cancel_reason'];
                /* 记录订单操作日志 */
                $order_log =& m('orderlog');
                $order_log->add(array(
                    'order_id'  => $id,
                    'operator'  => addslashes($this->visitor->get('user_name')),
                    'order_status' => order_status($order_info[$id]['status']),
                    'changed_status' => order_status(ORDER_CANCELED),
                    'remark'    => $cancel_reason,
                    'log_time'  => gmtime(),
                ));

				if($order_info[$id]['payment_code']=='deposit')
				{
					$deposit_record_mod = &m('deposit_record');
					$deposit_account_mod= &m('deposit_account');
					$deposit_refund_mod = &m('deposit_refund');
					if($deposit_record = $deposit_record_mod->get(array('conditions'=>"order_sn='".$order_info[$id]['order_sn']."' AND party_id=".$this->visitor->get('user_id'))))
					{
						
						$deposit_record_mod->edit("order_sn='".$order_info[$id]['order_sn']."' AND user_id=".$order_info[$id]['buyer_id'], array('status' =>'CLOSED', 'end_time'=>gmtime()));
					
						
						$data_refund = array(
							'record_id'	=>	$deposit_record['record_id'],
							'user_id'	=>	$order_info[$id]['buyer_id'],// 获得退款的用户ID
							'amount'	=>	$deposit_record['amount'],
							'status'	=>	'SUCCESS',
							'remark'	=>	LANG::get('seller_cancel_order'),
						);
						$deposit_refund_mod->add($data_refund);
						
						
						$deposit_account_mod->_update_deposit_money($order_info[$id]['buyer_id'], $deposit_record['amount'], 'add');
					}
				}
                /* 发送给买家订单取消通知 */
                $model_member =& m('member');
                $buyer_info   = $model_member->get($order_info[$id]['buyer_id']);
                $mail = get_mail('tobuyer_cancel_order_notify', array('order' => $order_info[$id], 'reason' => $_POST['remark']));
                $this->_mailto($buyer_info['email'], addslashes($mail['subject']), addslashes($mail['message']));

                $new_data = array(
                    'status'    => Lang::get('order_canceled'),
                    'actions'   => array(), //取消订单后就不能做任何操作了
                );
            }
            $this->pop_warning('ok', 'seller_order_cancel_order');
        }

    }

    /**
     *    完成交易(货到付款的订单)
     *
     *    @author    Garbin
     *    @return    void
     */
    function finished()
    {
        list($order_id, $order_info)    = $this->_get_valid_order_info(ORDER_SHIPPED, 'payment_code=\'cod\'');
        if (!$order_id)
        {
            echo Lang::get('no_such_order');

            return;
        }
        if (!IS_POST)
        {
            header('Content-Type:text/html;charset=' . CHARSET);
            /* 当前用户中心菜单 */
            $this->_curitem('seller_order');
            /* 当前所处子菜单 */
            $this->_curmenu('finished');
            $this->assign('_curmenu','finished');
            $this->assign('order', $order_info);
            $this->display('seller_order.finished.html');
        }
        else
        {
            $now = gmtime();
            $model_order    =&  m('order');
            $model_order->edit($order_id, array('status' => ORDER_FINISHED, 'pay_time' => $now, 'finished_time' => $now));
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
                'remark'    => $_POST['remark'],
                'log_time'  => gmtime(),
            ));

            /* 更新累计销售件数 */
            $model_goodsstatistics =& m('goodsstatistics');
            $model_ordergoods =& m('ordergoods');
            $order_goods = $model_ordergoods->find("order_id={$order_id}");
            foreach ($order_goods as $goods)
            {
                $model_goodsstatistics->edit($goods['goods_id'], "sales=sales+{$goods['quantity']}");
            }
            
            
            /* 发送给买家交易完成通知，提示评论 */
            $model_member =& m('member');
            $buyer_info   = $model_member->get($order_info['buyer_id']);
            $mail = get_mail('tobuyer_cod_order_finish_notify', array('order' => $order_info));
            $this->_mailto($buyer_info['email'], addslashes($mail['subject']), addslashes($mail['message']));

            $new_data = array(
                'status'    => Lang::get('order_finished'),
                'actions'   => array(), //完成订单后就不能做任何操作了
            );

            $this->pop_warning('ok');
        }

    }
	
	/*打印发货单*/
   	function shipped_print()
   	{
	   	$order_ids = isset($_GET['order_id']) ? $_GET['order_id'] : 0;
     	$order_id = explode(",",$order_ids);
        if (!$order_id)
        {
          $this->show_message('no_such_order');	
          return;
        }
     	$model_order = &m('order');
     	$order_info = $model_order->findAll(array(
            'fields'	=>'this.*,s.tel,shipping_fee,consignee,phone_tel,phone_mob,order_extm.region_name,order_extm.address',
     		'conditions' =>  "order_alias.order_id" . db_create_in($order_id) . " AND seller_id=" . $this->visitor->get('manage_store'),
     		'join'      => 'has_orderextm,belongs_to_store',
			'include' => array('has_ordergoods'),
           
        ));
     	//dump($order_info);
		$goods_mod =  &m('goods');
	
        foreach($order_info as $k=>$v)
        {
	        if($v['order_goods'])
	        {
	        	foreach($v['order_goods'] as $key=>$value)
		        {
		        	$order_info[$k]['count_goods']+=$value['quantity'];
		        	$goods_info = $goods_mod->get_list($value['goods_id']);
		        	$order_info[$k]['order_goods'][$key]['sku'] = $goods_info[$value['goods_id']]['sku'];
		        }
	        }
	        else
	       {
	       		$order_info[$k]['nogoods'] =1;
	        }
	       
        }
        //dump($order_info);
        $this->assign('order_info',$order_info);
        $this->display('shipped_print.html');
   	}
	
	/*打印发货单*/
   	function post_print()
   	{
	   	$order_ids = isset($_GET['order_id']) ? $_GET['order_id'] : 0;
     	$order_id = explode(",",$order_ids);
        if (!$order_id)
        {
          $this->show_message('no_such_order');	
          return;
        }
     	$model_order = &m('order');
     	$order_info = $model_order->findAll(array(
            'fields'	=>'this.*,s.tel,shipping_fee,consignee,phone_tel,phone_mob,order_extm.region_name,order_extm.address',
     		'conditions' =>  "order_alias.order_id" . db_create_in($order_id) . " AND seller_id=" . $this->visitor->get('manage_store'),
     		'join'      => 'has_orderextm,belongs_to_store',
			'include' => array('has_ordergoods'),
           
        ));
     	//dump($order_info);
		$goods_mod =  &m('goods');
	
        foreach($order_info as $k=>$v)
        {
	        if($v['order_goods'])
	        {
	        	foreach($v['order_goods'] as $key=>$value)
		        {
		        	$order_info[$k]['count_goods']+=$value['quantity'];
		        	$goods_info = $goods_mod->get_list($value['goods_id']);
		        	$order_info[$k]['order_goods'][$key]['sku'] = $goods_info[$value['goods_id']]['sku'];
		        }
	        }
	        else
	       {
	       		$order_info[$k]['nogoods'] =1;
	        }
	       
        }
        //dump($order_info);
        $this->assign('order_info',$order_info);
        $this->display('post_print.html');
   	}

    /**
     *    获取有效的订单信息
     *
     *    @author    Garbin
     *    @param     array $status
     *    @param     string $ext
     *    @return    array
     */
    function _get_valid_order_info($status, $ext = '')
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (!$order_id)
        {

            return array();
        }
        if (!is_array($status))
        {
            $status = array($status);
        }

        if ($ext)
        {
            $ext = ' AND ' . $ext;
        }

        $model_order    =&  m('order');
        /* 只有已发货的货到付款订单可以收货 */
        $order_info     = $model_order->get(array(
            'conditions'    => "order_id={$order_id} AND seller_id=" . $this->visitor->get('manage_store') . " AND status " . db_create_in($status) . $ext,
        ));
        if (empty($order_info))
        {

            return array();
        }

        return array($order_id, $order_info);
    }
    /**
     *    获取订单列表
     *
     *    @author    Garbin
     *    @return    void
     */
    function _get_orders()
    {
        $page = $this->_get_page();
        $model_order =& m('order');

        !$_GET['type'] && $_GET['type'] = 'all_orders';

        $conditions = '';

        // 团购订单
        if (!empty($_GET['group_id']) && intval($_GET['group_id']) > 0)
        {
            $groupbuy_mod = &m('groupbuy');
            $order_ids = $groupbuy_mod->get_order_ids(intval($_GET['group_id']));
            $order_ids && $conditions .= ' AND order_alias.order_id' . db_create_in($order_ids);
        }

        $conditions .= $this->_get_query_conditions(array(
            array(      //按订单状态搜索
                'field' => 'status',
                'name'  => 'type',
                'handler' => 'order_status_translator',
            ),
            array(      //按买家名称搜索
                'field' => 'buyer_name',
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
        ));

        /* 查找订单 */
        $orders = $model_order->findAll(array(
            'conditions'    => "seller_id=" . $this->visitor->get('manage_store') . "{$conditions}",
            'count'         => true,
            'join'          => 'has_orderextm',
            'limit'         => $page['limit'],
            'order'         => 'add_time DESC',
            'include'       =>  array(
                'has_ordergoods',       //取出商品
            ),
        ));
		$refund_mod =& m('refund');
		$member_mod =& m('member');
        $model_spec =& m('goodsspec');
		
        foreach ($orders as $key1 => $order)
        {
            foreach ($order['order_goods'] as $key2 => $goods)
            {
                empty($goods['goods_image']) && $orders[$key1]['order_goods'][$key2]['goods_image'] = Conf::get('default_goods_image');
				
				$refund = $refund_mod->get(array(
					'conditions'=>'order_id='.$goods['order_id'].' and goods_id='.$goods['goods_id'].' and spec_id='.$goods['spec_id'],
					'fields'=>'status,order_id'
				));
				if($refund) {
					$orders[$key1]['order_goods'][$key2]['refund_status'] = $refund['status'];
					$orders[$key1]['order_goods'][$key2]['refund_id'] = $refund['refund_id'];
				}
				$spec = $model_spec->get(array('conditions'=>'spec_id='.$goods['spec_id'],'fields'=>'sku')); 
				$orders[$key1]['order_goods'][$key2]['sku'] = $spec['sku'];
            }

			$orders[$key1]['goods_quantities'] = count($order['order_goods']);
			$orders[$key1]['buyer_info'] = $member_mod->get(array('conditions'=>'user_id='.$order['buyer_id'],'fields'=>'real_name,im_qq,im_aliww,im_msn'));
        }

        $page['item_count'] = $model_order->getCount();
        $this->_format_page($page);
        $this->assign('types', array('all' => Lang::get('all_orders'),
                                     'pending' => Lang::get('pending_orders'),
                                     'submitted' => Lang::get('submitted_orders'),
                                     'accepted' => Lang::get('accepted_orders'),
                                     'shipped' => Lang::get('shipped_orders'),
                                     'finished' => Lang::get('finished_orders'),
                                     'canceled' => Lang::get('canceled_orders')));
        $this->assign('type', $_GET['type']);
        $this->assign('orders', $orders);
        $this->assign('page_info', $page);
    }
    /*三级菜单*/
    function _get_member_submenu()
    {
        $array = array(
            array(
                'name' => 'all_orders',
                'url' => 'index.php?app=seller_order&amp;type=all_orders',
            ),
            array(
                'name' => 'pending',
                'url' => 'index.php?app=seller_order&amp;type=pending',
            ),
            array(
                'name' => 'submitted',
                'url' => 'index.php?app=seller_order&amp;type=submitted',
            ),
            array(
                'name' => 'accepted',
                'url' => 'index.php?app=seller_order&amp;type=accepted',
            ),
            array(
                'name' => 'shipped',
                'url' => 'index.php?app=seller_order&amp;type=shipped',
            ),
            array(
                'name' => 'finished',
                'url' => 'index.php?app=seller_order&amp;type=finished',
            ),
            array(
                'name' => 'canceled',
                'url' => 'index.php?app=seller_order&amp;type=canceled',
        ),
        );
        return $array;
    }
}

?>
