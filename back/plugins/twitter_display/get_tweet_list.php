<?php 
/**
* get_tweet_list.php
* Return a list of the most recent tweets as HTML
* Older tweets are requested with the query of last=[tweet_id] by site.js
* 
* @author Adam Green <140dev@gmail.com>
* @license GNU Public License
* @version BETA 0.10
*/
require_once('./twitter_display_config.php' );
require_once('./linkify.php');
require_once('../../db/140dev_config.php');
require_once('../../db/db_lib.php' ); 
$oDB = new db;

$query = 'SELECT profile_image_url, created_at, screen_name, ' .
  'name, tweet_text, tweet_id, entities ' .
  'FROM tweets ';

// Query string of last=[tweet_id] means that this script was called by site.js
// when the More Tweets button was clicked
if (isset($_GET['last'])) {  
  $query .= 'WHERE tweet_id < "' . $_GET['last'] . '" ';
}

$query .= 'ORDER BY tweet_id DESC LIMIT ' . TWEET_DISPLAY_COUNT;
$result = $oDB->select($query);

// Use the text file tweet_template.txt to construct each tweet in the list
$tweet_template = file_get_contents('tweet_template.txt');
$tweet_list = '';
$tweets_found = 0;
while (($row = mysqli_fetch_assoc($result))
  &&($tweets_found < TWEET_DISPLAY_COUNT)) { 
  
  ++$tweets_found; 
	
  // create a fresh copy of the empty template
  $current_tweet = $tweet_template;
	
  // Fill in the template with the current tweet
  $current_tweet = str_replace( '[profile_image_url]', 
    $row['profile_image_url'], $current_tweet);
  $current_tweet = str_replace( '[created_at]', 
    twitter_time($row['created_at']), $current_tweet);    		
  $current_tweet = str_replace( '[screen_name]', 
	  $row['screen_name'], $current_tweet);  
  $current_tweet = str_replace( '[name]', 
    $row['name'], $current_tweet);    
  $current_tweet = str_replace( '[user_mention_title]', 
    USER_MENTION_TITLE . ' ' . $row['screen_name'] . ' (' . $row['name'] . ')', 
    $current_tweet);  
  $current_tweet = str_replace( '[tweet_display_title]', 
    TWEET_DISPLAY_TITLE, $current_tweet);  
		
  // The entities object was stored as base64_encode(serialize())
  $entities = unserialize(base64_decode($row['entities']));
  $current_tweet = str_replace( '[tweet_text]', 
    linkify($row['tweet_text'], $entities), $current_tweet);  
		
  // Include each tweet's id so site.js can request older or newer tweets
  $current_tweet = str_replace( '[tweet_id]', 
    $row['tweet_id'], $current_tweet); 
		
  // Add this tweet to the list
  $tweet_list .= $current_tweet;
}

if (!$tweets_found) {
  if (isset($_GET['last'])) {
    $tweet_list = '<strong>No more tweets found</strong><br />';
  } else {
    $tweet_list = '<strong>No tweets found</strong><br />';	
  }	
}

if (isset($_GET['last'])) {
  // Called by site.js with Ajax, so print HTML to the browser
  print $tweet_list;
} else {
  // Called by index.php with include(), so return the value
  return $tweet_list;
}

// Convert the tweet creation date/time to Twitter format
// This eliminates annoying server vs. browser time zone differences
function twitter_time($time) {
  $delta = time() - strtotime($time);
  if ($delta < 60) {
    return 'less than a minute ago';
  } else if ($delta < 120) {
    return 'about a minute ago';
  } else if ($delta < (45 * 60)) {
    return floor($delta / 60) . ' minutes ago';
  } else if ($delta < (90 * 60)) {
    return 'about an hour ago.';
  } else if ($delta < (24 * 60 * 60)) {
    return floor($delta / 3600) . ' hours ago';
  } else if ($delta < (48 * 60 * 60)) {
    return '1 day ago';
  } else {
    return floor($delta / 86400) . ' days ago';
	}
}
?>