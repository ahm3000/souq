<?php
class Login extends CI_Controller {

	public function __construct() {
		parent::__construct ();
		
		$this->load->model ( 'users_model', 'users' );
		$this->users->set_table ( 'users' );
	}
	
	public function index() {
		if ($this->input->post ( 'submit_action' )) {
			
			$login = $this->input->post ( 'login' );
			$password = $this->input->post ( 'password' );
			
			if ($this->users->login ( $login, $password )) {
				$url=base64_decode( $this->input->post ( 'redirect' ));
				redirect ( 'market' );
			} else {
				
				$this->data ['message'] = "اسم المستخدم أو كلمة المرور غير صحيحة <br>الرجاء التأكد من المعلومات !!";
				$this->load->view ( 'login', $this->data );
			}
		} else {
			$this->data ['message'] = '';
			$this->load->view ( 'login', $this->data );
		}
	}
}