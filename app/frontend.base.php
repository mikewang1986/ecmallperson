<?php



/**

 *    前台控制器基础类

 *

 *    @author    Garbin

 *    @usage    none

 */

class FrontendApp extends ECBaseApp

{

    function __construct()

    {

        $this->FrontendApp();

    }

    function FrontendApp()

    {

        Lang::load(lang_file('common'));

        Lang::load(lang_file(APP));

        parent::__construct();



        // 判断商城是否关闭

        if (!Conf::get('site_status'))

        {

            $this->show_warning(Conf::get('closed_reason'));

            exit;

        }

        # 在运行action之前，无法访问到visitor对象

    }

    function _config_view()

    {

        parent::_config_view();

        $this->_view->template_dir  = ROOT_PATH . '/themes';

        $this->_view->compile_dir   = ROOT_PATH . '/temp/compiled/mall';

        $this->_view->res_base      = SITE_URL . '/themes';

        $this->_config_seo(array(

            'title' => Conf::get('site_title'),

            'description' => Conf::get('site_description'),

            'keywords' => Conf::get('site_keywords')

        ));

    }

	//360cd.cn

	function anyoneRegister()

    { 

	

        if (!empty($_GET['ret_url']))

        {

            $ret_url = trim($_GET['ret_url']);

        }

        else

        {

            if (isset($_SERVER['HTTP_REFERER']))

            {

                $ret_url = $_SERVER['HTTP_REFERER'];

            }

            else

            {

                $ret_url = SITE_URL . '/index.php';

            }

        }



        /* 防止登陆成功后跳转到登陆、退出的页面 */

        $ret_url = strtolower($ret_url); 

		//echo $ret_url;exit;

       if (str_replace(array('act=login', 'act=logout', 'act=register'), '', $ret_url) != $ret_url)

        {

		

            $ret_url = SITE_URL . '/index.php';

        }

		

      $local_user=ecm_getcookie('ecm_local_user');

      if(!(isset($local_user) && !empty($local_user)))

      {

        $str = '1234567890abcdefghijklmnopqrstuvwxyz';

		for($i=0;$i<4;$i++){

		$string.=$str[rand(0,35)];

		}

		 $local_user='e'.$string;

      }

      //$local_user='ecu'.gmtime().mt_rand(1,9);



      

      $user_mod= &m('member');

      $ms =& ms(); //连接用户中心

      $user_info=$user_mod->get(array('conditions'=>" user_name='".$local_user."'"));

	

      if(!$user_info)

      {

       

        $user_id = $ms->user->register($local_user, '123456', $local_user.'@126.com');

		$content="尊敬的".$local_user."，初始密码为123456，为了账号的安全，请及时修改密码";

		$user_mod->edit('user_id='.$user_id,'ugrade=1');

		$to_ids = array();

        $to_ids[] = $user_id;

        $msg_id = $ms->pm->send(0, $to_ids, '修改你的初始密码', $content);

		$this->_do_login($user_id);

		$synlogin = $ms->user->synlogin($user_id);

		//ecm_setcookie('ecm_local_user',$local_user,gmtime()+2592000);

		 $this->show_message('恭喜！你已完成注册,初始密码为123456为了你的安全，请即时修复' . $synlogin,

                'back_before_login', rawurldecode($_GET['ret_url']),

                'enter_member_center', 'index.php?app=member'

            );

        

      }else{



        $user_id=$user_info['user_id'];

		//$user_id = $ms->user->auth($user_info['user_name'],$user_info['password']);

         

      }

	

       $this->_do_login($user_id);

            

            /* 同步登陆外部系统 */

       $synlogin = $ms->user->synlogin($user_id);

	   if(trim($user_info['password'])=='e10adc3949ba59abbe56e057f20f883e'){

	   $content="尊敬的".$local_user."，初始密码为123456，为了账号的安全，请及时修改密码";

		$to_ids = array();

        $to_ids[] = $user_id;

        $msg_id = $ms->pm->send(0, $to_ids, '修改你的初始密码', $content);

		//ecm_setcookie('ecm_local_user',$local_user,gmtime()+2592000);

	   $this->show_message('恭喜！你已完成注册,初始密码为123456为了你的安全，请即时修复' . $synlogin,

                'back_before_login', rawurldecode($_GET['ret_url']),

                'enter_member_center', 'index.php?app=member'

            );

	   }else{

		 //ecm_setcookie('ecm_local_user',$local_user,gmtime()+2592000);

	     $this->show_message('恭喜！登录成功' . $synlogin,

                'back_before_login', rawurldecode($_GET['ret_url']),

                'enter_member_center', 'index.php?app=member'

            );

	   }

      

    }




	//360cd.cn

	 /**

     *    获取可用功能列表

     *

     *    @author    andcpp

     *    @return    array

     */

    function _get_functions()

    {

        $arr = array();        

        $arr[] = 'buy'; //来自买家下单通知   

        $arr[] = 'send'; //卖家发货通知买家   

		$arr[] = 'check';//来自买家确认通知   

        return $arr;

    }

	

	//中国网建接口 by andcpp 

	function Sms_Get($url)

	{

		if(function_exists('file_get_contents'))

		{

			$file_contents = file_get_contents($url);

		}

		else

		{

			$ch = curl_init();

			$timeout = 5;

			curl_setopt ($ch, CURLOPT_URL, $url);

			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

			$file_contents = curl_exec($ch);

			curl_close($ch);

		}

		return $file_contents;

	}

	   function _check_express_plugin()
	{
		$plugin_inc_file = ROOT_PATH . '/data/plugins.inc.php';
        if (is_file($plugin_inc_file))
        {
            $plugins =  include($plugin_inc_file);
			return isset($plugins['on_query_express']['kuaidi100']);
        }

        return false;
	}

	

	
function get_ip_location() {
        $baidu_ak = Conf::get('baidu_ak');
        if(empty($baidu_ak)){
            $this->show_warning('error');
            return;
        }
        
        $ip = $_SERVER["REMOTE_ADDR"];
        $url = "http://api.map.baidu.com/location/ip?ak=" . $baidu_ak . "&ip=" . $ip . "&coor=bd09ll";

        $content = file_get_contents($url);
        $result = ecm_json_decode($content);

        if ($result->status == '0') {
            $data['zoom'] = 15; //地图显示的层级
            $data['lng'] = $result->content->point->x;
            $data['lat'] = $result->content->point->y;
        } else {
            $this->show_warning($content);
            exit;
        }
        return $data;
    }
    
	

    function display($tpl)

