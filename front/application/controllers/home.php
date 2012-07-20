<?php

class Home extends CI_Controller {

	public $location = 2434560;
	public $location_list;
	
	function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
		$this->load->library('user_agent');
		if ($this->agent->mobile() == TRUE){
		    //redirect('mobile');
		}	
		
		$this->location = $this->tool->set_location();
		$this->location_list = $this->Locations_m->get_locations();
	}
	
	function index()
	{	
		$tags = $this->Tags_m->promoted_tags($this->location);
		// Load favorites as panels //
		$widgets = array();
		foreach($tags as $tag) {
			$widgets[$tag]['info'] = $this->Tags_m->get_tag($tag);
			$widgets[$tag]['content'] = $this->Posts_m->get_tweets_with_authors($widgets[$tag]['info'],10);
		}
		$view = array(
			'page_title' => 'Town.ee',
			'body_classes' => 'home',
			'partial' => 'board',
			'widgets' => $widgets,
			'locations' => $this->location_list,
			'location' => $this->location
		);
		$this->load->view('templates/layout1', $view);
	}	
}

/* End of file home.php */
