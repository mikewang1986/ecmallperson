<?php

/**
 *    退款维权管理控制器
 *
 *    @author    Garbin
 *    @usage    none
 */
class RefundApp extends MemberbaseApp
{
	var $_order_mod;
	var $_order_log_mod;
	var $_order_extm_mod;
	var $_goods_mod;
	var $_ordergoods_mod;
	var $_refund_mod;
	var $_store_mod;
	var $_member_mod;
	var $_refund_message_mod;
	
	function __construct()
    {
        $this->RefundApp();
    }
    function RefundApp()
    {
        parent::__construct();
        $this->_order_mod = &m('order');
		$this->_order_log_mod = &m('orderlog');
		$this->_order_extm_mod = &m('orderextm');
        $this->_goods_mod = &m('goods');
		$this->_ordergoods_mod = &m('ordergoods');
		$this->_refund_mod = &m('refund');
		$this->_store_mod = &m('store');
		$this->_member_mod = &m('member');
		$this->_refund_message_mod = &m('refund_message');
    }
	
    function index()
    {	
		$page   =   $this->_get_page(10);   //获取分页信息
		$refunds = $this->_refund_mod->find(array(
			'conditions'=>'buyer_id='.$this->visitor->get('user_id'),
			'limit'=>$page['limit'],
			'order'     => 'created desc',
			'count'   => true
		));
		$page['item_count']=$this->_refund_mod->getCount();
		foreach($refunds as $key=>$refund)
		{
			$store = $this->_store_mod->get(array('conditions'=>'store_id='.$refund['seller_id'],'fields'=>'store_name,owner_name'));
			$refunds[$key]['store_name']=$store['store_name'];
			$refunds[$key]['user_name'] = $store['owner_name'];
			$goods = $this->_goods_mod->get(array('conditions'=>'goods_id='.$refund['goods_id'],'fields'=>'goods_name'));
			$refunds[$key]['goods_name'] = $goods['goods_name'];
			
			$order = $this->_order_mod->get(array('conditions'=>'order_id='.$refund['order_id'],'fields'=>'order_sn'));
			$refunds[$key]['order_sn'] = $order['order_sn'];
			$refunds[$key]['refund_fee'] = $refund['refund_goods_fee'] + $refund['refund_shipping_fee'];
		}
		$this->_format_page($page);
		$this->assign('page_info', $page); 
		
		
		/* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),url('app=member'),
                         LANG::get('refund'),url('app=refund'),LANG::get('refund_apply'));

        /* 当前用户中心菜单 */
        $this->_curitem('refund_apply');
		$this->_curmenu('refund_apply');
        $this->_config_seo('title', Lang::get('member_center'));
		
		$this->assign('refunds',$refunds);
		$this->display('refund.index.html');
		
	}
	function view()
	{
		$refund_id = empty($_GET['refund_id'])? 0 : intval($_GET['refund_id']);
		if(!$refund_id){
			return;
		}
		
		
		$refund = $this->_refund_mod->get(array('conditions'=>'refund_id='.$refund_id.' and (buyer_id='.$this->visitor->get('user_id').' or seller_id='.$this->visitor->get('user_id').')'));
		if(!$refund){
			$this->show_warning('refund_not_exist');
			return;
		}
		if(!IS_POST)
		{
			$refund['shipped_text'] = Lang::get('shipped_'.$refund['shipped']);
			$refund['refund_fee'] = $refund['refund_goods_fee'] + $refund['refund_shipping_fee'];
			
			/* 当前位置 */
        	$this->_curlocal(LANG::get('member_center'),url('app=member'),
                         LANG::get('refund'),url('app=refund'),LANG::get('refund_view'));

        	/* 当前用户中心菜单 */
			$curitem = $refund['seller_id'] == $this->visitor->get('user_id') ? 'refund_receive' : 'refund_apply';
        	$this->_curitem($curitem);
			$this->_curmenu('refund_view');
        	$this->_config_seo('title', Lang::get('member_center'));
			
			$page   =   $this->_get_page(5);   //获取分页信息
			$refund['message'] = $this->_refund_message_mod->find(array(
				'conditions'=>'refund_id='.$refund_id,
				'order'=>'created desc',
				'limit'=>$page['limit'],
				'count'   => true				
			));	
			$page['item_count']=$this->_refund_message_mod->getCount();
			$this->_format_page($page);
			$this->assign('page_info', $page); 
			$this->assign('refund',$refund);
			$this->display('refund.view.html');			
		}
		
		else
		{
			
			if($refund['status']=='SUCCESS' || $refund['CLOSED']){
				$this->show_warning('add_refund_message_not_allow');
				return;
			}
			
			$refund_image = $this->_upload_files();
            if ($refund_image === false){
				$this->show_warning('refund_message_image_upload_error');
                return;
            }
			$data = array(
				'owner_id'	=> $this->visitor->get('user_id'),
				'owner_role'=> $refund['buyer_id']==$this->visitor->get('user_id') ? 'buyer' : ($refund['seller_id']==$this->visitor->get('user_id') ? 'seller' : 'admin'),
				'refund_id'	=> $refund_id,
				'content'	=> htmlspecialchars(trim($_POST['content'])),
				'pic_url'	=> $refund_image['refund_cert'],
				'created'	=> gmtime()				
			);
			$this->_refund_message_mod->add($data);
			$this->show_message('add_ok');
		}
	}
	
