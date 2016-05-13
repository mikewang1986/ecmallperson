<?php

/**
 *  商家会员 设置以及显示
 */

class My_membership_card_infoApp extends StoreadminbaseApp{
    
    var $_store_id;
    var $_membership_card_info_mod;
    
    function __construct()
    {
        $this->My_membership_cardApp();
    }
    
    function My_membership_cardApp()
    {
        parent::__construct();
        $this->_store_id  = intval($this->visitor->get('manage_store'));
        $this->_membership_card_info_mod = &m('membership_card_info');
    }
    
    
    /**
     * 店铺会员卡列表
     */
    function index() {
        $conditions = 'store_id = '.  $this->_store_id;
        
        if (trim($_GET['keyword'])) {
            $str = "LIKE '%" . trim($_GET['keyword']) . "%'";
            if ($_GET['character']) {
                switch ($_GET['character']) {
                    case 'card_num':
                        $conditions .= " AND card_num {$str}";
                        break;
                    case 'user_name':
                        $conditions .= " AND user_name {$str}";
                        break;
                    case 'phone':
                        $conditions .= " AND phone {$str}";
                        break;
                }
            }
        }
        
        $page   =   $this->_get_page(10);   //获取分页信息
        $membership_card_infos = $this->_membership_card_info_mod->find(
                array(
                    'conditions'  => $conditions,
                    'limit'   =>$page['limit'],
                    'count'   => true   //允许统计
                )
        );
        
        $this->assign('datas', $membership_card_infos);
        $this->_curitem('my_membership_card_info');
        $this->_curmenu('my_membership_card_info');
        $this->display('my_membership_card_info.index.html');
    }
    
    


    
    /*
     * 对会员信息进行编辑
     */
    function edit() {
        $membership_card_info_id = intval($_GET['id']);
        if (empty($membership_card_info_id)) {
            $this->show_message('hack');
        }

        $membership_card_info = $this->_membership_card_info_mod->get($membership_card_info_id);

        if (empty($membership_card_info)||$membership_card_info['store_id']!=$this->_store_id) {
            $this->show_message('error');
        }
        
        
        
        if (!IS_POST) {
            $region_mod = & m('region');
            $this->assign('regions', $region_mod->get_options(0));

            $this->_curitem('my_membership_card_info');
            $this->_curmenu('my_membership_card_info_edit');

            $this->import_resource('jquery.plugins/jquery.validate.js,mlselection.js');

            $this->assign('data', $membership_card_info);
            $this->display('my_membership_card_info.edit.html');
        }else{
            $data = array(
                'user_name' => $_POST['user_name'],
                'phone'     => $_POST['phone'],
                'sex'       => $_POST['sex'],
                'region_id' => $_POST['region_id'],
                'region_name' => $_POST['region_name'],
                'address'   => $_POST['address'],
            );
            
            $this->_membership_card_info_mod->edit($membership_card_info_id,$data);
            $this->show_message('edit_ok');
        }
    }
    
    
    /**
     * 对会员进行冻结
     */
    function freeze()
    {
        $membership_card_info_id = intval($_GET['id']);
        if (empty($membership_card_info_id)) {
            $this->show_message('hack');
        }
        $membership_card_info = $this->_membership_card_info_mod->get($membership_card_info_id);
        if (empty($membership_card_info)||$membership_card_info['store_id']!=$this->_store_id) {
            $this->show_message('error');
        }
        
        $this->_membership_card_info_mod->edit($membership_card_info_id,array('status'=>0));
        $this->show_message('edit_ok');
    }
    
    
    /**
     * 对会员进行解冻
     */
    function unfreeze()
    {
        $membership_card_info_id = intval($_GET['id']);
        if (empty($membership_card_info_id)) {
            $this->show_message('hack');
        }
        $membership_card_info = $this->_membership_card_info_mod->get($membership_card_info_id);
        if (empty($membership_card_info)||$membership_card_info['store_id']!=$this->_store_id) {
            $this->show_message('error');
        }
        
        $this->_membership_card_info_mod->edit($membership_card_info_id,array('status'=>1));
        $this->show_message('edit_ok');
    }
    
    
    
    
    function _get_member_submenu()
    {
        if (ACT == 'index') {
            $menus = array(
                array(
                    'name' => 'my_membership_card_info',
                    'url' => 'index.php?app=my_membership_card_info&act=card_info',
                ),
            );
        } else {
            $menus = array(
                array(
                    'name' => 'my_membership_card_info',
                    'url' => 'index.php?app=my_membership_card_info',
                ),
                array(
                    'name' => 'my_membership_card_info_edit',
                    'url' => 'index.php?app=my_membership_card_info',
                ),
            );
        }
        return $menus;
    }
    
    
}
?>
