<?php
class Data_model extends CI_Model {
	private $table_name ='';
	private $field_id_name = 'id';
	private $db_last_error = '';
	private $db_last_error_no = '';
	public $order_by_field = 'id';
	public $order_type = 'desc';
	public $insert_id = '0';
	
	function add($data){
		if ($this->db->insert($this->table_name, $data)){
			$txt = (isset($data['name']) && strlen($data['name'])>0)?" (".$data['name'].") ":'';
			$this->insert_id = $this->db->insert_id();
			return true;
		}
		else{
			$txt = (isset($data['name']) && strlen($data['name'])>0)?" (".$data['name'].") ":'';
			$this->db_last_error = $this->db->_error_message();
			$this->db_last_error_no = $this->db->_error_number();
			return false;
		}
	}
	
	function edit($data,$id){
		$id=intval($id);
		$this->db->where($this->field_id_name, $id);
		$this->db->update($this->table_name, $data);
		
		if ($this->db->affected_rows()>0){
			$txt = (isset($data['name']) && strlen($data['name'])>0)?" (".$data['name'].") ":'';
			return true;
		}
		else{
			$txt = (isset($data['name']) && strlen($data['name'])>0)?" (".$data['name'].") ":'';
			$this->db_last_error = $this->db->_error_message();
			$this->db_last_error_no = $this->db->_error_number();
			return false;
		}
	}
	
	function delete($id){
		$id=intval($id);
		$this->db->where($this->field_id_name, $id);
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows()>0){
			return true;
		}
		else{
			$this->db_last_error = $this->db->_error_message();
			$this->db_last_error_no = $this->db->_error_number();
			return false;
		}
	} 
	
	function get($id){
		$id=intval($id);
		$this->db->where($this->field_id_name, $id);
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() > 0){
			$row = $query->result_array();
			$active_row = $row[0];
			return $active_row;
		}
		else{
			$this->db_last_error = "ID incorrect value";
			$this->db_last_error_no = 1000001;
			return false;
		}
		$this->db_last_error = $this->db->_error_message();
		$this->db_last_error_no = $this->db->_error_number();
		return false;
	}
	
	function get_selected($id,$fields="*"){
		$id=intval($id);
		$this->db->select($fields);
		$this->db->where($this->field_id_name, $id);
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() > 0){
			$row = $query->result_array();
			$active_row = $row[0];
			return $active_row;
		}
		else
		{
			$this->db_last_error = "ID incorrect value";
			$this->db_last_error_no = 1000001;
			return false;
		}
		$this->db_last_error = $this->db->_error_message();
		$this->db_last_error_no = $this->db->_error_number();
		return false;
	}
	
	function getrows($fromRow=0,$limit=1000000){
		$this->db->select($this->field_id_name);
		$this->db->order_by($this->order_by_field,$this->order_type);
		$this->db->limit($limit,$fromRow);
		$query = $this->db->get($this->table_name);
		$rows = $query->result_array();
		return $rows;
	}
	
	function rowscount(){
		$this->db->select($this->field_id_name);
		$query = $this->db->get($this->table_name);
		$rows = $query->result_array();
		return count($rows);
	}
	
	function getwhere($where,$value='',$fromRow=0,$limit=1000){
		$this->db->select($this->field_id_name);
		$this->db->order_by($this->order_by_field,$this->order_type);
		$this->db->limit($limit,$fromRow);
		if (is_array($where)){
			$where_array= $where;
		}
		else {
			$where_array = array($where => $value);
		}
		
		$query = $this->db->get_where($this->table_name, $where_array, $limit, $fromRow);
		
		$rows = $query->result_array();
		return $rows;
	}
	
	function get_error(){
		$this->db_last_error = str_replace("'", "", $this->db_last_error);
		return array(
				'text'=>$this->db_last_error,
				'no'=>$this->db_last_error_no,
		);
	}

	function set_table($table_name){
		$this->table_name = $table_name;
	}
	
	function set_field_id($field_id_name){
		$this->field_id_name = $field_id_name;
	}
	
	function set_order_by($order_by_field){
		$this->order_by_field = $order_by_field;
	}
	
}