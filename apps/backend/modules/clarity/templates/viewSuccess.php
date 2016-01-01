<?php use_stylesheet('be/view.css') ?>
<h2><?php echo $part['part_no'] ?></h2>
<img id='part_img' src='<?php echo $part['img_src'] ?>' alt='' />
<form id='pricing' method='post' action='<?php echo url_for('@update_pricing') ?>' enctype='application/x-www-form-urlencoded'>
	<p><input type='radio' class='rdo' name='display' value='1' <?php echo $part['display'] == '1' ? "checked='checked' " : '' ?>/> New</p>
	<p><input type='radio' class='rdo' name='display' value='2' <?php echo $part['display'] == '2' ? "checked='checked' " : '' ?>/> Green</p>
	<p><input type='radio' class='rdo' name='display' value='3' <?php echo $part['display'] == '3' ? "checked='checked' " : '' ?>/> New &amp; Green</p>
	<p><input type='radio' class='rdo' name='display' value='0' <?php echo $part['display'] == '0' ? "checked='checked' " : '' ?>/> Off</p>
	<p><input type='submit' value='Update' /></p>
	<input type='hidden' value='<?php echo $part['part_no'] ?>' name='part_no' />
</form>
