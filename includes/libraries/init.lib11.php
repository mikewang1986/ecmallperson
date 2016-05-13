<?php

if (!Conf::get('moolau') || Conf::get('moolau') == '') {
    $mod = &m('privilege');
    $result = $mod->db->getAll('SHOW COLUMNS FROM ' . DB_PREFIX . 'store');
    $fields = array();
    foreach ($result as $v) {
        $fields[] = $v['Field'];
    }
    if (!in_array('pic_slides', $fields)) {
        $sql = 'ALTER TABLE `' . DB_PREFIX . 'store` ADD `pic_slides` TEXT NOT NULL AFTER `im_msn`';
        $mod->db->query($sql);
    }
    if (!in_array('hotline', $fields)) {
        $sql = 'ALTER TABLE `' . DB_PREFIX . 'store` ADD `hotline` VARCHAR( 255 ) NOT NULL AFTER `im_msn`';
        $mod->db->query($sql);
    }
    if (!in_array('online_service', $fields)) {
        $sql = 'ALTER TABLE `' . DB_PREFIX . 'store` ADD `online_service` VARCHAR( 255 ) NOT NULL AFTER `im_msn`';
        $mod->db->query($sql);
    }
    if (!in_array('hot_search', $fields)) {
        $sql = 'ALTER TABLE `' . DB_PREFIX . 'store` ADD `hot_search` VARCHAR( 255 ) NOT NULL AFTER `im_msn`';
        $mod->db->query($sql);
    }
    if (!in_array('business_scope', $fields)) {
        $sql = 'ALTER TABLE `' . DB_PREFIX . 'store` ADD `business_scope` VARCHAR( 50 ) NOT NULL AFTER `hot_search`';
        $mod->db->query($sql);
    }
    $result = $mod->db->getAll('SHOW COLUMNS FROM ' . DB_PREFIX . 'groupbuy');
    $fields = array();
    foreach ($result as $v) {
        $fields[] = $v['Field'];
    }
    if (!in_array('group_image', $fields)) {
        $sql = 'ALTER TABLE `' . DB_PREFIX . 'groupbuy` ADD `group_image` VARCHAR( 255 ) NOT NULL AFTER `group_name` ';
        $mod->db->query($sql);
    }
    $result = $mod->db->getAll('SHOW COLUMNS FROM ' . DB_PREFIX . 'navigation');
    $fields = array();
    foreach ($result as $v) {
        $fields[] = $v['Field'];
    }
    if (!in_array('hot', $fields)) {
        $sql = "ALTER TABLE `" . DB_PREFIX . "navigation` ADD  `hot` TINYINT( 3 ) NOT NULL DEFAULT  '0' ";
        $mod->db->query($sql);
    }
    $sql = " CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ultimate_store` (
	  `ultimate_id` int(255) NOT NULL AUTO_INCREMENT,
	  `brand_id` int(50) NOT NULL,
	  `keyword` varchar(20) NOT NULL,
	  `cate_id` int(50) NOT NULL,
	  `store_id` int(50) NOT NULL,
	  `status` tinyint(1) NOT NULL DEFAULT '0',
	  `description` varchar(255) DEFAULT NULL,
	  PRIMARY KEY (`ultimate_id`)
	) ENGINE = MYISAM DEFAULT CHARSET=" . str_replace('-', '', CHARSET) . ";";
    $mod->db->query($sql);
    $sql = 'CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'cate_pvs` (
  		`cate_id` int(11) NOT NULL,
  		`pvs` text NOT NULL
	) ENGINE=MyISAM DEFAULT CHARSET=' . str_replace('-', '', CHARSET) . ';';
    $mod->db->query($sql);
    $sql = 'CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'goods_prop` (
  		`pid` int(11) NOT NULL auto_increment,
  		`name` varchar(50) NOT NULL,
  		`status` int(1) NOT NULL,
  		`sort_order` int(11) NOT NULL,
  		PRIMARY KEY  (`pid`)
	) ENGINE=MyISAM  DEFAULT CHARSET=' . str_replace('-', '', CHARSET) . ';';
    $mod->db->query($sql);
    $sql = 'CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'goods_prop_value` (
  		`vid` int(11) NOT NULL auto_increment,
  		`pid` int(11) NOT NULL,
  		`prop_value` varchar(255) NOT NULL,
  		`status` int(1) NOT NULL,
  		`sort_order` int(11) NOT NULL,
  		PRIMARY KEY  (`vid`)
	) ENGINE=MyISAM  DEFAULT CHARSET=' . str_replace('-', '', CHARSET) . ';';
    $mod->db->query($sql);
    $sql = 'CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'goods_pvs` (
  		`goods_id` int(11) NOT NULL,
  		`pvs` text NOT NULL,
  		PRIMARY KEY  (`goods_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=' . str_replace('-', '', CHARSET) . ';';
    $mod->db->query($sql);
$sql = 'CREATE TABLE IF NOT EXISTS `'.DB_PREFIX .'ju` (
  		`group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  		`template_id` int(10) unsigned DEFAULT NULL,
  		`cate_id` int(10) unsigned DEFAULT NULL,
  		`group_name` varchar(255) NOT NULL,
  		`group_desc` text,
  		`goods_id` int(10) unsigned NOT NULL,
  		`store_id` int(10) unsigned NOT NULL,
  		`spec_price` text NOT NULL,
  		`max_per_user` smallint(5) unsigned,
  		`status` tinyint(3) unsigned NOT NULL,
		`status_desc` varchar(50) NOT NULL,
  		`recommend` tinyint(3) unsigned NOT NULL,
  		`views` int(10) unsigned NOT NULL,
  		`image` varchar(255) DEFAULT NULL,
  		PRIMARY KEY (`group_id`),
  		KEY `goods_id` (`goods_id`),
  		KEY `store_id` (`store_id`)
		) ENGINE=MyISAM DEFAULT CHARSET='.str_replace('-','',CHARSET) .';';
$mod->db->query($sql);
$sql = 'CREATE TABLE IF NOT EXISTS `'.DB_PREFIX .'ju_cate` (
  		`cate_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  		`cate_name` varchar(20) NOT NULL,
  		`parent_id` int(10) unsigned NOT NULL,
  		`sort_order` tinyint(1) unsigned NOT NULL,
  		PRIMARY KEY (`cate_id`)
		) ENGINE=MyISAM DEFAULT CHARSET='.str_replace('-','',CHARSET) .';';
$mod->db->query($sql);
$sql = 'CREATE TABLE IF NOT EXISTS `'.DB_PREFIX .'ju_template` (
  		`template_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  		`template_name` varchar(50) NOT NULL,
  		`start_time` int(10) unsigned NOT NULL,
		`join_end_time` int(10) unsigned NOT NULL,
  		`end_time` int(10) unsigned NOT NULL,
  		`state` tinyint(1) unsigned NOT NULL,
  		PRIMARY KEY (`template_id`)
		) ENGINE=MyISAM DEFAULT CHARSET='.str_replace('-','',CHARSET) .';';
