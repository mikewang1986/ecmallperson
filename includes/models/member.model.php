<?php

/* 会员 member */
class MemberModel extends BaseModel
{
    var $table  = 'member';
    var $prikey = 'user_id';
    var $_name  = 'member';

    /* 与其它模型之间的关系 */
    var $_relation = array(
        // 一个会员拥有一个店铺，id相同
        'has_store' => array(
            'model'       => 'store',       //模型的名称
            'type'        => HAS_ONE,       //关系类型
            'foreign_key' => 'store_id',    //外键名
            'dependent'   => true           //依赖
        ),
		
		     // 一个会员拥有一个店铺，id相同
       'has_wx' => array(
            'model'       => 'weixinuser',       //模型的名称
            'type'        => HAS_ONE,       //关系类型
            'foreign_key' => 'user_id',    //外键名
            'dependent'   => true           //依赖
        ),
		
		'has_msg' => array(
            'model'       => 'msg',       //模型的名称
            'type'        => HAS_ONE,       //关系类型
            'foreign_key' => 'user_id',    //外键名
            'dependent'   => true           //依赖
        ),
		// 一个会员有多条供求信息
        'has_sdinfo' => array(
            'model'         => 'sdinfo',
            'type'          => HAS_MANY,
            'foreign_key' => 'user_id',
            'dependent' => true
        ),
        'manage_mall'   =>  array(
            'model'       => 'userpriv',
            'type'        => HAS_ONE,
            'foreign_key' => 'user_id',
            'ext_limit'   => array('store_id' => 0),
            'dependent'   => true
        ),
        // 一个会员拥有多个收货地址
        'has_address' => array(
            'model'       => 'address',
            'type'        => HAS_MANY,
            'foreign_key' => 'user_id',
            'dependent'   => true
        ),
        'has_msglog' => array(
            'model'       => 'msglog',
            'type'        => HAS_MANY,
            'foreign_key' => 'user_id',
            'dependent'   => true
        ),
        // 一个用户有多个订单
        'has_order' => array(
            'model'         => 'order',
            'type'          => HAS_MANY,
            'foreign_key'   => 'buyer_id',
            'dependent' => true
        ),
         // 一个用户有多条收到的短信
        'has_received_message' => array(
            'model'         => 'message',
            'type'          => HAS_MANY,
            'foreign_key'   => 'to_id',
            'dependent' => true
        ),
        // 一个用户有多条发送出去的短信
        'has_sent_message' => array(
            'model'         => 'message',
            'type'          => HAS_MANY,
            'foreign_key'   => 'from_id',
            'dependent' => true
        ),
        // 会员和商品是多对多的关系（会员收藏商品）
        'collect_goods' => array(
            'model'        => 'goods',
            'type'         => HAS_AND_BELONGS_TO_MANY,
            'middle_table' => 'collect',    //中间表名称
            'foreign_key'  => 'user_id',
            'ext_limit'    => array('type' => 'goods'),
            'reverse'      => 'be_collect', //反向关系名称
        ),
		

		
		
		

        // 会员和店铺是多对多的关系（会员收藏店铺）
        'collect_store' => array(
            'model'        => 'store',
            'type'         => HAS_AND_BELONGS_TO_MANY,
            'middle_table' => 'collect',
            'foreign_key'  => 'user_id',
            'ext_limit'    => array('type' => 'store'),
            'reverse'      => 'be_collect',
        ),
        // 会员和店铺是多对多的关系（会员拥有店铺权限）
        'manage_store' => array(
            'model'        => 'store',
            'type'         => HAS_AND_BELONGS_TO_MANY,
            'middle_table' => 'user_priv',
            'foreign_key'  => 'user_id',
            'reverse'      => 'be_manage',
        ),
        // 会员和好友是多对多的关系（会员拥有多个好友）
        'has_friend' => array(
            'model'        => 'member',
            'type'         => HAS_AND_BELONGS_TO_MANY,
            'middle_table' => 'friend',
            'foreign_key'  => 'owner_id',
            'reverse'      => 'be_friend',
        ),
        // 好友是多对多的关系（会员拥有多个好友）
        'be_friend' => array(
            'model'        => 'member',
            'type'         => HAS_AND_BELONGS_TO_MANY,
            'middle_table' => 'friend',
            'foreign_key'  => 'friend_id',
            'reverse'      => 'has_friend',
        ),
        //用户与商品咨询是一对多的关系，一个会员拥有多个商品咨询
        'user_question' => array(
            'model' => 'goodsqa',
            'type' => HAS_MANY,
            'foreign_key' => 'user_id',
        ),
        //会员和优惠券编号是多对多的关系
        'bind_couponsn' => array(
            'model'        => 'couponsn',
            'type'         => HAS_AND_BELONGS_TO_MANY,
            'middle_table' => 'user_coupon',
            'foreign_key'  => 'user_id',
            'reverse'      => 'bind_user',
        ),
        // 会员和团购活动是多对多的关系（会员收藏商品）
        'join_groupbuy' => array(
            'model'        => 'groupbuy',
            'type'         => HAS_AND_BELONGS_TO_MANY,
            'middle_table' => 'groupbuy_log',    //中间表名称
            'foreign_key'  => 'user_id',
            'reverse'      => 'be_join', //反向关系名称
        ),
        // 一个会员发起一个团购
        'start_groupbuy' => array(
            'model'         => 'groupbuy',
            'type'          => HAS_ONE,
            'foreign_key'   => 'store_id',
            'dependent'   => true
        ),
		
		
	'has_sent_refund' => array(
	    				'model' => 'refund',
	    				'type' => HAS_MANY,
	    				'foreign_key' => 'from_id',
	    	),
		
		
		
    );

