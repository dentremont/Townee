<?php
/**
* parse_tweets.php
* Populate the database with new tweet data from the json_cache table
* Latest copy of this code: http://140dev.com/free-twitter-api-source-code-library/
* @author Adam Green <140dev@gmail.com>
* @license GNU Public License
* @version BETA 0.10
*/
set_time_limit(0);
require_once('./140dev_config.php');
require_once('./db_lib.php');
$oDB = new db;

$loc_results = $oDB->select("SELECT * FROM location_syn");
$locations_array = array();
$locations = array();
while($row = mysqli_fetch_assoc($loc_results)) {
	$locations_array[] = $row['synonym'];
	$locations[$row['synonym']] = $row['locations_id'];
}

while (true) {  
  // Process all new tweets
  $query = 'SELECT cache_id, raw_tweet ' .
    'FROM json_cache WHERE NOT parsed LIMIT 50000';
  $cacheResult = $oDB->select($query);
  
  while($row = mysqli_fetch_assoc($cacheResult)) {
		
    $cache_id = $row['cache_id'];
    // Each JSON payload for a tweet from the API was stored in the database  
    // by serializing it as text and saving it as base64 raw data
    $tweet_object = unserialize(base64_decode($row['raw_tweet']));
		
    // Mark the tweet as having been parsed
    $oDB->update('json_cache','parsed = true','cache_id = ' . $cache_id);
		
    // Gather tweet data from the JSON object
    // $oDB->escape() escapes ' and " characters, and blocks characters that
    // could be used in a SQL injection attempt
    
    // Check if location is enabled for the tweet / user
    
    if(isEligible($tweet_object) ) {	    
	    // Get tags
	    //$query = 'SELECT tid, hashtag, locations_id FROM tags';
	    //$tagResult = $oDB->select($query);    
	    
	    $tweet_id = $tweet_object->id_str;
	    $tweet_text = $oDB->escape($tweet_object->text);
	    $created_at = $oDB->date($tweet_object->created_at);
	    if (isset($tweet_object->geo)) {
	      $geo_lat = $tweet_object->geo->coordinates[0];
	      $geo_long = $tweet_object->geo->coordinates[1];
	    } else {
	      $geo_lat = $geo_long = 0;
	    }
	    
	    $user_object = $tweet_object->user;	    
	    
	    foreach($locations as $key => $value) {
	    	if($tweet_object->place->name == $key || $tweet_object->place->full_name == $key || $user_object->location == $key) {
	    		$tweet_location = $value;
	    	}
	    }
	    
	    $user_id = $user_object->id_str;
	    $screen_name = $oDB->escape($user_object->screen_name);
	    $name = $oDB->escape($user_object->name);
	    $profile_image_url = $user_object->profile_image_url;
	    $entities = $tweet_object->entities;
			
	    // Add a new user row or update an existing one
	    $field_values = 'screen_name = "' . $screen_name . '", ' .
	      'profile_image_url = "' . $profile_image_url . '", ' .
	      'author_id = ' . $user_id . ', ' .
	      'name = "' . $name . '", ' .
	      'location = "' . $oDB->escape($user_object->location) . '", ' . 
	      'followers_count = ' . $user_object->followers_count . ', ' .
	      'statuses_count = ' . $user_object->statuses_count . ', ' . 
	      'time_zone = "' . $user_object->time_zone . '"';		
	
	    if ($oDB->in_table('authors','author_id="' . $user_id . '"')) {
	      $oDB->update('authors',$field_values,'author_id = "' .$user_id . '"');
	    } else {			
	      $oDB->insert('authors',$field_values);
	    }
			
	    // Add the new tweet
	    // The streaming API sometimes sends duplicates, 
	    // so test the tweet_id before inserting
	    if (! $oDB->in_table('tweets','tweet_id=' . $tweet_id )) {
			
	      // The entities JSON object is saved with the tweet
	      // so it can be parsed later when the tweet text needs to be linkified
	      $field_values = 'tweet_id = ' . $tweet_id . ', ' .
	        'tweet_text = "' . $tweet_text . '", ' .
	        'created_at = "' . $created_at . '", ' .
	        'geo_lat = ' . $geo_lat . ', ' .
	        'geo_long = ' . $geo_long . ', ' .
	        'author_id = ' . $user_id . ', ' .				
	        'location_id = "' . $tweet_location . '", ' .
	        'visible = ' . '1' . ', ' .
	        'entities ="' . base64_encode(serialize($entities)) . '"';
				
	      $oDB->insert('tweets',$field_values);
	    }
	
	    foreach ($entities->hashtags as $hashtag) {

	      $where = 'tweet_id=' . $tweet_id . ' ' .
	        'AND tag="' . $hashtag->text . '"';		
						
	      if(! $oDB->in_table('tweet_tags',$where)) {
				
	        $field_values = 'tweet_id=' . $tweet_id . ', ' .
	          'tag="' . $hashtag->text . '"';	
					
	        $oDB->insert('tweet_tags',$field_values);
	      }
	    }
    } else {
    	// Delete cache item if not elligible
    	//$oDB->delete_cache_item($cache_id);
    }
    
    	
  }
		
  // You can adjust the sleep interval to handle the tweet flow and 
  // server load you experience
  sleep(10);
}

//Place all eligibility checks here.

function isEligible($tweet)
{
	$user = $tweet->user;
	$flag = false;
	global $locations_array;
	
	if( is_numeric(array_search($user->location, $locations_array)) ) {
		$flag = true;
	} elseif( isset($tweet->place) ) {
		if( is_numeric(array_search($tweet->place->name, $locations_array)) || is_numeric(array_search($tweet->place->full_name, $locations_array)) ) {
			$flag = true;
		}
	}
	if( ! $user->lang == "en") {
		$flag = false;
	}
	return $flag;
}

?>