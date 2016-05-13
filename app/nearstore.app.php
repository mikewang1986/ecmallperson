<?php

class NearstoreApp extends MallbaseApp {

    function index() {
        $this->_get_stores();
        $this->display('nearstore.index.html');
    }

    function baidumap() {
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
        
        
        $this->_get_stores($limit);
        
        $this->assign('baidu_ak', Conf::get('baidu_ak'));
        $this->display('nearstore.baidumap.html');
    }
/*
select *,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*(28.21347823-lat)/360),2)+COS(PI()*28.21347823/180)* COS(lat * PI()/180)*POW(SIN(PI()*(112.97935279-lng)/360),2)))) as juli 
from `ecm_store` 
order by juli asc 
limit 0,10
 */
    function _get_stores($limit=10) {
        $user_id = $this->visitor->get('user_id');
        if (empty($user_id)) {
            $member_info = $this->get_ip_location();
        } else {
            $member_mod = & m('member');
            $member_info = $member_mod->get($user_id);

            if ($member_info['lng'] == '0' || $member_info['lat'] == '0') {
                //如果客户没有设置地理位置则  根据IP 获取经纬度
                $data = $this->get_ip_location();
                $member_info = array_merge($member_info, $data);
            }
        }
        $this->assign('member_info', $member_info);


        /* 取得该分类及子分类cate_id */
        $cate_id = empty($_GET['cate_id']) ? 0 : intval($_GET['cate_id']);
        $cate_ids = array();
        $condition_id = '';
        if ($cate_id > 0) {
            $scategory_mod = & m('scategory');
            $cate_ids = $scategory_mod->get_descendant($cate_id);
        }
        /* 店铺分类检索条件 */
        $condition_id = implode(',', $cate_ids);
        $condition_id && $condition_id = ' AND cate_id IN(' . $condition_id . ')';

        $conditions = ' AND lat !=0.00000000 AND lng !=0.00000000';


        

        $page = $this->_get_page($limit);
        $store_mod = & m('store');
        $stores = $store_mod->find(
                array(
                    'conditions' => 'state = ' . STORE_OPEN . $condition_id . $conditions,
                    'fields' => 'this.* ,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*(' . $member_info['lat'] . '-lat)/360),2)+COS(PI()*' . $member_info['lat'] . '/180)* COS(lat * PI()/180)*POW(SIN(PI()*(' . $member_info['lng'] . '-lng)/360),2)))) as juli ',
                    'limit' => $page['limit'],
                    'order' => 'add_time DESC',
                    'join'    => 'has_scategory',
                    'count' => true,
                )
        );

        $model_goods = &m('goods');
        foreach ($stores as $key => $store) {
            //店铺logo
            empty($store['store_logo']) && $stores[$key]['store_logo'] = Conf::get('default_store_logo');
            //商品数量
            $stores[$key]['goods_count'] = $model_goods->get_count_of_store($store['store_id']);
            $stores[$key]['juli'] = round($store['juli'], 2);
            ;
        }



        $this->assign('stores', $stores);
        $scategorys = $this->_list_scategory();
        $this->assign('scategorys', $scategorys);


        $page['item_count'] = $store_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);
    }

    /* 取得店铺分类 */

    function _list_scategory() {
        $scategory_mod = & m('scategory');
        $scategories = $scategory_mod->get_list(-1, true);

        import('tree.lib');
        $tree = new Tree();
        $tree->setTree($scategories, 'cate_id', 'parent_id', 'cate_name');
        return $tree->getArrayList(0);
    }

    function test() {
        $lng1 = '112.99294300';
        $lat1 = '28.23610000';
        $lng2 = '112.99364500';
        $lat2 = '28.22897900';
        echo $this->getDistanceFromXtoY($lat1, $lng1, $lat2, $lng2) . "<br/>";
        echo $this->GetDistance($lat1, $lng1, $lat2, $lng2);
    }

    //根据经纬度 获取距离 算法1
    function rad($d) {
        return $d * 3.1415926535898 / 180.0;
    }

    //根据经纬度 获取距离 算法2
    function GetDistance($lat1, $lng1, $lat2, $lng2) {
        $EARTH_RADIUS = 6378.137 * 1000;
        $radLat1 = $this->rad($lat1);
        $radLat2 = $this->rad($lat2);
        $a = $radLat1 - $radLat2;
        $b = $this->rad($lng1) - $this->rad($lng2);
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        $s = $s * $EARTH_RADIUS;
        $s = round($s * 10000) / 10000;
        return $s;
    }

    //根据经纬度 获取距离 算法2
    function getDistanceFromXtoY($lat_a, $lng_a, $lat_b, $lng_b) {
        $pk = 180 / 3.14169;
        $a1 = $lat_a / $pk;
        $a2 = $lng_a / $pk;
        $b1 = $lat_b / $pk;
        $b2 = $lng_b / $pk;
        $t1 = cos($a1) * cos($a2) * cos($b1) * cos($b2);
        $t2 = cos($a1) * sin($a2) * cos($b1) * sin($b2);
        $t3 = sin($a1) * sin($b1);
        $tt = acos($t1 + $t2 + $t3);
        return 6366000 * $tt;
    }

}

?>
