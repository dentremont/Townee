</div><!-- close #content -->
<div id="bottom">
	<?php if($this->uri->segment(1) == "dash") :?>
	<div id="administer">
	<div id="manage">
		<form method="post" action="<?php echo site_url('dash/favorites');?>">
			<fieldset>    
			<legend>Choose the Town Tags you'd like add to your dashboard</legend>
			<ol>
			<?php foreach($tags as $tag) :?>
				<li>
				<?php if(in_array($tag->tid, $user_favs)){$chk='checked="checked"';}else{$chk='';}?>
				<label class="tagSelect<?php if($chk) { echo ' checked';}?>" for="checkbox-<?php echo $tag->tid;?>">#<?php echo $tag->hashtag;?></label>
				<input id="checkbox-<?php echo $tag->tid;?>" type="checkbox" name="fav[]" value="<?php echo $tag->tid;?>" <?php echo $chk;?> class="checkbox"/>
				</li>
			<?php endforeach;?>
			<li><input class="submit" type="submit" name="favorites" value="Save Settings" /></li>
			</ol>
			</fieldset>
		</form>
	</div>
	<div id="addTag">
		<form method="post" action="<?php echo site_url('dash');?>"><fieldset>
		<legend>Add a Town Tag!</legend><ol>
		<?php echo validation_errors(); ?>
		<li>
		<label>Hashtag #</label>
		<input name="hashtag" type="text" value="" />
		</li>
		
		<li>
		<label>Town Tag Title</label>
		<input name="name" type="text" value="" />
		</li>
		
		<li>
		<label>Category</label>
		<select name="category">
		<?php foreach($categories as $cat) : ?>
		<option value="<?php echo $cat->cid;?>"><?php echo $cat->name;?></option>
		<?php endforeach;?>
		</select>
		</li>
		
		<li>
		<label>Description</label>
		<textarea name="description" cols="20" rows="4"></textarea>
		</li>
		
		<li>
		<input name="addTag" type="submit" value="create towntag" />
		</li>
		</ol></fieldset>
		</form>
	</div>
	<div class="clear"></div>
	</div>
	<?php endif; ?>
	<div id="footer">
		<div id="credit">
			<p>Copyright Pixelbrush Studios 2011</p> 
		</div>
		<div id="links">
			<ul>
				<li><a href="<?php echo site_url('about');?>">About</a></li>
				<li><a href="<?php echo site_url('about/participate');?>">Participate</a></li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
  var is_ssl = ("https:" == document.location.protocol);
  var asset_host = is_ssl ? "https://s3.amazonaws.com/getsatisfaction.com/" : "http://s3.amazonaws.com/getsatisfaction.com/";
  document.write(unescape("%3Cscript src='" + asset_host + "javascripts/feedback-v2.js' type='text/javascript'%3E%3C/script%3E"));
</script>

<script type="text/javascript" charset="utf-8">
  var feedback_widget_options = {};

  feedback_widget_options.display = "overlay";  
  feedback_widget_options.company = "townee";
  feedback_widget_options.placement = "left";
  feedback_widget_options.color = "#222";
  feedback_widget_options.style = "idea";
  var feedback_widget = new GSFN.feedback_widget(feedback_widget_options);
</script>
</body>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-21124488-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</html>