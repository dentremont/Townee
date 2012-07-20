<?php 

class Site_m extends CI_Model {
	
	private $table = "options";
	private $query;
	
	function __construct() 
	{
		parent::__construct();
	}

	function _return($type)
	{
		if($type == 'select')
		{
			if ($this->query->num_rows() > 0) {
				return $this->query->result();
			} else {
				return false;
			}
		} 
		elseif($type == 'insert')
		{
			if($this->db->affected_rows() > 0) {
				return mysql_insert_id();
			} else {
				return false;
			}
		} 
		else 
		{
		
		}
	}
	
	function get_option($option = '')
	{
		$this->query = $this->db->select('option_value');
		$this->query = $this->db->from($this->table);
		$this->query = $this->db->where('option_name', $option);
		$this->query = $this->db->get();
		return array_shift($this->_return('select'))->option_value;
	}
	
	function set_option($option = '', $value = '')
	{
	
	}
	
	function new_option($option = '', $value = '')
	{
	
	}

}
	