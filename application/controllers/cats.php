<?php
include_once 'secure.php';
class Cats extends Secure {
	var $perm = 1040;
	function __construct(){
		parent::__construct();
		
		$this->pagetitle = "إدارة تصنيفات المنتجات";
		if(($this->users->is_perm($this->perm+2)))
		$sub_menu['cats/add']= 'إضافة تصنيف';
		$sub_menu['cats']='استعراض التصنيفات';
		if(($this->users->is_perm($this->perm+2)))
		$sub_menu['products/add']= 'إضافة منتج';
		$sub_menu['products']='استعراض المنتجات';
		$sub_menu['products/all_orders']='طلبات في الانتظار';
		$this->sub_menu = $sub_menu;
		$this->controler_name = strtolower(__CLASS__);
		$this->load->model('data_model','cats');
		$this->cats->set_table('cats');
	}
	
	private function fields(){
		return array('name','text','active');
	}
	
	function index($offset=0){
		if(!($this->users->is_perm($this->perm+1))){
			redirect("admin/permission_not_allowed");
		}
		$this->cats->order_by_field = "id";
		$rows = $this->cats->getrows();
		if (count($rows)>0) {
			$allrows = count($rows);
			$rows = $this->cats->getrows($offset,$this->rows_per_page);
			$this->load->library('list_table');
			$this->list_table->set_heading(array('م','اسم التصنيف','عمليات'));
			foreach ($rows as $row){
				$offset++;
				$data_row = $this->cats->get($row['id']);
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
			redirect("admin/permission_not_allowed");
		}
		$content = '';
		
		if ($this->input->post('submit_action')) {
			$fields = $this->fields();
			foreach ($fields as $field){
				$data[$field] = $this->input->post($field);
			}
			$field_name = 'img';
			$this->load->library('upload2','upload2');
			$file_info = $this->upload2->do_upload($field_name);
			if ($file_info !== false) {
				$data[$field_name] = $file_info['file_full_path'];
			}
			if ($this->cats->add($data)) {
// 				$this->action_log(__FUNCTION__,0);
				$this->alert('تم إضافة   : '.$this->input->post('name'));
			}
			else {
				$error = $this->cats->get_error();
				$error_text = $error['no'].':'.$error['text'];
				$message = 'لم يتم إضافة   : '.$this->input->post('name') ."<br>".$error_text;
				$this->alert($message);
			}
			redirect("cats");
			
		}
		else {
			$data['mode'] = 'add';
			$data['content'] = $this->load->view('cats', $data,true);
		}
		
		$this->render_page('page', $data);
	}

	function view($id){
		if(!($this->users->is_perm($this->perm+1))){
			redirect("admin/permission_not_allowed");
		}
		$content = '';
		$data_row = $this->cats->get($id);
		if (is_array($data_row)) {
		
			
			$data_row['mode'] = 'view';
			$data['content'] = $this->load->view('cats', $data_row,true);
			
		}
		else {
			$message = "رقم العنصر غير صحيح !!!";
			$this->alert($message,'e');
			redirect("cats");
		}
		
		$this->render_page('page', $data);
		
	}
	
	function edit($id){
		if(!($this->users->is_perm($this->perm+3))){
			redirect("admin/permission_not_allowed");
		}
		$content = '';
		$data_row = $this->cats->get($id);
		if (is_array($data_row)) {
		
			if ($this->input->post('submit_action')) {
				$fields = $this->fields();
				foreach ($fields as $field){
					$data[$field] = $this->input->post($field);
				}
				$field_name = 'img';
				$this->load->library('upload2','upload2');
				$file_info = $this->upload2->do_upload($field_name);
				if ($file_info !== false) {
					$data[$field_name] = $file_info['file_full_path'];
				}
				if ($this->cats->edit($data,$id)) {
// 					$this->action_log(__FUNCTION__,0);
					$this->alert('تم تعديل   : '.$this->input->post('name'));
				}
				else {
					$error = $this->cats->get_error();
					$error_text = $error['no'].':'.$error['text'];
					$message = 'لم يتم تعديل   : '.$this->input->post('name') ."<br>".$error_text;
					$this->alert($message);
	
									
				}
				redirect("cats");
				
			}
			else {
				$data_row['mode'] = 'edit';
				$data['content'] = $this->load->view('cats', $data_row,true);
			}
		}
		else {
			$message = "رقم العنصر غير صحيح !!!";
			$this->alert($message,'e');
			redirect("cats");
		}
		
		$this->render_page('page', $data);
		
	}
	
	function delete($id,$confirm=0){
		if(!($this->users->is_perm($this->perm+4))){
			redirect("admin/permission_not_allowed");
		}
		$content = '';
		$data_row = $this->cats->get($id);
		
		if (is_array($data_row)) {
			if ($confirm ==1){
				$this->removeimg($id,true);
				$result = $this->cats->delete($id);
				if ($result) {
					$this->alert("تم الحذف بنجاح : " . $data_row['name'],'s');
				}
				else {
					$this->alert("لم يتم الحذف بنجاح ",'e');
				}
				redirect("cats");
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
			redirect("cats");
		}
	}
	
	function removeimg($id=0,$ret=FALSE){
		if(!($this->users->is_perm($this->perm+3))){
			redirect("admin/permission_not_allowed");
		}
		$id=intval($id);
		$data_row = $this->cats->get($id);
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
				$this->cats->edit($data,$id);
				redirect("cats/edit/".$id);
			}
		}
		else {
			$message = "رقم العنصر غير صحيح !!!";
			$this->alert($message,'e');
			redirect("cats");
		}
	}
}