	function add()
	{
		$order_id = intval($_GET['order_id']);
		$goods_id = intval($_GET['goods_id']);
		$spec_id  = intval($_GET['spec_id']);
		
		
		if(!$this->available_refund($order_id,$goods_id,$spec_id)){
			$this->show_warning('not_allow_refund');
			return;
		}
		
		$order = $this->_order_mod->get($order_id);
		$shipping_info = $this->_order_extm_mod->get($order_id);
		$goods = $this->get_order_goods($order_id,$goods_id,$spec_id);

		
		$goods_amount_after_adjust = $order['goods_amount'];
		$goods_amount_before_adjust = $this->get_order_goods_amount($order_id);
		
		
		if($goods_amount_before_adjust > 0) {
			$goods_share_rate = round($goods['price'] * $goods['quantity'] / $goods_amount_before_adjust,2);
		} else $goods_share_rate = 0;
		
		
		
		if($goods_amount_before_adjust == $goods_amount_after_adjust){
			$goods['goods_fee'] = $goods['price'] * $goods['quantity'] - $order['discount'] * $goods_share_rate;
		} elseif($goods_amount_before_adjust !=0) {
			$goods_total_fee = $goods['price'] * (1-($goods_amount_before_adjust-$goods_amount_after_adjust) / $goods_amount_before_adjust) * $goods['quantity'];
			$goods['goods_fee'] = round($goods_total_fee,2);
		} else  {
			$goods['goods_fee'] = 0;
		}
		
		
		$ordergoods = $this->_ordergoods_mod->find(array('conditions'=>'order_id='.$order_id,'fields'=>'rec_id'));
		if($goods_amount_before_adjust > 0) {
			$goods['shipping_fee'] = $shipping_info['shipping_fee'] * $goods_share_rate;
		} else $goods['shipping_fee'] = round($shipping_info['shipping_fee'] / count($ordergoods), 2); // 平均分
		
		
		if(!IS_POST)
		{
			$refund = array();
			$refund['goods_fee'] = $refund['refund_fee'] = $goods['goods_fee'];
			$refund['total_fee'] =  $goods['goods_fee'] + $goods['shipping_fee'];
			$refund['shipping_fee'] = $goods['shipping_fee'];
			$this->assign('refund', $refund);
			
			
        	$this->_curlocal(LANG::get('member_center'),url('app=member'),
                         LANG::get('refund'),url('app=refund'),LANG::get('refund_add'));

        	/* 当前用户中心菜单 */
        	$this->_curitem('refund_apply');
			$this->_curmenu('refund_add');
        	$this->_config_seo('title', Lang::get('member_center'));
			$this->display('refund.form.html');
			
		}
		else 
		{
			
			$this->_check_post_data($goods);
			
			$refund_shipping_fee = $_POST['refund_shipping_fee'] ? $_POST['refund_shipping_fee'] : 0;

			$data =  array(
				'refund_sn'				=>$this->_refund_mod->gen_refund_sn(),
				'order_id' 				=>$order_id,
				'goods_id' 				=>$goods_id,
				'spec_id'       		=>$spec_id,
				'refund_reason'			=>htmlspecialchars(trim($_POST['refund_reason'])),
				'refund_desc'   		=>htmlspecialchars(trim($_POST['refund_desc'])),
				'total_fee'				=>$goods['goods_fee'] + $goods['shipping_fee'],
				'goods_fee'	    		=>$goods['goods_fee'],
				'shipping_fee'			=>$goods['shipping_fee'],
				'refund_goods_fee'		=>trim($_POST['refund_goods_fee']),
				'refund_shipping_fee'	=>trim($_POST['refund_shipping_fee']),
				'shipped'				=>$_POST['shipped'] ? intval(trim($_POST['shipped'])) : 0,
				'buyer_id'				=>$order['buyer_id'],
				'seller_id'				=>$order['seller_id'],
				'status'				=>'WAIT_SELLER_AGREE', // 买家已经申请退款，等待卖家同意
				'created'				=>gmtime(),
			);
			if($refund_id = $this->_refund_mod->add($data)) {
				
				$this->_refund_message_mod->add(array(
					'owner_id'	=> $this->visitor->get('user_id'),
					'owner_role'=> 'buyer',
					'refund_id'	=> $refund_id,
					'content'	=> sprintf(LANG::get('apply_refund_content_change'), $_POST['refund_goods_fee'], $refund_shipping_fee, LANG::get('shipped_'.$_POST['shipped']), $_POST['refund_reason'], $_POST['refund_desc']),
					'created'	=> gmtime(),
				));
				
				$this->show_message('add_ok','back_list', 'index.php?app=refund');
			}
		}
	}
	function edit()
	{
		$refund_id = empty($_GET['refund_id'])? 0 : intval($_GET['refund_id']);
		if(!$refund_id){
			$this->show_warning('no_such_refund');
			return;
		}
		
		
		$refund = $this->_refund_mod->get(array('conditions'=>'(status != "SUCCESS" AND status != "CLOSED" AND status != "WAIT_ADMIN_AGREE") and refund_id='.$refund_id.' and buyer_id='.$this->visitor->get('user_id')));
		if(!$refund){
			$this->show_warning('refund_not_allow_edit');
			return;
		}
		
		if(!IS_POST)
		{
			$this->assign('refund', $refund);
			
			/* 当前位置 */
        	$this->_curlocal(LANG::get('member_center'),url('app=member'),
                         LANG::get('refund'),url('app=refund'),LANG::get('refund_edit'));

        	/* 当前用户中心菜单 */
        	$this->_curitem('refund_apply');
			$this->_curmenu('refund_edit');
        	$this->_config_seo('title', Lang::get('member_center'));
			$this->display('refund.form.html');			
		}
		else
		{	
			// 检查提交的数据
			$this->_check_post_data($refund);

			$data =  array(
				'status'				=> 'WAIT_SELLER_CONFIRM',
				'refund_reason'			=> htmlspecialchars(trim($_POST['refund_reason'])),
				'refund_desc'   		=> htmlspecialchars(trim($_POST['refund_desc'])),
				'refund_goods_fee'		=> trim($_POST['refund_goods_fee']),
				'refund_shipping_fee'	=> trim($_POST['refund_shipping_fee']),
				'shipped'				=> $_POST['shipped'] ? intval(trim($_POST['shipped'])) : 0,
			);
			$this->_refund_mod->edit($refund_id,$data);
			
			$this->_refund_message_mod->add(array(
				'owner_id'	=> $this->visitor->get('user_id'),
				'owner_role'=> 'buyer',
				'refund_id'	=> $refund_id,
				'content'	=> sprintf(LANG::get('refund_content_change'), $_POST['refund_goods_fee'], $_POST['refund_shipping_fee'], LANG::get('shipped_'.$_POST['shipped']), $_POST['refund_reason'], $_POST['refund_desc']),
				'created'	=> gmtime(),
			));
					
			$this->show_message('edit_ok','back_list', 'index.php?app=refund');
		}
	}
	
