<?php
include_once 'secure.php';
class imgs extends Secure {
	var $perm = 1040;
	function __construct(){
		parent::__construct();
		
		$this->pagetitle = "إدارة المنتجات";
		if(($this->users->is_perm($this->perm+2)))
			$sub_menu['cats/add']= 'إضافة تصنيف';
			$sub_menu['cats']='استعراض التصنيفات';
		if(($this->users->is_perm($this->perm+2)))
			$sub_menu['imgs/add']= 'إضافة منتج';
			$sub_menu['imgs']='استعراض المنتجات';		
		$this->sub_menu = $sub_menu;
		$this->controler_name = strtolower(__CLASS__);
		$this->load->model('data_model','imgs');
		$this->imgs->set_table('imgs');
	}
	
	private function fields(){
		return array('name');
	}
	
	
	function add($product_id){
		if(!($this->users->is_perm($this->perm+2))){
			redirect("secure/permission_not_allowed");
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
			$data['product_id'] = $product_id;
			if ($this->imgs->add($data)) {
				//$this->action_log(__FUNCTION__,0);
				$this->alert('تم إضافة   : '.$this->input->post('name'));
			}
			else {
				$error = $this->imgs->get_error();
				$error_text = $error['no'].':'.$error['text'];
				$message = 'لم يتم إضافة   : '.$this->input->post('name') ."<br>".$error_text;
				$this->alert($message);
			}
			redirect("products/edit/".$product_id);
			
		}
		else {
			$data['mode'] = 'add';
			$data['product_id'] = $product_id;
			$data['cats'] = $this->table_array('cats');
			$data['content'] = $this->load->view('imgs', $data,true);
		}
		
		$this->render_page('page', $data);
	}

	
	function delete($id,$confirm=0){
		if(!($this->users->is_perm($this->perm+4))){
			redirect("secure/permission_not_allowed");
		}
		$content = '';
		$data_row = $this->imgs->get($id);
		
		if (is_array($data_row)) {
			if ($confirm ==1){
				$this->removeimg($id,true);
				$result = $this->imgs->delete($id);
				if ($result) {
					$this->alert("تم الحذف بنجاح : " . $data_row['name'],'s');
				}
				else {
					$this->alert("لم يتم الحذف بنجاح ",'e');
				}
				redirect("products/edit/".$data_row['product_id']);
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
			redirect("products");
		}
	}
	
	function removeimg($id=0,$ret=FALSE){
		if(!($this->users->is_perm($this->perm+3))){
			redirect("secure/permission_not_allowed");
		}
		$id=intval($id);
		$data_row = $this->imgs->get($id);
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
				$this->imgs->edit($data,$id);
				redirect("products");
			}
		}
		else {
			$message = "رقم العنصر غير صحيح !!!";
			$this->alert($message,'e');
			redirect("products");
		}
	}
	
}