$mod->db->query($sql);
}

class Init_FrontendApp {

    function _get_carts_top($sess_id, $user_id = 0) {
        $where_user_id = $user_id ? " AND user_id={$user_id}" : '';
        $carts = array();
        $cart_model = &m('cart');
        $cart_items = $cart_model->find(array(
            'conditions' => 'session_id = ' . "'" . $sess_id . "'" . $where_user_id,
            'fields' => '',
        ));
        $total = 0;
        foreach ($cart_items as $key => $val) {
            $total += $val['price'] * $val['quantity'];
        }
        return array('cart_items' => $cart_items, 'total' => $total);
    }

    function _get_header_gcategories($amount, $position, $brand_is_recommend = 1) {
        $gcategory_mod = &bm('gcategory', array('_store_id' => 0));
        $gcategories = array();
        if (!$amount) {
            $gcategories = $gcategory_mod->get_list(-1, true);
        } else {
            $gcategory = $gcategory_mod->get_list(0, true);
            $gcategories = $gcategory;
            foreach ($gcategory as $val) {
                $result = $gcategory_mod->get_list($val['cate_id'], true);
                $result = array_slice($result, 0, $amount);
                $gcategories = array_merge($gcategories, $result);
            }
        }
        import('tree.lib');
        $tree = new Tree();
        $tree->setTree($gcategories, 'cate_id', 'parent_id', 'cate_name');
        $gcategory_list = $tree->getArrayList(0);
        $i = 0;
        $brand_mod = &m('brand');
        foreach ($gcategory_list as $k => $v) {
            $gcategory_list[$k]['top'] = isset($position[$i]) ? $position[$i] : '0px';
            $i++;
            $gcategory_list[$k]['brands'] = $brand_mod->find(array(
                'conditions' => "tag = '" . $v['value'] . "' AND recommended=" . $brand_is_recommend,
                'order' => 'sort_order asc,brand_id desc'
            ));
        }
        return array('gcategories' => $gcategory_list);
    }

}

