<?php
/**
 * 
 * 第三方登录
 * @author xiaozhuge
 *
 */
class third_loginApp extends StorebaseApp {
	
	function third_loginApp() {
		parent::__construct();
	}
	/**
	 * (non-PHPdoc)
	 * @see eccore/controller/BaseApp::index()
	 */
	function index()
	{
		
	}
	/**
	 * QQ登录
	 */
	function qq()
	{
		$qq_app_key='101098508';
		$qq_app_secret='edf0792789c5a6e78e39e21114c94701';

		$redirect_to_login='/includes/third/qq_api/oauth/redirect_to_login.php?qq_app_key='.$qq_app_key
		.'&qq_app_secret='.$qq_app_secret;
		//exit($redirect_to_login);
		header("location:$redirect_to_login");
		exit();
	}
	/**
	 * 
	 * QQ登录回调
	 */
	function qq_callback()
	{
		$third_name='qq';
		$email = isset($_GET["qq_email"])?$_GET["qq_email"]:'';
		$token=isset($_GET["qq_token"])?$_GET["qq_token"]:'';
		$token_secret=isset($_GET["qq_token_secret"])?$_GET["qq_token_secret"]:''; 
		$openid=isset($_GET["qq_openid"])?$_GET["qq_openid"]:'';
		$user_name=isset($_GET["qq_nickname"])?$_GET["qq_nickname"]:'';

		$demon = get_subdomain();
		//$store_id = get_subdomain_store_id($demon);
		$demon_arr = explode('.',$demon);
		
		if(!$email)
		{
			if($demon_arr[0]=='www'){
				$email = $this->cn2pinyin($user_name,'gbk').'@'.$demon_arr[1].'.com';
			}else{
				$email = $this->cn2pinyin($user_name,'gbk').'@'.$demon_arr[0].'.com';
			}
		}
		$user_name2 = $user_name;

		//是否已存在该用户
		$third_mod=&m("third_login");
		$where=" user_name='$user_name2' and third_name='$third_name'";
		$user = $third_mod->find (
			 array (
			 'conditions' => $where, 
			 'limit' => 1) 
		 );
		 //存在时
		if($user)
		{
			$user=current($user);

			$data=array(
			'token'=>$token,
			'token_secret'=>$token_secret,
			'openid'=>$openid,
			'update_time'=>gmtime(),
			);
			$third_mod->edit("id=".$user["id"],$data);
			
			 //登录
	        $this->_do_login($user["member_id"]);
	        
	        //跳转
	        $retrun_url = !empty($_POST['ret_url']) ? $_POST['ret_url'] : '/index.php';
	        $this->show_message('login_successed',
	            'back_before_register', rawurldecode($retrun_url),
	            'enter_member_center', '/index.php?app=member',
	            'apply_store', 'index.php?app=apply'
	        );
		}
		else 
		{
			//注册用户
			$ms =& ms(); //连接用户中心
	        $member_id = $ms->user->register($user_name2, $user_name2, $email);
	        
	        if (!$member_id)
	        {
	        	$error = current($ms->user->get_error());
	            $this->show_warning(Lang::get($error['msg']));
	            return;
	        }
			//添加到third_login表
			$data=array(
			'third_name'=>$third_name,
			'token'=>$token,
			'token_secret'=>$token_secret,
			'openid'=>$openid,
			'user_id'=>'',
			'user_name'=>$user_name2,
			'member_id'=>$member_id,
			'add_time'=>gmtime(),
			'update_time'=>gmtime(),
			);
			
			$third_mod->add($data);
			
			 //登录
	        $this->_do_login($member_id);
	        
	        
	        //跳转
	        $retrun_url = !empty($_POST['ret_url']) ? $_POST['ret_url'] : '/index.php';
	        $this->show_message('login_successed',
	            'back_before_register', rawurldecode($retrun_url),
	            'enter_member_center', '/index.php?app=member',
	            'apply_store', 'index.php?app=apply'
	        );
	        
		}
	}
	/**
	 * 
	 * 新浪微博登录
	 */
	function sina()
	{
		//dump($this->site_config);
		$sina_app_key='3225529982';
		$sina_app_secret='c5a0f3b60777d181ef0584920e53f117';
		//dump($sina_app_secret);
		$redirect_to_login='/includes/third/sina_api/index.php?sina_app_key='.$sina_app_key
		.'&sina_app_secret='.$sina_app_secret;
		//exit($redirect_to_login);
		header("location:$redirect_to_login");
		exit();
	}
	/**
	 * 
	 * 新浪微博登录回调
	 */
	function sina_callback()
	{
		//dump($_GET);
		$third_name='sina';
		$email = isset($_GET["sina_email"])?$_GET["sina_email"]:'';
		$token=isset($_GET["sina_token"])?$_GET["sina_token"]:'';
		$token_secret=isset($_GET["sina_token_secret"])?$_GET["sina_token_secret"]:''; 
		$user_id=isset($_GET["sina_user_id"])?$_GET["sina_user_id"]:'';
		$user_name=isset($_GET["sina_nickname"])?$_GET["sina_nickname"]:'';
		
		$demon = get_subdomain();
		//$store_id = get_subdomain_store_id($demon);
		$demon_arr = explode('.',$demon);
		if(!$email)
		{
			if($demon_arr[0]=='www'){
				$email = $this->cn2pinyin($user_name,'gbk').'@'.$demon_arr[1].'.com';
			}else{
				$email = $this->cn2pinyin($user_name,'gbk').'@'.$demon_arr[0].'.com';
			}
		}
		$user_name2 = $user_name;
		
		//是否已存在该用户
		$third_mod=&m("third_login");
		$where=" user_name='$user_name2' and third_name='$third_name'";
		$user = $third_mod->find (
		 array (
		 'conditions' => $where, 
		 'limit' => 1) );
		 //存在时
		if($user)
		{
			$user=current($user);

			$data=array(
			'token'=>$token,
			'token_secret'=>$token_secret,
			'user_id'=>$user_id,
			'update_time'=>gmtime(),
			);
			$third_mod->edit("id=".$user["id"],$data);
			
			 //登录
	        $this->_do_login($user["member_id"]);
	        
	        //跳转
	        $retrun_url = !empty($_POST['ret_url']) ? $_POST['ret_url'] : '/index.php';
	        $this->show_message('login_successed',
	            'back_before_register', rawurldecode($retrun_url),
	            'enter_member_center', '/index.php?app=member',
	            'apply_store', 'index.php?app=apply'
	        );
		}
		else 
		{
			//注册用户
			$ms =& ms(); //连接用户中心
	        $member_id = $ms->user->register($user_name2, $user_name2, $email);
	        
	        if (!$member_id)
	        {
	        	$error = current($ms->user->get_error());
	            $this->show_warning(Lang::get($error['msg']));
	            return;
	        }
			//添加到third_login表
			$data=array(
			'third_name'=>$third_name,
			'token'=>$token,
			'token_secret'=>$token_secret,
			'openid'=>'',
			'user_id'=>$user_id,
			'user_name'=>$user_name2,
			'member_id'=>$member_id,
			'add_time'=>gmtime(),
			'update_time'=>gmtime(),
			);
			
			$third_mod->add($data);
			
			 //登录
	        $this->_do_login($member_id);
	        
	        //跳转
	        $retrun_url = !empty($_POST['ret_url']) ? $_POST['ret_url'] : '/index.php';
	        $this->show_message('login_successed',
	            'back_before_register', rawurldecode($retrun_url),
	            'enter_member_center', '/index.php?app=member',
	            'apply_store', 'index.php?app=apply'
	        );
	        
		}
	}
	
/**
	 * 
	 * 支付宝登录
	 */
	function alipay()
	{
		$redirect_to_login='/includes/third/alipay_api/alipay_auth_authorize.php';
		//exit($redirect_to_login);
		header("location:$redirect_to_login");
		exit();
	}
	/**
	 * 
	 * 支付宝登录回调
	 */
	function alipay_callback()
	{
		//dump($_GET);
		$third_name='alipay';
		$email = isset($_GET["alipay_email"])?$_GET["alipay_email"]:'';
		$token=isset($_GET["alipay_token"])?$_GET["alipay_token"]:'';
		$token_secret=isset($_GET["alipay_token_secret"])?$_GET["alipay_token_secret"]:''; 
		$user_id=isset($_GET["alipay_user_id"])?$_GET["alipay_user_id"]:'';
		$user_name=isset($_GET["alipay_real_name"])?$_GET["alipay_real_name"]:'';
		
		
		$demon = get_subdomain();
		//$store_id = get_subdomain_store_id($demon);
		$demon_arr = explode('.',$demon);
		if(!$email)
		{
			if($demon_arr[0]=='www'){
				$email = $this->cn2pinyin($user_name,'gbk').'@'.$demon_arr[1].'.com';
			}else{
				$email = $this->cn2pinyin($user_name,'gbk').'@'.$demon_arr[0].'.com';
			}
		}
		$user_name2 = $user_name;
		
		//是否已存在该用户
		$third_mod=&m("third_login");
		$where=" user_name='$user_name2' and third_name='$third_name'";
		$user = $third_mod->find (
		 array (
		 'conditions' => $where, 
		 'limit' => 1) );
		 //存在时
		if($user)
		{
			$user=current($user);

			$data=array(
			'token'=>$token,
			'token_secret'=>$token_secret,
			'user_id'=>$user_id,
			'update_time'=>gmtime(),
			);
			$third_mod->edit("id=".$user["id"],$data);
			
			 //登录
	        $this->_do_login($user["member_id"]);
	        
	        //跳转
	        $retrun_url = !empty($_POST['ret_url']) ? $_POST['ret_url'] : '/index.php';
	        $this->show_message('login_successed',
	            'back_before_register', rawurldecode($retrun_url),
	            'enter_member_center', '/index.php?app=member',
	            'apply_store', 'index.php?app=apply'
	        );
		}
		else 
		{
			//注册用户
			$ms =& ms(); //连接用户中心
	        $member_id = $ms->user->register($user_name2, $user_name2, $email);
	        
	        if (!$member_id)
	        {
	        	$error = current($ms->user->get_error());
	            $this->show_warning(Lang::get($error['msg']));
	            return;
	        }
			//添加到third_login表
			$data=array(
			'third_name'=>$third_name,
			'token'=>$token,
			'token_secret'=>$token_secret,
			'openid'=>'',
			'user_id'=>$user_id,
			'user_name'=>$user_name2,
			'member_id'=>$member_id,
			'add_time'=>gmtime(),
			'update_time'=>gmtime(),
			);
			
			$third_mod->add($data);
			
			 //登录
	        $this->_do_login($member_id);
	        
	        
	        //跳转
	        $retrun_url = !empty($_POST['ret_url']) ? $_POST['ret_url'] : '/index.php';
	        $this->show_message('login_successed',
	            'back_before_register', rawurldecode($retrun_url),
	            'enter_member_center', '/index.php?app=member',
	            'apply_store', 'index.php?app=apply'
	        );
	        
		}
	}
	
