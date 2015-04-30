<?php
include_once 'secure.php';
class Orders extends Secure {
	var $perm = 1100;
	function __construct(){
		parent::__construct();
		
		$this->pagetitle = "طلباتي";	
		$this->sub_menu = array();
		$this->controler_name = strtolower(__CLASS__);
		$this->load->model('data_model','products');
		$this->products->set_table('products');
		$this->load->model('data_model','orders');
		$this->orders->set_table('orders');
	}
	
	
	function index(){
// 		exit("__LINE__ : ".__LINE__);
		if(($this->users->is_perm($this->perm))){
			redirect("secure/permission_not_allowed");
		}
// 		exit("__LINE__ : ".__LINE__);
		$this->orders->order_by_field = "indate";
		$this->orders->order_type = "desc";
		$rows = $this->orders->getwhere('user_id',$this->_UserID);
		$this->load->library('list_table');
		
		$content='';
		$offset = 0;
		if (count($rows)>0) {
			$this->list_table->set_heading(array('م','اسم المنتج','تاريخ الطلب','السعر', 'عمليات'));
			foreach ($rows as $row){
				$offset++;
				$row_order = $this->orders->get($row['id']);
				$row_product = $this->products->get($row_order['product_id']);
				if ($row_order['sticky'] == 0) {
					$data_btn['btn_type']='delete';
					$data_btn['url']=base_url(''.$this->controler_name.'/delete/'.$row_order['id']);
					$buttons = $this->load->view('button',$data_btn,true);
				}
				else {
					$buttons = "تم اعتماد الطلب";
				}
				$this->list_table->add_row(array($offset,$row_product['name'],date("d/m/Y h:i",$row_order['indate']),$row_product['price'].' ريال سعودي',$buttons));
			}
			$data['content'] = $this->list_table->generate();
// 			$data['content'] = $content;
		}
		else {
			$data['content'] = $this->get_alert("عفواً لا يوجد لديك أي طلبات مسبقاً  .");
		}
		$this->render_page('page', $data);
	}
	
	function add($id,$confirm=0){
		if(($this->users->is_perm($this->perm))){
			redirect("secure/permission_not_allowed");
		}
		$data_row = $this->products->get($id);
		if (is_array($data_row)) {
			$product_name = $data_row['name'];
			if ($confirm == 1) {
				$indate = time();
				$user_id = $this->_UserID;
				$sql = "INSERT INTO orders SET user_id='$user_id',product_id='$id',indate='$indate',sticky=0;";
// 				exit($sql);
				$this->db->query($sql);
				$message = "تم إضافة المنتج : ".$product_name."إلى قائمة الطلبات لديك";
				$this->alert($message,'i');
				$this->SendMail($product_name);
				redirect("market");
			}
			else {
				$data_row['mode'] = 'delete';
				$data_row['id'] = $id;
				$data_row['func'] = "add";
				$data_row['message'] = "ستم إضافة المنتج : ".$product_name ." إلى قائمة الطلبات لديك هل أنت متأكد ؟";
				$data_row['controler_name'] = $this->controler_name;
				$data['content'] = $this->load->view('confirm', $data_row,true);
				$this->render_page('page', $data);
			}
		}
		else{
			$message = "رقم العنصر غير صحيح !!!";
			$this->alert($message,'e');
			redirect("market");
		}
// 		$this->render_page('page', $data);
	}
	
	function delete($id,$confirm=0){
		if(($this->users->is_perm($this->perm))){
			redirect("secure/permission_not_allowed");
		}
		$content = '';
		$where = array(
				'id'=>$id,
				'user_id'=>$this->_UserID
		);
		$data_row = $this->orders->getwhere($where);
		
		if (count($data_row)>0) {
// 			print_r($data_row);
			$data_row = $this->orders->get($data_row[0]['id']);
			$row_product = $this->products->get($data_row['product_id']);
			if ($confirm ==1){
				$result = $this->orders->delete($id);
				if ($result) {
					$this->alert("تم الحذف بنجاح : " . $row_product['name'],'s');
				}
				else {
					$this->alert("لم يتم الحذف بنجاح ",'e');
				}
				redirect("orders");
			}
			else {
				$data_row['mode'] = 'delete';
				$data_row['id'] = $id;
				$data_row['message'] = "هل ترغب في حذف الطلب : ".$row_product['name'];
				$data_row['controler_name'] = $this->controler_name;
				$data['content'] = $this->load->view('confirm', $data_row,true);
				$this->render_page('page', $data);
			}
		}
		else {
			$message = "رقم العنصر غير صحيح !!!";
			$this->alert($message,'e');
			redirect("orders");
		}
	}
	
	function delete100($id,$confirm=0){
		if(($this->users->is_perm($this->perm))){
			redirect("secure/permission_not_allowed");
		}
		$content = '';
		$where = array(
				'id'=>$id,
		);
		$data_row = $this->orders->getwhere($where);
		
		if (count($data_row)>0) {
// 			print_r($data_row);
			$data_row = $this->orders->get($data_row[0]['id']);
			$row_product = $this->products->get($data_row['product_id']);
			if ($confirm ==1){
				$result = $this->orders->delete($id);
				if ($result) {
					$this->alert("تم الحذف بنجاح : " . $row_product['name'],'s');
				}
				else {
					$this->alert("لم يتم الحذف بنجاح ",'e');
				}
				redirect("orders");
			}
			else {
				$data_row['mode'] = 'delete';
				$data_row['id'] = $id;
				$data_row['message'] = "هل ترغب في حذف الطلب : ".$row_product['name'];
				$data_row['controler_name'] = $this->controler_name;
				$data['content'] = $this->load->view('confirm', $data_row,true);
				$this->render_page('page', $data);
			}
		}
		else {
			$message = "رقم العنصر غير صحيح !!!";
			$this->alert($message,'e');
			redirect("orders");
		}
	}
	
	function SendMail($product_name){
		$this->config->load('emails');
		$to = $this->config->item('email_orders');
		$username = $this->_UserScreenName;
		$product_name = trim($product_name);
		$this->load->library('email');
		
		$this->email->from('souq@alaqsa.edu.sa', 'Alaqsa Souq');
		$this->email->to($to);
		
		$this->email->subject('طلب جديد');
		$message =<<<EOF
		يوجد طلب جديد على الموقع بخصوص المنتج : 
		$product_name
		والذي يخص العضو : 
		$username
EOF;
		$this->email->message($message);
		
		$this->email->send();
	}
	
	 
	
}