class Init_JuApp
{

		public function lefttime( $time )
		{
				$lefttime = $time - gmtime( );
				if ( empty( $time ) || $lefttime <= 0 )
				{
						return array( );
				}
				$d = sprintf( "%02d", intval( $lefttime / 86400 ) );
				$lefttime -= $d * 86400;
				$h = sprintf( "%02d", intval( $lefttime / 3600 ) );
				$lefttime -= $h * 3600;
				$m = sprintf( "%02d", intval( $lefttime / 60 ) );
				$lefttime -= $m * 60;
				$s = sprintf( "%02d", $lefttime );
				return array(
						"d" => $d,
						"h" => $h,
						"m" => $m,
						"s" => $s
				);
		}

		public function format_groupbuy_hot( $groupbuy_hot )
		{
				if ( !is_array( $groupbuy_hot ) && empty( $groupbuy_hot ) )
				{
						return $groupbuy_hot;
				}
				foreach ( $groupbuy_hot as $key => $group )
				{
						$price = @unserialize( $group['spec_price'] );
						if ( $group['default_spec'] )
						{
								$price = $price[$group['default_spec']];
								$groupbuy_hot[$key]['group_price'] = $price['price'];
								if ( 0 < $groupbuy['price'] )
								{
										$groupbuy_hot[$key]['discount'] = round( $price['price'] / $group['price'] * 10, 1 );
								}
								else
								{
										$groupbuy_hot['discount'] = 0;
								}
						}
				}
				return $groupbuy_hot;
		}

}

class Init_Ju_decorationApp
{

		public function lefttime( $time )
		{
				$lefttime = $time - gmtime( );
				if ( empty( $time ) || $lefttime <= 0 )
				{
						return array( );
				}
				$d = sprintf( "%02d", intval( $lefttime / 86400 ) );
				$lefttime -= $d * 86400;
				$h = sprintf( "%02d", intval( $lefttime / 3600 ) );
				$lefttime -= $h * 3600;
				$m = sprintf( "%02d", intval( $lefttime / 60 ) );
				$lefttime -= $m * 60;
				$s = sprintf( "%02d", $lefttime );
				return array(
						"d" => $d,
						"h" => $h,
						"m" => $m,
						"s" => $s
				);
		}

}

class Init_Ju_lifeApp
{

		public function format_ju_list( $ju_list, $ju_mod )
		{
				if ( !is_array( $ju_list ) && empty( $ju_list ) )
				{
						return $ju_list;
				}
				foreach ( $ju_list as $key => $ju )
				{
						$ju_list[$key]['group_price'] = unserialize( $ju['spec_price'] );
						$ju_list[$key]['group_price'] = $ju_list[$key]['group_price'][$ju['default_spec']]['price'];
						$ju_list[$key]['price_save'] = round( $ju['price'] - $ju_list[$key]['group_price'], 2 );
						$ju_list[$key]['all_count'] = $ju_mod->_get_group_join( $ju['group_id'] );
						if ( 0 < $ju['price'] )
						{
								$ju_list[$key]['discount'] = round( $ju_list[$key]['group_price'] / $ju['price'] * 10, 1 );
						}
						else
						{
								$ju_list[$key]['discount'] = 0;
						}
						if ( empty( $ju['default_image'] ) )
						{
								$ju_list[$key]['default_image'] = Conf::get( "default_goods_image" );
						}
				}
				return $ju_list;
		}

}

