<?php
/**
* 140dev_config.php
* Constants for the entire 140dev Twitter framework
* You MUST modify these to match your server setup when installing the framework
* 
* Latest copy of this code: http://140dev.com/free-twitter-api-source-code-library/
* @author Adam Green <140dev@gmail.com>
* @license GNU Public License
* @version BETA 0.10
*/

// Directory for db_config.php
define('DB_CONFIG_DIR', '/home/accounts/towne/public_html/db/');

// Server path for scripts within the framework to reference each other
define('CODE_DIR', '/home/accounts/towne/public_html/');

// External URL for Javascript code in browsers to call the framework with Ajax
define('AJAX_URL', 'http://174.121.22.176/~towne');

// Basic authorization settings for connecting to the Twitter streaming API
// Fill in the values for a valid Twitter account
define('STREAM_ACCOUNT', 'towneebeta');
define('STREAM_PASSWORD', 'lexip219');

// MySQL time zone setting to normalize dates
define('TIME_ZONE','America/New_York');

// Settings for monitor_tweets.php
define('TWEET_ERROR_INTERVAL',10);
// Fill in the email address for error messages
define('TWEET_ERROR_ADDRESS','david@pixelbrushstudios.com');
?>