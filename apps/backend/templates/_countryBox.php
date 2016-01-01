<?php if(isset($form)) : ?>
<p <?php echo isset($class) ? "class={$class}" : '' ?>>
	<?php if(!isset($no_label)) : ?>
	<label for='country'>Country:</label>
	<?php endif; ?>
	<select name='country' id='country'>
		<option value='USA' <?php echo $form['country'] == 'USA' ? "selected='selected'" : '' ?>>USA</option>
		<option value='Canada' <?php echo $form['country'] == 'Canada' ? "selected='selected'" : '' ?>>Canada</option>
		<option value='Mexico' <?php echo $form['country'] == 'Mexico' ? "selected='selected'" : '' ?>>Mexico</option>
		<option value='Other' <?php echo $form['country'] == 'Other' ? "selected='selected'" : '' ?>>Other</option>
	</select>
</p>
<?php else : ?>
<p <?php echo isset($class) ? "class={$class}" : '' ?>>
	<?php if(!isset($no_label)) : ?>
	<label for='country'>Country:</label>
	<?php endif; ?>
	<select name='country' id='country'>
		<option value='USA' selected='selected'>USA</option>
		<option value='Canada'>Canada</option>
		<option value='Mexico'>Mexico</option>
		<option value='Other'>Other</option>
	</select>
</p>
<?php endif; ?>