    {
		
		//新增表
		$this->_creat_table();

        $cart =& m('cart');

        $this->assign('cart_goods_kinds', $cart->get_kinds(SESS_ID, $this->visitor->get('user_id')));

		/* 新消息 */

        $this->assign('new_message', isset($this->visitor) ? $this->_get_new_message() : '');



		import('init.lib');

		$init = new Init_FrontendApp();

		$this->assign('carts_top', $init->_get_carts_top(SESS_ID, $this->visitor->get('user_id')));

		

		/* 所有商品类目，头部通用  position: 给弹出层设置高度，使得页面效果美观 */

		$position = array('0px','-39px','-50px','-80px','-100px','-170px','-200px','-100px');

		$this->assign('header_gcategories',$init->_get_header_gcategories(0,$position,1));// 参数说明（二级分类显示数量,弹出层位置,品牌是否为推荐）

		

		$this->_do_wxautologin();

		/* 热门搜素 tyioocom */

        $this->assign('hot_keywords', $this->_get_hot_keywords());

		

		

		

		if($this->visitor->get('user_id'))

		{

			

		$deposit_account_mod = &m('deposit_account');

		$deposit_account = $deposit_account_mod->get(array('conditions'=>'user_id='.$this->visitor->get('user_id')));

		if(!$deposit_account)

		{

		

		$datamod = array(

				'user_id'		=>$this->visitor->get('user_id'),

				'account'		=>time().'@qq.com',

				'password'		=>md5('123456'),

				'real_name'		=>$this->visitor->get('user_name'),

				'pay_status'	=>	'ON',

				'add_time'		=>	time(),

				//'last_update'	=> 	$add_time,

			);

		

		$deposit_account_mod ->add($datamod);

			

		}

		

		

		

		}

		

		/* 用于前台判断快递跟踪插件是否安装 tyioocom */
		$this->assign('enable_express', $this->_check_express_plugin());
		/* 手机版数据 */
		
		$recom_mod =& m('recommend');
		
	   $img_goods_list = $recom_mod->get_recommended_goods('-100', 6, true, '0');
	   /* 手机*/
	  $img_goods_list1 = $recom_mod->get_recommended_goods('-100', 6, true, '1');
	  
	 $img_goods_list33672 = $recom_mod->get_recommended_goods('-100', 9, true, '3672');
	 $img_goods_list3437 = $recom_mod->get_recommended_goods('-100', 9, true, '3437');


        $groupbuy_mod = &m('groupbuy');
        $groupbuy_list_wap = $groupbuy_mod->find(array(
            'conditions'    => $conditions,
            'fields'        => 'gb.*,g.default_image,g.price,default_spec,s.store_name',
            'join'          => 'belong_store, belong_goods',
            'limit'         => $page['limit'],
            'count'         => true,   //允许统计
            'order'         => isset($_GET['order']) && isset($orders[$_GET['order']]) ? $_GET['order'] : 'group_id desc',
        ));
        if ($ids = array_keys($groupbuy_list_wap))
        {
            $quantity = $groupbuy_mod->get_join_quantity($ids);
        }
        foreach ($groupbuy_list_wap as $key => $groupbuy)
        {
            $groupbuy_list_wap[$key]['quantity'] = empty($quantity[$key]['quantity']) ? 0 : $quantity[$key]['quantity'];
            $groupbuy['default_image'] || $groupbuy_list_wap[$key]['default_image'] = Conf::get('default_goods_image');
            $groupbuy['spec_price'] = unserialize($groupbuy['spec_price']);
            $groupbuy_list_wap[$key]['group_price'] = $groupbuy['spec_price'][$groupbuy['default_spec']]['price'];
            $groupbuy['state'] == GROUP_ON && $groupbuy_list_wap[$key]['lefttime'] = lefttime($groupbuy['end_time']);
			if($groupbuy['price'] != 0){
				$groupbuy_list_wap[$key]['discount'] = round($groupbuy['spec_price'][$groupbuy['default_spec']]['price'] / $groupbuy['price'] * 10,1);
			} else {
				$groupbuy_list_wap[$key]['discount'] = 0;
			}
		}
        $this->assign('state', array(
             'on' => Lang::get('group_on'),
             'end' => Lang::get('group_end'),
             'finished' => Lang::get('group_finished'),
             'canceled' => Lang::get('group_canceled'))
        );


$this->assign('groupbuy_list_wap',$groupbuy_list_wap);
$this->assign('img_goods_list1', $img_goods_list1);
$this->assign('img_goods_list3479', $img_goods_list3479);
$this->assign('img_goods_list', $img_goods_list);

/*结束*/

        $this->assign('navs', $this->_get_navs());  // 自定义导航

        $this->assign('acc_help', ACC_HELP);        // 帮助中心分类code

        $this->assign('site_title', Conf::get('site_title'));

        $this->assign('site_logo', Conf::get('site_logo'));

        $this->assign('statistics_code', Conf::get('statistics_code')); // 统计代码

        $current_url = explode('/', $_SERVER['REQUEST_URI']);

        $count = count($current_url);

        $this->assign('current_url',  $count > 1 ? $current_url[$count-1] : $_SERVER['REQUEST_URI']);// 用于设置导航状态(以后可能会有问题)

        parent::display($tpl);

    }

