<div id="content">
	<div class="login">
		<h2>Login</h2>
		<?php echo validation_errors(); ?>
		<?php echo $message; ?>
		<?php
		$attr = array('class'=>'login');
		echo form_open('users/login', $attr);
		$attr = array('name'=>'email', 'id'=>'email', 'value'=>'email');
		echo form_input($attr);
		$attr = array('name'=>'password', 'id'=>'password', 'value'=>'password');
		echo form_password($attr);
		echo form_submit('login', 'Login');
		echo form_close();
		?>
	</div>
</div><!-- close #content -->