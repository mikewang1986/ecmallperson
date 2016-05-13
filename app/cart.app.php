<?php

/**
 *    购物车控制器，负责会员购物车的管理工作，她与下一步售货员的接口是：购物车告诉售货员，我要买的商品是我购物车内的商品
 *
 *    @author    Garbin
 */

class CartApp extends MallbaseApp
{
    /**
     *    列出购物车中的商品
     *
     *    @author    Garbin
     *    @return    void
     */
    function index()
    {
        $store_id = isset($_GET['store_id']) ? intval($_GET['store_id']) : 0;
        $carts = $this->_get_carts($store_id);
        $this->_curlocal(
            LANG::get('cart')
        );
        $this->_config_seo('title', Lang::get('confirm_goods') . ' - ' . Conf::get('site_title'));

        if (empty($carts))
        {
            $this->_cart_empty();

            return;
        }
		
		/*  tyioocom  感兴趣的商品 */
		$goods_mod = &m('goods');
		$gst_mod = &m('goodsstatistics');
		$interest = $goods_mod->find(array(
		   'conditions'=>'',
		   'join'=>'has_goodsstatistics',
		   'order' => 'views desc,collects desc, sales desc',
		   'fields' =>'g.goods_id,goods_name,price,sales,default_image',
		   'limit'=>6
		));
		$this->assign('interest',$interest);
		/* end */		

        $this->assign('carts', $carts);
   //360cd.cn
        if(isset($_SESSION['wapstore']) && $_SESSION['wapstore']=='zlstore')
        {
            $this->assign('store',array('store_id'=>$_SESSION['wapstore_id']));
            $this->display('zlstore/cart.index.html');
            return;
        }
        //360cd.cn
        $this->display('cart.index.wind.html');
    }
	
	    //360cd.cn
    //检查是否存在于购物车
    function check_goods()
    {
        $spec_id   = isset($_GET['spec_id']) ? intval($_GET['spec_id']) : 0;
        /* 是否添加过 */
        $model_cart =& m('cart');
        $item_info  = $model_cart->get("spec_id={$spec_id} AND session_id='" . SESS_ID . "'");
        if (!empty($item_info))
        {
           $this->json_result(array('status'=>false,'quantity'=>$item_info['quantity'],'rec_id'=>$item_info['rec_id']),'goods_already_in_cart');
        }else{
           $this->json_result(array('status'=>true)); 
        }
        
    }

    function get_goods()
    {
        $cart_status = $this->_get_cart_status();
        $this->json_result(array(
            'cart'      =>  $cart_status['status'],                     //返回总的购物车状态
            
        ), 'update_item_successed');
    }

    
    //360cd.cn