	function ask_customer()
	{
		$refund_id = empty($_GET['refund_id'])? 0 : intval($_GET['refund_id']);
		if(!$refund_id){
			return;
		}
		
		$refund = $this->_refund_mod->get(array('conditions'=>'ask_customer !=1 and (status!="SUCCESS" AND status!="CLOSED") and refund_id='.$refund_id.' and (buyer_id='.$this->visitor->get('user_id').' or seller_id='.$this->visitor->get('user_id').')','fields'=>'refund_id,refund_sn,buyer_id,seller_id'));
		if(!$refund){
			$this->show_warning('ask_customer_not_allow');
			return;
		}
		$this->_refund_mod->edit($refund_id,array('ask_customer'=>1));
		
		
		if($refund['buyer_id']==$this->visitor->get('user_id')){
			$owner_role = 'buyer';
		} else {
			$owner_role = 'seller';
		}
		$data = array(
			'owner_id'	=> $this->visitor->get('user_id'),
			'owner_role'=> $owner_role,
			'refund_id'	=> $refund_id,
			'content'	=> sprintf(Lang::get('ask_customer_content_change'), Lang::get($owner_role)),
			'created'	=> gmtime(),		
		);
		$this->_refund_message_mod->add($data);
		$this->show_message('ask_customer_ok','back_list', 'index.php?app=refund&act=view&refund_id='.$refund_id);	
	}
	
