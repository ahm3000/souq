<?php
include_once 'secure.php';
class Users extends Secure {
	var $perm = 2000;
	function __construct(){
		parent::__construct();
		
		$this->pagetitle = "إدارة العضويات";
		if(($this->users->is_perm($this->perm+2)))
		$sub_menu['users/add']= 'إضافة عضو';
		$sub_menu['users']='استعراض الكل';		
		$this->sub_menu = $sub_menu;
		$this->controler_name = strtolower(__CLASS__);
// 		$this->load->model('users_model','users');
// 		$this->users->set_table('users');
	}
	
	private function fields(){
		return array('name','login','password','mobile','email');
	}
	
	function index($offset=0){
		if(!($this->users->is_perm($this->perm+1))){
			redirect("secure/permission_not_allowed");
		}
		$this->users->order_by_field = "name";
		$this->users->order_type = "ASC";
		$rows = $this->users->getrows();
		if (count($rows)>0) {
			$allrows = count($rows);
			$rows = $this->users->getrows($offset,$this->rows_per_page);
			$this->load->library('list_table');
			$this->list_table->set_heading(array('م','اسم العضو','عمليات'));
			foreach ($rows as $row){
				$offset++;
				$data_row = $this->users->get($row['id']);
				$buttons ='';
				if(($this->users->is_perm($this->perm+1))){
					$data_btn['btn_type']='view';
					$data_btn['url']=base_url(''.$this->controler_name.'/view/'.$data_row['id']);
					$buttons .= $this->load->view('button',$data_btn,true);
				}
				if(($this->users->is_perm($this->perm+3))){
					$data_btn['btn_type']='edit';
					$data_btn['url']=base_url(''.$this->controler_name.'/edit/'.$data_row['id']);
					$buttons .= $this->load->view('button',$data_btn,true);
				}
				if(($this->users->is_perm($this->perm+4))){
					$data_btn['btn_type']='delete';
					$data_btn['url']=base_url(''.$this->controler_name.'/delete/'.$data_row['id']);
					$buttons .= $this->load->view('button',$data_btn,true);
				}
				
				$this->list_table->add_row(array($offset,$data_row['name'],$buttons));
			}
			$data['content'] = $this->load->view('users_search',array(),true);
			$data['content'] .= $this->list_table->generate();
			$data['content'] .= $this->pagination($allrows,$offset);
		}
		else {
			$data['content'] = $this->get_alert("عفواً لا يوجد سجلات حالياً في هذا القسم .");
		}
		$this->render_page('page', $data);
	}
	
	public function search(){
		if(!($this->users->is_perm($this->perm+1))){
			redirect("secure/permission_not_allowed");
		}
		
		if ($this->input->post('action')) {
	
			$flag = false;
			
			if (strlen(trim($this->input->post('name')))>0) {
				$strfind_form = $this->input->post('name');
// 				$strfind_form = str_replace("عبد", "عبد ", $strfind_form);
				$strfind_form = trim($strfind_form);
				$words = explode(" ", $strfind_form);
				foreach ($words as $word){
// 					$strfind = $this->sqlalt($word);
					$strfind = trim($word);
					if (strlen($strfind)>2) {
						$this->db->where("name rlike '$strfind'");
						$flag = true;
					}
				}
			}
		}
		else {
			$data['content'] = "لا يوجد أي إدخالات بحث !!!";
		}
// 		exit("LINE : ".__LINE__);
		if ($flag) {
			$this->db->select('id');
			$this->db->order_by("name","asc");
			$query = $this->db->get('users');
			$rows = $query->result_array();
// 			$rows = '';
			$i=0;
			$offset=0;
			// 			print_r($result);
			$all_rows_cout = count($rows);
			if ($all_rows_cout>0) {

				$this->load->library('list_table');
				$this->list_table->set_heading(array('م','اسم المستخدم','عمليات'));
				foreach ($rows as $row){
					$offset++;
					$data_row = $this->users->get($row['id']);
					$buttons ='';
					if(($this->users->is_perm($this->perm+1))){
						$data_btn['btn_type']='view';
						$data_btn['url']=base_url(''.$this->controler_name.'/view/'.$data_row['id']);
						$buttons .= $this->load->view('button',$data_btn,true);
					}
					if(($this->users->is_perm($this->perm+3))){
						$data_btn['btn_type']='edit';
						$data_btn['url']=base_url(''.$this->controler_name.'/edit/'.$data_row['id']);
						$buttons .= $this->load->view('button',$data_btn,true);
					}
					if(($this->users->is_perm($this->perm+4))){
						$data_btn['btn_type']='delete';
						$data_btn['url']=base_url(''.$this->controler_name.'/delete/'.$data_row['id']);
						$buttons .= $this->load->view('button',$data_btn,true);
					}
					
					$this->list_table->add_row(array($offset,$data_row['name'],$buttons));
				}
				$data['content'] = $this->load->view('users_search',array(),true);
				$data['content'] .= $this->list_table->generate();
				
// 				$data['content'] .= $this->pagination($allrows,$offset);
			}
			else {
				$data['content'] = "عفواً لا يوجد نتائج لعملية البحث";
// 				$this->render_page ( $this->controler_name.'/list_table', $data );
			}
		}
		else {
			$data['content'] = "لا يوجد أي إدخالات بحث !!!";
// 			$this->render_page ( $this->controler_name.'/list_table', $data );
		}
		
		$this->render_page('page', $data);
	
	}
	
