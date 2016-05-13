<?php

/**
 *    收银台控制器，其扮演的是收银员的角色，你只需要将你的订单交给收银员，收银员按订单来收银，她专注于这个过程
 *
 *    @author    Garbin
 */
class CashierApp extends ShoppingbaseApp
{
    /**
     *    根据提供的订单信息进行支付
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
    function index()
    {
        /* 外部提供订单号 */
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (!$order_id)
        {
            $this->show_warning('no_such_order');

            return;
        }
        /* 内部根据订单号收银,获取收多少钱，使用哪个支付接口 */
        $order_model =& m('order');
        $order_info  = $order_model->get("order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id'));
        if (empty($order_info))
        {
            $this->show_warning('no_such_order');

            return;
        }
        /* 订单有效性判断 */
        if ($order_info['payment_code'] != 'cod' && $order_info['payment_code'] != 'cos' && $order_info['status'] != ORDER_PENDING)
        {
            $this->show_warning('no_such_order');
            return;
        }
        $payment_model =& m('payment');
        $store_mod = & m('store');
        if (!$order_info['payment_id'])
        {
            /* 若还没有选择支付方式，则让其选择支付方式 */
        	$store_info = $store_mod->get_info($order_info['seller_id']);
        	if($store_info['is_open_pay']){
        		$payments = $payment_model->get_enabled($order_info['seller_id']);
        	}else{
        		$payments = $payment_model->get_enabled(0);	
        	}
            if (empty($payments))
            {
                $this->show_warning('store_no_payment');

                return;
            }
            /* 找出配送方式，判断是否可以使用货到付款 */
            $model_extm =& m('orderextm');
            $consignee_info = $model_extm->get($order_id);
            if (!empty($consignee_info))
            {
                /* 需要配送方式 */
                $model_shipping =& m('shipping');
				if(!$consignee_info['shipping_id'])
				{
					$current_payment=current($payments);
					$all_store_ships=$model_shipping->find("store_id=".$current_payment['store_id']);
					if($all_store_ships)
					{
						$cod_regions=array();
						foreach($all_store_ships as $key=>$val)
						{
							 $cod_regions+= unserialize($val['cod_regions']);
						}
					}
				}else{
					$shipping_info = $model_shipping->get($consignee_info['shipping_id']);
					$cod_regions   = unserialize($shipping_info['cod_regions']);
				}
                $cod_usable = true;//默认可用
                if (is_array($cod_regions) && !empty($cod_regions))
                {
                    /* 取得支持货到付款地区的所有下级地区 */
                    $all_regions = array();
                    $model_region =& m('region');
                    foreach ($cod_regions as $region_id => $region_name)
                    {
                        $all_regions = array_merge($all_regions, $model_region->get_descendant($region_id));
                    }

                    /* 查看订单中指定的地区是否在可货到付款的地区列表中，如果不在，则不显示货到付款的付款方式 */
                    if (!in_array($consignee_info['region_id'], $all_regions))
                    {
                        $cod_usable = false;
                    }
                }
                else
                {
                    $cod_usable = false;
                }

            }
            $all_payments = array('online' => array(), 'offline' => array());
            foreach ($payments as $key => $payment)
            {
				
				if( $payment['payment_code']!='alipay_bank')
				{
					
				 if ($payment['is_online'] )
                {
                    $all_payments['online'][] = $payment;
                }
                else
                {
                    $all_payments['offline'][] = $payment;
                }
				
				}else{
					 $this->assign('alipay_bank', '1');
				
					}			
            }

			//站内宝 v2.2.1 读取资金，读取店铺是否安装支付方式
			$my_money_model =& m('my_money');//model
			$user_id=$this->visitor->get('user_id');
			$my_money=$my_money_model->getAll("select * from ".DB_PREFIX."my_money where user_id=$user_id");
			$this->assign('money', $my_money);
			
			$seller_id=$order_info['seller_id'];
			$sft=$payment_model->getAll("select * from ".DB_PREFIX."payment where store_id=$seller_id and enabled=1 and payment_code='sft'");
			$this->assign('sft', $sft);
			//站内宝 v2.2.1 结束
            $this->assign('order', $order_info);
            $this->assign('payments', $all_payments);
			$this->assign('alipaybank', $this->_get_bank_inc('alipaybank'));
            $this->_curlocal(
                LANG::get('cashier')
            );

            $this->_config_seo('title', Lang::get('confirm_payment') . ' - ' . Conf::get('site_title'));
            $this->display('cashier.payment.html');
        }
        else
        {
            /* 否则直接到网关支付 */
            /* 验证支付方式是否可用，若不在白名单中，则不允许使用 */
            if (!$payment_model->in_white_list($order_info['payment_code']))
            {
                $this->show_warning('payment_disabled_by_system');

                return;
            }
            $store_mod = & m('store');
        	$store_info = $store_mod->get_info($order_info['seller_id']);
        	if($store_info['is_open_pay']){
            	$payment_info  = $payment_model->get("payment_code = '{$order_info['payment_code']}' AND store_id={$order_info['seller_id']}");
        	}else{
        		$payment_info  = $payment_model->get("payment_code = '{$order_info['payment_code']}' AND store_id=0");
        	
			
			}	
			
			  if ($order_info['payment_code']!='alipay_bank'){
            /* 若卖家没有启用，则不允许使用 */
            if (!$payment_info['enabled'])
            {
                $this->show_warning('payment_disabled');

                return;
            }
			  }
            /* 生成支付URL或表单 */
         if($order_info['payment_code']=='wapalipay')
			{
		    $payment    = $this->_get_payment2($order_info['payment_code'], $payment_info);
            $payment_form = $payment->get_payform($order_info);
				
			}else {
				
			$payment  = $this->_get_payment($order_info['payment_code'], $payment_info);
            $payment_form = $payment->get_payform($order_info);
				}

            /* 货到付款，则显示提示页面 */
            if ($payment_info['payment_code'] == 'cod')
            {
                $this->show_message('cod_order_notice',
                    'view_order',   'index.php?app=buyer_order',
                    'close_window', 'javascript:window.close();'
                );

                return;
            }
			
            /* 到店付款，则显示提示页面 */
            if ($payment_info['payment_code'] == 'cos')
            {
                $this->show_message('cos_order_notice',
                    'view_order',   'index.php?app=buyer_order',
                    'close_window', 'javascript:window.close();'
                );

                return;
            }
			
			
			 /* 微信支付，则显示提示页面 */
            if ($payment_info['payment_code'] == 'weixin')
            {
                 /* 跳转到真实收银台 */
            $this->_config_seo('title', Lang::get('cashier'));
            $this->assign('payform', $payment_form);
            $this->assign('payment', $payment_info);
            $this->assign('order', $order_info);
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->display('cashier.payform_weixin.html');

                return;
            }
			

            /* 微信支付，则显示提示页面 */
            if ($payment_info['payment_code'] == 'wxnative')
            {
                 /* 跳转到真实收银台 */
            $this->_config_seo('title', Lang::get('cashier'));
            $this->assign('payform', $payment_form);
            $this->assign('payment', $payment_info);
            $this->assign('order', $order_info);
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->display('cashier.payform_wx.html');

                return;
            }

            
			

            /* 线下付款的 */
            if (!$payment_info['online'])
            {
                $this->_curlocal(
                    Lang::get('post_pay_message')
                );
            }

            /* 跳转到真实收银台 */
            $this->_config_seo('title', Lang::get('cashier'));
            $this->assign('payform', $payment_form);
            $this->assign('payment', $payment_info);
            $this->assign('order', $order_info);
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->display('cashier.payform.html');
        }
    }

