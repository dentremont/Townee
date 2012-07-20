<?php
/**
* cleanup.php
* This script will check the database for old cache items and delete them.
*/
	set_time_limit(0);
	require_once('./140dev_config.php');
	require_once('./db_lib.php');
	$oDB = new db;

	$date = date("Y-m-d H:i:s", strtotime("-1 weeks"));
	$query = 'SELECT cache_id' .
	' FROM json_cache WHERE json_cache.cache_date <= "'.$date.'" LIMIT 50000';
	$result = $oDB->select($query);
	while($row = mysqli_fetch_assoc($result)) {
		// Mark the tweet as having been parsed
		$oDB->delete_cache_item($row['cache_id']);	
	}
		


?>