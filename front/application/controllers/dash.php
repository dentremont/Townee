<?php
/*
	The dashboard will be a users place for displaying his favorite tags.
*/
class Dash extends CI_Controller {

	var $data;
	public $message = '';
	public $location;
	public $location_list;
	public $user;
	public $title = "Town.ee";
	public $classes = "dashboard";
	public $partial = "dashboard";
	public $widgets;
	public $tags;
	
	function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
		if( ! $this->tool->isLoggedIn() ) {
			redirect('users/login');
		}
		// Get user //
		$this->user = $this->session->userdata('uid');
		$this->user = $this->Users_m->get_user_by_id($this->user);
		
		// Location
		$this->location = $this->tool->set_location();
		$this->location_list = $this->Locations_m->get_locations();
		
		// Load
		$this->load->library('form_validation');
		$this->tags = $this->Tags_m->get_tags_for_location($this->user->locations_id);
	}
	
	function index()
	{		
		if($this->user->favorites) {
			$favorites = unserialize($this->user->favorites);
		} else {
			$favorites = array(0 =>'1', 1 =>'7', 2 =>'9');
		}
		$tags = $this->tags;
		$categories = $this->Tags_m->get_parents();
		
		// Load favorites as panels //
		$widgets = array();
		foreach($favorites as $favorite) {
			if($tag = $this->Tags_m->get_tag($favorite)) {
				$widgets[$favorite]['info'] = $tag;
				$widgets[$favorite]['content'] = $this->Posts_m->get_tweets_with_authors($widgets[$favorite]['info'],10);
			}
		}
		
		/// Check for POST
		if(isset($_POST['addTag'])) {
			$this->form_validation->set_rules('hashtag', 'Hashtag', 'required|callback_duplicate_check');
			$this->form_validation->set_rules('name', 'Title', 'required');
			// Run Validation //
			if($this->form_validation->run() == FALSE) {
				// Validation failure //
			} else {
				$data = array(
					'hashtag' => $this->input->post('hashtag'),
					'name' => $this->input->post('name'),
					'locations_id' => $this->user->locations_id,
					'meta' => $this->input->post('description'),
					'owner' => $this->session->userdata('uid'),
					'parent_id' => $this->input->post('category')
				);
				if(!$this->Tags_m->add_tag($data)) {
					$this->session->set_flashdata('message', 'Failed to add a category.');
				}
			}
		}
				
		$view = array(
			'page_title' => 'Town.ee | Beta',
			'body_classes' => 'dashboard',
			'partial' => 'dashboard',
			'widgets' => $widgets,
			'user' => $this->user,
			'tags' => $tags,
			'user_favs' => $favorites,
			'categories' => $categories,
			'locations' => $this->location_list,
			'location' => $this->location
		);
		$this->load->view('templates/layout1', $view);
	}
	
	function favorites()
	{
		if(isset($_POST['favorites'])) {
			if(!isset($_POST['fav'])) {
				$faves = array(0 => '0');
			} else {
				$faves = $_POST['fav'];
			}
			if($this->Users_m->save_favorites($faves)) {
				$this->session->set_flashdata('message', 'Favorites saved! :)');
				redirect('/dash');
			} else {
				$this->session->set_flashdata('message', 'Failed to save your favorites :(');
				redirect('/dash');
			}
		}
	}
	
	function duplicate_check($str)
	{
		$location = $this->user->locations_id;
		if($this->Tags_m->tag_exists($str, $location)) {
			// Email already exists //
			$this->form_validation->set_message('duplicate_check', 'This hashtag already exists for your town. Try another.');
			$result = false;
		} else {
			$result = true;
		}
		return $result;
	}
	
}

/* End of file dashboard.php */