class Init_Ju_brandApp
{

		public function format_ju_list( $ju_list, $ju_mod )
		{
				if ( !is_array( $ju_list ) && empty( $ju_list ) )
				{
						return $ju_list;
				}
				foreach ( $ju_list as $key => $ju )
				{
						$ju_list[$key]['group_price'] = unserialize( $ju['spec_price'] );
						$ju_list[$key]['group_price'] = $ju_list[$key]['group_price'][$ju['default_spec']]['price'];
						$ju_list[$key]['price_save'] = round( $ju['price'] - $ju_list[$key]['group_price'], 2 );
						$ju_list[$key]['all_count'] = $ju_mod->_get_group_join( $ju['group_id'] );
						if ( 0 < $ju['price'] )
						{
								$ju_list[$key]['discount'] = round( $ju_list[$key]['group_price'] / $ju['price'] * 10, 1 );
						}
						else
						{
								$ju_list[$key]['discount'] = 0;
						}
						if ( empty( $ju['default_image'] ) )
						{
								$ju_list[$key]['default_image'] = Conf::get( "default_goods_image" );
						}
				}
				return $ju_list;
		}

}
class Init_Seller_juApp
{

		public function format_groupbuy_list( $groupbuy_list, $ju_mod, $jutemplate_mod )
		{
				if ( empty( $groupbuy_list ) || !is_array( $groupbuy_list ) )
				{
						return $groupbuy_list;
				}
				foreach ( $groupbuy_list as $key => $group )
				{
						$ju_template = $jutemplate_mod->get( intval( $group['template_id'] ) );
						if ( $ju_template )
						{
								$groupbuy_list[$key] += $ju_template;
						}
						$groupbuy_list[$key]['quantity'] = $ju_mod->_get_group_join( intval( $group['group_id'] ) );
						if ( empty( $group['default_image'] ) )
						{
								$groupbuy_list[$key]['default_image'] = Conf::get( "default_goods_image" );
						}
				}
				return $groupbuy_list;
		}

}


class Init_SearchApp {

    function _get_group_by_info_by_brands($by_brands, $param) {
        if (!empty($param["brand"])) {
            unset($by_brands[$param['brand']]);
        }
        return $by_brands;
    }

    function _get_group_by_info_by_region($sql, $param) {
        $goods_mod = &m('goods');
        $by_regions = $goods_mod->getAll($sql);
        if (!empty($param["region_id"])) {
            foreach ($by_regions as $k => $v) {
                if ($v["region_id"] == $param["region_id"]) {
                    unset($by_regions[$k]);
                }
            }
        }
        return $by_regions;
    }

    function _get_ultimate_store($conditions, $brand) {
        $store = array();
        $us_mod = &m('ultimate_store');
        $store_mod = &m('store');
        $ultimate_store = $us_mod->get(array('conditions' => 'status=1 ' . $conditions, 'fields' => 'store_id,description'));
        if ($ultimate_store) {
            $store = $store_mod->get(array('conditions' => 'store_id=' . $ultimate_store['store_id'], 'fields' => 'store_logo,store_name'));
            empty($store['store_logo']) && $store['store_logo'] = Conf::get('default_store_logo');
            if ($brand && !empty($brand['brand_logo'])) {
                $store['store_logo'] = $brand['brand_logo'];
            }
            $store = array(array_merge($ultimate_store, $store));
        }
        return $store;
    }

}

class Init_OrderApp {

    function get_available_coupon($store_id) {
        $time = gmtime();
        $model_cart = &m('cart');
        $item_info = $model_cart->find("store_id={$store_id} AND session_id='" . SESS_ID . "'");
        $price = 0;
        foreach ($item_info as $val) {
            $price = $price + $val['price'] * $val['quantity'];
        }
        $coupon = $model_cart->getAll("SELECT *FROM " . DB_PREFIX . "coupon_sn couponsn " .
                "LEFT JOIN " . DB_PREFIX . "coupon coupon ON couponsn.coupon_id=coupon.coupon_id " .
                "LEFT JOIN " . DB_PREFIX . "user_coupon user_coupon ON user_coupon.coupon_sn=couponsn.coupon_sn " .
                "WHERE coupon.store_id = " . $store_id . " AND couponsn.remain_times >=1 " .
                "AND user_coupon.user_id=" . $this->visitor->get('user_id') . " " .
                "AND coupon.start_time <= " . $time . " AND coupon.end_time >= " . $time . " AND coupon.min_amount <= " . $price
        );
        return $coupon;
    }

}

