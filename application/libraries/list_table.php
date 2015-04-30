<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class List_table {

	private $_ci;

	function __construct()
	{
		$this->_ci =& get_instance();
		$this->_ci->load->library('table');
	}
	
	function generate(){
		$tmpl = array (
				'table_open'          => '<table class="table table-hover table-striped tablesorter">',
		
				'heading_row_start'   => '<tr>',
				'heading_row_end'     => '</tr>',
				'heading_cell_start'  => '<th class="header">',
				'heading_cell_end'    => '<i class="fa fa-sort"></i></th>',
		
				'row_start'           => '<tr>',
				'row_end'             => '</tr>',
				'cell_start'          => '<td>',
				'cell_end'            => '</td>',
		
				'row_alt_start'       => '<tr>',
				'row_alt_end'         => '</tr>',
				'cell_alt_start'      => '<td>',
				'cell_alt_end'        => '</td>',
		
				'table_close'         => '</table>'
		);
		
		$this->_ci->table->set_template($tmpl);
		
		return $this->_ci->table->generate();
	}
	
	function set_heading($heading = array()){
		$this->_ci->table->set_heading($heading);
	}
	
	function add_row($row=array()){
		$this->_ci->table->add_row($row);
	}
	
}