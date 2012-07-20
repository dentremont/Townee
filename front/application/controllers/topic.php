<?php

class Topic extends CI_Controller {

	public $message;
	public $location;
	public $location_list;
	public $user = null;
	public $title = "Town.ee - Beta";
	public $classes = "board";
	public $partial = "board";
	public $widgets;

	function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
		if( $this->session->userdata('uid') ) {
			$this->user = $this->Users_m->get_user_by_id($this->session->userdata('uid'));
		}
		$this->location = $this->tool->set_location();
		$this->location_list = $this->Locations_m->get_locations();
	}
	
	function _widgets($tags)
	{
		// Load favorites as panels //
		$widgets = array();
		if(!empty($tags)) {
			foreach($tags as $tag) {
				$widgets[$tag->tid]['info'] = $this->Tags_m->get_tag($tag->tid);
				$widgets[$tag->tid]['content'] = $this->Posts_m->get_tweets_with_authors($widgets[$tag->tid]['info'], 10);
			}
		} else {
			return false;
		}
		return $widgets;
	}
	
	function _view()
	{
		$view = array(
			'page_title' => $this->title,
			'body_classes' => $this->classes,
			'partial' => $this->partial,
			'widgets' => $this->widgets,
			'user' => $this->user,
			'locations' => $this->location_list,
			'location' => $this->location,
			'message' => $this->message
		);
		$this->load->view('templates/layout1', $view);
	}
	
	function food()
	{
		$this->title = "Food | Town.ee";
		$tags = $this->Tags_m->get_tags_for_category(3, $this->location);
		// Load favorites as panels //
		$this->widgets = $this->_widgets($tags);
		$this->_view();
	}
	
	function lifestyle()
	{
		$this->title = "Lifestyle | Town.ee";
		$tags = $this->Tags_m->get_tags_for_category(5, $this->location);
		// Load favorites as panels //
		$this->widgets = $this->_widgets($tags);
		$this->_view();
	}
	
	function entertainment()
	{
		$this->title = "Entertainment | Town.ee";
		$tags = $this->Tags_m->get_tags_for_category(1, $this->location);
		// Load favorites as panels //
		$this->widgets = $this->_widgets($tags);
		$this->_view();
	}
	
	function business()
	{
		$this->title = "Business | Town.ee";
		$tags = $this->Tags_m->get_tags_for_category(2, $this->location);
		// Load favorites as panels //
		$this->widgets = $this->_widgets($tags);
		$this->_view();
	}
	
	function sports()
	{
		$this->title = "Sports | Town.ee";
		$tags = $this->Tags_m->get_tags_for_category(4, $this->location);
		// Load favorites as panels //
		$this->widgets = $this->_widgets($tags);
		$this->_view();
	}
	
	function favorites()
	{
		$this->title = "Town Favorites | Town.ee";
		$tags = $this->Tags_m->get_popular_tags($this->location);
		if( ! $this->widgets = $this->_widgets($tags)) {
			$this->message = "No favorites here.";
		}
		
		$this->_view();
	}
	
	function recent()
	{
		$this->title = "Recent | Town.ee";
		$tags = $this->Tags_m->get_recent_tags($this->location, $limit = 6);// Load favorites as panels //
		$this->widgets = $this->_widgets($tags);
		$this->_view();
	}	
}