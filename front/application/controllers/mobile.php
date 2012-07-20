<?php

class Mobile extends CI_Controller {

	var $location = 2434560;
	var $location_list;

	function __construct()
	{
		parent::__construct();
		$this->location = $this->session->userdata('selected_location');
		$this->location_list = $this->Locations_m->get_locations();
	}
	
	function index()
	{
		$categoryArray = $this->Tags_m->get_parents();
		$categories = array();
		foreach($categoryArray as $cat) {
			$categories[$cat->cid]['name'] = $cat->name;
			$children = $this->Tags_m->get_tags_for_category($cat->cid, $this->session->userdata('selected_location'));
			foreach($children as $tag) {
				$categories[$cat->cid]['tags'][$tag->tid] = $this->Tags_m->get_tag($tag->tid);
			}
		}
		//print_r($categories);
		$view = array(
			'partial' => 'home',
			'categories' => $categories,
			'locations' => $this->location_list
		);
		$this->load->view('mobile/template', $view);
	}
	
	function posts($tid)
	{
		$tag = $this->Tags_m->get_tag($tid);
		$posts = $this->Posts_m->get_tweets_with_authors($tag, $this->location, 10);
		//print_r($posts);
		$view = array(
			'partial' => 'posts',
			'tag' => $tag,
			'posts' => $posts
		);
		$this->load->view('mobile/template', $view);
	}
	
	function location()
	{
		if(isset($_POST['location'])) {
			$this->session->set_userdata(array('selected_location' => $_POST['location']));
			return true;
		}
	}
	
}