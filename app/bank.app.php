<?php

class BankApp extends MemberbaseApp
{
	var $_bank_mod;
	
	/* 构造函数 */
    function __construct()
    {
         $this->BankApp();
    }

    function BankApp()
    {
        parent::__construct();
		$this->_bank_mod = &m('bank');
    }
    function index()
    {
		
    }
	
	function add()
	{
		if(!IS_POST)
		{
			/* 当前位置 */
        	$this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('deposit'),         'index.php?app=deposit',
                         LANG::get('bank_add')
			);
						 
			/* 当前所处子菜单 */
        	$this->_curmenu('bank_add');
        	/* 当前用户中心菜单 */
        	$this->_curitem('deposit');
		
			$this->assign('bank_inc', $this->_get_bank_inc());
			
			$this->display('bank.form.html');
		}
		else
		{
			$short_name = trim($_POST['short_name']);
			$account_name = trim($_POST['account_name']);
			$type	= trim($_POST['type']);
			$num 	= trim($_POST['num']);
			
			if(empty($short_name)) {
				$this->show_warning('short_name_error');
				return;
			}
			if(empty($num)) {
				$this->show_warning('num_empty');
				return;
			}
			if(empty($account_name) || strlen($account_name)<6 || strlen($account_name)>30) {
				$this->show_warning('account_name_error');
				return;
			}
			if(!in_array($type, array('debit','credit'))){
				$this->show_warning('type_error');
				return;
			}
			$bank_name = $this->_get_bank_name($short_name);
			if(empty($bank_name))
			{
				$this->show_warning('bank_name_error');
				return;
			}
			
			if (base64_decode($_SESSION['captcha']) != strtolower($_POST['captcha']))
            {
                $this->show_warning('captcha_failed');
                return;
            }
			
			$data = array(
				'user_id'		=>	$this->visitor->get('user_id'),
				'bank_name'		=>	$bank_name,
				'short_name'	=>	strtoupper($short_name),
				'account_name'	=>	$account_name,
				'open_bank'		=>  trim($_POST['open_bank']),
				'type'			=> 	$type,
				'num'			=>	$num,
			);
			
			if(!$this->_bank_mod->add($data)){
				$this->show_warning('add_error');
				return;
			}
			$this->show_message('add_ok', 'deposit_index', 'index.php?app=deposit');
		}
	}
	
	function edit()
	{
		$short_name = trim($_GET['short_name']);
		$bid = intval($_GET['bid']);
		
		if($bid) 
		{
			$card = $this->_bank_mod->get($bid);
		}
		else
		{
			if(!$this->_check_short_name($short_name)){
				$this->show_warning('short_name_error');
				return;
			}

			$card = $this->_bank_mod->get(array('conditions'=>"short_name='".strtoupper($short_name)."'"));
		}
		
		if(!IS_POST)
		{
			/* 当前位置 */
        	$this->_curlocal(LANG::get('member_center'),   'index.php?app=member',
                         LANG::get('deposit'),         'index.php?app=deposit',
                         LANG::get('bank_edit')
			);
						 
			/* 当前所处子菜单 */
        	$this->_curmenu('bank_edit');
        	/* 当前用户中心菜单 */
        	$this->_curitem('deposit');
		
			$this->assign('bank_inc', $this->_get_bank_inc());
			$this->assign('card', $card);
			$this->display('bank.form.html');
		}
		else
		{
			
			$short_name = trim($_POST['short_name']);
			$account_name = trim($_POST['account_name']);
			$type	= trim($_POST['type']);
			$num 	= trim($_POST['num']);
			
			if(empty($short_name)) {
				$this->show_warning('short_name_empty');
				return;
			}
			if(empty($num)) {
				$this->show_warning('num_empty');
				return;
			}
			if(empty($account_name) || strlen($account_name)<6 || strlen($account_name)>30) {
				$this->show_warning('account_name_error');
				return;
			}
			if(!in_array($type, array('debit','credit'))){
				$this->show_warning('type_error');
				return;
			}

			$bank_name = $this->_get_bank_name($short_name);
			if(empty($bank_name))
			{
				$this->show_warning('bank_name_error');
				return;
			}
			
			if (base64_decode($_SESSION['captcha']) != strtolower($_POST['captcha']))
            {
                $this->show_warning('captcha_failed');
                return;
            }
			
			$data = array(
				'user_id'		=>	$this->visitor->get('user_id'),
				'bank_name'		=>	$bank_name,
				'short_name'	=>	strtoupper($short_name),
				'account_name'	=>	$account_name,
				'open_bank'		=>  trim($_POST['open_bank']),
				'type'			=> 	$type,
				'num'			=>	$num,
			);

			if(!$this->_bank_mod->edit($card['bid'],$data)){
				$this->show_warning('edit_error');
				return;
			}
			$this->show_message('edit_ok', 'deposit_index', 'index.php?app=deposit');
		}
	}
	
	function drop()
	{
		$bid = intval($_GET['bid']);
		if(!$bid)
		{
			$this->show_warning('no_such_bank');
			return;
		}
		
		if(!$this->_bank_mod->drop($bid))
		{
			$this->show_warning('drop_bank_error');
			return;
		}
		$this->show_message('drop_ok', 'deposit_index', 'index.php?app=deposit');
	}
	
	function _check_short_name($short_name)
	{
		$bank_inc = $this->_get_bank_inc();
		
		if(!is_array($bank_inc) || count($bank_inc)<1){
			return false;
		}
		
		foreach($bank_inc as $key=>$bank)
		{
			if(strtoupper($short_name)==strtoupper($key)) {
				return true;
			}
		}
		return false;
	}
	
	function _get_bank_name($short_name)
	{
		if(!$this->_check_short_name($short_name)) return '';
		$bank_inc = $this->_get_bank_inc();
		return $bank_inc[$short_name];
	}
	
	/**
     *    三级菜单
     *
     *    @author    psmb
     *    @return    void
     */
    function _get_member_submenu()
    {
        $data = array(
            array(
                'name'  => 'deposit_index',
                'url'   => 'index.php?app=deposit',
            ),
			array(
				'name'  => 'deposit_config',
				'url'	=> 'index.php?app=deposit&act=config',
			),
			array(
				'name'	=>	'recordlist',
				'url'	=>	'index.php?app=deposit&act=recordlist',
			),
			array(
				'name'	=>	'bank_add',
				'url'	=>	'index.php?app=bank&act=add',
			),
        );
		if(ACT=='edit')
		{
			$data[] = array(
				'name'	=>	'bank_edit',
				'url'	=>	'',
			);
		}
		
		return $data;
    }
}

?>