	function agree()
	{
		$refund_id = empty($_GET['refund_id']) ? 0 : intval($_GET['refund_id']);
		if(!$refund_id){
			return;
		}
		
		
		$refund = $this->_refund_mod->get(array('conditions'=>'(status !="SUCCESS" AND status !="CLOSED" AND status !="WAIT_ADMIN_AGREE") and refund_id='.$refund_id.' and seller_id='.$this->visitor->get('user_id')));
		
		if(!$refund){
			$this->show_warning('agree_no_allow');
			return;
		}
		
		$order_id 		= $refund['order_id'];
		
		$order_info		= $this->_order_mod->get($order_id);
		$seller_info  	= $this->_member_mod->get($order_info['seller_id']);
		$buyer_info   	= $this->_member_mod->get($order_info['buyer_id']);
		
		
		
		if($order_info['payment_code'] == 'deposit')
		{
			
			$depopay_type    =&  dpt('outlay', 'refund');
			$tradesn 		= $depopay_type->submit(array(
				'trade_info' =>  array('user_id'=>$order_info['seller_id'],'party_id'=>$order_info['buyer_id'],'amount'=>$refund['refund_goods_fee'] + $refund['refund_shipping_fee']),
				'extra_info' =>  $order_info + array('refund_id'=> $refund_id, 'seller_user_name'=>$seller_info['user_name'],'operator' => 'seller'),
				'post'		 =>	 $_POST,
			));
			if(!$tradesn)
			{
				$this->show_warning('seller_agree_refund_error');
				return;
			}
			
			$this->show_message('seller_agree_refund_ok', 'back_list', 'index.php?app=refund&act=view&refund_id='.$refund_id);
		}
		
		else{
			
			$this->show_warning('payment_not_support_refund', 'back_list', 'index.php?app=refund&act=view&refund_id='.$refund_id);
		}
	}
	
	
	function refuse()
	{
		$refund_id = empty($_GET['refund_id'])? 0 : intval($_GET['refund_id']);
		if(!$refund_id){
			return;
		}
		
		
		$refund = $this->_refund_mod->get(array('conditions'=>'(status!="SUCCESS" AND status!="CLOSED" AND status!="WAIT_ADMIN_AGREE") and refund_id='.$refund_id.' and seller_id='.$this->visitor->get('user_id')));
		
		if(!$refund){
			$this->show_warning('refuse_not_allow');
			return;
		}
		
		if(!IS_POST)
		{
			$this->assign('refund', $refund);
			
			/* 当前位置 */
        	$this->_curlocal(LANG::get('member_center'),url('app=member'),
                         LANG::get('refund'),url('app=refund'),LANG::get('refund_refuse'));

        	/* 当前用户中心菜单 */
        	$this->_curitem('refund_receive');
			$this->_curmenu('refund_refuse');
        	$this->_config_seo('title', Lang::get('member_center'));
			$this->display('refund.refuse.html');			
		}
		else
		{
			$refund_image = $this->_upload_files();
            if ($refund_image === false)
            {
				$this->show_warning('refund_message_image_upload_error');
                return;
            }
			
			$this->_refund_mod->edit($refund_id,array('status'=>'SELLER_REFUSE_BUYER'));
			
			$data = array(
				'owner_id'	=> $this->visitor->get('user_id'),
				'owner_role'=> 'seller',
				'refund_id'	=> $refund_id,
				'content'	=> sprintf(Lang::get('refuse_content_change'),htmlspecialchars(trim($_POST['content']))),
				'pic_url'	=> $refund_image['refund_cert'],
				'created'	=> gmtime()				
			);
			$this->_refund_message_mod->add($data);
			$this->show_message('submit_ok','back_list', 'index.php?app=refund&act=view&refund_id='.$refund_id);	
		}
		
	}
	
