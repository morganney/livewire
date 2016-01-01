<?php $n = isset($editable) ? "u:{$name}[]" : "{$name}[]" ?>
<select name="<?php echo $n ?>" <?php echo isset($rfq) ? "disabled='disabled' class='disabled'" : '' ?>>
<?php if(isset($rfq)) : ?>
	<option value='Both' <?php echo $rfq[$name] == 'Both' ? "selected='selected'" : '' ?>>Both</option>
	<option value='New' <?php echo $rfq[$name] == 'New' ? "selected='selected'" : '' ?>>New</option>
  <option value='Green' <?php echo $rfq[$name] == 'Green' ? "selected='selected'" : '' ?>>Green</option>
<?php else : ?>
	<option value='Both'>Both</option>
	<option value='New' selected='selected'>New</option>
	<option value='Green'>Green</option>
<?php endif; ?>
</select>
