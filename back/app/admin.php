<?php
	
	if(isset($_POST['clear'])) {
		$sel = $_POST['log'];
		if($sel == "php") {
			unlink('../db/error_log.txt');
		} elseif($sel == "tweetlog") {
			unlink('../db/error_log');
		}
	}
	
	if(is_readable('../db/error_log.txt')) {
		$phpErrors = file_get_contents('../db/error_log.txt');
	} else {
		$phpErros = "No errors!";
	}	
	if(is_readable('../db/error_log')) {
		$tweetLog = file_get_contents('../db/error_log');
	} else {
		$tweetLog = "No logs :(";
	}	
	
?>
<html>
<head>
<title>Town.ee | Administration</title>
<style>
.wrapper {
	width: 1130px;
	margin: 0 auto;
}
.codewindow {
	width: 1100px;
	height: 500px;
	overflow: scroll;
}
pre {
	background-color: #ececec;
}
</style>
</head>
<body>
<div class="wrapper">
	<h1>Town.ee Administration</h1>
	<div class="controller">
		<span>Clear logs</span>
		<form method="post" action="admin.php">
			<input type="radio" name="log" value="php" />PHP Errors<br>
			<input type="radio" name="log" value="tweetlog" />Tweet Catcher<br>
			<input type="submit" name="clear" value="Clear" />
		</form>
		<a href="admin.php">Refresh</a>
	</div>
	<h2>Tweet Catcher Log</h2>
	<div class="codeWindow"><pre><?php echo $tweetLog; ?></pre></div>
	<hr>
	<h2>PHP Errors</h2>
	<div class="codeWindow"><pre><?php echo $phpErrors; ?></pre></div>
	<hr>
</div>
</body>
</html>