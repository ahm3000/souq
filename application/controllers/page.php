<?php
include_once 'secure.php';
class Page extends Secure {
	var $perm = 1050;
	function __construct(){
		parent::__construct();		
		$this->controler_name = strtolower(__CLASS__);
		$this->load->model('data_model','pages');
		$this->pages->set_table('pages');
	}
	function view($id){
		$data_row = $this->pages->get($id);
		if (is_array($data_row)) {
		
			$this->pagetitle = $data_row['name'];
			$data['content'] = nl2br($data_row['text']);
			
		}
		else {
			$message = "رقم العنصر غير صحيح !!!";
			$this->alert($message,'e');
			redirect("pages");
		}
		
		$this->render_page('page', $data);
		
	}
	
}
