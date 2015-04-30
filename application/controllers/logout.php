<?php
include_once APPPATH.'controllers/secure.php';
class Logout extends Secure {

	public function __construct() {
		parent::__construct ();
		
		$this->load->model ( 'users_model', 'users' );
		$this->users->set_table ( 'users' );
	}
	
	public function index() {
		$this->users->logout ();
		redirect ( '/' );
	}
}