	function add(){
		if(!($this->users->is_perm($this->perm+2))){
			redirect("secure/permission_not_allowed");
		}
		$content = '';
		
		if ($this->input->post('submit_action')) {
			$fields = $this->fields();
			foreach ($fields as $field){
				$data[$field] = $this->input->post($field);
			}
// 			$data['reg_date'] = time();
// 			$data['active_mobile'] = 1;;
// 			$data['password'] = ($data['password']);
			if ($this->users->add($data)) {
				$user_new_id =$this->db->insert_id();
				$this->users->save_user_permissions($user_new_id,$this->input->post('perm'));
				//$this->action_log(__FUNCTION__,0);
				$this->alert('تم إضافة   : '.$this->input->post('name'));
			}
			else {
				$error = $this->users->get_error();
				$error_text = $error['no'].':'.$error['text'];
				$message = 'لم يتم إضافة   : '.$this->input->post('name') ."<br>".$error_text;
				$this->alert($message);
			}
			redirect("users");
			
		}
		else {
			$data['mode'] = 'add';
			$data['permissions'] = $this->users->get_list_perm();
			$data['users_permissions'] = array();
			$data['content'] = $this->load->view('users', $data,true);
		}
		
		$this->render_page('page', $data);
	}

	function view($id){
		if(!($this->users->is_perm($this->perm+1))){
			redirect("secure/permission_not_allowed");
		}
		$content = '';
		$data_row = $this->users->get($id);
		if (is_array($data_row)) {
		
			
			$data_row['mode'] = 'view';
			$data['permissions'] = $this->users->get_list_perm();
			$data['users_permissions'] = $this->users->get_user_permissions($id);
			$data['content'] = $this->load->view('users', $data_row,true);
			
		}
		else {
			$message = "رقم العنصر غير صحيح !!!";
			$this->alert($message,'e');
			redirect("users");
		}
		
		$this->render_page('page', $data);
		
	}
	
	
	function edit($id){
		if(!($this->users->is_perm($this->perm+3))){
			redirect("secure/permission_not_allowed");
		}
		$content = '';
		$data_row = $this->users->get($id);
		if (is_array($data_row)) {
		
			if ($this->input->post('submit_action')) {
				$fields = $this->fields();
				foreach ($fields as $field){
					$data[$field] = $this->input->post($field);
				}
				if ($this->users->edit($data,$id)) {
					$this->users->save_user_permissions($id,$this->input->post('perm'));
					//$this->action_log(__FUNCTION__,0);
					$this->alert('تم تعديل   : '.$this->input->post('name'));
				}
				else {
					$error = $this->users->get_error();
					$error_text = $error['no'].':'.$error['text'];
					$message = 'لم يتم تعديل   : '.$this->input->post('name') ."<br>".$error_text;
					$this->alert($message);
	
									
				}
				redirect("users");
				
			}
			else {
				$data_row['mode'] = 'edit';
				$data_row['permissions'] = $this->users->get_list_perm();
				$data_row['users_permissions'] = $this->users->get_user_permissions($id);
				$data['content'] = $this->load->view('users', $data_row,true);
			}
		}
		else {
			$message = "رقم العنصر غير صحيح !!!";
			$this->alert($message,'e');
			redirect("users");
		}
		
		$this->render_page('page', $data);
		
	}
	
	function delete($id,$confirm=0){
		if(!($this->users->is_perm($this->perm+4))){
			redirect("secure/permission_not_allowed");
		}
		$content = '';
		$data_row = $this->users->get($id);
		
		if (is_array($data_row)) {
			if ($confirm ==1){
				$result = $this->users->delete($id);
				if ($result) {
					$this->alert("تم الحذف بنجاح : " . $data_row['name'],'s');
				}
				else {
					$this->alert("لم يتم الحذف بنجاح ",'e');
				}
				redirect("users");
			}
			else {
				$data_row['mode'] = 'delete';
				$data_row['id'] = $id;
				$data_row['message'] = "هل ترغب في حذف السجل : ".$data_row['name'];
				$data_row['controler_name'] = $this->controler_name;
				$data['content'] = $this->load->view('confirm', $data_row,true);
				$this->render_page('page', $data);
			}
		}
		else {
			$message = "رقم العنصر غير صحيح !!!";
			$this->alert($message,'e');
			redirect("users");
		}
	}
	
}
