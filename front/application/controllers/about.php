<?php

class About extends CI_Controller {
	
	public $location;
	public $location_list;
	
	function __construct()
	{
		parent::__construct();
		
		if( $this->session->userdata('uid') ) {
			$this->user = $this->Users_m->get_user_by_id($this->session->userdata('uid'));
		}
		$this->location = $this->tool->set_location();
		$this->location_list = $this->Locations_m->get_locations();
	}
	
	function index()
	{
		$view = array(
			'page_title' => 'About - Town.ee',
			'body_classes' => 'interior about',
			'header' => 'About Us',
			'partial' => 'about',
			'locations' => $this->location_list
		);
		$this->load->view('templates/layout1', $view);
	}
	
	function participate()
	{
		$view = array(
			'page_title' => 'Participate - Town.ee',
			'body_classes' => 'interior participate',
			'header' => 'Participate',
			'partial' => 'participate',
			'locations' => $this->location_list
		);
		$this->load->view('templates/layout1', $view);
	}
	
	function feedback()
	{
		$this->load->library('form_validation');
		$message ='';
		if(isset($_POST['feedback'])) {
			$this->form_validation->set_rules('description', 'Description', 'required');
			// Run Validation //
			if($this->form_validation->run() == FALSE) {
				// Validation failure //
			} else {
				$message = $this->input->post('description');
				$this->tool->emailUser('david@pixelbrushstudios.com', 'Feedback', $message);
				$message = '<p>Thanks for the feedback!</p>';
			}
		} elseif(isset($_POST['addTown'])) {
		
		}
		
		$view = array(
			'page_title' => 'Feedback - Town.ee',
			'body_classes' => 'interior feedback',
			'header' => 'Feedback',
			'partial' => 'feedback',
			'message' => $message,
			'locations' => $this->location_list
		);
		$this->load->view('templates/layout1', $view);
	}
	
}
