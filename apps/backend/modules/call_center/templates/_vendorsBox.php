<?php $n = isset($editable) ? 'u:vendor_id[]' : 'vendor_id[]' ?>
<select name="<?php echo $n ?>" <?php echo isset($vmx) ? "disabled='disabled' class='req disabled'" : "class='req'" ?>>
<?php if(isset($vmx)) : ?>
	<?php foreach($vendors as $vendor) : ?>
	<option value='<?php echo $vendor['vendor_id'] ?>' <?php echo $vmx['vendor_id'] == $vendor['vendor_id'] ? "selected='selected'" : '' ?>><?php echo htmlentities($vendor['name']) ?></option>
	<?php endforeach; ?>
<?php else : ?>
	<?php foreach($vendors as $vendor) : ?>
	<option value='<?php echo $vendor['vendor_id'] ?>'><?php echo htmlentities($vendor['name']) ?></option>
	<?php endforeach; ?>
<?php endif; ?>
</select>