    /**
     *    确认支付
     *
     *    @author    Garbin
     *    @return    void
     */
    function goto_pay()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        $payment_id = isset($_POST['payment_id']) ? intval($_POST['payment_id']) : 0;
    	
		  $payment_model =& m('payment');
		if($_POST['defaultbank'])
		{
	
	  $payment_info  = $payment_model->get("payment_code = 'alipay_bank' AND store_id=0");
	
	 
	   $payment_id= $payment_info['payment_id'];
		}
		
	
	 /*   if(!$payment_id)
		{
			  $payment_id='91';
		}*/
		 
	    if (!$order_id)
        {
            $this->show_warning('no_such_order');

            return;
        }
        if (!$payment_id)
        {
            $this->show_warning('no_such_payment');

            return;
        }
        $order_model =& m('order');
        $order_info  = $order_model->get("order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id'));
       
	   
	   	if($_POST['defaultbank'])
		{
	
	   $payment_info  = $payment_model->get("payment_code = 'alipay_bank' AND store_id=$order_info[seller_id]");
	

	   $payment_id= $payment_info['payment_id'];
	 
		}
	
	    if (empty($order_info))
        {
            $this->show_warning('no_such_order');

            return;
        }

        #可能不合适
        if ($order_info['payment_id'])
        {
            $this->_goto_pay($order_id);
            return;
        }

        /* 验证支付方式 */
        $payment_model =& m('payment');
        $payment_info  = $payment_model->get($payment_id);
        if (!$payment_info)
        {
            $this->show_warning('no_such_payment');

            return;
        }
		
		
		if($_POST['defaultbank'])
		{
	 
	 	 $edit_data = array(
            'payment_id'    =>  $payment_info['payment_id'],
            'payment_code'  => 'alipay_bank',
            'payment_name'  =>  $payment_info['payment_name'],
		    'payment_bank'  =>  $_POST['defaultbank'],
         );	
			
	   
	    }else {
			$edit_data = array(
            'payment_id'    =>  $payment_info['payment_id'],
            'payment_code'  =>  $payment_info['payment_code'],
            'payment_name'  =>  $payment_info['payment_name'],
        );
			
			}

        /* 保存支付方式 */
        

        /* 如果是货到付款，则改变订单状态 */
        if ($payment_info['payment_code'] == 'cod')
        {
            $edit_data['status']    =   ORDER_SUBMITTED;
        }
		
        /* 如果是到店付款，则改变订单状态 */
        if ($payment_info['payment_code'] == 'cos')
        {
            $edit_data['status']    =   ORDER_SUBMITTED;
        }

        $order_model->edit($order_id, $edit_data);

        /* 开始支付 */
        if($payment_info['payment_code'] == 'wxjsapi')
        {
            $this->_goto_wxjsapi($order_id);
        }
        else
        {
            $this->_goto_pay($order_id);
        }
        
    }

