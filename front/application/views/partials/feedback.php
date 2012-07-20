<div id="content" class="page">
	<h1>Send us your feedback</h1>
		<h2>Login</h2>
		<?php echo validation_errors(); ?>
		<?php echo $message; ?>
		<?php
		$attr = array('class'=>'feedback');
		echo form_open('about/feedback', $attr);
		echo form_label('Your email:');
		$attr = array('name'=>'email', 'id'=>'email', 'value'=>'');
		echo form_input($attr);
		echo form_label('Your feedback:');
		$attr = array('name'=>'description', 'id'=>'description', 'value'=>'');
		echo form_textarea($attr);
		echo form_submit('feedback', 'Submit');
		echo form_close();
		?>	
</div>