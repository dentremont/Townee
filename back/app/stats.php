<?php
require_once('../db/140dev_config.php');
require_once('../db/db_lib.php');
$oDB = new db;
	
$query = "SELECT name, count(*) from tweets JOIN locations ON tweets.location_id = locations.lid GROUP BY location_id ORDER BY COUNT(*) DESC";
$tweetsByTown = $oDB->select($query);

$query = "SELECT DISTINCT hashtag FROM tags";
$distinctTags = $oDB->select($query);
$tagCount=0;
while($row = mysqli_fetch_assoc($distinctTags)) {
$tagCount++;
}

$query = "SELECT count(uid) FROM `users`";
$users = $oDB->select($query);
$numUsers=0;
while($row = mysqli_fetch_assoc($users)) {
$numUsers = $row['count(uid)'];
}
?>

<html>
<head>
<title>Town.ee Stats</title>
<style>
.wrapper {
	width: 960px;
	margin: 0 auto;
}
</style>
</head>
<body>
<div class="wrapper">
	<div id="header">
		<h1>Statistics</h1>
	</div>
	<div id="main">
		<div class="section">
			<h2>Tweets by town</h2>
			<table>
				<thead>
					<tr><td>Town</td><td>Tweets</td></tr>
				</thead>
				<tbody>
					<?php while($row = mysqli_fetch_assoc($tweetsByTown)) : ?>
					<tr><td><?php echo $row['name'];?></td><td><?php echo $row['count(*)'];?></td></tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		<div class="section">
			<h2>Distinct tags being tracked: <?php echo $tagCount;?></h2>
		</div>
		<div class="section">
			<h2>Number of users: <?php echo $numUsers;?></h2>
		</div>
	</div>
</div>
</body>
</html>