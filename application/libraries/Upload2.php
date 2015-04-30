<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Upload2 {
	private $CI ;
	private $dir_upload;
	private $error;
	function __construct(){
		$this->CI =& get_instance();
		$this->dir_upload = $this->CI->config->item('upload_path');
		$config['upload_path'] = $this->dir_upload;//'';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|';
		$config['max_size']	= $this->max_filesize_byte();
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['encrypt_name']  = TRUE;
		$this->CI->load->library('upload', $config);
	}
	
	function do_upload($field_name){
		
		if ( ! $this->CI->upload->do_upload($field_name))
		{
			$this->error = $this->CI->upload->display_errors();
			return false;
		}
		else
		{
			$file_info =  $this->CI->upload->data();
			$file_info['file_full_path'] = $this->dir_upload.$file_info['file_name'];
			return $file_info;
		}
	}
	
	function get_error(){
		return $this->error;
	}
	
	function max_filesize_byte(){
		$upload_max_filesize = ini_get("upload_max_filesize");
		$upload_max_filesize = trim($upload_max_filesize);
		$last = strtolower($upload_max_filesize[strlen($upload_max_filesize)-1]);
		switch($last) {
			// The 'G' modifier is available since PHP 5.1.0
			case 'G':
			case 'g':
				$upload_max_filesize *= 1024;
			case 'M':
			case 'm':
				$upload_max_filesize *= 1024;
			case 'K':
			case 'k':
				$upload_max_filesize *= 1024;
		}
		
		return $upload_max_filesize;
	}
}

