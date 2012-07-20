<?php 

class Users_m extends CI_Model {
	
	private $table = "users";
	private $query;
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function create_user($username='', $password='', $email='', $location='')
	{
		
		$uid = time();
		$data = array(
			'uid' => $uid,
			'username' => $username,
			'password' => md5($password),
			'email' => $email,
			'locations_id' => $location,
			'favorites' => null
		);
		$this->query = $this->db->insert($this->table, $data);
		if($this->query) {
			return $uid;
		} else {
			return false;
		}
	}
	
	function email_exists($email)
	{
		$this->query = $this->db->select('email');
		$this->query = $this->db->from($this->table);
		$this->query = $this->db->where('email', $email);
		$this->query = $this->db->get();
		if ($this->query->num_rows() > 0) {
			$result = true;
		} else {
			$result = false;
		} 
		return $result;
	}
	
	function get_user_by_id($user_id)
	{
		$this->query = $this->db->select('*');
		$this->query = $this->db->from($this->table);
		$this->query = $this->db->where('uid', $user_id);
		$this->query = $this->db->get();
		if ($this->query->num_rows() > 0) {
			return array_shift($this->query->result());
		} else {
			return false;
		}
	}
	
	function update_user($user)
	{
		$this->query = $this->db->where('uid', $user['uid']);
		$this->query = $this->db->update($this->table, $user);
	}
	
	function save_favorites($faves)
	{
		$data = serialize($faves);
		if($data == 'a:1:{i:0;s:1:"0";}') {
			$data = NULL;
		}
		$user_id = $this->session->userdata('uid');
		$this->query = $this->db->where('uid', $user_id);
		$this->query = $this->db->update($this->table, array('favorites' => $data));
	}
	
}