    /**
     *    线下支付消息
     *
     *    @author    Garbin
     *    @return    void
     */
    function offline_pay()
    {
        if (!IS_POST)
        {
            return;
        }
        $order_id       = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        $pay_message    = isset($_POST['pay_message']) ? trim($_POST['pay_message']) : '';
        if (!$order_id)
        {
            $this->show_warning('no_such_order');
            return;
        }
        if (!$pay_message)
        {
            $this->show_warning('no_pay_message');

            return;
        }
        $order_model =& m('order');
        $order_info  = $order_model->get("order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id'));
        if (empty($order_info))
        {
            $this->show_warning('no_such_order');

            return;
        }
        $edit_data = array(
            'pay_message' => $pay_message
        );

        $order_model->edit($order_id, $edit_data);

        /* 线下支付完成并留下pay_message,发送给卖家付款完成提示邮件 */
        $model_member =& m('member');
        $seller_info   = $model_member->get($order_info['seller_id']);
        $mail = get_mail('toseller_offline_pay_notify', array('order' => $order_info, 'pay_message' => $pay_message));
        $this->_mailto($seller_info['email'], addslashes($mail['subject']), addslashes($mail['message']));

        $this->show_message('pay_message_successed',
            'view_order',   'index.php?app=buyer_order',
            'close_window', 'javascript:window.close();');
    }

    function _goto_wxjsapi($order_id)
    {
        header('Location:index.php?app=cashier&act=wxjsapi&order_id=' . $order_id);
    }
    function _goto_pay($order_id)
    {
        header('Location:index.php?app=cashier&order_id=' . $order_id);
    }

    function wxjsapi()
    {


        /* 外部提供订单号 */
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (!$order_id)
        {
            $this->show_warning('no_such_order');

            return;
        }
        /* 内部根据订单号收银,获取收多少钱，使用哪个支付接口 */
        $order_model =& m('order');
               
        $order_info = $order_model->get("order_id={$order_id}");
        //$order_info  = $order_model->get("order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id'));
        if (empty($order_info))
        {
            $this->show_warning('no_such_order');

            return;
        }
        /* 订单有效性判断 */
        if ($order_info['payment_code'] != 'cod' && $order_info['payment_code'] != 'cos' && $order_info['status'] != ORDER_PENDING)
        {
            $this->show_warning('no_such_order');
            return;
        }
        $payment_model =& m('payment');
        $store_mod = & m('store');
        if (!$order_info['payment_id'])
        {
            /* 若还没有选择支付方式，则让其选择支付方式 */
        	$store_info = $store_mod->get_info($order_info['seller_id']);
        	if($store_info['is_open_pay']){
        		$payments = $payment_model->get_enabled($order_info['seller_id']);
        	}else{
        		$payments = $payment_model->get_enabled(0);	
        	}
            if (empty($payments))
            {
                $this->show_warning('store_no_payment');

                return;
            }
            /* 找出配送方式，判断是否可以使用货到付款 */
            $model_extm =& m('orderextm');
            $consignee_info = $model_extm->get($order_id);
            if (!empty($consignee_info))
            {
                /* 需要配送方式 */
                $model_shipping =& m('shipping');
				if(!$consignee_info['shipping_id'])
				{
					$current_payment=current($payments);
					$all_store_ships=$model_shipping->find("store_id=".$current_payment['store_id']);
					if($all_store_ships)
					{
						$cod_regions=array();
						foreach($all_store_ships as $key=>$val)
						{
							 $cod_regions+= unserialize($val['cod_regions']);
						}
					}
				}else{
					$shipping_info = $model_shipping->get($consignee_info['shipping_id']);
					$cod_regions   = unserialize($shipping_info['cod_regions']);
				}
                $cod_usable = true;//默认可用
                if (is_array($cod_regions) && !empty($cod_regions))
                {
                    /* 取得支持货到付款地区的所有下级地区 */
                    $all_regions = array();
                    $model_region =& m('region');
                    foreach ($cod_regions as $region_id => $region_name)
                    {
                        $all_regions = array_merge($all_regions, $model_region->get_descendant($region_id));
                    }

                    /* 查看订单中指定的地区是否在可货到付款的地区列表中，如果不在，则不显示货到付款的付款方式 */
                    if (!in_array($consignee_info['region_id'], $all_regions))
                    {
                        $cod_usable = false;
                    }
                }
                else
                {
                    $cod_usable = false;
                }
                if (!$cod_usable)
                {
                    /* 从列表中去除货到付款的方式 */
                    foreach ($payments as $_id => $_info)
                    {
                        if ($_info['payment_code'] == 'cod')
                        {
                            /* 如果安装并启用了货到付款，则将其从可选列表中去除 */
                            unset($payments[$_id]);
                        }
                    }
                }
            }
            $all_payments = array('online' => array(), 'offline' => array());
            foreach ($payments as $key => $payment)
            {
				
				if( $payment['payment_code']!='alipay_bank')
				{
					
				 if ($payment['is_online'] )
                {
                    $all_payments['online'][] = $payment;
                }
                else
                {
                    $all_payments['offline'][] = $payment;
                }
				
				}else{
					 $this->assign('alipay_bank', '1');
				
					}
               
				
				
				
				
            }

			//站内宝 v2.2.1 读取资金，读取店铺是否安装支付方式
			$my_money_model =& m('my_money');//model
			$user_id=$this->visitor->get('user_id');
			$my_money=$my_money_model->getAll("select * from ".DB_PREFIX."my_money where user_id=$user_id");
			$this->assign('money', $my_money);
			
			$seller_id=$order_info['seller_id'];
			$sft=$payment_model->getAll("select * from ".DB_PREFIX."payment where store_id=$seller_id and enabled=1 and payment_code='sft'");
			$this->assign('sft', $sft);
			//站内宝 v2.2.1 结束
            $this->assign('order', $order_info);
            $this->assign('payments', $all_payments);
			$this->assign('alipaybank', $this->_get_bank_inc('alipaybank'));
            $this->_curlocal(
                LANG::get('cashier')
            );

            $this->_config_seo('title', Lang::get('confirm_payment') . ' - ' . Conf::get('site_title'));
            $this->display('cashier.payment.html');
        }
        else
        {
            /* 否则直接到网关支付 */
            /* 验证支付方式是否可用，若不在白名单中，则不允许使用 */
            if (!$payment_model->in_white_list($order_info['payment_code']))
            {
                $this->show_warning('payment_disabled_by_system');

                return;
            }
            $store_mod = & m('store');
        	$store_info = $store_mod->get_info($order_info['seller_id']);
        	if($store_info['is_open_pay']){
            	$payment_info  = $payment_model->get("payment_code = '{$order_info['payment_code']}' AND store_id={$order_info['seller_id']}");
        	}else{
        		$payment_info  = $payment_model->get("payment_code = '{$order_info['payment_code']}' AND store_id=0");
        	
			
			}	
			
			  if ($order_info['payment_code']!='alipay_bank'){
            /* 若卖家没有启用，则不允许使用 */
            if (!$payment_info['enabled'])
            {
                $this->show_warning('payment_disabled');

                return;
            }
			  }
            /* 生成支付URL或表单 */
         if($order_info['payment_code']=='wapalipay')
			{
		    $payment    = $this->_get_payment2($order_info['payment_code'], $payment_info);
            $payment_form = $payment->get_payform($order_info);
				
			}else {
				
			$payment  = $this->_get_payment($order_info['payment_code'], $payment_info);
            $payment_form = $payment->get_payform($order_info);
				}

            /* 货到付款，则显示提示页面 */
            if ($payment_info['payment_code'] == 'cod')
            {
                $this->show_message('cod_order_notice',
                    'view_order',   'index.php?app=buyer_order',
                    'close_window', 'javascript:window.close();'
                );

                return;
            }
			
            /* 到店付款，则显示提示页面 */
            if ($payment_info['payment_code'] == 'cos')
            {
                $this->show_message('cos_order_notice',
                    'view_order',   'index.php?app=buyer_order',
                    'close_window', 'javascript:window.close();'
                );

                return;
            }
			
			 /* 微信支付，则显示提示页面 */
            if ($payment_info['payment_code'] == 'weixin')
            {
                 /* 跳转到真实收银台 */
            $this->_config_seo('title', Lang::get('cashier'));
            $this->assign('payform', $payment_form);
            $this->assign('payment', $payment_info);
            $this->assign('order', $order_info);
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->display('cashier.payform_weixin.html');

                return;
            }
			

            /* 微信支付，则显示提示页面 */
            if ($payment_info['payment_code'] == 'wxjsapi')
            {
                 /* 跳转到真实收银台 */
            $this->_config_seo('title', Lang::get('cashier'));
            $this->assign('payform', $payment_form);
            $this->assign('payment', $payment_info);
            $this->assign('order', $order_info);
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->display('cashier.payform_wx.html');

                return;
            }

            
			

            /* 线下付款的 */
            if (!$payment_info['online'])
            {
                $this->_curlocal(
                    Lang::get('post_pay_message')
                );
            }

            /* 跳转到真实收银台 */
            $this->_config_seo('title', Lang::get('cashier'));
            $this->assign('payform', $payment_form);
            $this->assign('payment', $payment_info);
            $this->assign('order', $order_info);
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->display('cashier.payform.html');
        }
    }
}

?>
