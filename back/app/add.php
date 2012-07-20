<?php
if( isset($_POST['submit']) ) {
	require_once('../db/140dev_config.php');
	require_once('../db/db_lib.php');
	$oDB = new db;
	if( isset($_POST['woeid']) && isset($_POST['name']) ) {
		
		$query ="INSERT INTO locations SET "."lid=".$_POST['woeid'].",name='".$_POST['name']."',subdomain='".$_POST['subdomain']."'";
		$oDB->insertsql($query);
		
		$query ="INSERT INTO location_syn SET "."locations_id=".$_POST['woeid'].", synonym='".$_POST['name']."'";
		$oDB->insertsql($query);
		
		foreach( $_POST['syn'] as $key => $value ) {
			if( ! empty($value) ) {
				$query ="INSERT INTO location_syn SET "."locations_id=".$_POST['woeid'].", synonym='".$value."'";
				$oDB->insertsql($query);
			}
		}
		
		$tags = array(
			array(
				'hashtag' => 'deals',
				'name' => 'Hot Deals',
				'locations_id' => $_POST['woeid'],
				'owner' => 1,
				'parent_id' => 2,
				'promoted' => 1
			),
			array(
				'hashtag' => 'lunchspecials',
				'name' => 'Lunch Specials',
				'locations_id' => $_POST['woeid'],
				'owner' => 1,
				'parent_id' => 3,
				'promoted' => 1
			),
			array(
				'hashtag' => 'livemusic',
				'name' => 'Live Music',
				'locations_id' => $_POST['woeid'],
				'owner' => 1,
				'parent_id' => 1,
				'promoted' => 1
			),
			array(
				'hashtag' => 'downtown',
				'name' => 'Downtown',
				'locations_id' => $_POST['woeid'],
				'owner' => 1,
				'parent_id' => 1,
				'promoted' => 1
			),
			array(
				'hashtag' => 'jobs',
				'name' => 'Jobs',
				'locations_id' => $_POST['woeid'],
				'owner' => 1,
				'parent_id' => 2,
				'promoted' => 1
			),
			array(
				'hashtag' => 'discounts',
				'name' => 'Discounts',
				'locations_id' => $_POST['woeid'],
				'owner' => 1,
				'parent_id' => 1,
				'promoted' => 1
			),
			array(
				'hashtag' => 'drinkspecial',
				'name' => 'Drink Specials',
				'locations_id' => $_POST['woeid'],
				'owner' => 1,
				'parent_id' => 3,
				'promoted' => 1
			),
			array(
				'hashtag' => 'single',
				'name' => 'Meet Singles',
				'locations_id' => $_POST['woeid'],
				'owner' => 1,
				'parent_id' => 5,
				'promoted' => 1
			),
			array(
				'hashtag' => 'townee',
				'name' => 'Town.ee',
				'locations_id' => $_POST['woeid'],
				'owner' => 1,
				'parent_id' => 1,
				'promoted' => 1
			)
		);
	
		foreach($tags as $tag) {
			$query ="INSERT INTO tags SET hashtag='".$tag['hashtag']."',name='".$tag['name']."',locations_id=".$tag['locations_id'].",owner=1,parent_id=".$tag['parent_id'].",promoted=1";
			$oDB->insertsql($query);
		}
	} else {
		$message = "<p>Fill in the form, yo!</p>";
	}
}
?>
<html>
<head>
<title>Town.ee Adder</title>
<style>
* {
	margin: 0;
	padding: 0;
}
body {
	background-color: #F0F3EF;
	color: #333;
	font-family: "Helvetica", Arial, sans-serif;
}
.wrapper{
	width: 400px;
	margin: 10px auto;
	background-color: #FFF;
	padding: 20px;
	border: 2px solid #DBDEDA;
}
ul {
	list-style: none;
	margin-left: 20px;
	margin-top: 15px;
}
li {
	width: 350px;
	margin: 5px 0;
}
label {
	float: left;
	width: 100px;
}
</style>
</head>
<body>
<div class="wrapper">
<h1>Add a town</h1>
<p><a href="http://sigizmund.info/woeidinfo/?woeid=louisiana" target="_blank">Get WOEID</a></p>
<?php if(!empty($message)) { echo $message; } ?>
<form method="post" action="add.php">
	<ul>
		<li>
			<label>WOEID</label>
			<input type="text" name="woeid" value="" placeholder="2347577"/>
		</li>
		<li>
			<label>Name</label>
			<input type="text" name="name" value="" placeholder="New Orleans, LA"/>
		</li>
		<li>
			<label>Subdomain</label>
			<input type="text" name="subdomain" value="" placeholder="neworleans"/>
		</li>
	</ul>
	<ul>
		<li>
			<label>Synonym</label>
			<input type="text" name="syn[]" value="" placeholder="nola"/>
		</li>
		<li>
			<label>Synonym</label>
			<input type="text" name="syn[]" value="" />
		</li>
		<li>
			<label>Synonym</label>
			<input type="text" name="syn[]" value="" />
		</li>
		<li>
			<label>Synonym</label>
			<input type="text" name="syn[]" value="" />
		</li>
		<li>
			<label>Synonym</label>
			<input type="text" name="syn[]" value="" />
		</li>
		<li>
			<label>Synonym</label>
			<input type="text" name="syn[]" value="" />
		</li>
		<li>
			<label>Synonym</label>
			<input type="text" name="syn[]" value="" />
		</li>
		<li>
			<label>Synonym</label>
			<input type="text" name="syn[]" value="" />
		</li>
		<li>
			<label>Synonym</label>
			<input type="text" name="syn[]" value="" />
		</li>
	</ul>
	<ul>
		<li>
			<input type="submit" name="submit" value="Add It" />
		</li>
	</ul>
</form>
</div>
</body>
</html>