    /**
     *    放入商品(根据不同的请求方式给出不同的返回结果)
     *
     *    @author    Garbin
     *    @return    void
     */
    function add()
    {
		$group_id = isset($_GET['gid'])? intval($_GET['gid']) : 0;
        $spec_id   = isset($_GET['spec_id']) ? intval($_GET['spec_id']) : 0;
        $quantity   = isset($_GET['quantity']) ? intval($_GET['quantity']) : 0;
        if (!$spec_id || !$quantity)
        {
            return;
        }

        /* 是否有商品 */
        $spec_model =& m('goodsspec');
        $spec_info  =  $spec_model->get(array(
            'fields'        => 'g.if_open,g.store_id, g.goods_id, g.goods_name, g.spec_name_1, g.spec_name_2, g.default_image, gs.spec_1, gs.spec_2, gs.stock, gs.price',
            'conditions'    => $spec_id,
            'join'          => 'belongs_to_goods',
        ));

        if (!$spec_info)
        {
            $this->json_error('no_such_goods');
            /* 商品不存在 */
            return;
        }
		
		/* 读取促销价格 */
		$promotion_mod = &m('promotion');
		
		// 促销价格优先
		if($promotion_mod->goods_has_promotion($spec_info['goods_id'])) {
			$spec_info['price'] = $promotion_mod->get_promotion_price($spec_info['goods_id'], $spec_info['spec_id']);
		}
		else
		{
			//把原价改为会员所获得的优惠价
			if($spec_info['if_open'] == 1)
			{
				$gradegoods_mod=&m('gradegoods');
				$discount=$gradegoods_mod->get_user_discount($this->visitor->get('user_id'),$spec_info['goods_id']);
				if($discount > 0)
				{
					$spec_info['price']=round($spec_info['price']*$discount,2);
				}
			}
		}
		
		

        /* 如果是自己店铺的商品，则不能购买 */
        if ($this->visitor->get('manage_store'))
        {
            if ($spec_info['store_id'] == $this->visitor->get('manage_store'))
            {
                $this->json_error('can_not_buy_yourself');

                return;
            }
        }

        /* 是否添加过 */
        $model_cart =& m('cart');
        $item_info  = $model_cart->get("spec_id={$spec_id} AND session_id='" . SESS_ID . "'");
        if (!empty($item_info))
        {
            $this->json_error('goods_already_in_cart');

            return;
        }

        if ($quantity > $spec_info['stock'])
        {
            $this->json_error('no_enough_goods');
            return;
        }
	
	//如果是通过聚划算购买的，则取聚划算价格
		if($group_id)
		{
			$ju_mod =&m('ju');
			$groupbuy = $ju_mod->get('status=1 AND goods_id='.$spec_info['goods_id']);
			if($groupbuy)
			{
				$spec_price = unserialize($groupbuy['spec_price']);
				if($spec_price[$spec_info['spec_id']]['price'] && $spec_info['price']>$spec_price[$spec_info['spec_id']]['price'] ) 
				{
					$group_price = $spec_price[$spec_info['spec_id']]['price'];
					$spec_info['old_price'] = $spec_info['price'];//原价转存
					$spec_info['price'] = $group_price;
				}
				
			}
		}

        $spec_1 = $spec_info['spec_name_1'] ? $spec_info['spec_name_1'] . ':' . $spec_info['spec_1'] : $spec_info['spec_1'];
        $spec_2 = $spec_info['spec_name_2'] ? $spec_info['spec_name_2'] . ':' . $spec_info['spec_2'] : $spec_info['spec_2'];

        $specification = $spec_1 . ' ' . $spec_2;

        /* 将商品加入购物车 */
        $cart_item = array(
            'user_id'       => $this->visitor->get('user_id'),
            'session_id'    => SESS_ID,
            'store_id'      => $spec_info['store_id'],
            'spec_id'       => $spec_id,
            'goods_id'      => $spec_info['goods_id'],
            'goods_name'    => addslashes($spec_info['goods_name']),
            'specification' => addslashes(trim($specification)),
            'price'         => $spec_info['price'],
            'quantity'      => $quantity,
            'goods_image'   => addslashes($spec_info['default_image']),
			'group_id'      => $group_id,
			'old_price'		=> $spec_info['old_price'],
        );

        /* 添加并返回购物车统计即可 */
        $cart_model =&  m('cart');
        $cart_model->add($cart_item);
		
        $cart_status = $this->_get_cart_status();

        /* 更新被添加进购物车的次数 */
        $model_goodsstatistics =& m('goodsstatistics');
        $model_goodsstatistics->edit($spec_info['goods_id'], 'carts=carts+1');

        $this->json_result(array(
            'cart'      =>  $cart_status['status'],  //返回购物车状态
        ), 'addto_cart_successed');
    }
	
    /**
     *    丢弃商品
     *
     *    @author    Garbin
     *    @return    void
     */
    function drop()
    {
        /* 传入rec_id，删除并返回购物车统计即可 */
        $rec_id = isset($_GET['rec_id']) ? intval($_GET['rec_id']) : 0;
        if (!$rec_id)
        {
            return;
        }

        /* 从购物车中删除 */
        $model_cart =& m('cart');
        $droped_rows = $model_cart->drop('rec_id=' . $rec_id . ' AND session_id=\'' . SESS_ID . '\'', 'store_id');
        if (!$droped_rows)
        {
            return;
        }
		
        /* 返回结果 */
        $dropped_data = $model_cart->getDroppedData();
        $store_id     = $dropped_data[$rec_id]['store_id'];
        $cart_status = $this->_get_cart_status();
        $this->json_result(array(
            'cart'  =>  $cart_status['status'],                      //返回总的购物车状态
            'amount'=>  $cart_status['carts'][$store_id]['amount']   //返回指定店铺的购物车状态
        ),'drop_item_successed');
    }