	/**
	 * 
	 * 中文转换成汉语拼音
	 * @author guolei 
	*/ 
	function cn2pinyin($_string, $_code='gb2312') {
	    
	    if ($_code != 'gb2312')
	        $_string = $this->_u2_utf8_gb($_string);
	    $_res = '';
	    for ($i = 0; $i < strlen($_string); $i++) {
	        $_p = ord(substr($_string, $i, 1));
	        if ($_p > 160) {
	            $_q = ord(substr($_string, ++$i, 1));
	            $_p = $_p * 256 + $_q - 65536;
		        $_res .= $this->_pinyin($_p);
	        }else{
	        	$_res .= substr($_string, $i, 1);
	        }
	    }
	    $_res = strtolower($_res);
	    return preg_replace("/[^a-z0-9]*/", '', $_res);
	}
	
	function _pinyin($_num) {
		$_tdatakey = array('a','ai','an','ang','ao','ba','bai','ban','bang','bao','bei','ben','beng','bi','bian','biao','bie','bin','bing','bo','bu','ca','cai','can','cang','cao','ce','ceng','cha',
            'chai','chan','chang','chao','che','chen','cheng','chi','chong','chou','chu','chuai','chuan','chuang','chui','chun','chuo','ci','cong','cou','cu',
            'cuan','cui','cun','cuo','da','dai','dan','dang','dao','de','deng','di','dian','diao','die','ding','diu','dong','dou','du','duan','dui','dun','duo','e','en','er',
            'fa','fan','fang','fei','fen','feng','fo','fou','fu','ga','gai','gan','gang','gao','ge','gei','gen','geng','gong','gou','gu','gua','guai','guan','guang','gui',
            'gun','guo','ha','hai','han','hang','hao','he','hei','hen','heng','hong','hou','hu','hua','huai','huan','huang','hui','hun','huo','ji','jia','jian','jiang',
            'jiao','jie','jin','jing','jiong','jiu','ju','juan','jue','jun','ka','kai','kan','kang','kao','ke','ken','keng','kong','kou','ku','kua','kuai','kuan','kuang',
            'kui','kun','kuo','la','lai','lan','lang','lao','le','lei','leng','li','lia','lian','liang','liao','lie','lin','ling','liu','long','lou','lu','lv','luan','lue',
            'lun','luo','ma','mai','man','mang','mao','me','mei','men','meng','mi','mian','miao','mie','min','ming','miu','mo','mou','mu','na','nai','nan','nang','nao','ne',
            'nei','nen','neng','ni','nian','niang','niao','nie','nin','ning','niu','nong','nu','nv','nuan','nue','nuo','o','ou','pa','pai','pan','pang','pao','pei','pen',
            'peng','pi','pian','piao','pie','pin','ping','po','pu','qi','qia','qian','qiang','qiao','qie','qin','qing','qiong','qiu','qu','quan','que','qun','ran','rang',
            'rao','re','ren','reng','ri','rong','rou','ru','ruan','rui','run','ruo','sa','sai','san','sang','sao','se','sen','seng','sha','shai','shan','shang','shao',
            'she','shen','sheng','shi','shou','shu','shua','shuai','shuan','shuang','shui','shun','shuo','si','song','sou','su','suan','sui','sun','suo','ta','tai',
            'tan','tang','tao','te','teng','ti','tian','tiao','tie','ting','tong','tou','tu','tuan','tui','tun','tuo','wa','wai','wan','wang','wei','wen','weng','wo','wu',
            'xi','xia','xian','xiang','xiao','xie','xin','xing','xiong','xiu','xu','xuan','xue','xun','ya','yan','yang','yao','ye','yi','yin','ying','yo','yong','you',
            'yu','yuan','yue','yun','za','zai','zan','zang','zao','ze','zei','zen','zeng','zha','zhai','zhan','zhang','zhao','zhe','zhen','zheng','zhi','zhong',
            'zhou','zhu','zhua','zhuai','zhuan','zhuang','zhui','zhun','zhuo','zi','zong','zou','zu','zuan','zui','zun','zuo');
	    
	    $_tdatavalue = array('-20319','-20317','-20304','-20295','-20292','-20283','-20265','-20257','-20242','-20230','-20051','-20036','-20032','-20026','-20002','-19990',
            '-19986','-19982','-19976','-19805','-19784','-19775','-19774','-19763','-19756','-19751','-19746','-19741','-19739','-19728','-19725',
            '-19715','-19540','-19531','-19525','-19515','-19500','-19484','-19479','-19467','-19289','-19288','-19281','-19275','-19270','-19263',
            '-19261','-19249','-19243','-19242','-19238','-19235','-19227','-19224','-19218','-19212','-19038','-19023','-19018','-19006','-19003',
            '-18996','-18977','-18961','-18952','-18783','-18774','-18773','-18763','-18756','-18741','-18735','-18731','-18722','-18710','-18697',
            '-18696','-18526','-18518','-18501','-18490','-18478','-18463','-18448','-18447','-18446','-18239','-18237','-18231','-18220','-18211',
            '-18201','-18184','-18183','-18181','-18012','-17997','-17988','-17970','-17964','-17961','-17950','-17947','-17931','-17928','-17922',
            '-17759','-17752','-17733','-17730','-17721','-17703','-17701','-17697','-17692','-17683','-17676','-17496','-17487','-17482','-17468',
            '-17454','-17433','-17427','-17417','-17202','-17185','-16983','-16970','-16942','-16915','-16733','-16708','-16706','-16689','-16664',
            '-16657','-16647','-16474','-16470','-16465','-16459','-16452','-16448','-16433','-16429','-16427','-16423','-16419','-16412','-16407',
            '-16403','-16401','-16393','-16220','-16216','-16212','-16205','-16202','-16187','-16180','-16171','-16169','-16158','-16155','-15959',
            '-15958','-15944','-15933','-15920','-15915','-15903','-15889','-15878','-15707','-15701','-15681','-15667','-15661','-15659','-15652',
            '-15640','-15631','-15625','-15454','-15448','-15436','-15435','-15419','-15416','-15408','-15394','-15385','-15377','-15375','-15369',
            '-15363','-15362','-15183','-15180','-15165','-15158','-15153','-15150','-15149','-15144','-15143','-15141','-15140','-15139','-15128',
            '-15121','-15119','-15117','-15110','-15109','-14941','-14937','-14933','-14930','-14929','-14928','-14926','-14922','-14921','-14914',
            '-14908','-14902','-14894','-14889','-14882','-14873','-14871','-14857','-14678','-14674','-14670','-14668','-14663','-14654','-14645',
            '-14630','-14594','-14429','-14407','-14399','-14384','-14379','-14368','-14355','-14353','-14345','-14170','-14159','-14151','-14149',
            '-14145','-14140','-14137','-14135','-14125','-14123','-14122','-14112','-14109','-14099','-14097','-14094','-14092','-14090','-14087',
            '-14083','-13917','-13914','-13910','-13907','-13906','-13905','-13896','-13894','-13878','-13870','-13859','-13847','-13831','-13658',
            '-13611','-13601','-13406','-13404','-13400','-13398','-13395','-13391','-13387','-13383','-13367','-13359','-13356','-13343','-13340',
            '-13329','-13326','-13318','-13147','-13138','-13120','-13107','-13096','-13095','-13091','-13076','-13068','-13063','-13060','-12888',
            '-12875','-12871','-12860','-12858','-12852','-12849','-12838','-12831','-12829','-12812','-12802','-12607','-12597','-12594','-12585',
            '-12556','-12359','-12346','-12320','-12300','-12120','-12099','-12089','-12074','-12067','-12058','-12039','-11867','-11861','-11847',
            '-11831','-11798','-11781','-11604','-11589','-11536','-11358','-11340','-11339','-11324','-11303','-11097','-11077','-11067','-11055',
            '-11052','-11045','-11041','-11038','-11024','-11020','-11019','-11018','-11014','-10838','-10832','-10815','-10800','-10790','-10780',
            '-10764','-10587','-10544','-10533','-10519','-10331','-10329','-10328','-10322','-10315','-10309','-10307','-10296','-10281','-10274',
            '-10270','-10262','-10260','-10256','-10254');
	    $_data = (php_version >= '5.0') ? array_combine($_tdatakey, $_tdatavalue) : $this->_array_combine($_tdatakey, $_tdatavalue);
	    arsort($_data);
	    reset($_data);
	    if ($_num > 0 && $_num < 160)
	        return chr($_num);
	    elseif ($_num < -20319 || $_num > -10247)
	        return '';
	    else {
	        foreach ($_data as $k => $v) {
	            if ($v <= $_num)
	                break;
	        }
	        return $k;
	    }
	}
	
	function _u2_utf8_gb($_c) {
	    $_string = '';
	    if ($_c < 0x80)
	        $_string .= $_c;
	    elseif ($_c < 0x800) {
	        $_string .= chr(0xc0 | $_c >> 6);
	        $_string .= chr(0x80 | $_c & 0x3f);
	    } elseif ($_c < 0x10000) {
	        $_string .= chr(0xe0 | $_c >> 12);
	        $_string .= chr(0x80 | $_c >> 6 & 0x3f);
	        $_string .= chr(0x80 | $_c & 0x3f);
	    } elseif ($_c < 0x200000) {
	        $_string .= chr(0xf0 | $_c >> 18);
	        $_string .= chr(0x80 | $_c >> 12 & 0x3f);
	        $_string .= chr(0x80 | $_c >> 6 & 0x3f);
	        $_string .= chr(0x80 | $_c & 0x3f);
	    }
	    return iconv('utf-8', 'gb2312', $_string);
	}
	
	function _array_combine($_arr1, $_arr2) {
	    for ($i = 0; $i < count($_arr1); $i++)
	        $_res[$_arr1[$i]] = $_arr2[$i];
	    return $_res;
	}	
}