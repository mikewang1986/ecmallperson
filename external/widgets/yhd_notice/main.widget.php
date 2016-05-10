<?php

/**
 * ¹«¸æÀ¸¹Ò¼þ
 *
 */
class Yhd_noticeWidget extends BaseWidget
{
    var $_name = 'yhd_notice';
    var $_ttl  = 86400;
    var $_num  = 5;

    function _get_data()
    {
        $cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {
            $acategory_mod =& m('acategory');
            $article_mod =& m('article');
            $data = $article_mod->find(array(
                'conditions'    => 'cate_id=' . $acategory_mod->get_ACC(ACC_NOTICE) . ' AND if_show = 1',
                'order'         => 'sort_order ASC, add_time DESC',
                'fields'        => 'article_id, title, add_time',
                'limit'         => $this->_num,
            ));
            $cache_server->set($key, $data, $this->_ttl);
        }

        return $data;
    }

}

?>