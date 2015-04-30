<?php
include_once 'secure.php';
class Market extends Secure {
	var $perm = 1100;
	function __construct(){
		parent::__construct();
		
		$this->pagetitle = "المعرض";	
		$this->sub_menu = array();
		$this->controler_name = strtolower(__CLASS__);
		$this->load->model('data_model','products');
		$this->products->set_table('products');
		$this->load->model('data_model','cats');
		$this->cats->set_table('cats');
	}
	
	
	function index($offset=0){
		if(($this->users->is_perm($this->perm))){
			redirect("secure/permission_not_allowed");
		}
		$this->products->order_by_field = "id";
		$this->cats->order_by_field = "id";
		$where = array('active'=>1);
		$rows = $this->cats->getwhere($where);
		
		$content='';
		if (count($rows)>0) {
			
			foreach ($rows as $row){
				$offset++;
				$data_row = $this->cats->get($row['id']);
				
				
				$where = array(
						'closed'=>0,
						'cat_id'=>$row['id']
				);
				$rows = $this->products->getwhere($where);
				
				$data_row['counts'] = count($rows);
				if ($data_row['counts']>0) {
					$content .= $this->load->view('product_market_cats', $data_row,true);
				}
				
			}
			$data['content'] = $content;
		}
		
		
		$where = array(
				'closed'=>0,
				'homepage'=>1
		);
		$rows = $this->products->getwhere($where);
		
		$content='';
		if (count($rows)>0) {
			$data['content'] .= '<div class="col-lg-12"></>';
			foreach ($rows as $row){
				$offset++;
				$data_row = $this->products->get($row['id']);	
				$content .= $this->load->view('product_market', $data_row,true);
			}
			$data['content'] .= $content;
		}
		
		$this->render_page('page', $data);
	}
	
	function cats($id){
		$this->products->order_by_field = "id";
		$where = array(
				'closed'=>0,
				'cat_id'=>$id
		);
		$rows = $this->products->getwhere($where);
		
		$content='';
		if (count($rows)>0) {
			$data['content'] .= '<div class="col-lg-12"></>';
			foreach ($rows as $row){
				$data_row = $this->products->get($row['id']);
				$content .= $this->load->view('product_market', $data_row,true);
			}
			$data['content'] .= $content;
		}
		else {
			$data['content'] .= "لا يوجد منتجات في هذا القسم !!";
		}
		
		$this->render_page('page', $data);
	}
	
	

	function view($id){
		if(($this->users->is_perm($this->perm))){
			redirect("secure/permission_not_allowed");
		}
		$content = '';
		$data_row = $this->products->get($id);
		if (is_array($data_row)) {
			$query = $this->db->query("SELECT id FROM orders WHERE product_id='$id'");
			$data_row['no_orders'] = intval($query->num_rows());
			$data_row['imgs'] = $this->getimgs($id);
			$data['content'] = $this->load->view('product_view', $data_row,true);
			
		}
		else {
			$message = "الرابط الذي تحاول الوصول إليه غير صحيح !!!";
			$this->alert($message,'e');
			redirect("market");
		}
		
		$this->render_page('page', $data);
		
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
