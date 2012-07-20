<?php

class Tags extends CI_Controller {

	
	function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
		if( ! $this->tool->isLoggedIn() ) {
			redirect('users/login');
		}
	}
	
	function add()
	{	
		if(isset($_POST['addTag'])) {
			$data = array(
				'hashtag' => $this->input->post('hashtag'),
				'name' => $this->input->post('name'),
				'locations_id' => 2434560,
				'meta' => $this->input->post('description'),
				'owner' => $this->session->userdata('uid'),
				'parent_id' => $this->input->post('category')
			);
			if(!$this->Tags_m->add_tags($data)) {
				$this->session->set_flashdata('message', 'Failed to add a category.');
			}
		}
		redirect('/dash');
	}
}