    var $_autov = array(
        'user_name' => array(
            'required'  => true,
            'filter'    => 'trim',
        ),
        'password' => array(
            'required' => true,
            'filter'   => 'trim',
            'min'      => 6,
        ),
    );
	//获取会员等级信息 by cengnlaeng
	function get_grade_info($user_id)
	{
		if(!$user_id)
		{
			return;
		}
		$user=$this->get($user_id);
		$ugrade_mod=&m('ugrade');
		$ugrade=$ugrade_mod->get(array('conditions'=>'grade='.$user['ugrade']));
		$higher_grade=$ugrade_mod->get(array(
			'conditions'=>'grade='.($ugrade['grade']+1),
		));
		$data=array(
			'distant_growth'=>$higher_grade['floor_growth']-$user['growth'],
			'grade_name'=>$ugrade['grade_name'],
			'grade_icon'=>$ugrade['grade_icon'],
			'growth' =>$user['growth'],
			'higher_grade_name'=>$higher_grade['grade_name']
		);
		return $data;
	}
	//修改会员的成长值和会员等级
	function edit_growth($user_id,$behave,$order_amount='')
	{
		$growth_value=0;
		$model_growth = &af('growth');
        $growth = $model_growth->getAll();
		switch($behave){
		   case 'register':	
		   $growth_value=$growth['register_growth'];
		   break;
		   case 'bought':
		   $growth_value=$growth['bought_growth']*$order_amount;
		   break;
		   case 'comment':
		   $growth_value=$growth['comment_growth'];
		   break;
		}
		$user=$this->get($user_id);
		$this->edit($user['user_id'],array('growth'=>$growth_value+$user['growth']));//更新成长值
		$user=$this->get($user_id);//重新读取member表的数据
		$ugrade_mod=&m('ugrade');
		$ugrade=$ugrade_mod->get(array('conditions'=>"floor_growth <= ".$user['growth']." AND (top_growth IS NULL || top_growth > ".$user['growth']." )",'field'=>'grade'));
		$this->edit($user['user_id'],array('ugrade'=>$ugrade['grade']));//更新等级
	}
	//end by cengnlaeng
    /*
     * 判断名称是否唯一
     */
    function unique($user_name, $user_id = 0)
    {
        $conditions = "user_name = '" . $user_name . "'";
        $user_id && $conditions .= " AND user_id <> '" . $user_id . "'";
        return count($this->find(array('conditions' => $conditions))) == 0;
    }

    function drop($conditions, $fields = 'portrait')
    {
		
	
			
			
			
        if ($droped_rows = parent::drop($conditions, $fields))
        {
            restore_error_handler();
            $droped_data = $this->getDroppedData();
			
			
            foreach ($droped_data as $row)
            {
                $row['portrait'] && @unlink(ROOT_PATH . '/' . $row['portrait']);
            }
            reset_error_handler();
        }
        return $droped_rows;
    }
}

?>