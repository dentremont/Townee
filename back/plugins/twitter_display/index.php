<?php
/**
* index.php
* Central script for the Twitter display plugin
* Deliver a complete set of tweets including the supporting HTML elements
* Latest copy of this code: http://140dev.com/free-twitter-api-source-code-library/
* @author Adam Green <140dev@gmail.com>
* @license GNU Public License
* @version BETA 0.10
*/

// Get the HTML structure 
$tweet_page = file_get_contents('tweet_list_template.txt');

// Fill in the most recent individual tweets
$tweet_page = str_replace( '[tweets]', 
  include('get_tweet_list.php'), $tweet_page); 
		
// Fill in the constants and strings needed by site.js after the page loads
require_once('./twitter_display_config.php'); 
$tweet_page = str_replace( '[new_count_refresh]', 
  NEW_COUNT_REFRESH, $tweet_page); 
$tweet_page = str_replace( '[ajax_url]', 
  AJAX_URL, $tweet_page); 
$tweet_page = str_replace( '[more_button]', 
  MORE_BUTTON, $tweet_page); 

// Return the results as HTML
// Print is used because this script is executed with file_get_contents()
print $tweet_page;
?>