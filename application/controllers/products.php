<?php
include_once 'secure.php';
class products extends Secure {
	var $perm = 1040;
	function __construct(){
		parent::__construct();
		
		$this->pagetitle = "إدارة المنتجات";
		if(($this->users->is_perm($this->perm+2)))
			$sub_menu['cats/add']= 'إضافة تصنيف';
			$sub_menu['cats']='استعراض التصنيفات';
		if(($this->users->is_perm($this->perm+2)))
			$sub_menu['products/add']= 'إضافة منتج';
			$sub_menu['products']='استعراض المنتجات';	
			$sub_menu['products/all_orders']='طلبات في الانتظار';	
		$this->sub_menu = $sub_menu;
		$this->controler_name = strtolower(__CLASS__);
		$this->load->model('data_model','products');
		$this->products->set_table('products');
	}
	
	private function fields(){
		return array('name','text','price','all_no','cat_id','homepage','price0');
	}
	
	function index($offset=0){
		if(!($this->users->is_perm($this->perm+1))){
			redirect("secure/permission_not_allowed");
		}
		
		$this->products->order_by_field = "id";
		$rows = $this->products->getrows();
		
		if (count($rows)>0) {
			$cats = $this->table_array('cats');
			$allrows = count($rows);
			$rows = $this->products->getrows($offset,$this->rows_per_page);
			$this->load->library('list_table');
			
			$this->list_table->set_heading(array('م','اسم المنتج','التصنيف','عمليات'));
			foreach ($rows as $row){
				$offset++;
				$data_row = $this->products->get($row['id']);
				$buttons ='';
				if(($this->users->is_perm($this->perm+1))){
					$data_btn['btn_type']='list';
					$data_btn['url']=base_url(''.$this->controler_name.'/orders/'.$data_row['id']);
					$buttons .= $this->load->view('button',$data_btn,true);
				}
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
				
				$this->list_table->add_row(array($offset,$data_row['name'],$cats[$data_row['cat_id']],$buttons));
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
			$field_name = 'img';
			$this->load->library('upload2','upload2');
			$file_info = $this->upload2->do_upload($field_name);
			if ($file_info !== false) {
				$data[$field_name] = $file_info['file_full_path'];
			}
			$data['last_reg'] = date_string2int($this->input->post('last_reg'));
			if ($this->products->add($data)) {
				//$this->action_log(__FUNCTION__,0);
				$this->alert('تم إضافة   : '.$this->input->post('name'));
			}
			else {
				$error = $this->products->get_error();
				$error_text = $error['no'].':'.$error['text'];
				$message = 'لم يتم إضافة   : '.$this->input->post('name') ."<br>".$error_text;
				$this->alert($message);
			}
			redirect("products");
			
		}
		else {
			$data['mode'] = 'add';
			$data['cat_id'] = 0;
			$data['cats'] = $this->table_array('cats');
			$data['content'] = $this->load->view('products', $data,true);
		}
		
		$this->render_page('page', $data);
	}

	function view($id){
		if(!($this->users->is_perm($this->perm+1))){
			redirect("secure/permission_not_allowed");
		}
		$content = '';
		$data_row = $this->products->get($id);
		if (is_array($data_row)) {
		
			
			$data_row['mode'] = 'view';
			$data_row['imgs'] = $this->getimgs($id);
			$data_row['cats'] = $this->table_array('cats');
			$data['content'] = $this->load->view('products', $data_row,true);
			
		}
		else {
			$message = "رقم العنصر غير صحيح !!!";
			$this->alert($message,'e');
			redirect("products");
		}
		
		$this->render_page('page', $data);
		
	}
	
	function edit($id){
		if(!($this->users->is_perm($this->perm+3))){
			redirect("secure/permission_not_allowed");
		}
		$content = '';
		$data_row = $this->products->get($id);
		if (is_array($data_row)) {
		
			if ($this->input->post('submit_action')) {
				$fields = $this->fields();
				foreach ($fields as $field){
					$data[$field] = $this->input->post($field);
				}
				$data['last_reg'] = date_string2int($this->input->post('last_reg'));
				$field_name = 'img';
				$this->load->library('upload2','upload2');
				$file_info = $this->upload2->do_upload($field_name);
				if ($file_info !== false) {
					$data[$field_name] = $file_info['file_full_path'];
				}
				else {
					$this->alert($this->upload2->get_error());
				}
				if ($this->products->edit($data,$id)) {

				}
				else {
					$error = $this->products->get_error();
					$error_text = $error['no'].':'.$error['text'];
					$message = 'لم يتم تعديل   : '.$this->input->post('name') ."<br>".print_r($error,true);
					$this->alert($message);
	
									
				}
				redirect("products");
				
			}
			else {
				$data_row['mode'] = 'edit';
				$data_row['imgs'] = $this->getimgs($id);
				$data_row['cats'] = $this->table_array('cats');
				$data['content'] = $this->load->view('products', $data_row,true);
			}
		}
		else {
			$message = "رقم العنصر غير صحيح !!!";
			$this->alert($message,'e');
			redirect("products");
		}
		
		$this->render_page('page', $data);
		
	}
	
	function delete($id,$confirm=0){
		if(!($this->users->is_perm($this->perm+4))){
			redirect("secure/permission_not_allowed");
		}
		$content = '';
		$data_row = $this->products->get($id);
		
		if (is_array($data_row)) {
			if ($confirm ==1){
				$this->removeimg($id,true);
				$this->removeorders($id);
				$result = $this->products->delete($id);
				if ($result) {
					$this->alert("تم الحذف بنجاح : " . $data_row['name'],'s');
				}
				else {
					$this->alert("لم يتم الحذف بنجاح ",'e');
				}
				redirect("products");
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
	
	function removeorders($id=0){
		$this->load->model('data_model','orders');
		$this->orders->set_table('orders');
		$rows = $this->orders->getwhere('product_id',$id);
		if (count($rows)>0) {
			foreach ($rows as $row){
				$this->orders->delete($row['id']);
			}
		}
		
	}
	function removeimg($id=0,$ret=FALSE){
		if(!($this->users->is_perm($this->perm+3))){
			redirect("secure/permission_not_allowed");
		}
		$id=intval($id);
		$data_row = $this->products->get($id);
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
				$this->products->edit($data,$id);
				redirect("products/edit/".$id);
			}
		}
		else {
			$message = "رقم العنصر غير صحيح !!!";
			$this->alert($message,'e');
			redirect("products");
		}
	}
	
	function orders($id=0){
		if(!($this->users->is_perm($this->perm+1))){
			redirect("secure/permission_not_allowed");
		}
		
		$this->load->model('data_model','orders');
		$this->orders->set_table('orders');
		$data_row = $this->products->get($id);
		if(is_array($data_row)){
			$this->sub_menu = '';
			$this->pagetitle = "عرض الطلبات لـ : ".$data_row['name'];
			$rows = $this->orders->getwhere('product_id',$id);
			$this->load->library('list_table');
			
			$content='';
			$offset = 0;
			if (count($rows)>0) {
				$this->list_table->set_heading(array('م','اسم العضو','تاريخ الطلب', 'عمليات'));
				foreach ($rows as $row){
					
					$offset++;
					$row_order = $this->orders->get($row['id']);
					$row_user = $this->users->get($row_order['user_id']);
					if ($row_order['sticky'] == 0) {
						$data_btn['btn_type']='delete';
						$data_btn['url']=base_url('orders/delete100/'.$row_order['id']);
						$buttons = $this->load->view('button',$data_btn,true);
						
					}
					else {
						$buttons = "تم اعتماد الطلب";
					}
					$this->list_table->add_row(array($offset,$row_user['name'],date("d/m/Y h:i",$row_order['indate']),$buttons));
				}
				$data['content'] = $this->list_table->generate();
				if ($data_row['closed']==0){
					$data_btn['btn_type']='apply';
					$data_btn['url']=base_url($this->controler_name.'/apply/'.$id);
					$buttons = $this->load->view('button',$data_btn,true);
					$data['content'] .= $buttons;
				}
			}
			else {
				$data['content'] = $this->get_alert("عفواً لا يوجد لديك أي طلبات لهذا المنتج  .");
			}
		}
		else {
			$message = "رقم العنصر غير صحيح !!!";
			$this->alert($message,'e');
			redirect("products");
		}
		
		$this->render_page('page', $data);
		
	}
	
	function all_orders(){
		$this->load->model('data_model','orders');
		$this->orders->set_table('orders');
// 		$this->sub_menu = '';
		$this->pagetitle = "عرض جميع الطلبات في الانتظار  : ";
		$rows = $this->orders->getwhere('sticky',0);
		$this->load->library('list_table');
			
		$content='';
		$offset = 0;
		if (count($rows)>0) {
			$this->list_table->set_heading(array('م','اسم العضو','اسم المنتج','السعر','تاريخ الطلب', 'عمليات'));
			foreach ($rows as $row){
					
				$offset++;
				$row_order = $this->orders->get($row['id']);
				$product_row = $this->products->get($row_order['product_id']);
				$row_user = $this->users->get($row_order['user_id']);
				if ($row_order['sticky'] == 0) {
					$data_btn['btn_type']='delete';
					$data_btn['url']=base_url('orders/delete100/'.$row_order['id']);
					$buttons = $this->load->view('button',$data_btn,true);
					$data_btn['btn_type']='applyone';
					$data_btn['url']=base_url('products/applyone/'.$row_order['id']);
					$buttons .= $this->load->view('button',$data_btn,true);
				}
// 				else {
// 					$buttons = "تم اعتماد الطلب";
// 				}
				$this->list_table->add_row(array($offset,$row_user['name'],$product_row['name'],$product_row['price'],date("d/m/Y h:i",$row_order['indate']),$buttons));
			}
			$data['content'] = $this->list_table->generate();
// 			if ($data_row['closed']==0){
// 				$data_btn['btn_type']='apply';
// 				$data_btn['url']=base_url($this->controler_name.'/apply/'.$id);
// 				$buttons = $this->load->view('button',$data_btn,true);
// 				$data['content'] .= $buttons;
// 			}
		}
		else {
			$data['content'] = $this->get_alert("عفواً لا يوجد أي طلبات في الانتظار   .");
		}
		$this->render_page('page', $data);
	}
	
	function apply($id,$confirm=0){
		$id = intval($id);
		$row_product = $this->products->get($id);
		if(is_array($row_product)){
			if ($confirm ==1){
				$this->db->query("UPDATE products SET closed=1 WHERE id='$id';");
				$this->db->query("UPDATE orders SET sticky=1 WHERE product_id='$id';");
				redirect("products/orders/".$id);
			}
			else {
				$data_row['func'] = 'apply';
				$data_row['id'] = $id;
				$data_row['message'] = "هل ترغب في تأكيد جميع طلبات الاأعضاء لهذا المنتج : ".$row_product['name'] .'؟';
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
// 		$this->render_page('page', $data);
	}
	
	function applyone($order_id){
		$this->db->query("UPDATE orders SET sticky=1 WHERE id='$order_id';");
		redirect("products/all_orders");
	}
	
	function getimgs($id){
		$this->load->model('data_model','imgs');
		$this->imgs->set_table('imgs');
		$rows = $this->imgs->getwhere('product_id',$id);
		if (count($rows)>0)
		{
			$data =  array();
			foreach ($rows as $row){
				$data[] = $this->imgs->get($row['id']);
			}
			return $data;
		}
		else {
			return FALSE;
		}
	}
	
}
