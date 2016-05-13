<?php

/**
 * 友情链接挂件
 */
class PartnersWidget extends Store_baseWidget
{
    var $_name = 'partners';
	var $_ttl  = 86400;
	function _get_data()
    {
		$data = $this->_get_partners($this->_store_id);
        return $data;
    }
    /* 取得友情链接 */
    function _get_partners($id)
    {
        $partner_mod =& m('partner');
        return $partner_mod->find(array(
            'conditions' => "store_id = '$id'",
            'order' => 'sort_order',
        ));
    }
}

?>