	function cancel()
	{
		$refund_id = empty($_GET['refund_id']) ? 0 : intval($_GET['refund_id']);
		if(!$refund_id){
			return;
		}
		
		$refund = $this->_refund_mod->get(array('conditions'=>'(status!="SUCCESS" AND status!="CLOSED" AND status!="WAIT_ADMIN_AGREE") and refund_id='.$refund_id.' and buyer_id='.$this->visitor->get('user_id'),'fields'=>'refund_id,refund_sn'));
		if(!$refund)
		{
			$this->show_warning('cancel_not_allow');
			return;
		}
		$this->_refund_mod->edit($refund_id, array('status'=>'CLOSED', 'end_time' => gmtime()));
		$this->_refund_message_mod->add(array(
			'owner_id'	=> $this->visitor->get('user_id'),
			'owner_role'=> 'buyer',
			'refund_id'	=> $refund_id,
			'content'	=> sprintf(Lang::get('cancel_content_change'), $refund['refund_sn']),
			'created'	=> gmtime(),
		));
		$this->show_message('cancel_ok');
	}
	function available_refund($order_id,$goods_id,$spec_id)
	{
		if(!$order_id || !$goods_id || !$spec_id) {
			return false;
		}
		
		
		$order = $this->_order_mod->get(array('conditions'=>'order_id='.$order_id.' and buyer_id='.$this->visitor->get('user_id'),'fields'=>'order_id,status'));
		if(empty($order)){
			return false;
		} elseif($order['status'] !=20 && $order['status'] !=30){ 
			return false;
		}
		
		$ordergoods=$this->_ordergoods_mod->get(array('conditions'=>'order_id='.$order_id.' and goods_id='.$goods_id.' and spec_id='.$spec_id,'fields'=>'rec_id'));
		if(empty($ordergoods)){
			return false;
		}
		
		if($this->_refund_mod->get(array('conditions'=>'order_id='.$order_id.' and goods_id='.$goods_id.' and spec_id='.$spec_id,'fields'=>'refund_id'))){
			return false;
		}
		return true;
	}
	function get_order_goods($order_id,$goods_id,$spec_id)
	{
		$ordergoods = $this->_ordergoods_mod->get(array('conditions'=>'order_id='.$order_id.' and goods_id='.$goods_id.' and spec_id='.$spec_id));
		return $ordergoods;		
	}
	function get_order_goods_amount($order_id)
	{
		$goods_amount = 0;
		
		if(!$order_id) return $goods_amount;
		
		$ordergoods = $this->_ordergoods_mod->find(array('conditions'=>'order_id='.$order_id,'fields'=>'price,quantity'));
		foreach($ordergoods as $goods){
			$goods_amount += $goods['price'] * $goods['quantity'];
		}
		return $goods_amount;
	}
	
