<div id="content">
	<?php if(isset($message)) { echo $message; } ?>
	<?php if($widgets) : ?>
	<?php foreach($widgets as $widget) : ?>
	<div class="portlet widget" id="<?php echo $widget['info']->tid;?>">
		<div class="portlet-header widgetHeader">
			<h2><?php echo $widget['info']->name;?></h2>
			<h4>Town Tag: #<?php echo $widget['info']->hashtag;?></h4>
		</div>
		<div class="widgetBody">
			<?php if( ! empty($widget['content'])) : ?>			
			<ul class="all jcarousel-skin-tango">
			<?php foreach($widget['content'] as $tweet) :?>
			<li><div class="post">
				<img class="img" src="<?php echo $tweet->profile_image_url; ?>">
				<p><span class="author"><a href="http://www.twitter.com/<?php echo $tweet->screen_name; ?>"><?php echo $tweet->name;?></a>: </span><?php echo $tweet->tweet_text; ?> <span class="time"> <a href="http://www.twitter.com/<?php echo $tweet->screen_name; ?>/status/<?php echo $tweet->tweet_id;?>"><?php echo $this->tool->timeAgo($tweet->created_at); ?></a></span></p>
				
				<?php if(isset($user)) :?>
				<?php if( $user->uid == $widget['info']->owner || $user->uid == '1' ) : ?>
					<div class="controls">
						<a href="<?php echo site_url('tweets/hide/'.base64_encode($tweet->tweet_id));?>">Delete</a>
					</div>
				<?php endif; ?>
				<?php endif; ?>
			</div></li>
			<?php endforeach; ?>
			</ul>
			<div class="feed"><a title="RSS Feed" href="<?php echo site_url('feed/tag/'.$widget['info']->tid);?>">Feed</a></div>
			<?php else : ?>
				<p>No tweets :(</p>
				<?php 
					$string = " #".$widget['info']->hashtag;
				?>
				<p>You should <a target="_blank" href="http://twitter.com/?status=<?php echo urlencode($string);?>">tweet</a> something to get the conversation started!</p>
			<?php endif; ?>
		</div>
	</div>
	<?php endforeach;?>
	<?php endif; ?>
</div>