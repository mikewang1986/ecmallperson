<?php

/**
 *    平台支付网关通知接口
 *
 *    @author    Garbin
 *    @usage    none
 */
class DepopaynotifyApp extends MallbaseApp
{
    /**
     *    支付完成后返回的URL，在此只进行提示，不对订单进行任何修改操作,这里不严格验证，不改变订单状态
     *
     *    @author    psmb
     *    @return    void
     */
    function index()
    {
        //这里是支付宝，财付通等当订单状态改变时的通知地址
		
        $tradesn   = isset($_GET['tradesn']) ? trim($_GET['tradesn']) : ''; //哪个订单
        if (!$tradesn)
        {
            /* 无效的通知请求 */
            $this->show_warning('forbidden');
			return;
        }

        /* 获取充值信息 */
		$deposit_recharge_mod = &m('deposit_recharge');
		$trade_info = $deposit_recharge_mod->get('tradesn='.$tradesn);

		if(!$trade_info)
		{
			/* 没有该充值记录 */
            $this->show_warning('forbidden');
			return;
		}
		
		$recharge_extra = unserialize($trade_info['extra']);
		
		$payment_model =& m('payment');
		$payment_info  = $payment_model->get("payment_code ='".$recharge_extra['payment_code']."' AND store_id=0");
				
		/* 若平台没有启用，则不允许使用 */
		if (!$payment_info['enabled'])
		{
			$this->show_warning('payment_disabled');

			return;
		}
						
		/* 调用相应的支付方式 */
		$payment    = $this->_get_platform_payment($recharge_extra['payment_code'], $payment_info);


        /* 获取验证结果 */
        $notify_result = $payment->verify_notify($trade_info);
		
        if ($notify_result === false)
        {
            /* 支付失败 */
            $this->show_warning($payment->get_error());

            return;
        }

        /* 只有支付时会使用到return_url，所以这里显示的信息是支付成功的提示信息 */
        $this->_curlocal(LANG::get('pay_successed'));
        $this->assign('trade', $trade_info);
        $this->assign('payment', $payment_info);
        $this->display('depopaynotify.index.html');
    }

    /**
     *    支付完成后，外部网关的通知地址，在此会进行订单状态的改变，这里严格验证，改变订单状态
     *
     *    @author    Garbin
     *    @return    void
     */
    function notify()
    {		
        //这里是支付宝，财付通等当订单状态改变时的通知地址
        $tradesn   = 0;
        if(isset($_POST['tradesn']))
        {
            $tradesn = trim($_POST['tradesn']);
        }
        else
        {
            $tradesn = trim($_GET['tradesn']);
        }
        if (!$tradesn)
        {
            /* 无效的通知请求 */
            $this->show_warning('no_such_trade');
            return;
        }
		
		/* 获取充值信息 */
		$deposit_recharge_mod = &m('deposit_recharge');
		$trade_info = $deposit_recharge_mod->get('tradesn='.$tradesn);
		
		if(!$trade_info)
		{
			/* 没有该充值记录 */
            $this->show_warning('no_such_trade');
			return;	
		}
		
		$recharge_extra = unserialize($trade_info['extra']);
		
		$payment_model =& m('payment');
		$payment_info  = $payment_model->get("payment_code ='".$recharge_extra['payment_code']."' AND store_id=0");
		
		/* 若平台没有启用，则不允许使用 */
		if (!$payment_info['enabled'])
		{
			$this->show_warning('payment_disabled');

			return;
		}
						
		/* 调用相应的支付方式 */
		$payment    = $this->_get_platform_payment($recharge_extra['payment_code'], $payment_info);
        /* 获取验证结果 */
        $notify_result = $payment->verify_notify($trade_info, true);
		
        if ($notify_result === false)
        {
            /* 支付失败 */
            $payment->verify_result(false);
            return;
        }

        //改变交易状态
        $this->_change_trade_status($tradesn, $notify_result);
        $payment->verify_result(true);
    }
	
	/**
     *    改变交易状态
     *
     *    @author    psmb
     *    @param     int $tradesn
     *    @param     array  $notify_result
     *    @return    void
     */
    function _change_trade_status($tradesn, $notify_result)
    {
		/* 将验证结果传递给业务类型处理 */
		$depopay_type    =&  dpt('income', 'recharge');
		$depopay_type->respond_notify($tradesn, $notify_result);    //响应通知
    }
}

?>
