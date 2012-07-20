<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $page_title; ?></title>
	<meta name="description" content="Town.ee allows you to track and submit Twitter hashtags in your town!" />
	<meta name="keywords" content="Twitter, hashtags, local, location based hashtags, track, location, Pixelbrush Studios" />
	<link rel="stylesheet" href="<?php echo base_url();?>styles/reset.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url();?>styles/style.css" type="text/css" />
	<link href="<?php echo base_url();?>styles/skins/tango/skin.css" rel="stylesheet" type="text/css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js" type="text/javascript"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo base_url();?>scripts/jquery.jcarousel.min.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:light,regular' rel='stylesheet' type='text/css'>
	<link rel="text/javascript" href="<?php echo base_url();?>scripts/crir/crir.js" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url();?>scripts/crir/crir.css" type="text/css" />
	<script src="<?php echo base_url();?>scripts/townee.js" type="text/javascript"></script>

</head>
<body class="<?php echo $body_classes; ?>">
<div id="top">
	<div id="header">
		<a style="text-decoration: none;" href="<?php echo base_url();?>"><h1 class="logo"><span class="name">Town.ee</span><span>Real Time Town Buzz</span></h1></a>
		<div id="pageInfo">
			<select id="townSelect">
			<?php foreach($locations as $town) : ?>
				<?php if($location == $town->lid) { $sel="selected"; } else { $sel=''; } ?>
			<option value="<?php echo $town->subdomain; ?>" <?php echo $sel; ?>><?php echo $town->name; ?></option>
			<?php endforeach; ?>
			</select>
			<?php echo $this->tool->accountMenu(); ?>
		</div>
	</div>
	<?php if( ! $this->tool->isLoggedIn() ) : ?>
	<div id="promo">
		<h2>See and Share whats happening locally.</h2>		
		<h4>Get twitter updates filtered from the people in your town.</h4>		
		
	</div>
	<?php endif; ?>
	<div id="nav">
		<?php echo $this->tool->print_navigation(); ?>
	</div>