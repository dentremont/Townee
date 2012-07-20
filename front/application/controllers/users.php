<?php

class Users extends CI_Controller {

	public $message = '';
	public $locations;

	function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
		
		// Load //
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->locations = $this->Locations_m->get_locations();
	}
	
	function index()
	{
		if( ! $this->tool->isLoggedIn() ) {
			redirect('users/login');
		} else {
			redirect('dash');
		}
	}
	
	function register()
	{		
		if(isset($_POST['register'])) {
			// Validate input //
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
			
			// Run Validation //
			if($this->form_validation->run() == FALSE) {
				// Validation failure //
				
			} else {
				// Validation Success //
				// Get POST data //
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$email = 	$this->input->post('email');
				$location = $this->input->post('location');
				//$location = 2434560;
				$message = '<h1>Welcome to Town.ee!</h1><p>Now you can start tracking hashtags in your town and adding your own.</p><p>Keep this email for your records.<br/>';
				$message .= 'Your email login: ' . $email . '<br/>Your password: ' . $password . '</p>';				
				
				// Create User //
				$user_id = $this->Users_m->create_user($username, $password, $email, $location);
				if( ! $user_id) {
					// There was a problem inserting the user //
					echo "DB ERROR. Could not insert user.";
				} else {
					$this->tool->emailUser($email, "Welcome to Town.ee!", $message);
					// Create session //
					//Destroy old session
					$this->session->sess_destroy();
					
					//Create a fresh, brand new session
					$this->session->sess_create();
					
					//Set session data
					$this->session->set_userdata(array('uid' => $user_id,'username' => $username));
					
					//Set logged_in to true
					$this->session->set_userdata(array('logged_in' => true, 'selected_location' => $location, 'location' => $this->Locations_m->get_location_name($location)));
					
					redirect('/dash');
				}
			}
			
		}
		// Output 
		$view = array(
			'page_title' => 'Town.ee | Real Time buzz in Lafayette, Louisiana',
			'body_classes' => 'register',
			'message' => $this->message,
			'locations' => $this->locations
		);
		$this->load->view('register', $view);
	}
	
	function email_check($str)
	{	
		if($this->Users_m->email_exists($str)) {
			// Email already exists //
			$this->form_validation->set_message('email_check', 'This email address has already been registered.');
			$result = false;
		} else {
			$result = true;
		}
		return $result;
	}
	
	function logout() 
	{
		//Destroy session
		$this->session->sess_destroy();
		redirect('/');
	}
	
	function login()
	{		
		// Load //
		$this->load->library('form_validation');
		$this->load->helper('form');
		
		if(isset($_POST['login'])) {
			// Rules //
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if($this->form_validation->run() == FALSE) {

			} else {
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				
				if ($this->simplelogin->login($email, $password)) {
					redirect("/dash");
				} else {
					$this->message = "Incorrect login.";
				}
			}
			
		}

		// Output 
		// Output 
		$view = array(
			'page_title' => 'Town.ee | Real Time buzz in Lafayette, Louisiana',
			'body_classes' => 'login',
			'message' => $this->message
		);
		$this->load->view('login', $view);
	}

	function settings()
	{
		$user = $this->Users_m->get_user_by_id($this->session->userdata('uid'));

		if(isset($_POST['save'])) {
			// save new user settings
			$this->form_validation->set_rules('username', 'Username', 'required');
			//$this->form_validation->set_rules('password', 'Password', 'required');
			//$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
			
			// Run Validation //
			if($this->form_validation->run() == FALSE) {
				// Validation failure //
				
			} else {
				// Validation Success //
				// Get POST data //
				if($this->input->post('password')) {
					$pass = $this->input->post('password');
				} else {
					$pass = $user->password;
				}
				$data = array(
					'uid' => $user->uid,
					'username' => $this->input->post('username'),
					'password' => md5($pass),
					'locations_id' => $this->input->post('location')
				);
				$this->Users_m->update_user($data);
			}
		}
		
		
		// Output 
		$view = array(
			'page_title' => 'Town.ee - Settings',
			'body_classes' => 'settings',
			'partial' => 'settings',
			'message' => $this->message,
			'user' => $user,
			'locations' => $this->locations
		);
		$this->load->view('templates/layout1', $view);
	}
	
	function favorites()
	{
		if(isset($_POST['favorites'])) {
			$faves = $_POST['favorites'];
			$this->Users_m->save_favorites($faves);
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */