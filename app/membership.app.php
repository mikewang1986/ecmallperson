<?php

class MembershipApp extends MemberbaseApp
{
    var $_user_id;
    var $_store_mod;
    var $_membership_card_info_mod;
    var $_membership_setting_mod;
    
    
    
    function __construct()
    {
        $this->MembershipApp();
    }
    function MembershipApp()
    {
        parent::__construct();
        $this->_user_id = $this->visitor->get('user_id');
        $this->_store_mod =& m('store');
        $this->_membership_card_info_mod = &m('membership_card_info');
        $this->_membership_setting_mod = &m('membership_setting');
    }
    
    
    
    function index()
    {
        
        /* 检测是否 绑定了此店铺的会员卡 */
        $store_id = intval($_GET['id']);
        if (empty($store_id)) {
            $this->show_message('hack');
        }

        $store = $this->_store_mod->get($store_id);
        if (empty($store)) {
            $this->show_message('hack');
        }

        $membership_card_infos = $this->_membership_card_info_mod->find(
                array(
                    'conditions' => 'store_id=' . $store_id . ' AND user_id=' . $this->_user_id,
                )
        );
        if (count($membership_card_infos) > 1) {
            $this->show_message('error');
            return;
        }
        $this->assign('data_card_info', current($membership_card_infos));
        
        
        //获取当前店铺的相关配置信息
        $data_card = $this->_membership_setting_mod->get($this->_store_id);
        if (empty($data_card)) {
            $this->show_message('对不起此会员未设置会员卡', 'back_list', 'index.php?app=store&id='.$store_id);
        }
        $this->assign('data_card', $data_card);
        
        
        
        
        $this->display('membership.index.html');
    }
    
    
    function card_info_add() {
        /* 检测是否 绑定了此店铺的会员卡 */
        $store_id = intval($_GET['id']);
        if (empty($store_id)) {
            $this->show_message('hack');
        }

        $store = $this->_store_mod->get($store_id);
        if (empty($store)) {
            $this->show_message('hack');
        }

        
        $membership_card_infos = $this->_membership_card_info_mod->find(
                array(
                    'conditions' => 'store_id=' . $store_id . ' AND user_id=' . $this->_user_id,
                )
        );

        if (count($membership_card_infos) != 0) {
            $this->show_message('error');
            return;
        }

        if (!IS_POST) {
            $region_mod = & m('region');
            $this->assign('regions', $region_mod->get_options(0));

            $this->display('membership.card_info.html');
        } else {
            $data = array(
                'user_id'   => $this->_user_id,
                'store_id'  => $store_id,
                'user_name' => $_POST['user_name'],
                'card_num'  => 1000000 + $this->_user_id,
                'phone'     => $_POST['phone'],
                'sex'       => $_POST['sex'],
                'region_id' => $_POST['region_id'],
                'region_name' => $_POST['region_name'],
                'address' => $_POST['address'],
                'create_time' => gmtime(),
            );
            $this->_membership_card_info_mod->add($data);
            $this->show_message('add_ok', 'back_list', 'index.php?app=membership&id='.$store_id);
        }
    }
    
    
    function card_info_edit() {
        
        /* 检测是否 绑定了此店铺的会员卡 */
        $store_id = intval($_GET['id']);
        if (empty($store_id)) {
            $this->show_message('hack');
        }

        $store = $this->_store_mod->get($store_id);
        if (empty($store)) {
            $this->show_message('hack');
        }

        
        $membership_card_infos = $this->_membership_card_info_mod->find(
                array(
                    'conditions' => 'store_id=' . $store_id . ' AND user_id=' . $this->_user_id,
                )
        );

        if (count($membership_card_infos) != 1) {
            $this->show_message('error');
            return;
        }
        
        
        if (!IS_POST) {
            $region_mod = & m('region');
            $this->assign('regions', $region_mod->get_options(0));
            $this->assign('data', current($membership_card_infos));
            $this->display('membership.card_info.html');
        } else {
            $membership_card_info = current($membership_card_infos);
            $membership_card_info_id = $membership_card_info['membership_card_info_id'];
            
            $data = array(
                'user_name' => $_POST['user_name'],
                'phone' => $_POST['phone'],
                'sex' => $_POST['sex'],
                'region_id' => $_POST['region_id'],
                'region_name' => $_POST['region_name'],
                'address' => $_POST['address'],
            );
            $this->_membership_card_info_mod->edit($membership_card_info_id,$data);
            $this->show_message('edit_ok', 'back_list', 'index.php?app=membership&id='.$store_id);
        }
        
        
        
    }
    
    
    
    
    
    
}
?>