    /**
     *    更新购物车中商品的数量，以商品为单位，AJAX更新
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
    function update()
    {
        $spec_id  = isset($_GET['spec_id']) ? intval($_GET['spec_id']) : 0;
        $quantity = isset($_GET['quantity'])? intval($_GET['quantity']): 0;
        if (!$spec_id || !$quantity)
        {
            /* 不合法的请求 */
            return;
        }

        /* 判断库存是否足够 */
        $model_spec =& m('goodsspec');
        $spec_info  =  $model_spec->get($spec_id);
        if (empty($spec_info))
        {
            /* 没有该规格 */
            $this->json_error('no_such_spec');
            return;
        }

        if ($quantity > $spec_info['stock'])
        {
            /* 数量有限 */
            $this->json_error('no_enough_goods');
            return;
        }

        /* 修改数量 */
        $where = "spec_id={$spec_id} AND session_id='" . SESS_ID . "'";
        $model_cart =& m('cart');
		

        /* 获取购物车中的信息，用于获取价格并计算小计 */
        $cart_spec_info = $model_cart->get($where);
        if (empty($cart_spec_info))
        {
            /* 并没有添加该商品到购物车 */
            return;
        }

        $store_id = $cart_spec_info['store_id'];

        /* 修改数量 */
        $model_cart->edit($where, array(
            'quantity'  =>  $quantity,
        ));

        /* 小计 */
        $subtotal   =   $quantity * $cart_spec_info['price'];

        /* 返回JSON结果 */
        $cart_status = $this->_get_cart_status();
        $this->json_result(array(
            'cart'      =>  $cart_status['status'],                     //返回总的购物车状态
            'subtotal'  =>  $subtotal,                                  //小计
            'amount'    =>  $cart_status['carts'][$store_id]['amount']  //店铺购物车总计
        ), 'update_item_successed');
    }

    /**
     *    获取购物车状态
     *
     *    @author    Garbin
     *    @return    array
     */
    function _get_cart_status()
    {
        /* 默认的返回格式 */
        $data = array(
            'status'    =>  array(
                'quantity'  =>  0,      //总数量
                'amount'    =>  0,      //总金额
                'kinds'     =>  0,      //总种类
            ),
            'carts'     =>  array(),    //购物车列表，包含每个购物车的状态
        );

        /* 获取所有购物车 */
        $carts = $this->_get_carts();
        if (empty($carts))
        {
            return $data;
        }
        $data['carts']  =   $carts;
        foreach ($carts as $store_id => $cart)
        {
            $data['status']['quantity'] += $cart['quantity'];
            $data['status']['amount']   += $cart['amount'];
            $data['status']['kinds']    += $cart['kinds'];
        }

        return $data;
    }

    /**
     *    购物车为空
     *
     *    @author    Garbin
     *    @return    void
     */
    function _cart_empty()
    {
		$goods_mod = &m('goods');
		$gst_mod = &m('goodsstatistics');
		$interest = $goods_mod->find(array(
		   'conditions'=>'',
		   'join'=>'has_goodsstatistics',
		   'order' => 'views desc,collects desc, sales desc',
		   'fields' =>'g.goods_id,goods_name,price,sales,default_image',
		   'limit'=>6
		));
		$this->assign('interest',$interest);
         //360cd.cn
        if(isset($_SESSION['wapstore']) && $_SESSION['wapstore']=='zlstore')
        {
            $this->assign('store',array('store_id'=>$_SESSION['wapstore_id']));
            $this->display('zlstore/cart.empty.html');
            return;
        }
        //360cd.cn
        $this->display('cart.empty.html');
    }

    /**
     *    以购物车为单位获取购物车列表及商品项
     *
     *    @author    Garbin
     *    @return    void
     */
    function _get_carts($store_id = 0)
    {
        $carts = array();

        /* 获取所有购物车中的内容 */
        $where_store_id = $store_id ? ' AND cart.store_id=' . $store_id : '';

        /* 只有是自己购物车的项目才能购买 */
        $where_user_id = $this->visitor->get('user_id') ? " AND cart.user_id=" . $this->visitor->get('user_id') : '';
        $cart_model =& m('cart');
        $cart_items = $cart_model->find(array(
            'conditions'    => 'session_id = \'' . SESS_ID . "'" . $where_store_id . $where_user_id,
            'fields'        => 'this.*,store.store_name',
            'join'          => 'belongs_to_store',
        ));
        if (empty($cart_items))
        {
            return $carts;
        }
        $kinds = array();
        foreach ($cart_items as $item)
        {
            /* 小计 */
            $item['subtotal']   = $item['price'] * $item['quantity'];
            $kinds[$item['store_id']][$item['goods_id']] = 1;

            /* 以店铺ID为索引 */
            empty($item['goods_image']) && $item['goods_image'] = Conf::get('default_goods_image');
            $carts[$item['store_id']]['store_name'] = $item['store_name'];
            $carts[$item['store_id']]['amount']     += $item['subtotal'];   //各店铺的总金额
            $carts[$item['store_id']]['quantity']   += $item['quantity'];   //各店铺的总数量
            $carts[$item['store_id']]['goods'][]    = $item;
        }

        foreach ($carts as $_store_id => $cart)
        {
            $carts[$_store_id]['kinds'] =   count(array_keys($kinds[$_store_id]));  //各店铺的商品种类数
        }

        return $carts;
    }
}

?>
