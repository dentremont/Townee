<?php

class Tweets extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if( ! $this->tool->isLoggedIn() ) {
			redirect('users/login');
		}
	}
	
	function hide()
	{
		$tweet_id = base64_decode($this->uri->segment(3));
		// Check ownership
		$this->Posts_m->hide_tweet($tweet_id);
		redirect('/dash');
	}
	
}