<div id="content">
	<div class="register">
		<h2>Register</h2>
	<?php echo validation_errors(); ?>
	<?php
	$attr = array('class'=>'register');
	echo form_open('users/register', $attr);
	$attr = array('name'=>'username', 'id'=>'username', 'value'=>'username');
	echo form_input($attr);
	$attr = array('name'=>'email', 'id'=>'email', 'value'=>'email');
	echo form_input($attr);
	$attr = array('name'=>'password', 'id'=>'password', 'value'=>'password');
	echo form_password($attr);
	$options = array('70506'=>'Lafayette, LA');
	echo form_dropdown('location', $options, '70506');
	echo form_reset('reset', 'Reset');
	echo form_submit('register', 'Register');
	echo form_close();
	?>
	</div>
</div><!-- close #content -->