class Init_Taocz_articleWidget {

    var $options = null;

    function _get_data($i) {
        $acategory_mod = &m('acategory');
        $cate_ids = $acategory_mod->get_descendant($this->options['cate_id_' . $i]);
        if ($cate_ids) {
            $conditions = ' AND cate_id ' . db_create_in($cate_ids);
        } else {
            $conditions = '';
        }
        return $conditions;
    }

}

class Init_Taocz_floorWidget {

    function _get_data($options = array()) {
        $recom_mod = &m('recommend');
        $goods_list = $recom_mod->get_recommended_goods($options['img_recom_id'], 10, true, $options['img_cate_id']);
        return $goods_list;
    }

}

class Init_Taocz_four_tabWidget {

    function _get_data($options = array(), $amount) {
        $recom_mod = &m('recommend');
        $data = array();
        for ($i = 1; $i <= $amount; $i++) {
            $data['goods_list'][] = $recom_mod->get_recommended_goods($options['img_recom_id_' . $i], 3, true, $options['img_cate_id_' . $i]);
            $data['tabs'][] = $options['tab_' . $i];
        }
        return $data;
    }

}


class Init_Xiaomi_articleWidget {

    var $options = null;

    function _get_data($i) {
        $acategory_mod = &m('acategory');
        $cate_ids = $acategory_mod->get_descendant($this->options['cate_id_' . $i]);
        if ($cate_ids) {
            $conditions = ' AND cate_id ' . db_create_in($cate_ids);
        } else {
            $conditions = '';
        }
        return $conditions;
    }

}

class Init_Xiaomi_floorWidget {

    function _get_data($options = array()) {
        $recom_mod = &m('recommend');
        $goods_list = $recom_mod->get_recommended_goods($options['img_recom_id'], 10, true, $options['img_cate_id']);
        return $goods_list;
    }

}

class Init_Xiaomi_four_tabWidget {

    function _get_data($options = array(), $amount) {
        $recom_mod = &m('recommend');
        $data = array();
        for ($i = 1; $i <= $amount; $i++) {
            $data['goods_list'][] = $recom_mod->get_recommended_goods($options['img_recom_id_' . $i], 3, true, $options['img_cate_id_' . $i]);
            $data['tabs'][] = $options['tab_' . $i];
        }
        return $data;
    }

}


class Limit_domain {

    var $notice = 'If you see this page, please enter the admin page to click Update cache!';
    var $check_domain = true;
    var $order_id = '1234567890';
    var $remote_domain = array('allow' => '127.0.0.1,ecmjx.jyds95.com', 'notice' => '');

    function __construct() {
        
    }

    function check_domain_allow() {
        $error_code = ' error code:' . $this->order_id;
        $cache_server = &cache_server();
        $remote = $this->remote_domain;
        $domains = $this->get_current_domain();
        $find = false;
        if (is_array($domains)) {
            foreach ($domains as $domain) {
                $current_domain = $domain;
                $current_ip = $_SERVER['REMOTE_ADDR'];
                $allow_domain = explode(',', $remote['allow']);
                if (in_array($current_domain, $allow_domain) || in_array($current_ip, $allow_domain)) {
                    $find = true;
                }
            }
        }
        if ($find === false) {
            if (isset($remote[$notice]) && !empty($remote[$notice])) {
                $this->notice = $remote[$notice];
            }
            exit($this->notice . $error_code);
        }
    }

