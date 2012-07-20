<h4>Add a hashtag</h4>
<?php echo validation_errors(); ?>
<form method="post" action="<?php echo base_url();?>tags/add">
	<label>Category</label>
	<select name="catparent">
		<?php foreach($parents as $p) : ?>
		<option value="<?php echo $p->parent_id;?>"><?php echo $p->parent_name;?></option>
		<?php endforeach;?>
	</select>
	<label>Name</label>
	<input type="text" name="catname" value="" />
	<label>Hashtag</label>
	#<input type="text" name="cathash" value="" />
	<label>Description</label>
	<input type="text" name="catdesc" value="" />
	<input type="submit" name="add_category" value="Add" />
</form>