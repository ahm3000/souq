<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class Sync extends CI_Controller {
	
	public function index() {
		
		$salt = '3dz48';
		$password = '12345';
		$password_encoded = trim(md5(md5($password).$salt));
		//exit($password_encoded);
//		$this->db->query ( "INSERT INTO users SET name='admin', login='admin' , password='$password_encoded' , salt='$salt' , lastupdate='0' , email='',active='1';" );
		
		$this->db_emp = $this->load->database ( 'emp', TRUE );
		$limit = 50000;
		$query = $this->db_emp->query ( "SELECT name,employment_number , login_pass , salt ,email FROM employees limit $limit;" );
		if ($query->num_rows () > 0) {
			foreach ( $query->result () as $row ) {
				$name = trim($row->name);
				$login = trim($row->employment_number);
				$password = trim($row->login_pass);
				$salt = trim($row->salt);
				$email = trim($row->email);
				$lastupdate = time();
				if(strlen($login)>0 && strlen($password)>0){
//					$this->db = $this->load->database ( 'default', TRUE );
					$query1 = $this->db->query ( "SELECT * FROM users WHERE login='$login';" );
					if ($query1->num_rows () > 0) {
						$this->db->query ( "UPDATE users SET name='$name',password='$password' , salt='$salt' , lastupdate='$lastupdate' , email='$email' WHERE login='$login';" );	
					}
					else {
						$this->db->query ( "INSERT INTO users SET name='$name', login='$login' , password='$password' , salt='$salt' , lastupdate='$lastupdate' , email='$email',active='1';" );
					}
					echo "$login ..<br>";
				}
			}
		}
	}

}

