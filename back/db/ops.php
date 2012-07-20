<?php
require_once('./140dev_config.php');
require_once('./db_lib.php');
$oDB = new db;

$tags = array(
	array(
		'hashtag' => 'deals',
		'name' => 'Hot Deals',
		'owner' => 1,
		'parent_id' => 2
	),
	array(
		'hashtag' => 'lunchspecials',
		'name' => 'Lunch Specials',
		'owner' => 1,
		'parent_id' => 4
	),
	array(
		'hashtag' => 'livemusic',
		'name' => 'Live Music',
		'owner' => 1,
		'parent_id' => 1
	),
	array(
		'hashtag' => 'downtown',
		'name' => 'Downtown',
		'owner' => 1,
		'parent_id' => 1
	),
	array(
		'hashtag' => 'jobs',
		'name' => 'Jobs',
		'owner' => 1,
		'parent_id' => 2
	),
	array(
		'hashtag' => 'discounts',
		'name' => 'discounts',
		'owner' => 1,
		'parent_id' => 1
	),
	array(
		'hashtag' => 'drinkspecial',
		'name' => 'Drink Specials',
		'owner' => 1,
		'parent_id' => 5
	),
	array(
		'hashtag' => 'single',
		'name' => 'Meet Singles',
		'owner' => 1,
		'parent_id' => 5
	),
	array(
		'hashtag' => 'townee',
		'name' => 'Town.ee',
		'owner' => 1,
		'parent_id' => 1
	)
	
);
$results = $oDB->select("SELECT * FROM locations WHERE lid=2458833");
while($row = mysqli_fetch_assoc($results)) {
	foreach($tags as $tag) {
		$field_values = 'hashtag="' . $tag['hashtag'] . '", ' .
		  'name="' . $tag['name'] . '", '. 'locations_id="'.$row['lid'].'", '.'owner="1", '. 'parent_id="'.$tag['parent_id'].'", promoted="1"';
		  $oDB->insert('tags', $field_values);
	}
}

?>