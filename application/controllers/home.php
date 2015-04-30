<?php
include_once 'secure.php';
class Home extends Secure {
	var $perm = 2000;
	function __construct(){
		parent::__construct();

		$this->pagetitle = "إدارة المشرفين";
// 		if(($this->users->is_perm($this->perm+2)))
// 			$sub_menu['products']= 'استعراض المنتجات';
		$sub_menu['admincp/admins']='استعراض الكل';
		$this->sub_menu = $sub_menu;
		$this->controler_name = strtolower(__CLASS__);
		// 		$this->load->model('users_model','admins');
		// 		$this->admins->set_table('admins');
	}
	
	function index(){
		
		$data = array();
		$data['pagetitle'] = "Hello";
		$data['content'] = "Hello";
		
		$this->render_page('page', $data);
		
	}
	
}