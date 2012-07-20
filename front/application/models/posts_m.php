<?php 

class Posts_m extends CI_Model {
	
	private $tweets = "tweets";
	private $authors = "authors";
	private $hashtags = "tweet_tags";
	private $query;
	
	function __construct() 
	{
		parent::__construct();
	}

	function get_tweets_with_authors($tag,$limit=null)
	{
		$fields = array('tweets.tweet_id','tweets.tweet_text', 'tweets.created_at', 'tweets.author_id', 'authors.screen_name', 'authors.name', 'authors.profile_image_url');
		$query = $this->db->select($fields);
		$query = $this->db->from('tweet_tags');
		$query = $this->db->join('tweets', 'tweet_tags.tweet_id = tweets.tweet_id');
		$query = $this->db->join('authors', 'tweets.author_id = authors.author_id');
		$query = $this->db->where('tweet_tags.tag_id', $tag->tid);
		$query = $this->db->limit($limit);
		$query = $this->db->order_by('created_at', 'desc');
		$query = $this->db->get();
		if($query->num_rows() > 0) { 
			$results = $query->result();
			return $results;
		} else { 
			return false;
		}
	}	
	
	function get_tweets($tag, $limit) 
	{
		$query = $this->db->select('*');
		$query = $this->db->from($this->tweets);
		$query = $this->db->limit($limit);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) { 
			$results = $query->result();
			return $results;
		} else { 
			return false;
		}
	}

	function hide_tweet($tweet_id)
	{
		$this->query = $this->db->where('tweet_id', $tweet_id);
		$this->query = $this->db->update($this->tweets, array('visible' => '0'));
		if($this->db->affected_rows() <= 0) {
			return false;
		}
	}
	
}