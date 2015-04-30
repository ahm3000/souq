<?php
include_once 'secure.php';
class Pages extends Secure {
	var $perm = 1050;
	function __construct(){
		parent::__construct();
		
		$this->pagetitle = "إدارة الصفحات";
		if(($this->users->is_perm($this->perm+2)))
			$sub_menu['pages/add']= 'إضافة صفحة';
			$sub_menu['pages']='استعراض الصفحات';
		$this->sub_menu = $sub_menu;
		$this->controler_name = strtolower(__CLASS__);
		$this->load->model('data_model','pages');
		$this->pages->set_table('pages');
	}
	
	private function fields(){
		return array('name','text');
	}
	
	function index($offset=0){
		if(!($this->users->is_perm($this->perm+1))){
			redirect("secure/permission_not_allowed");
		}
		
		$this->pages->order_by_field = "id";
		$rows = $this->pages->getrows();
		
		if (count($rows)>0) {
			$cats = $this->table_array('cats');
			$allrows = count($rows);
			$rows = $this->pages->getrows($offset,$this->rows_per_page);
			$this->load->library('list_table');
			
			$this->list_table->set_heading(array('م','اسم الصفحة','عمليات'));
			foreach ($rows as $row){
				$offset++;
				$data_row = $this->pages->get($row['id']);
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
			$data['content'] = $this->list_table->generate();
			
			$data['content'] .= $this->pagination($allrows,$offset);
		}
		else {
			$data['content'] = $this->get_alert("عفواً لا يوجد سجلات حالياً في هذا القسم .");
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
			
			if ($this->pages->add($data)) {
				//$this->action_log(__FUNCTION__,0);
				$this->alert('تم إضافة   : '.$this->input->post('name'));
			}
			else {
				$error = $this->pages->get_error();
				$error_text = $error['no'].':'.$error['text'];
				$message = 'لم يتم إضافة   : '.$this->input->post('name') ."<br>".$error_text;
				$this->alert($message);
			}
			redirect("pages");
			
		}
		else {
			$data['mode'] = 'add';
			$data['content'] = $this->load->view('pages', $data,true);
		}
		
		$this->render_page('page', $data);
	}

	function view($id){
		if(!($this->users->is_perm($this->perm+1))){
			redirect("secure/permission_not_allowed");
		}
		$content = '';
		$data_row = $this->pages->get($id);
		if (is_array($data_row)) {
		
			
			$data_row['mode'] = 'view';
			$data['content'] = $this->load->view('pages', $data_row,true);
			
		}
		else {
			$message = "رقم العنصر غير صحيح !!!";
			$this->alert($message,'e');
			redirect("pages");
		}
		
		$this->render_page('page', $data);
		
	}
	
	function edit($id){
		if(!($this->users->is_perm($this->perm+3))){
			redirect("secure/permission_not_allowed");
		}
		$content = '';
		$data_row = $this->pages->get($id);
		if (is_array($data_row)) {
		
			if ($this->input->post('submit_action')) {
				$fields = $this->fields();
				foreach ($fields as $field){
					$data[$field] = $this->input->post($field);
				}
// 				$field_name = 'img';
// 				$this->load->library('upload2','upload2');
// 				$file_info = $this->upload2->do_upload($field_name);
// 				if ($file_info !== false) {
// 					$data[$field_name] = $file_info['file_full_path'];
// 				}
// 				else {
// 					$this->alert($this->upload2->get_error());
// 				}
				if ($this->pages->edit($data,$id)) {

				}
				else {
					$error = $this->pages->get_error();
					$error_text = $error['no'].':'.$error['text'];
					$message = 'لم يتم تعديل   : '.$this->input->post('name') ."<br>".print_r($error,true);
					$this->alert($message);
	
									
				}
				redirect("pages");
				
			}
			else {
				$data_row['mode'] = 'edit';
				$data['content'] = $this->load->view('pages', $data_row,true);
			}
		}
		else {
			$message = "رقم العنصر غير صحيح !!!";
			$this->alert($message,'e');
			redirect("pages");
		}
		
		$this->render_page('page', $data);
		
	}
	
	function delete($id,$confirm=0){
		if(!($this->users->is_perm($this->perm+4))){
			redirect("secure/permission_not_allowed");
		}
		$content = '';
		$data_row = $this->pages->get($id);
		
		if (is_array($data_row)) {
			if ($confirm ==1){
// 				$this->removeimg($id,true);
				$result = $this->pages->delete($id);
				if ($result) {
					$this->alert("تم الحذف بنجاح : " . $data_row['name'],'s');
				}
				else {
					$this->alert("لم يتم الحذف بنجاح ",'e');
				}
				redirect("pages");
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
			redirect("pages");
		}
	}
	
	function removeimg($id=0,$ret=FALSE){
		if(!($this->users->is_perm($this->perm+3))){
			redirect("secure/permission_not_allowed");
		}
		$id=intval($id);
		$data_row = $this->pages->get($id);
		if(is_array($data_row)){
			$data = array(
					'img'=>""
			);
			$this->load->helper('file');
			$path = $data_row['img'];
			if (file_exists($path)) {
				unlink($path) ;
			}
			if (!$ret) {
				$this->pages->edit($data,$id);
				redirect("pages/edit/".$id);
			}
		}
		else {
			$message = "رقم العنصر غير صحيح !!!";
			$this->alert($message,'e');
			redirect("pages");
		}
	}
}
