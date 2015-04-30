<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

		$this->load->view('welcome_message');
		// 		$sql = "INSERT INTO dbo.Color (ColorCode,ColorDescAr,ColorDescEn) VALUES ('Red','أحمر','Red');" ;
// 		$query = $this->db->query($sql);
// 		$sql = "INSERT INTO dbo.Color (ColorCode,ColorDescAr,ColorDescEn) VALUES('Yel','أصفر','Yellow');" ;
// 		$query = $this->db->query($sql);
// 		$sql = "INSERT INTO dbo.Color (ColorCode,ColorDescAr,ColorDescEn) VALUES('Grn','أخضر','Green');" ;
// 		$query = $this->db->query($sql);

		
// 		$sql = "SELECT * FROM dbo.Color WHERE ColorDescAr like '%مر%';" ;
// 		$sql = "SELECT * FROM color;" ;
// // 		$query = $this->db->get("Color");
// 		$query = $this->db->query($sql	);
// 		echo "<pre>";
// 		foreach ($query->result() as $row)
// 		{
// 			print_r($row);
// 		}
// 		echo "</pre>";
	}
}


// Name	Info
//  ColorID	int, not null
//  ColorCode	nvarchar(50), not null
//  ColorDescAr	nvarchar(50), not null
//  ColorDescEn	nvarchar(50), null


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */