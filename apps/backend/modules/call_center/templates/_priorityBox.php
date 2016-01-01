
<select name='priority' <?php echo isset($priority) ? "disabled='disabled' class='disabled'" : '' ?>>
<?php if(isset($priority)) : ?>
	<option value='Low' <?php echo $priority == 'Low' ? "selected='selected'" : '' ?>>Low</option>
	<option value='Normal' <?php echo $priority == 'Normal' ? "selected='selected'" : '' ?>>Normal</option>
	<option value='High' <?php echo $priority == 'High' ? "selected='selected'" : '' ?>>High</option>
<?php else : ?>
	<option value='Low'>Low</option>
	<option value='Normal' selected='selected'>Normal</option>
	<option value='High'>High</option>
<?php endif; ?>
</select>
