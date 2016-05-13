<?php

/**
 *  商家会员卡 设置
 */

class My_membership_settingApp extends StoreadminbaseApp{
    
    var $_store_id;
    var $_membership_setting_mod;
    
    function __construct()
    {
        $this->My_membership_settingApp();
    }
    
    function My_membership_settingApp()
    {
        parent::__construct();
        $this->_store_id  = intval($this->visitor->get('manage_store'));
        $this->_membership_setting_mod = &m('membership_setting');
    }
    
    /*
     * 店铺会员卡设置   用户微信发送消息展示提示
     */
    function index() {
        if (!IS_POST){
            $data = $this->_membership_setting_mod->get($this->_store_id);
            
            if(empty($data)){
                $this->_membership_setting_mod->add(array('membership_setting_id'=>$this->_store_id));
            }else{
                $this->assign('data', $data);
            }
            $region_mod =& m('region');
            $this->assign('regions', $region_mod->get_options(0));
            
            $this->_curitem('my_membership_setting');
            $this->_curmenu('my_membership_setting');
            $this->import_resource('jquery.plugins/jquery.validate.js,mlselection.js');
            
            $this->display('my_membership_setting.index.html');
        }else{
            
            $data = array(
                'title'       =>$_POST['title'],
                'region_id'   =>$_POST['region_id'],
                'region_name' =>$_POST['region_name'],
                'address'     =>$_POST['address'],
                'phone'       =>$_POST['phone'],
            );
            
            $cover_image = $this->_upload_image('cover_image');
            
            if($cover_image != ''){
                $data['cover_image'] = $cover_image;
            }
            $this->_membership_setting_mod->edit($this->_store_id, $data);
            $this->show_message('edit_ok');
        }
    }
    

    
    
    
    
    /**
     *  用户用户显示的会员卡
     */
    
    function card()
    {
        if (!IS_POST){
            FOR ($i = 1; $i <= 23; $i++) {
                if($i<10){
                    $i = '0'.$i;
                }
                $mubans[$i] = 'themes/mall/taocz/styles/default/images/huodong/membership_card/card_bg/card_bg'.$i.'.png';
            }
            $this->assign('mubans', $mubans);
            
            $data = $this->_membership_setting_mod->get($this->_store_id);
            if(empty($data)){
                $this->_membership_setting_mod->add(array('membership_setting_id'=>$this->_store_id));
            }else{
                $this->assign('data', $data);
            }
            
            $this->_curitem('my_membership_setting_card');
            $this->_curmenu('my_membership_setting_card');
            
            $this->display('my_membership_setting.card.html');
            
        }else{
            
            $data = array(
                'card_name'         =>$_POST['card_name'],
                'card_name_color'   =>$_POST['card_name_color'],
                'card_bg'           =>$_POST['card_bg'],
                'card_num_color'    =>$_POST['card_num_color'],
                'card_description'  =>$_POST['card_description'],
            );
            
            $card_bg = $this->_upload_image('card_bg');
            if($card_bg != ''){
                $data['card_bg'] = $card_bg;
            }else{
                $data['card_bg'] = $_POST['bg'];
            }
            $this->_membership_setting_mod->edit($this->_store_id, $data);
            $this->show_message('edit_ok');
        }
    }
    
    
    
    /*
     * 上传文件  根据文件类型 上传
     */
    
    function _upload_image($type) {

        import('uploader.lib');
        $uploader = new Uploader();
        $uploader->allowed_type(IMAGE_FILE_TYPE);
        $uploader->allowed_size(SIZE_STORE_CERT); // 400KB

        $file = $_FILES[$type];
        if ($file['error'] == UPLOAD_ERR_OK) {
            if (empty($file)) {
                continue;
            }
            $uploader->addFile($file);
            if (!$uploader->file_info()) {
                $this->_error($uploader->get_error());
                return false;
            }

            $uploader->root_dir(ROOT_PATH);
            
            $data = $uploader->save('data/files/store_' . $this->_store_id . '/membership', $type);
            
        }
        
        return $data;
        
    }
            
    
    
    
    
    
    
    function _get_member_submenu()
    {
        return array(
            array(
                'name' => 'my_membership_setting',
                'url'  => 'index.php?app=my_membership_setting',
            ),
            array(
                'name' => 'my_membership_setting_card',
                'url'  => 'index.php?app=my_membership_setting&act=card',
            ),
        );
    }
    
    
    
    
}
?>
