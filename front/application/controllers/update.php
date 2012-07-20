<?php
/*
	The task class is run via cron to frequently update the database.
*/
class Update extends CI_Controller {

	var $data;
	
	function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler(TRUE);	
	}
	
	function sub()
	{
		if( $this->data['domain'] = $this->tool->validDomain() ) {
			echo $this->data['domain']->lid." is a valid subdomain!";
		} else {
			echo "Invalid subdomain";
		}
	}

	function test()
	{
//		$tag = "deals";
//		$location = "2434560";
//		$limit = 2;
//		$posts = $this->Posts_m->get_tweets_with_authors($tag, $location, $limit=null);
//		print_r($posts);
		
		$tag = $this->Tags_m->get_tag('1');
		print_r($tag);

	}


	function twitter()
	{
		// Load //
		$this->load->library('twitter');
		$this->twitter->auth('davidentremont', 'stpeter0527');
		// Get Items to be updated //
		$tags = $this->Tags_m->get_tags();
		
		// Process items //
		foreach($tags as $tag) {
			if($tag->last_search) {
				$tweets = $this->twitter->search('search', array(
					'q' => '%23'.$tag->hashtag, 
					'geocode' => $tag->geo.$tag->radius.'mi', 
					'result_type' => 'recent', 
					'rpp' => '100', 
					'since_id' => $tag->last_search
				));
			} else {
				$tweets = $this->twitter->search('search', array(
					'q' => '%23'.$tag->hashtag, 
					'geocode' => $tag->geo.$tag->radius.'mi', 
					'result_type' => 'recent', 
					'rpp' => '100'
				));
			}
			$results = $tweets->results;
			//print_r($results);
			//print_r($tags);
			if($results) {
				foreach($results as $tweet) {
					$this->Posts_m->insert_tweet($tweet, $tag);
				}
				$this->Tags_m->record_last_search($tag, $results[0]);
			}
		}
		$status = $this->twitter->call('account/rate_limit_status');
		print_r($status);
	}
	
	
	
}

/* End of file task.php */