    function get_current_domain() {
        $address = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
        $parsed_url = parse_url($address);
        if (isset($parsed_url['host'])) {
            $check = $this->esip($parsed_url['host']);
            $host = $parsed_url['host'];
        } else {
            $check = $this->esip($address);
            $host = $address;
        }
        $domain = array();
        if ($check == FALSE) {
            if ($host != "") {
                $domain[] = $this->domain($host);
                $domain[] = $this->domain_second($host);
            } else {
                $domain[] = $this->domain($address);
                $domain[] = $this->domain_second($address);
            }
        } else {
            $domain[] = $host;
        }
        return $domain;
    }

    function get_remote_domain() {
        return $this->remote_domain['allow'];
    }

    function domain_second($address) {
        preg_match('@^(?:http://)?([^/]+)@i', $address, $matches);
        $host = $matches[1];
        preg_match('/[^.]+\.[^.]+$/', $host, $matches);
        return $matches[0];
    }

    function esip($ip_addr) {
        if (preg_match("/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/", $ip_addr)) {
            $parts = explode(".", $ip_addr);
            foreach ($parts as $ip_parts) {
                if (intval($ip_parts) > 255 || intval($ip_parts) < 0)
                    return FALSE;
            }
            return TRUE;
        }
        else
            return FALSE;
    }

    function domain($domainb) {
        $bits = explode('/', $domainb);
        if ($bits[0] == 'http:' || $bits[0] == 'https:') {
            $domainb = $bits[2];
        } else {
            $domainb = $bits[0];
        }
        unset($bits);
        $bits = explode('.', $domainb);
        $idz = count($bits);
        $idz-=3;
        if (strlen($bits[($idz + 2)]) == 2) {
            $url = $bits[$idz] . '.' . $bits[($idz + 1)] . '.' . $bits[($idz + 2)];
        } else if (strlen($bits[($idz + 2)]) == 0) {
            $url = $bits[($idz)] . '.' . $bits[($idz + 1)];
        } else {
            $url = $bits[($idz + 1)] . '.' . $bits[($idz + 2)];
        }
        return $url;
    }

    function get_url_contents($url) {
        if (function_exists('file_get_contents'))
            if (ini_get("allow_url_fopen") == "1")
                return @file_get_contents($url);
        $result = ecm_fopen($url);
        return $result;
    }

    function url_exist($url, $allow_size = -1, $remain = -1) {
        if (!function_exists('get_headers')) {

            function get_headers($url, $format = 0) {
                $url = parse_url($url);
                $end = "\r\n\r\n";
                $fp = fsockopen($url['host'], (empty($url['port']) ? 80 : $url['port']), $errno, $errstr, 30);
                if ($fp) {
                    $out = "GET " . $url['path'] . " HTTP/1.1\r\n";
                    $out .= "Host: " . $url['host'] . "\r\n";
                    $out .= "Connection: Close\r\n\r\n";
                    $var = '';
                    fwrite($fp, $out);
                    while (!feof($fp)) {
                        $var.=fgets($fp, 1280);
                        if (strpos($var, $end))
                            break;
                    }
                    fclose($fp);
                    $var = preg_replace("/\r\n\r\n.*\$/", '', $var);
                    $var = explode("\r\n", $var);
                    if ($format) {
                        foreach ($var as $i) {
                            if (preg_match('/^([a-zA-Z -]+): +(.*)$/', $i, $parts))
                                $v[$parts[1]] = $parts[2];
                        }
                        return $v;
                    }
                    else
                        return $var;
                }
            }

        }
        $head = get_headers($url);
        if (is_array($head) && !empty($head)) {
            foreach ($head as $key => $val) {
                $pos = strpos($val, 'Content-Length');
                if ($key == 0) {
                    $hhttp = explode(' ', $val);
                    $hsize = count($hhttp) - 1;
                    $res = strcmp($hhttp[$hsize], "OK");
                    if ($res != 0) {
                        return 1;
                    }
                } elseif ($pos === false) {
                    continue;
                } elseif ($pos >= 0) {
                    $size = explode(' ', $val);
                    $count = count($size);
                    $count = $count - 1;
                    $res = intval($size[$count]);
                    if ($allow_size >= 0 && $res > $allow_size) {
                        return 2;
                    }
                    if ($remain >= 0 && $res > $remain) {
                        return 3;
                    }
                }
            }
        } else {
            return 1;
        }
        return true;
    }

}

?>   