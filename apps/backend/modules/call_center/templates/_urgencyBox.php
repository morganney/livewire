
<select name='urgency' <?php echo isset($urgency) ? "disabled='disabled' class='disabled'" : '' ?>>
<?php if(isset($urgency)) : ?>
	<option value='Now' <?php echo $urgency == 'Now' ? "selected='selected'" : '' ?>>Now</option>
	<option value='3 Days' <?php echo $urgency == '3 Days' ? "selected='selected'" : '' ?>>3 Days</option>
	<option value='1 Week' <?php echo $urgency == '1 Week' ? "selected='selected'" : '' ?>>1 Week</option>
	<option value='2 Weeks' <?php echo $urgency == '2 Weeks' ? "selected='selected'" : '' ?>>2 Weeks</option>
	<option value='1 Month' <?php echo $urgency == '1 Month' ? "selected='selected'" : '' ?>>1 Month</option>
	<option value='2 Months+' <?php echo $urgency == '2 Months+' ? "selected='selected'" : '' ?>>2 Months+</option>
<?php else : ?>
	<option value='Now'>Now</option>
	<option value='3 Days'>3 Days</option>
	<option value='1 Week'>1 Week</option>
	<option value='2 Weeks'>2 Weeks</option>
	<option value='1 Month'>1 Month</option>
	<option value='2 Months+'>2 Months+</option>
<?php endif; ?>
</select>
