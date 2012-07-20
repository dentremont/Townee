<div data-role="page" id="home">
	<div data-role="header">
			<a href="#location" data-rel="dialog" data-transition="flip">Location</a>
		<h1>Town.ee</h1>
	</div> 
	<div data-role="content">
		<ul data-role="listview" data-theme="g">
			<?php foreach($categories as $cid => $value) : ?>
				<li><a href="#cat-<?php echo $cid; ?>"><?php echo $value['name']; ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div> 
</div>

<div data-role="page" id="location">
	<div data-role="header">
		<h1>Your Location</h1>
	</div>
	<div data-role="content">
		<form method="post" action="<?php echo site_url('mobile/location');?>">
		<fieldset data-role="controlgroup">
	    	<legend>Choose a town:</legend>
	         	<?php foreach($locations as $town) : ?>
	         	<?php if($this->session->userdata('selected_location') == $town->lid) { $sel='checked="checked"'; } else { $sel=''; } ?>
	         	<input type="radio" name="location" id="radio-choice-<?php echo $town->lid;?>" value="<?php echo $town->lid;?>" <?php echo $sel;?>/>
	         	<label for="radio-choice-<?php echo $town->lid;?>"><?php echo $town->name;?></label>
	         	<?php endforeach; ?>
	    </fieldset>
	    </form>
	</div>
</div>

<?php foreach($categories as $cid => $value) : ?>
<div data-role="page" id="cat-<?php echo $cid; ?>">
	<div data-role="header">
		<h1><?php echo $value['name']; ?></h1>
	</div>
	<div data-role="content">
		<ul data-role="listview" data-theme="g">
			<?php foreach($value['tags'] as $tag) : ?>
			<li><a href="/mobile/posts/<?php echo $tag->tid; ?>/"><?php echo $tag->name;?> #<?php echo $tag->hashtag;?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php endforeach; ?>
