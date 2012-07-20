<div id="content" class="page">
	<div class="settings">
		<h2>User Settings for <em><?php echo $user->username; ?></em></h2>
		<form action="<?php echo site_url('users/settings');?>" method="post" class="settings">
		       <?php echo validation_errors(); ?>
		       <ol>
		       
		       <li> 
		       <label>Username</label>
		        <input type="text" name="username" value="<?php echo $user->username;?>" id="username" >
		        </li>
		        
		   <li>
		    <label>New Password</label>
		    <input type="password" name="password" value="" placeholder="new password" id="password">
		    </li>
		
			 <li>
			    <label>Select Your City</label>
			    <select name="location">
			<?php foreach($locations as $town) : ?>
				<?php if($user->locations_id == $town->lid) { $sel="selected"; } else { $sel=''; } ?>
			<option value="<?php echo $town->lid; ?>" <?php echo $sel; ?>><?php echo $town->name; ?></option>
			<?php endforeach; ?>
			</select>
			</li>
		
			<li>
			<input type="submit" name="save" value="Save" class="submit">
			</li>
		</ol>
		</form>
	</div>
</div><!-- close #content -->