	function _creat_table()
	{
		$mod =& m('privilege');
		$sql='CREATE TABLE IF NOT EXISTS `'.DB_PREFIX.'ugrade` (
			 `grade_id` INT( 255 ) NOT NULL AUTO_INCREMENT ,
			 `grade_name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
			 `grade` TINYINT( 3 ) NOT NULL ,
			 `grade_icon` VARCHAR( 255 ) NULL ,
			 `growth_needed` INT( 20 ) NOT NULL ,
			 `top_growth` INT( 20 )   NULL ,
			 `floor_growth` INT( 20 ) NOT NULL ,
			 `add_time` INT( 20 ) NULL,
			 PRIMARY KEY (`grade_id`)
			 ) ENGINE=MyISAM DEFAULT CHARSET='.str_replace('-','',CHARSET).';';
		$mod->db->query($sql);
		$ugrade_mod=&m('ugrade');
		$ugrade=$ugrade_mod->get(1);
		if(empty($ugrade))
		{
			$sql="INSERT INTO `".DB_PREFIX."ugrade` (`grade_id`, `grade_name`,`grade`,`growth_needed`,`floor_growth`,`add_time`) VALUES('1',  '普通会员',  '1', '0','0',".gmtime().")";
		}
		$mod->db->query($sql);
		$sql='CREATE TABLE IF NOT EXISTS `'.DB_PREFIX.'grade_goods` (
			`goods_id` INT( 255 ) NOT NULL ,
			`grade_id` INT( 20 ) NOT NULL ,
			`grade` INT( 20 ) NOT NULL ,
			`grade_discount` DECIMAL(4,2) NOT NULL DEFAULT  1
			) ENGINE=MyISAM DEFAULT CHARSET='.str_replace('-','',CHARSET).';';
		$mod->db->query($sql);
		
		
		$result = $mod->db->getAll('SHOW COLUMNS FROM '. DB_PREFIX . 'member');
		$fields = array();
		foreach($result as $v) {
			$fields[] = $v['Field'];
			if($v['Field'] == 'ugrade')
			{
				$default=$v['Default'];
			}
		}
		if($default == 0){
			$sql="ALTER TABLE  `".DB_PREFIX."member` ALTER  `ugrade` SET DEFAULT '1' ";
			$mod->db->query($sql);
		}
		$user_mod=&m('member');
		$users=$user_mod->find(array('conditions'=>'ugrade = 0','fields'=>'ugrade'));
		if($users)
		{
			foreach($users as $user){
				$user_mod->edit($user['user_id'],array('ugrade'=>1));
			}
		}
		
		
		if(!in_array('growth', $fields)){
			$sql='ALTER TABLE  `'.DB_PREFIX.'member` ADD  `growth` INT( 20 ) NOT NULL DEFAULT  0 AFTER  `feed_config`';
			$mod->db->query($sql);
		}	
		
		
		$result = $mod->db->getAll('SHOW COLUMNS FROM '. DB_PREFIX . 'goods');
		$fields = array();
		foreach($result as $v) {
			$fields[] = $v['Field'];
		}
		if(!in_array('if_open', $fields)){
			$sql='ALTER TABLE  `'.DB_PREFIX.'goods` ADD  `if_open` TINYINT( 3 ) NOT NULL DEFAULT  0 AFTER  `closed`';
			$mod->db->query($sql);
		}
		
	}

	/* 热门搜素 tyioocom */

	function _get_hot_keywords()

    {

        $keywords = explode(',', conf::get('hot_search'));

        return $keywords;

    }

	

    function _do_wxautologin()

    {

        if(ECMALL_WAP != 1){

            return;

        }

        $user_openid  = $_GET['user_openid'];

        $store_openid = $_GET['store_openid'];

        $wx_store_id  = $_GET['wx_store_id'];

        if (!empty($user_openid) && !empty($store_openid) && !empty($wx_store_id)) {

            $_SESSION['user_openid']  = $user_openid;

            $_SESSION['store_openid'] = $store_openid;

            $_SESSION['wx_store_id']  = $wx_store_id;

            if ($this->visitor->get('user_id')) {

                return;

            }

            $wxrelation_mod =  & m('wxrelation');

            $data = $wxrelation_mod->get("user_openid = '".$user_openid ."' and store_openid = '".$store_openid ."'");

            //如果存在记录就自动登录

            if($data){

                $this->_do_login($data['user_id']);

            }

        }

    }

    

    function _do_wxloginrelation($user_id)

    {

        if(ECMALL_WAP != 1){

            return;

        }

        

        if(!empty($_SESSION['user_openid']) && !empty($_SESSION['store_openid']) && !empty($_SESSION['wx_store_id'])){

            $data = array(

                'user_openid' =>$_SESSION['user_openid'],

                'store_openid'=>$_SESSION['store_openid'],

                'store_id'    =>$_SESSION['wx_store_id'],

                'user_id'     =>$user_id

            );

            $wxrelation_mod =  & m('wxrelation');

            $wxrelation_mod ->add($data);

        }

    }

    

    function login()

    {

		

        if ($this->visitor->has_login)

        {

			

            $this->show_warning('has_login');



            return;

        }

        if (!IS_POST)

        {

            if (!empty($_GET['ret_url']))

            {

                $ret_url = trim($_GET['ret_url']);

            }

            else

            {

                if (isset($_SERVER['HTTP_REFERER']))

                {

                    $ret_url = $_SERVER['HTTP_REFERER'];

                }

                else

                {

                    $ret_url = SITE_URL . '/index.php';

                }

            }

            /* 防止登陆成功后跳转到登陆、退出的页面 */

            $ret_url = strtolower($ret_url);            

            if (str_replace(array('act=login', 'act=logout', 'act=register'), '', $ret_url) != $ret_url)

            {

                $ret_url = SITE_URL . '/index.php';

            }



            if (Conf::get('captcha_status.login'))

            {

                $this->assign('captcha', 1);

            }

            $this->import_resource(array('script' => 'jquery.plugins/jquery.validate.js'));

            $this->assign('ret_url', rawurlencode($ret_url));

            $this->_curlocal(LANG::get('user_login'));

            $this->_config_seo('title', Lang::get('user_login') . ' - ' . Conf::get('site_title'));
			
			$this->assign('qqconnect_open', $this->_get_enabled_plugins('on_qq_login', 'qqconnect') ? 1 : 0);
			$this->assign('xwbconnect_open', $this->_get_enabled_plugins('on_xwb_login', 'xwbconnect') ? 1 : 0);
			$this->assign('alipayconnect_open', $this->_get_enabled_plugins('on_alipay_login', 'alipayconnect') ? 1 : 0);
			
            $this->display('login.html');

            /* 同步退出外部系统 */

            if (!empty($_GET['synlogout']))

            {

                $ms =& ms();

                echo $synlogout = $ms->user->synlogout();

            }

        }

        else

        {

            if (Conf::get('captcha_status.login') && base64_decode($_SESSION['captcha']) != strtolower($_POST['captcha']))

            {

                $this->show_warning('captcha_failed');



                return;

            }

			$user_name = trim($_POST['user_name']);

            $password  = $_POST['password'];

			$ms =& ms();

			$member=& m('member');

	        $result=$member->find(array('fields'=>'user_id,password,user_name','conditions'=>'email="'.$user_name.'" or phone_mob="'.$_POST['user_name'].'"'));

			

		if($result){

			 foreach($result as $key=>$value){

			    $user_name=$value['user_name'];

			}

	            $user_id = $ms->user->auth($user_name, $password);

			}else{

		      $user_id = $ms->user->auth($user_name, $password);

		}

			/*switch($_POST['select']){

			   case 'phone_mob':

                 $user_id=$this->select($user_name,$_POST['select']);

				   break;

			   case 'email':

                 $user_id=$this->select($user_name,$_POST['select']);

				   break;

			   default:

             $user_id = $ms->user->auth($user_name, $password);

			}*/

 

            if (!$user_id)

            {

             

				/* 未通过验证，提示错误信息 */

                $this->show_warning($ms->user->get_error());



                return;

            }

            else

            {

                $this->_do_wxloginrelation($user_id);

                /* 通过验证，执行登陆操作 */

                $this->_do_login($user_id);



                /* 同步登陆外部系统 */

                $synlogin = $ms->user->synlogin($user_id);

				 

            }

	

            $this->show_message(Lang::get('login_successed') . $synlogin,

                'back_before_login', rawurldecode($_POST['ret_url']),

                'enter_member_center', 'index.php?app=member'

            );

        }

    }

 /*  function select($user_name,$select_name){

        $member=& m('member');

	    $result=$member->find(array('fields'=>'user_id','conditions'=>$select_name.'="'.$user_name.'"'));

		if($result){

			      foreach($result as $key=>$value){

			       $user_id=$key;

			}

			return $user_id;

			}else{



			$this->show_message(Lang::get($select_name).'不存在','back_before_login','index.php?app=member&act=login');

			 return;

			}

			

     }*/

	function _get_enabled_plugins($event, $plugin_id) 
	{
		$plugin = array();
		$plugin_inc_file = ROOT_PATH .'/data/plugins.inc.php';
		if (is_file($plugin_inc_file)) {
			$plugin = include($plugin_inc_file);
		}
		return $plugin[$event][$plugin_id];
	}

    function pop_warning ($msg, $dialog_id = '',$url = '')

    {

        if($msg == 'ok')

        {

            if(empty($dialog_id))

            {

                $dialog_id = APP . '_' . ACT;

            }

            if (!empty($url))

            {

                echo "<script type='text/javascript'>window.parent.location.href='".$url."';</script>";

            }

            echo "<script type='text/javascript'>window.parent.js_success('" . $dialog_id ."');</script>";

        }

        else

        {

            header("Content-Type:text/html;charset=".CHARSET);

            $msg = is_array($msg) ? $msg : array(array('msg' => $msg));

            $errors = '';

            foreach ($msg as $k => $v)

            {

                $error = $v[obj] ? Lang::get($v[msg]) . " [" . Lang::get($v[obj]) . "]" : Lang::get($v[msg]);

                $errors .= $errors ? "<br />" . $error : $error;

            }

            echo "<script type='text/javascript'>window.parent.js_fail('" . $errors . "');</script>";

        }

    }



    function logout()

    {

        $this->visitor->logout();



        /* 跳转到登录页，执行同步退出操作 */

        header("Location: index.php?app=member&act=login&synlogout=1");

        return;

    }



    /* 执行登录动作 */

function _do_login($user_id)

    {

        $mod_user =& m('member');



        $user_info = $mod_user->get(array(

            'conditions'    => "user_id = '{$user_id}'",

            'join'          => 'has_store',                 //关联查找看看是否有店铺

            'fields'        => 'user_id, user_name, reg_time, last_login, last_ip, store_id',

        ));

        /* 店铺ID */

        $my_store = empty($user_info['store_id']) ? 0 : $user_info['store_id'];



        /* 保证基础数据整洁 */

        //unset($user_info['store_id']);



        /* 分派身份 */

		//print_r($_SESSION);exit;

        $this->visitor->assign($user_info);



        /* 更新用户登录信息 */

        $mod_user->edit("user_id = '{$user_id}'", "last_login = '" . gmtime()  . "', last_ip = '" . real_ip() . "', logins = logins + 1");



		/*站内宝v2.2.1 自动注册开通 开始*/

		$db=&db();

		$my_money_row=$db->getAll("select * from ".DB_PREFIX."my_money where user_id='$user_id'");

		if(empty($my_money_row))

		{

			$member_row=$db->getrow("select * from ".DB_PREFIX."member where user_id='$user_id'");

			//站内宝 添加自动开通

			$my_money_mod =& m('my_money');

			$money_data=array(

			'user_id'=>$member_row['user_id'],

			'user_name'=>$member_row['user_name'],

			//'zf_pass'=>'',

			'zf_pass'=>$member_row['password'],

			'add_time'=>time(),

			);

			$my_money_mod->add($money_data);	

		}

	/*站内宝v2.2.1 自动注册开通 结束*/

        

        /* 更新购物车中的数据 */

        $mod_cart =& m('cart');

        $mod_cart->edit("(user_id = '{$user_id}' OR session_id = '" . SESS_ID . "') AND store_id <> '{$my_store}'", array(

            'user_id'    => $user_id,

            'session_id' => SESS_ID,

        ));



        /* 去掉重复的项 */

        $cart_items = $mod_cart->find(array(

            'conditions'    => "user_id='{$user_id}' GROUP BY spec_id",

            'fields'        => 'COUNT(spec_id) as spec_count, spec_id, rec_id',

        ));

        if (!empty($cart_items))

        {

            foreach ($cart_items as $rec_id => $cart_item)

            {

                if ($cart_item['spec_count'] > 1)

                {

                    $mod_cart->drop("user_id='{$user_id}' AND spec_id='{$cart_item['spec_id']}' AND rec_id <> {$cart_item['rec_id']}");

                }

            }

        }

    }



    /* 取得导航 */

    function _get_navs()

    {

        $cache_server =& cache_server();

        $key = 'common.navigation';

        $data = $cache_server->get($key);

        if($data === false)

        {

            $data = array(

                'header' => array(),

                'middle' => array(),

                'footer' => array(),

            );

            $nav_mod =& m('navigation');

            $rows = $nav_mod->find(array(

                'order' => 'type, sort_order',

            ));

            foreach ($rows as $row)

            {

                $data[$row['type']][] = $row;

            }

            $cache_server->set($key, $data, 86400);

        }



        return $data;

    }



    /**

     *    获取JS语言项

     *

     *    @author    Garbin

     *    @param    none

     *    @return    void

     */

    function jslang()

    {

        $lang = Lang::fetch(lang_file('jslang'));

        parent::jslang($lang);

    }



    /**

     *    视图回调函数[显示小挂件]

     *

     *    @author    Garbin

     *    @param     array $options

     *    @return    void

     */

    function display_widgets($options)

    {

        $area = isset($options['area']) ? $options['area'] : '';

        $page = isset($options['page']) ? $options['page'] : '';

        if (!$area || !$page)

        {

            return;

        }

        include_once(ROOT_PATH . '/includes/widget.base.php');



        /* 获取该页面的挂件配置信息 */

        $widgets = get_widget_config($this->_get_template_name(), $page);



        /* 如果没有该区域 */

        if (!isset($widgets['config'][$area]))

        {

            return;

        }



        /* 将该区域内的挂件依次显示出来 */

        foreach ($widgets['config'][$area] as $widget_id)

        {

            $widget_info = $widgets['widgets'][$widget_id];

            $wn     =   $widget_info['name'];

            $options=   $widget_info['options'];



            $widget =& widget($widget_id, $wn, $options);

            $widget->display();

        }

    }



    /**

     *    获取当前使用的模板名称

     *

     *    @author    Garbin

     *    @return    string

     */

    function _get_template_name()

    {

        return 'default';

    }



    /**

     *    获取当前使用的风格名称

     *

     *    @author    Garbin

     *    @return    string

     */

    function _get_style_name()

    {

        return 'default';

    }



    /**

     *    当前位置

     *

     *    @author    Garbin

     *    @param    none

     *    @return    void

     */

    function _curlocal($arr)

    {

        $curlocal = array(array(

            'text'  => Lang::get('index'),

            'url'   => SITE_URL . '/index.php',

        ));

        if (is_array($arr))

        {

            $curlocal = array_merge($curlocal, $arr);

        }

        else

        {

            $args = func_get_args();

            if (!empty($args))

            {

                $len = count($args);

                for ($i = 0; $i < $len; $i += 2)

                {

                    $curlocal[] = array(

                        'text'  =>  $args[$i],

                        'url'   =>  $args[$i+1],

                    );

                }

            }

        }



        $this->assign('_curlocal', $curlocal);

    }

    function _init_visitor()

    {

 if (!$_SESSION['user_info']['user_id']) {
                
           
	
		 $user_id=$this->weixinlogin();
	     $user_info= $this->wxloin($user_id);	
		 $_SESSION['user_info']=$user_info;
		  }
	
	
	$this->visitor =& env('visitor', new UserVisitor());
       

    }

function weixinlogin()
	{

		
		
	 
		
	  $wxid  = $_GET['wxid'];
	  $key = trim($_GET['key']);
	  $user_mod =& m('member');
	
	$user=$user_mod->get(array(
			  'join' => 'has_wx',
            'fields' => 'this.*,w.wxid,w.nickname,member.user_name,member.password,member.last_login,member.last_ip',
			 'conditions' => '1=1 and w.wxid="'.$wxid.'"',
			  ));
			  
		  $check_key = md5($user['user_id'].$user['user_name'].$user['password'].$user['last_login'].$user['last_ip']);
			 
			 
			   
		  if (!empty($wxid) && !empty($key))
		  {
			  
			 if ($_SESSION['user_info']['user_id']) {
                return;
            } 
			 
		  if($key == $check_key)
		  {
			
			 /* 更新用户登录信息 */
        $user_mod->edit("user_id = '{$user['user_id']}'", "last_login = '" . gmtime()  . "', last_ip = '" . real_ip() . "', logins = logins + 1");
			
			return $user['user_id'];
		
			
		}else{
			
			
			
		return 0;
			}
			 
			 
		 }	   
			   
 // print_r($weixi_info);			  
	
	}

function wxloin($user_id)

{

	

	 $mod_user =& m('member');



        $user_info = $mod_user->get(array(

            'conditions'    => "user_id = '$user_id'",

            'join'          => 'has_store',                 //关联查找看看是否有店铺

            'fields'        => 'user_id, user_name, reg_time, last_login, last_ip, store_id',

        ));



        /* 店铺ID */

        $my_store = empty($user_info['store_id']) ? 0 : $user_info['store_id'];

		

		

	 return  $user_info;

	





}





}


/**

 *    前台访问者

 *

 *    @author    Garbin

 *    @usage    none

 */

class UserVisitor extends BaseVisitor

{

    var $_info_key = 'user_info';



    /**

     *    退出登录

     *

     *    @author    Garbin

     *    @param    none

     *    @return    void

     */

    function logout()

    {

        /* 将购物车中的相关项的session_id置为空 */

        $mod_cart =& m('cart');

        $mod_cart->edit("user_id = '" . $this->get('user_id') . "'", array(

            'session_id' => '',

        ));



        /* 退出登录 */

        parent::logout();

    }

}

/**

 *    商城控制器基类

 *

 *    @author    Garbin

 *    @usage    none

 */

class MallbaseApp extends FrontendApp

{

    function _run_action()

    {

        /* 只有登录的用户才可访问 */

        if (!$this->visitor->has_login && in_array(APP, array('apply')))

        {

            header('Location: index.php?app=member&act=login&ret_url=' . rawurlencode($_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']));



            return;

        }



        parent::_run_action();

    }



    function _get_waptemplate_name()

    {

        $template_name = Conf::get('waptemplate_name');

        if (!$template_name)

        {

            $template_name = 'default';

        }

        return $template_name;

    }

    function _get_wapstyle_name()

    {

        $style_name = Conf::get('wapstyle_name');

        if (!$style_name)

        {

            $style_name = 'default';

        }

        return $style_name;

    }

    

    

    function _config_view()

    {

        parent::_config_view();

        if(ECMALL_WAP == 1){

            $template_name = $this->_get_waptemplate_name();

            $style_name = $this->_get_wapstyle_name();

            $this->_view->template_dir = ROOT_PATH . "/themes/wapmall/{$template_name}";

            $this->_view->compile_dir = ROOT_PATH . "/temp/compiled/wapmall/{$template_name}";

            $this->_view->res_base = SITE_URL . "/themes/wapmall/{$template_name}/styles/{$style_name}";

        }else{

            $template_name = $this->_get_template_name();

            $style_name = $this->_get_style_name();

            $this->_view->template_dir = ROOT_PATH . "/themes/mall/{$template_name}";

            $this->_view->compile_dir = ROOT_PATH . "/temp/compiled/mall/{$template_name}";

            $this->_view->res_base = SITE_URL . "/themes/mall/{$template_name}/styles/{$style_name}";

        }

    }



    /* 取得支付方式实例 */

    function _get_payment($code, $payment_info)

    {

        include_once(ROOT_PATH . '/includes/payment.base.php');

        include(ROOT_PATH . '/includes/payments/' . $code . '/' . $code . '.payment.php');

        $class_name = ucfirst($code) . 'Payment';



        return new $class_name($payment_info);

    }

	function _get_platform_payment($code, $payment_info)

    {

        include_once(ROOT_PATH . '/includes/payment.base.php');

        include(ROOT_PATH . '/includes/platform_payments/' . $code . '/' . $code . '.payment.php');

        $class_name = ucfirst($code) . 'Payment';



        return new $class_name($payment_info);

    }





function _get_bank_inc($type='')

	{

		if($type=='alipaybank') {

			$bank_inc = include ROOT_PATH .'/data/alipaybank.inc.php';

		}

		else $bank_inc = include ROOT_PATH .'/data/bank.inc.php';

		if(!is_array($bank_inc) || count($bank_inc)<1)

		{

			$this->show_warning('bank_inc_error');

			return;

		}

		return $bank_inc;

	}

    /**

     *   获取当前所使用的模板名称

     *

     *    @author    Garbin

     *    @return    string

     */

    function _get_template_name()

    {

        $template_name = Conf::get('template_name');

        if (!$template_name)

        {

            $template_name = 'default';

        }



        return $template_name;

    }



    /**

     *    获取当前模板中所使用的风格名称

     *

     *    @author    Garbin

     *    @return    string

     */

    function _get_style_name()

    {

        $style_name = Conf::get('style_name');

        if (!$style_name)

        {

            $style_name = 'default';

        }



        return $style_name;

    }

}



/**

 *    购物流程子系统基础类

 *

 *    @author    Garbin

 *    @usage    none

 */

class ShoppingbaseApp extends MallbaseApp

{

    function _run_action()

    {

        /* 只有登录的用户才可访问 */
		
        if (!$this->visitor->has_login && !in_array(ACT, array('login', 'register', 'check_user','wxjsapi')))
        {

            if (!IS_AJAX)

            {

                header('Location:index.php?app=member&act=login&ret_url=' . rawurlencode($_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']));



                return;

            }

            else

            {

                $this->json_error('login_please');

                return;

            }

        }



        parent::_run_action();

    }

}



/**

 *    用户中心子系统基础类

 *

 *    @author    Garbin

 *    @usage    none

 */

class MemberbaseApp extends MallbaseApp

{

    function _run_action()

    {

        /* 只有登录的用户才可访问 */

        if (!$this->visitor->has_login && !in_array(ACT, array('login', 'register', 'check_user')))

        {

            if (!IS_AJAX)

            {

                header('Location:index.php?app=member&act=login&ret_url=' . rawurlencode($_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']));



                return;

            }

            else

            {

                $this->json_error('login_please');

                return;

            }

        }



        parent::_run_action();

    }

    /**

     *    当前选中的菜单项

     *

     *    @author    Garbin

     *    @param     string $item

     *    @return    void

     */

    function _curitem($item)

    {

        $this->assign('has_store', $this->visitor->get('has_store'));

		// psmb

		$member_menu = $this->_get_member_menu();

		if(!$this->visitor->get('has_store')){

			unset($member_menu['im_seller']);

			$this->assign('member_role', 'buyer_admin');

		} else {

			if($_SESSION['member_role'] == 'buyer_admin') {

				unset($member_menu['im_seller']);

				$this->assign('member_role', 'buyer_admin');

			} else {

				unset($member_menu['im_buyer']);

				$this->assign('member_role', 'seller_admin');

			}

		}

        $this->assign('_member_menu', $member_menu);

        $this->assign('_curitem', $item);

    }

    /**

     *    当前选中的子菜单

     *

     *    @author    Garbin

     *    @param     string $item

     *    @return    void

     */

    function _curmenu($item)

    {

        $_member_submenu = $this->_get_member_submenu();

        foreach ($_member_submenu as $key => $value)

        {

            $_member_submenu[$key]['text'] = $value['text'] ? $value['text'] : Lang::get($value['name']);

        }

        $this->assign('_member_submenu', $_member_submenu);

        $this->assign('_curmenu', $item);

    }

    /**

     *    获取子菜单列表

     *

     *    @author    Garbin

     *    @param    none

     *    @return    void

     */

    function _get_member_submenu()

    {

        return array();

    }

    /**

     *    获取用户中心全局菜单列表

     *

     *    @author    Garbin

     *    @param    none

     *    @return    void

     */

    function _get_member_menu()

    {

        $menu = array();



        /* 我的ECMall */

        $menu['my_ecmall'] = array(

            'name'  => 'my_ecmall',

            'text'  => Lang::get('my_ecmall'),

            'submenu'   => array(

                'overview'  => array(

                    'text'  => Lang::get('overview'),

                    'url'   => 'index.php?app=member',

                    'name'  => 'overview',

                    'icon'  => 'ico1',

                ),

                'my_profile'  => array(

                    'text'  => Lang::get('my_profile'),

                    'url'   => 'index.php?app=member&act=profile',

                    'name'  => 'my_profile',

                    'icon'  => 'ico2',

                ),
				
				    'user'  => array(

                    'text'  => '推荐好友',

                    'url'   => 'index.php?app=user',

                    'name'  => 'user',

                    'icon'  => 'ico2',

                ),

                'message'  => array(

                    'text'  => Lang::get('message'),

                    'url'   => 'index.php?app=message&act=newpm',

                    'name'  => 'message',

                    'icon'  => 'ico3',

                ),

                'friend'  => array(

                    'text'  => Lang::get('friend'),

                    'url'   => 'index.php?app=friend',

                    'name'  => 'friend',

                    'icon'  => 'ico4',

                ),

                /*

                'my_credit'  => array(

                    'text'  => Lang::get('my_credit'),

                    'url'   => 'index.php?app=member&act=credit',

                    'name'  => 'my_credit',

                ),*/

				'jifenduihuan'  => array(

                    'text'  => '积分管理',

                    'url'   => 'index.php?app=my_money&act=jifen',

                    'name'  => 'jifenduihuan',

                    'icon'  => 'ico6',

					),

		/*		'jiaoyichaxun'  => array(

                    'text'  => '资金管理',

                    'url'   => 'index.php?app=my_money&act=loglist',

                    'name'  => 'jiaoyichaxun',

                    'icon'  => 'ico13',

                ),*/

				

				

					'deposit'  => array(

                    'text'  => '交易宝',

                    'url'   => 'index.php?app=deposit',

                    'name'  => 'deposit',

                    'icon'  => 'ico13',

                ),

            ),

        );

/* 站内宝v2.2.1 导航开始 */

       /* $menu['shangfutong'] = array(

            'name'  => 'shangfutong',

            'text'  => Lang::get('shangfutong'),

            'submenu'   => array(



                'jiaoyichaxun'  => array(

                    'text'  => Lang::get('jiaoyichaxun'),

                    'url'   => 'index.php?app=my_money&act=loglist',

                    'name'  => 'jiaoyichaxun',

                    'icon'  => 'ico5',

                ),



                'chongzhichaxun'  => array(

                    'text'  => Lang::get('chongzhichaxun'),

                    'url'   => 'index.php?app=my_money&act=paylist',

                    'name'  => 'chongzhichaxun',

                    'icon'  => 'ico13',

                ),



                'tixianshenqing'  => array(

                    'text'  => Lang::get('tixianshenqing'),

                    'url'   => 'index.php?app=my_money&act=txlist',

                    'name'  => 'tixianshenqing',

                    'icon'  => 'ico6',

                ),



                'zhanghushezhi'  => array(

                    'text'  => Lang::get('zhanghushezhi'),

                    'url'   => 'index.php?app=my_money&act=mylist',

                    'name'  => 'zhanghushezhi',

                    'icon'  => 'ico11',

                ),

            ),

        );
*/
        /* 站内宝 导航结束 */



        /* 我是买家 */

        $menu['im_buyer'] = array(

            'name'  => 'im_buyer',

            'text'  => Lang::get('im_buyer'),

            'submenu'   => array(

                'my_order'  => array(

                    'text'  => Lang::get('my_order'),

                    'url'   => 'index.php?app=buyer_order',

                    'name'  => 'my_order',

                    'icon'  => 'ico5',

                ),



             'my_groupbuy'  => array(

                    'text'  => Lang::get('my_groupbuy'),

                    'url'   => 'index.php?app=buyer_groupbuy',

                    'name'  => 'my_groupbuy',

                    'icon'  => 'ico21',

                ),


                'my_question' =>array(

                    'text'  => Lang::get('my_question'),

                    'url'   => 'index.php?app=my_question',

                    'name'  => 'my_question',

                    'icon'  => 'ico17',



                ),

                'my_favorite'  => array(

                    'text'  => Lang::get('my_favorite'),

                    'url'   => 'index.php?app=my_favorite',

                    'name'  => 'my_favorite',

                    'icon'  => 'ico6',

                ),

                'my_address'  => array(

                    'text'  => Lang::get('my_address'),

                    'url'   => 'index.php?app=my_address',

                    'name'  => 'my_address',

                    'icon'  => 'ico7',

                ),

                'my_coupon'  => array(

                    'text'  => Lang::get('my_coupon'),

                    'url'   => 'index.php?app=my_coupon',

                    'name'  => 'my_coupon',

                    'icon'  => 'ico20',

                ),

				'refund' => array(
					'text' => Lang::get('refund_apply'),
					'url'  => 'index.php?app=refund',
					'name' => 'refund_apply',
					'icon' => 'ico9',
				),
				'supply_demand'  => array(
                    'text'  => Lang::get('supply_demand'),
                    'url'   => 'index.php?app=supply_demand',
                    'name'  => 'supply_demand',
                    'icon'  => 'ico10',
                ),				

					'affiliate' => array(

                        'text' => '推荐分成',

                        'url' => 'index.php?app=affiliate',

                        'name' => 'affiliate',

						'icon'  => 'ico20',

                    ),

            ),

        );



        if (!$this->visitor->get('has_store') && Conf::get('store_allow'))

        {

            /* 没有拥有店铺，且开放申请，则显示申请开店链接 */

            /*$menu['im_seller'] = array(

                'name'  => 'im_seller',

                'text'  => Lang::get('im_seller'),

                'submenu'   => array(),

            );



            $menu['im_seller']['submenu']['overview'] = array(

                'text'  => Lang::get('apply_store'),

                'url'   => 'index.php?app=apply',

                'name'  => 'apply_store',

            );*/

            $menu['overview'] = array(

                'text' => Lang::get('apply_store'),

                'url'  => 'index.php?app=apply',

            );

        }

        if ($this->visitor->get('manage_store'))

        {

			

			$menu['my_ecmall']['submenu']['msg'] = array(

                    'text'  => Lang::get('msg'),

                    'url'   => 'index.php?app=msg',

                    'name'  => 'msg',

                    'icon'  => 'ico3',

                );

            /* 指定了要管理的店铺 */

            $menu['im_seller'] = array(

                'name'  => 'im_seller',

                'text'  => Lang::get('im_seller'),

                'submenu'   => array(),

            );
			$menu['im_seller']['submenu']['supply_demand'] = array(
                    'text'  => Lang::get('supply_demand'),
                    'url'   => 'index.php?app=supply_demand',
                    'name'  => 'supply_demand',
                    'icon'  => 'ico10',
                );
            $menu['im_seller']['submenu']['my_goods'] = array(

                    'text'  => Lang::get('my_goods'),

                    'url'   => 'index.php?app=my_goods',

                    'name'  => 'my_goods',

                    'icon'  => 'ico8',

            );

				$menu['im_seller']['submenu']['promotion_manage'] = array(

			        'text'  => Lang::get('promotion_manage'),

					'url'   => 'index.php?app=seller_promotion',

					'name'  => 'promotion_manage',

					'icon'  => 'ico9',

			);

	    	/*$menu['im_seller']['submenu']['seckill_manage'] = array(

                    'text'  => Lang::get('seckill_manage'),

                    'url'   => 'index.php?app=seckill',

                    'name'  => 'seckill_manage',

                    'icon'  => 'ico22',

            );*/

			$menu['im_seller']['submenu']['ju'] = array(

                    'text'  => Lang::get('ju_manage'),

                    'url'   => 'index.php?app=seller_ju',

                    'name'  => 'ju',

                    'icon'  => 'ico5',

            );

		

            $menu['im_seller']['submenu']['groupbuy_manage'] = array(

                    'text'  => Lang::get('groupbuy_manage'),

                    'url'   => 'index.php?app=seller_groupbuy',

                    'name'  => 'groupbuy_manage',

                    'icon'  => 'ico22',

            );

	

            $menu['im_seller']['submenu']['my_qa'] = array(

                    'text'  => Lang::get('my_qa'),

                    'url'   => 'index.php?app=my_qa',

                    'name'  => 'my_qa',

                    'icon'  => 'ico18',

            );

            $menu['im_seller']['submenu']['my_category'] = array(

                    'text'  => Lang::get('my_category'),

                    'url'   => 'index.php?app=my_category',

                    'name'  => 'my_category',

                    'icon'  => 'ico9',

            );

            $menu['im_seller']['submenu']['order_manage'] = array(

                    'text'  => Lang::get('order_manage'),

                    'url'   => 'index.php?app=seller_order',

                    'name'  => 'order_manage',

                    'icon'  => 'ico10',
            );
			$menu['im_seller']['submenu']['refund_receive']  = array(
					'text' => Lang::get('refund_receive'),
					'url'  => 'index.php?app=refund&act=receive',
					'name' => 'refund_receive',
					'icon' => 'ico9',
            );

            $menu['im_seller']['submenu']['my_store']  = array(

                    'text'  => Lang::get('my_store'),

                    'url'   => 'index.php?app=my_store',

                    'name'  => 'my_store',

                    'icon'  => 'ico11',

            );

			

		   $menu['im_seller']['submenu']['affiliate2']  = array(

                    'text'  => '分成查询',

		           'url'   => 'index.php?app=affiliate2',

                    'name'  => 'affiliate2',

                    'icon'  => 'ico12',

            );

            $menu['im_seller']['submenu']['my_theme']  = array(

                    'text'  => Lang::get('my_theme'),

                    'url'   => 'index.php?app=my_theme',

                    'name'  => 'my_theme',

                    'icon'  => 'ico12',
            );
	    	$menu['im_seller']['submenu']['template']  = array(
                    'text'  => Lang::get('template'),
                    'url'   => 'index.php?app=template',
                    'name'  => 'template',
                    'icon'  => 'ico22',
            );

			

            $menu['im_seller']['submenu']['my_payment'] =  array(

                    'text'  => Lang::get('my_payment'),

                    'url'   => 'index.php?app=my_payment',

                    'name'  => 'my_payment',

                    'icon'  => 'ico13',

            );

			

            $menu['im_seller']['submenu']['my_shipping'] = array(

                    'text'  => Lang::get('my_shipping'),

                    'url'   => 'index.php?app=my_shipping',

                    'name'  => 'my_shipping',

                    'icon'  => 'ico14',

            );

            $menu['im_seller']['submenu']['my_navigation'] = array(

                    'text'  => Lang::get('my_navigation'),

                    'url'   => 'index.php?app=my_navigation',

                    'name'  => 'my_navigation',

                    'icon'  => 'ico15',

            );

            $menu['im_seller']['submenu']['my_partner']  = array(

                    'text'  => Lang::get('my_partner'),

                    'url'   => 'index.php?app=my_partner',

                    'name'  => 'my_partner',

                    'icon'  => 'ico16',

            );

            $menu['im_seller']['submenu']['coupon']  = array(

                    'text'  => Lang::get('coupon'),

                    'url'   => 'index.php?app=coupon',

                    'name'  => 'coupon',

                    'icon'  => 'ico19',

            );

            $menu['im_seller']['submenu']['my_waptheme']  = array(

                    'text'  => Lang::get('my_waptheme'),

                    'url'   => 'index.php?app=my_waptheme',

                    'name'  => 'my_waptheme',

                    'icon'  => 'ico12',

            );

            $menu['im_seller']['submenu']['kmenus']  = array(

                    'text'  => Lang::get('kmenus'),

                    'url'   => 'index.php?app=kmenus',

                    'name'  => 'kmenus',

                    'icon'  => 'ico13',

            );

            $menu['im_seller']['submenu']['lunbo']  = array(

                    'text'  => Lang::get('lunbo'),

                    'url'   => 'index.php?app=lunbo',

                    'name'  => 'lunbo',

                    'icon'  => 'ico14',
            );
			// tyioocom datapacket 
			$menu['im_seller']['submenu']['my_datapacket']  = array(
                    'text'  => Lang::get('my_datapacket'),
                    'url'   => 'index.php?app=my_datapacket',
                    'name'  => 'my_datapacket',
                    'icon'  => 'ico10',
            );

            

            $menu['im_seller']['submenu']['my_membership_setting']  = array(

                    'text'  => Lang::get('my_membership_setting'),

                    'url'   => 'index.php?app=my_membership_setting',

                    'name'  => 'my_membership_setting',

                    'icon'  => 'ico14',

            );

            $menu['im_seller']['submenu']['my_membership_card_info']  = array(

                    'text'  => Lang::get('my_membership_card_info'),

                    'url'   => 'index.php?app=my_membership_card_info',

                    'name'  => 'my_membership_card_info',

                    'icon'  => 'ico14',

            );

            

            

            

            

            

            

            

        /* 卖家微信管理 */

        $menu['im_wx'] = array(

            'name'  => 'im_wx',

            'text'  => Lang::get('im_wx'),

            'submenu'   => array(

                'my_wxconfig'  => array(

                    'text'  => Lang::get('my_wxconfig'),

                    'url'   => 'index.php?app=my_wxconfig',

                    'name'  => 'my_wxconfig',

                    'icon'  => 'ico5',

                ),

                'my_wxfollow'  => array(

                    'text'  => Lang::get('my_wxfollow'),

                    'url'   => 'index.php?app=my_wxfollow',

                    'name'  => 'my_wxfollow',

                    'icon'  => 'ico21',

                ),

                'my_wxkeyword' =>array(

                    'text'  => Lang::get('my_wxkeyword'),

                    'url'   => 'index.php?app=my_wxkeyword',

                    'name'  => 'my_wxkeyword',

                    'icon'  => 'ico17',



                ),

                'my_wxmess'  => array(

                    'text'  => Lang::get('my_wxmess'),

                    'url'   => 'index.php?app=my_wxmess',

                    'name'  => 'my_wxmess',

                    'icon'  => 'ico6',

                ),

                'my_wxmenu'  => array(

                    'text'  => Lang::get('my_wxmenu'),

                    'url'   => 'index.php?app=my_wxmenu',

                    'name'  => 'my_wxmenu',

                    'icon'  => 'ico7',

                ),

            ),

        );

            

            

        }



        return $menu;

    }

}



/**

 *    店铺管理子系统基础类

 *

 *    @author    Garbin

 *    @usage    none

 */

class StoreadminbaseApp extends MemberbaseApp

{

    function _run_action()

    {

        /* 只有登录的用户才可访问 */

        if (!$this->visitor->has_login && !in_array(ACT, array('login', 'register', 'check_user')))

        {

            if (!IS_AJAX)

            {

                header('Location:index.php?app=member&act=login&ret_url=' . rawurlencode($_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']));



                return;

            }

            else

            {

                $this->json_error('login_please');

                return;

            }

        }

        $referer = $_SERVER['HTTP_REFERER'];

        if (strpos($referer, 'act=login') === false)

        {

            $ret_url = $_SERVER['HTTP_REFERER'];

            $ret_text = 'go_back';

        }

        else

        {

            $ret_url = SITE_URL . '/index.php';

            $ret_text = 'back_index';

        }



        /* 检查是否是店铺管理员 */

        if (!$this->visitor->get('manage_store'))

        {

            /* 您不是店铺管理员 */

            $this->show_warning(

                'not_storeadmin',

                'apply_now', 'index.php?app=apply',

                $ret_text, $ret_url

            );



            return;

        }



        /* 检查是否被授权 */

        $privileges = $this->_get_privileges();

        if (!$this->visitor->i_can('do_action', $privileges))

        {

            $this->show_warning('no_permission', $ret_text, $ret_url);




            return;

        }



        /* 检查店铺开启状态 */

        $state = $this->visitor->get('state');

        if ($state == 0)

        {

            $this->show_warning('apply_not_agree', $ret_text, $ret_url);



            return;

        }

        elseif ($state == 2)

        {

            $this->show_warning('store_is_closed', $ret_text, $ret_url);



            return;

        }



        /* 检查附加功能 */

        if (!$this->_check_add_functions())

        {

            $this->show_warning('not_support_function', $ret_text, $ret_url);

            return;

        }



        parent::_run_action();

    }

    function _get_privileges()

    {

        $store_id = $this->visitor->get('manage_store');

        $privs = $this->visitor->get('s');



        if (empty($privs))

        {

            return '';

        }



        foreach ($privs as $key => $admin_store)

        {

            if ($admin_store['store_id'] == $store_id)

            {

                return $admin_store['privs'];

            }

        }

    }

    

    /* 获取当前店铺所使用的主题 */

    function _get_theme()

    {

        $model_store =& m('store');

        $store_info  = $model_store->get($this->visitor->get('manage_store'));

        $theme = !empty($store_info['theme']) ? $store_info['theme'] : 'default|default';

        list($curr_template_name, $curr_style_name) = explode('|', $theme);

        return array(

            'template_name' => $curr_template_name,

            'style_name'    => $curr_style_name,

        );

    }



    function _check_add_functions()

    {

        $apps_functions = array( // app与function对应关系

            'seller_groupbuy' => 'groupbuy',

            'coupon' => 'coupon',
'template' => 'template',
			

        );

        if (isset($apps_functions[APP]))

        {

            $store_mod =& m('store');

            $settings = $store_mod->get_settings($this->_store_id);

            $add_functions = isset($settings['functions']) ? $settings['functions'] : ''; // 附加功能

            if (!in_array($apps_functions[APP], explode(',', $add_functions)))

            {

                return false;

            }

        }

        return true;

    }

}



/**

 *    虚拟币管理子系统基础类

 *

 *    @author    psmb

 *    @usage    none

 */

class DepositbaseApp extends MemberbaseApp

{

	function _run_action()

	{

		$this->assign('has_account', $this->_has_account());

		

		parent::_run_action();

	}

	

	

	function _has_account()

	{

		$deposit_account_mod = &m('deposit_account');

		$deposit_account = $deposit_account_mod->get(array('conditions'=>'user_id='.$this->visitor->get('user_id')));

		if($deposit_account) {

			return 1;

		}

		return 0;

	}   

}



/**

 *    店铺控制器基础类

 *

 *    @author    Garbin

 *    @usage    none

 */

class StorebaseApp extends FrontendApp

{

    var $_store_id;



    /**

     * 设置店铺id

     *

     * @param int $store_id

     */

    function set_store($store_id)

    {

        $this->_store_id = intval($store_id);



        /* 有了store id后对视图进行二次配置 */

        $this->_init_view();

        $this->_config_view();

    }



    function _get_waptemplate_name()

    {

        $store_info = $this->_get_store_info();

        $theme = !empty($store_info['waptheme']) ? $store_info['waptheme'] : 'default|default';

        list($template_name, $style_name) = explode('|', $theme);

        return $template_name;

    }

    function _get_wapstyle_name()

    {

        $store_info = $this->_get_store_info();

        $theme = !empty($store_info['waptheme']) ? $store_info['waptheme'] : 'default|default';

        list($template_name, $style_name) = explode('|', $theme);

        return $style_name;

    }



    function _config_view()

    {

        parent::_config_view();

        

        if(ECMALL_WAP == 1){

            $template_name = $this->_get_waptemplate_name();

            $style_name = $this->_get_wapstyle_name();

            

            $this->_view->template_dir = ROOT_PATH . "/themes/wapstore/{$template_name}";

            $this->_view->compile_dir = ROOT_PATH . "/temp/compiled/wapstore/{$template_name}";

            $this->_view->res_base = SITE_URL . "/themes/wapstore/{$template_name}/styles/{$style_name}";

            

        }else{

            $template_name = $this->_get_template_name();

            $style_name = $this->_get_style_name();



            $this->_view->template_dir = ROOT_PATH . "/themes/store/{$template_name}";

            $this->_view->compile_dir = ROOT_PATH . "/temp/compiled/store/{$template_name}";

            $this->_view->res_base = SITE_URL . "/themes/store/{$template_name}/styles/{$style_name}";

        }

    }



    /**

     * 取得店铺信息

     */

    function get_store_data()

    {

        $cache_server =& cache_server();

        $key = 'function_get_store_data_' . $this->_store_id;

        $store = $cache_server->get($key);

        if ($store === false)

        {

            $store = $this->_get_store_info();
          
            if (empty($store))

            {

                $this->show_warning('the_store_not_exist');

                exit;

            }

            if ($store['state'] == 2)

            {

                $this->show_warning('the_store_is_closed');

                exit;

            }

            $step = intval(Conf::get('upgrade_required'));

            $step < 1 && $step = 5;

            $store_mod =& m('store');

            $store['credit_image'] = $this->_view->res_base . '/images/' . $store_mod->compute_credit($store['credit_value'], $step);



            empty($store['store_logo']) && $store['store_logo'] = Conf::get('default_store_logo');

            $store['store_owner'] = $this->_get_store_owner();

            $store['store_navs']  = $this->_get_store_nav();

            $store['kmenus']     = $this->_get_store_kmenus($this->_store_id);

            $store['kmenusinfo'] = $this->_get_store_kmenusinfo($this->_store_id);

            $store['radio_new']  = 1;

            $store['radio_recommend']     = 1;

            $store['radio_hot']     = 1;

            $goods_mod =& m('goods');

            $store['goods_count'] = $goods_mod->get_count_of_store($this->_store_id);

            $store['store_gcates']= $this->_get_store_gcategory();

            $store['sgrade'] = $this->_get_store_grade('grade_name');

            $functions = $this->_get_store_grade('functions');

            $store['functions'] = array();

            if ($functions)

            {

                $functions = explode(',', $functions);

                foreach ($functions as $k => $v)

                {

                    $store['functions'][$v] = $v;

                }

            }

			

			$store['hot_saleslist'] = $this->_get_hot_saleslist();

			$store['collect_goodslist'] = $this->_get_collect_goods();

			$store['left_rec_goods'] = $this->_get_left_rec_goods($this->_store_id);

			

			if(!empty($store['hot_search'])) {

				$store['hot_search'] = explode(' ', $store['hot_search']);

			}

			

			$online_service = array();

			if(isset($store['im_qq']) && !empty($store['im_qq'])){

				$online_service['qq'][] = $store['im_qq'];

			}

			if(isset($store['im_ww']) && !empty($store['im_ww'])){

				$online_service['ww'][] = $store['im_ww'];

			}

			if(!empty($store['online_service']))

			{

				$qqww = explode('|', $store['online_service']);

				foreach($qqww as $key=>$val){

					if(!empty($val)){

						foreach(explode(';', $val) as $v){

							if(!empty($v)){

								$online_service[$key==0?'qq':'ww'][] = $v;

							}

						}

					}

				}

				unset($store['online_service']);

			}

			$store['online_service'] = $online_service;

			

			

			if(!empty($store['pic_slides'])){

				$pic_slides = array();

				$store['pic_slides'] = json_decode($store['pic_slides'],true);

			}

			

			

            $cache_server->set($key, $store, 1800);

        }

       $this->assign('kmenus', $store['kmenus']);

       $this->assign('kmenusinfo', $store['kmenusinfo']);

        return $store;

    }

    

    function _get_store_kmenus($store_id)

    {

        $kmenus_mod = & m('kmenus');

        $kmenus = $kmenus_mod->get($store_id);

        return $kmenus;

    }

    

    function _get_store_kmenusinfo($store_id) {

        $kmenusinfo_mod = & m('kmenusinfo');

        $kmenusinfo = $kmenusinfo_mod->find(

                array(

                    'conditions' => 'kmenus_id=' . $store_id

                )

        );

        return $kmenusinfo;

    }

    

	function _get_hot_saleslist()

	{

	   if (!$this->_store_id)

	   {

	      return array();

	   }

	   $goods_mod =& m('goods');

       $data = $goods_mod->find(array(

           'conditions' => "if_show = 1 AND store_id = '{$this->_store_id}' AND closed = 0 ",

           'order' => 'sales DESC',

           'fields' => 'g.goods_id, g.goods_name,goods.default_image,g.price,goods_statistics.sales',

           'join' => 'has_goodsstatistics',

           'limit' => 10,

       ));

	   return $data;

	}

	function _get_collect_goods()

	{

        $goods_mod =& m('goods');

        $data = $goods_mod->find(array(

            'conditions' => "if_show = 1 AND store_id = '{$this->_store_id}' AND closed = 0 ",

            'order' => 'collects DESC',

			'fields' => 'g.goods_id, g.goods_name,g.default_image,g.price,goods_statistics.collects',

			'join'  => 'has_goodsstatistics',

            'limit' => 10,

        ));

		return $data;

	}

	function _get_left_rec_goods($id, $num = 5)

	{

		$goods_mod =& bm('goods', array('_store_id' => $id));

        $goods_list = $goods_mod->find(array(

            'conditions' => "closed = 0 AND if_show = 1",

			'join'		 => 'has_goodsstatistics',

            'fields'     => 'goods_name, default_image, price,sales',

            'order'      => 'collects desc, views desc,comments desc,sales desc,add_time desc',

            'limit'      => $num,

        ));

        foreach ($goods_list as $key => $goods)

        {

            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');

        }

        return $goods_list;

	}



    /* 取得店铺信息 */

    function _get_store_info()

    {

        if (!$this->_store_id)

        {

            /* 未设置前返回空 */

            return array();

        }

        static $store_info = null;

        if ($store_info === null)

        {

            $store_mod  =& m('store');

            $store_info = $store_mod->get_info($this->_store_id);

        }



        return $store_info;

    }



    /* 取得店主信息 */

    function _get_store_owner()

    {

        $user_mod =& m('member');

        $user = $user_mod->get($this->_store_id);



        return $user;

    }



    /* 取得店铺导航 */

    function _get_store_nav()

    {

        $article_mod =& m('article');

        return $article_mod->find(array(

            'conditions' => "store_id = '{$this->_store_id}' AND cate_id = '" . STORE_NAV . "' AND if_show = 1",

            'order' => 'sort_order',

            'fields' => 'title',

        ));

    }

    /*  取的店铺等级   */



    function _get_store_grade($field)

    {

        $store_info = $store_info = $this->_get_store_info();

        $sgrade_mod =& m('sgrade');

        $result = $sgrade_mod->get_info($store_info['sgrade']);

        return $result[$field];

    }

    /* 取得店铺分类 */

    function _get_store_gcategory()

    {

        $gcategory_mod =& bm('gcategory', array('_store_id' => $this->_store_id));

        $gcategories = $gcategory_mod->get_list(-1, true);

        import('tree.lib');

        $tree = new Tree();

        $tree->setTree($gcategories, 'cate_id', 'parent_id', 'cate_name');

        return $tree->getArrayList(0);

    }



    /**

     *    获取当前店铺所设定的模板名称

     *

     *    @author    Garbin

     *    @return    string

     */

    function _get_template_name()

    {

        $store_info = $this->_get_store_info();

        $theme = !empty($store_info['theme']) ? $store_info['theme'] : 'default|default';

        list($template_name, $style_name) = explode('|', $theme);



        return $template_name;

    }



    /**

     *    获取当前店铺所设定的风格名称

     *

     *    @author    Garbin

     *    @return    string

     */

    function _get_style_name()

    {

        $store_info = $this->_get_store_info();

        $theme = !empty($store_info['theme']) ? $store_info['theme'] : 'default|default';

        list($template_name, $style_name) = explode('|', $theme);



        return $style_name;
    }
	
	function display_widgets($options)
    {
        $area = isset($options['area']) ? $options['area'] : '';
        $page = isset($options['page']) ? $options['page'] : '';
        if (!$area || !$page)
        {
            return;
        }
        include_once(ROOT_PATH . '/includes/widget.base.php');

        /* 获取该页面的挂件配置信息 */
		$page = "store_{$this->_store_id}_".$page;
        $widgets = get_widget_config($this->_get_template_name(), $page, 'store',$this->_get_style_name());

        /* 如果没有该区域 */
        if (!isset($widgets['config'][$area]))
        {
            return;
        }

        /* 将该区域内的挂件依次显示出来 */
        foreach ($widgets['config'][$area] as $widget_id)
        {
            $widget_info = $widgets['widgets'][$widget_id];
            $wn     =   $widget_info['name'];
            $options=   $widget_info['options'];

            $widget =& widget($widget_id, $wn, $options, 'store');
            $widget->display();
        }
    }
}

/* 实现消息基础类接口 */

class MessageBase extends MallbaseApp {};



/* 实现模块基础类接口 */

class BaseModule  extends FrontendApp {};



/* 消息处理器 */

require(ROOT_PATH . '/eccore/controller/message.base.php');

?>