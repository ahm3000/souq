<?php
class Users_model extends CI_Model {
	
	public $order_by_field = 'name';
	public $order_type = 'desc';
	private $field_id_name = 'id';
	private $pass_key_encode_decode = 'Wqq^123';
	private $table = 'users';
	
	function get($id){
		$this->db->where('id', $id);
		$result = $this->db->get($this->table);
		$row = $result->result_array();
		return $row[0];
	}
	
	function getall(){
		$this->db->select($this->field_id_name);
		$result = $this->db->get($this->table);
		$rows = $result->result_array();
		return $rows;
	}

	function getrows($fromRow=0,$limit=1000000){
		$this->db->select($this->field_id_name);
		// 		$this->db->order_by($this->field_id_name,'desc');
		$this->db->order_by($this->order_by_field,$this->order_type);
		$this->db->limit($limit,$fromRow);
		$query = $this->db->get($this->table);
		$rows = $query->result_array();
		return $rows;
	}
	
	function add($data){
// 		$data=array();
		$data2['name'] = $this->db->escape_str($data['name']);
		$data2['login'] = $this->db->escape_str($data['login']);
		$data2['password'] = $this->passwordencode($data['password']);
		$data2['active'] = 0;
		$this->db->insert($this->table, $data2);
		
		if ($this->db->affected_rows()>0){
			return $this->db->insert_id();
		}
		else{
			return false;
		}
	}
	
	function edit($data,$id){
// 		$data=array();
		if (strlen($data['name'])>0) {
			$data['name'] = $this->db->escape_str($data['name']);
		}
		if (strlen($data['password'])>0) {
			$data['password'] = $this->passwordencode($data['password']);
		}
		else {
			unset($data['password']);
		}
		$data['lastupdate'] = time();

		
// 		print_r($data);
		$this->db->where('id', $id);
		$this->db->update($this->table, $data);
// 		echo $this->db->last_query();
		if ($this->db->affected_rows()>0){
			return $this->db->affected_rows();
		}
		else{
			return false;
		}
	}
	
	function lastlogin($id){
		$data=array();
		$data['lastlogin'] = time();
		$this->db->where('id', $id);
		$this->db->update($this->table, $data);
		if ($this->db->affected_rows()>0){
			return $this->db->affected_rows();
		}
		else{
			return false;
		}
	}
	
	function active($id){
		$data=array();
		$data['active'] = 1;
		$this->db->where('id', $id);
		$this->db->update($this->table, $data);
		
		if ($this->db->affected_rows()>0){
			return true;
		}
		else{
			return false;
		}
	}
	
	function deactive($id){
		$data=array();
		$data['active'] = 0;
		$this->db->where('id', $id);
		$this->db->update($this->table, $data);
		
		if ($this->db->affected_rows()>0){
			return true;
		}
		else{
			return false;
		}
	}
	
	function delete($id){
		
		$this->db->where('id', $id);
		$this->db->delete($this->table);
		
		if ($this->db->affected_rows()>0){
			return $this->db->affected_rows();
		}
		else{
			return false;
		}
	}

	function permission ($perm,$id){
		
	}
	
	function login($login,$password){
		
		$login = $this->db->escape_str($login);
		$password_form = $this->db->escape_str($password);		
		$where = array(
			'login' => $login,
			'active' => 1
		);
		
		$this->db->where($where);
		$query = $this->db->get($this->table);
		if ($this->db->affected_rows()>0) {
			$password_db = ($query->row()->password);
			$salt = ($query->row()->salt);
			if ($this->check_password($password_form,$password_db,$salt)) {
				$id = $query->row()->id;
				$this->lastlogin($id);
				$this->session->set_userdata('username', $query->row()->name);
				$this->session->set_userdata('user_id', $id);
				return true;
			}
		}
		return false;
		
	}
	
	function check_password($pass_form,$pass_db,$salt){
		$encrypted_password = trim(md5(md5($pass_form).$salt));
		if ($encrypted_password == $pass_db){
			return true;
		}
		return false;
	}
	
	function logout(){

		$array_items = array('username' => '', 'user_id' => '');		
		$this->session->unset_userdata($array_items);
	}
	
	function is_login(){
		
		if (intval($this->session->userdata('user_id'))>0){
			$user_id = $this->session->userdata('user_id');
			$where = array(
					'id' => intval($user_id),
					'active' => 1
			);
			
			$this->db->where($where);
			$query = $this->db->get($this->table);
			
			if ($this->db->affected_rows()>0) {
				return true;
// 				print_r($this->session->userdata('user_id'));
			}
		}
		
		return false;
	}
	
	function get_user_id(){
		if ($this->is_login()) {
			return $this->session->userdata('user_id');
		}
		
		return 0;
	}
	
	function passwordencode($pass){
		$this->load->library('encrypt');
		$encrypted_string = $this->encrypt->encode($pass,$this->pass_key_encode_decode);
		return $encrypted_string;
	}
	
	function passworddecode($pass){
		$this->load->library('encrypt');
		$encrypted_string = $this->encrypt->decode($pass,$this->pass_key_encode_decode);
		return $encrypted_string;
	}
	
	function change_password($user_id,$old_password,$new_password){
		$row = $this->get($user_id);
		if ($this->passwordencode($old_password) == $row['password']) {
			$data['password'] = $new_password;
			return $this->edit($data,$user_id);
		}
		return false;
		
	}
	
	
	
	function is_perm($perm_id){
		$user_id = intval($this->session->userdata('user_id'));
		if ($user_id>0){
			$where = array(
					'user_id' => $user_id,
					'perm_id' => $perm_id
			);
			$this->db->where($where);
			$query = $this->db->get('users_permission');
			
			if ($this->db->affected_rows()>0) {
				return true;
			}
		}
		
		return false;
	}
	
	function get_list_perm(){
		$this->db->order_by("id");
		$result = $this->db->get('permission');
		$rows = $result->result_array();
		return $rows;
	}
	
	function get_user_permissions($user_id){
		$where = array(
				'user_id' => $user_id
		);
		$this->db->select("perm_id");
		$this->db->where($where);
		$result = $this->db->get('users_permission');
		$rows = $result->result_array();
		$data = array();
		foreach ($rows as $row){
			$data[] = $row['perm_id'];
		}
		return $data;
	}
	
	function save_user_permissions($user_id,$permissions=array()){
		$this->db->where("user_id", $user_id);
		$this->db->delete("users_permission");
		if (is_array($permissions)) 
		foreach ($permissions as $permission){
			$data=array(
					'user_id'=>$user_id,
					'perm_id'=>$permission,
			);
			$this->db->insert("users_permission", $data);
		}
	}
	
	function set_table($table){
		$this->table = $table;
	}
	
	
}