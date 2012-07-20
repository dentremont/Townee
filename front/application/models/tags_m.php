<?php 

class Tags_m extends CI_Model {
	
	private $table1 = "tags";
	private $table2 = "categories";
	private $table3 = "locations";
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
	
	function get_tags() 
	{
		$this->query = $this->db->select();
		$this->query = $this->db->from($this->table1);
		$this->query = $this->db->join($this->table3, $this->table3.'.lid = '.$this->table1.'.locations_id');
		$this->query = $this->db->get();
		return $this->_return('select');
	}
	
	function get_tags_for_location($lid) 
	{
		$this->query = $this->db->select();
		$this->query = $this->db->from($this->table1);
		$this->query = $this->db->where('locations_id', $lid);
		$this->query = $this->db->get();
		return $this->_return('select');
	}
	
	function get_tag($id)
	{
		$this->query = $this->db->select('*');
		$this->query = $this->db->from($this->table1);
		$this->query = $this->db->where('tid', $id);
		$this->query = $this->db->get();
		if($this->_return('select')) {
			return array_shift($this->_return('select'));
		} else {
			return false;
		}
	}
	
	function get_tag_name($id) {
		$this->query = $this->db->select('name');
		$this->query = $this->db->from($this->table1);
		$this->query = $this->db->where('tid', $id);
		$this->query = $this->db->get();
		$result = array_shift($this->_return('select'));
		return $result->cat_name;
	}
	
	function get_parents()
	{
		$this->query = $this->db->get($this->table2);
		return $this->_return('select');
	}
	
	function get_parent_by_id($cid)
	{
		$this->query = $this->db->select();
		$this->query = $this->db->from($this->table2);
		$this->query = $this->db->where('cid', $cid);
		$this->query = $this->db->get();
		return $this->_return('select');
	}
	
	function add_tag($data)
	{
		$this->query = $this->db->insert($this->table1, $data);
		return $this->_return('insert');
	}
	
	function promoted_tags($lid)
	{
		$this->query = $this->db->select('tid');
		$this->query = $this->db->from($this->table1);
		$this->query = $this->db->where('promoted', 1);
		$this->query = $this->db->where('locations_id', $lid);
		$this->query = $this->db->limit(6);
		$this->query = $this->db->order_by('weight', 'asc');
		$this->query = $this->db->get();
		if ($this->query->num_rows() > 0) {
			$result = $this->query->result();
			$tags = array();
			foreach($result as $tag) {
				$tags[] = $tag->tid;
			}
		} else {
			$tags = false;
		}
		return $tags;	
	}
	
	function get_tags_for_category($cid, $lid)
	{
		$this->query = $this->db->select('tid');
		$this->query = $this->db->from($this->table1);
		$this->query = $this->db->where('parent_id', $cid);
		$this->query = $this->db->where('locations_id', $lid);
		$this->query = $this->db->get();
		return $this->_return('select');
	}
	
	function record_last_search($tag, $tweet) {
		$this->query = $this->db->where('tid', $tag->tid);
		$this->query = $this->db->update($this->table1, array('last_search' => $tweet->id_str));
	}
	
	function tag_exists($tag, $location)
	{
		$this->query = $this->db->select('hashtag');
		$this->query = $this->db->from($this->table1);
		$this->query = $this->db->where('hashtag', $tag);
		$this->query = $this->db->where('locations_id', $location);
		$this->query = $this->db->get();
		if ($this->query->num_rows() > 0) {
			$result = true;
		} else {
			$result = false;
		} 
		return $result;
	}
	
	function get_recent_tags($lid, $limit)
	{
		$this->query = $this->db->select('tid');
		$this->query = $this->db->from($this->table1);
		$this->query = $this->db->where('locations_id', $lid);
		$this->query = $this->db->order_by('created_at', 'desc');
		$this->query = $this->db->limit($limit);
		$this->query = $this->db->get();
		return $this->_return('select');
	}
	
	function get_popular_tags($lid)
	{
		$this->query = $this->db->select('favorites');
		$this->query = $this->db->from('users');
		$this->query = $this->db->where('favorites !=', 'NULL');
		$this->query = $this->db->where('locations_id', $lid);
		$this->query = $this->db->get();
		$results = $this->query->result();
		if($this->query->num_rows() > 0) {
			$fav_array = array();
			foreach($results as $row) {
				$rowFavs = unserialize($row->favorites);
				foreach($rowFavs as $fav) {
					array_push($fav_array, $fav);
				}
			}
			$counted = array_count_values($fav_array);
			asort($counted);
			$counted = array_reverse($counted, TRUE);
			$data = array();
			foreach($counted as $key => $value) {
				$data[] = $key;
			}
			$count = count($data);
			if($count > 6) {
				$count = 6;
			}
			$set = array();
			for($i=0; $i<$count; $i++) {
				$set[] = (object)array("tid" => array_shift($data));
			}
			return $set;
		}
		return false;
	}
	
}