	function receive()
	{
		$page    =   $this->_get_page(10);  
		$refunds = $this->_refund_mod->find(array(
			'conditions'	=> 'seller_id='.$this->visitor->get('user_id'),
			'order' 		=> 'created desc',
			'limit'			=> $page['limit'],
			'count'   		=> true
		));
		$page['item_count']=$this->_refund_mod->getCount();
		foreach($refunds as $key=>$refund)
		{
			$member = $this->_member_mod->get(array('conditions'=>'user_id='.$refund['buyer_id'],'fields'=>'user_name'));
			$refunds[$key]['user_name'] = $member['user_name'];
			$goods = $this->_goods_mod->get(array('conditions'=>'goods_id='.$refund['goods_id'],'fields'=>'goods_name'));
			$refunds[$key]['goods_name'] = $goods['goods_name'];
			
			$order = $this->_order_mod->get(array('conditions'=>'order_id='.$refund['order_id'],'fields'=>'order_sn'));
			$refunds[$key]['order_sn'] = $order['order_sn'];
			
			$refunds[$key]['refund_fee'] = $refund['refund_goods_fee'] + $refund['refund_shipping_fee'];
		}
		$this->_format_page($page);
		$this->assign('page_info', $page); 
				
		/* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),url('app=member'),
                         LANG::get('refund'),url('app=refund'),LANG::get('refund_receive'));

        /* 当前用户中心菜单 */
        $this->_curitem('refund_receive');
		$this->_curmenu('refund_receive');
        $this->_config_seo('title', Lang::get('member_center'));
		
		$this->assign('refunds',$refunds);
		$this->display('refund.receive.html');		
	}
	
	function _check_post_data($refund = array())
	{
		if(empty($_POST['refund_goods_fee']) || floatval($_POST['refund_goods_fee'])<0)
		{
			$this->show_warning('refund_fee_ge0');
			exit;
			
		} elseif(floatval($_POST['refund_goods_fee']) > $refund['goods_fee']){
			$this->show_warning('refund_fee_error');
			exit;
		}
		if($_POST['refund_shipping_fee'] !='' && floatval($_POST['refund_shipping_fee'])<0)
		{
			$this->show_warning('refund_shipping_fee_ge0');
			exit;
			
		}
		if(floatval($_POST['refund_shipping_fee']) > $refund['shipping_fee']){
			$this->show_warning('refund_shipping_fee_error');
			exit;
		}
		if(!in_array(trim($_POST['shipped']), array(0,1,2))) {
			$this->show_warning('select_refund_shipped');
			exit;
		}
		if(empty($_POST['refund_reason'])){
			$this->show_warning('select_refund_reason');
			exit;
		}
	}
	
	function _get_member_submenu()
    {
		if(ACT=='receive'){
			$menus[] = array(
                'name'  => 'refund_receive',
                'url'   => '',
        	);
		}
		if(ACT=='add'){
			$menus[] = array(
				'name' => 'refund_add',
				'url'  => '',				
			);
		}
		if(ACT=='edit'){
			$menus[] = array(
				'name' => 'refund_edit',
				'url'  => '',				
			);
		}
		if(ACT=='view'){
			$menus[] = array(
				'name' => 'refund_view',
				'url'  => '',				
			);
		}
		if(ACT=='refuse'){
			$menus[] = array(
				'name' => 'refund_refuse',
				'url'  => '',				
			);
		}elseif(ACT=='index'){
			$menus[] = array(
                'name'  => 'refund_apply',
                'url'   => '',
        	);
		}
		
        return $menus;
    }
	
	/**
     * 上传凭证
     *
     */
    function _upload_files()
    {
        import('uploader.lib');
        $data      = array();
        $file = $_FILES['refund_cert'];
        if ($file['error'] == UPLOAD_ERR_OK && $file !='')
        {
            $uploader = new Uploader();
            $uploader->allowed_type(IMAGE_FILE_TYPE);
            $uploader->addFile($file);
            $uploader->root_dir(ROOT_PATH);
            $data['refund_cert'] = $uploader->save('data/files/refund_cert/member_'.$this->visitor->get('user_id'), $uploader->random_filename());
        }
        return $data;
    }

}

?>
