<?php 

class Locations_m extends CI_Model {
	
	private $table = "locations";
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
	
	function get_locations()
	{
		$this->query = $this->db->select('*');
		$this->query = $this->db->from($this->table);
		$this->query = $this->db->order_by('name', 'asc'); 
		$this->query = $this->db->get();
		return $this->_return('select');
	}
	
	function get_location_name($lid)
	{
		$this->query = $this->db->select('name');
		$this->query = $this->db->from($this->table);
		$this->query = $this->db->where('lid', $lid);
		$this->query = $this->db->get();
		return array_shift($this->_return('select'))->name;
	}
	
	function get_locations_for_search()
	{
		$this->query = $this->db->select(array('lid','bounds'));
		$this->query = $this->db->from($this->table);
		$this->query = $this->db->get();
		return $this->_return('select');
	}

}
	