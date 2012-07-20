<?php

class Feed extends CI_Controller {
	
	function tag($uri)
	{
		if($tag = $this->Tags_m->get_tag($uri)) {
			$item['info'] = $tag;
			$item['content'] = $this->Posts_m->get_tweets_with_authors($tag,10);
		}
		//print_r($item);
		$view = array(
			'items' => $item
		);
		$this->load->view('feed', $view);
	}
	
}

