<?php
class Secure extends CI_Controller {
	public $_UserScreenName ='';
	public $_UserID ='';
	public $pagetitle ='لوحة التحكم';
	public $controler_name ='';
	public $rows_per_page = 20;
	public $sub_menu=array();
	
	public function __construct() {
		parent::__construct ();
		
		$this->load->model('users_model','users');
		$this->users->set_table('users');
		
		if (! $this->users->is_login ()) {
			$url=base64_encode($_SERVER['REQUEST_URI']);
			$url = str_replace("=", '', $url);
// 			$url=($_SERVER['REQUEST_URI']);
			redirect ( 'login' );
		} else {
			// 			print_r($this->input->cookie);
			$this->_UserScreenName = $this->session->userdata( 'username' );
			$this->_UserID = $this->session->userdata ( 'user_id' );
		}
		
	}
	
	public function index(){
// 		$data =array();
// 		$data['pagetitle'] = "##pagetitle##";
		$data['content'] = "@@Admin Home Content@@";
		$this->render_page('page', $data);
	}
	
	
	public function render_page($view_file, $data=array()) {
		
		$data['username']=$this->_UserScreenName;
		$data['pagetitle']=$this->pagetitle;
		$data['sub_menu']=$this->sub_menu;
// 		$this->load->library('template');
// 		$data['user_name'] = "";

		
// 		$data['cur_page'] = 11;
		$data['controler_name'] = strtolower($this->controler_name);
		$data['permissions'] = $this->users->get_user_permissions($this->_UserID);
// 		print_r($data);

		$this->template->set_template("admin");
		$this->template->write_view ( 'content', $view_file, $data );
		$this->template->render ();
	}
	
	public function permission_not_allowed(){
		$message = "يبدو أنه ليس لديك صلاحية للوصول لهذه الصفحة !!";
		$this->pagetitle = "وصول غير مسموح !!";
		$data['content'] = $message;
		$this->render_page('page',$data);
	}
	
	public function errorpage($text){
		$this->pagetitle = "رسالة خطأ";
		$data['content'] = $text;
		$this->render_page('page',$data);
	}
	

	public function table_array($table){
		$this->load->model('data_model','tabledata');
		$this->tabledata->set_table($table);
		$ids = $this->tabledata->getrows(0,1000);
		$rows = array();
		foreach ($ids as $id){
			$row = $this->tabledata->get_selected($id['id'],'id,name');
			$rows[$row['id']] = $row['name'];
		}
		return $rows;
	}
	
	public function pagination($total_rows,$offset,$base_url=''){
		$this->load->library('pagination');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $this->rows_per_page;
		$config['base_url'] = $base_url;
		if (strlen($base_url)==''){
			$config['base_url'] = base_url($this->controler_name."/index/");
		}
		$config['prev_link'] = 'السابق';
		$config['next_link'] = 'التالي';
		$config['last_link'] = 'الأخير';
		$config['first_link'] = 'الأول';
		$config['num_tag_open'] = '<div class="btn btn-invert">';
		$config['num_tag_close'] = '</div>';
		$config['prev_tag_open'] = '<div class="btn btn-invert">';
		$config['prev_tag_close'] = '</div>';
		$config['next_tag_open'] = '<div class="btn btn-invert">';
		$config['next_tag_close'] = '</div>';
		$config['last_tag_open'] = '<div class="btn btn-invert">';
		$config['last_tag_close'] = '</div>';
		$config['first_tag_open'] = '<div class="btn btn-invert">';
		$config['first_tag_close'] = '</div>';
		$config['last_tag_open'] = '<div class="btn btn-invert">';
		$config['last_tag_close'] = '</div>';
		
		$config['cur_tag_open'] = '<div class="btn btn-primary">';//
		$config['cur_tag_close'] = '</div>';
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		return  $this->pagination->create_links();
	}
	
	public function alert($message,$type='i'){
		switch ($type){
			case "e":
				$message_type = "alert-danger";
				break;
			case "s":
				$message_type = "alert-success";
				break;
			default:
				$message_type = "alert-info";
				break;
				
		}
//		$this->session->keep_flashdata('message');
		
		$message2 = $this->session->flashdata('message');
		echo $message2;
		$message2 = (strlen($message2)>0)?$message2."<br>":"";
		$this->session->set_flashdata('message', $message2.$message);
		$this->session->set_flashdata('message_type', $message_type);
	}
	
	public function get_alert($message,$type='i'){
		
		switch ($type){
			case "e":
				$message_type = "alert-danger";
				break;
			case "s":
				$message_type = "alert-success";
				break;
			default:
				$message_type = "alert-info";
				break;
				
		}
		$data['message'] = $message;
		$data['message_type'] = $message_type;
		return  $this->load->view('alert', $data, true);
	}
	
	public function current_url()
	{
// 		$CI =& get_instance();
	
		$url = $this->config->site_url($CI->uri->uri_string());
		echo $url;
		return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
	}
	
	
}