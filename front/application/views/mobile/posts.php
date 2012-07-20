<div data-role="page" id="tags">
	<div data-role="header"><h1>#<?php echo $tag->hashtag;?></h1></div> 
	<div data-role="content">
		<?php if(!empty($posts)) : ?>
		<ul data-role="listview" data-theme="g">
			<?php foreach($posts as $tweet) :?>
			<li><div class="innerpost">
				<img src="<?php echo $tweet->profile_image_url;?>" />
				<h3 class="author"><?php echo $tweet->name;?></h3>
				<p><?php echo $tweet->tweet_text; ?></p>
				<a href="http://www.twitter.com/<?php echo $tweet->screen_name; ?>/status/<?php echo $tweet->tweet_id;?>"></a>
			</div></li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
	</div> 
</div>