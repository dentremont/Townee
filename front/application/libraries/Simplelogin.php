<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Simplelogin Class
 *
 * Makes authentication simple
 *
 * Simplelogin is released to the public domain
 * (use it however you want to)
 * 
 * Simplelogin expects this database setup
 * (if you are not using this setup you may
 * need to do some tweaking)
 *  * 
 */
class Simplelogin
{
	var $CI;
	var $user_table = 'users';

	function __construct()
	{
		// get_instance does not work well in PHP 4
		// you end up with two instances
		// of the CI object and missing data
		// when you call get_instance in the constructor
		$this->CI =& get_instance();

		//parent::__construct();
	}

	/**
	 * Login and sets session variables
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function login($email = '', $password = '') {
		//Put here for PHP 4 users
		//$this->CI =& get_instance();		

		//Make sure login info was sent
		if($email == '' OR $password == '') {
			return false;
		}

		//Check if already logged in
		if($this->CI->session->userdata('email') == $email) {
			//User is already logged in.
			return false;
		}
		
		//Check against user table
		$this->CI->db->where('email', $email); 
		$query = $this->CI->db->get_where($this->user_table);
		
		if ($query->num_rows() > 0) {
			$row = $query->row_array(); 
			
			//Check against password
			if(md5($password) != $row['password']) {
				return false;
			}
			
			// Check user status
			
			
			//Destroy old session
			$this->CI->session->sess_destroy();
			
			//Create a fresh, brand new session
			$this->CI->session->sess_create();
			
			//Remove the password field
			unset($row['password']);
			
			//Set session data
			$this->CI->session->set_userdata($row);
			
			//Set logged_in to true
			$this->CI->session->set_userdata(array('logged_in' => true, 'selected_location' => $row['locations_id'], 'location' => $this->CI->Locations_m->get_location_name($row['locations_id'])));			
			//Login was successful			
			return true;
		} else {
			//No database result found
			return false;
		}	

	}

	/**
	 * Logout user
	 *
	 * @access	public
	 * @return	void
	 */
	function logout() {
		//Put here for PHP 4 users
		//$this->CI =& get_instance();		

		//Destroy session
		$this->CI->session->sess_destroy();
	}
}
?>