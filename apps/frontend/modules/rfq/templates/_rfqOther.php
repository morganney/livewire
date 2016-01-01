
<p id='req_fields'>Required fields marked <span>*</span></p>
<?php if($sf_user->hasAttribute('rfq_form_values')) : $val = $sf_user->getAttribute('rfq_form_values'); ?>
<form id='rfq_form' name='rfq_form' class='rfq' method='post' action='<?php echo url_for("@rfq?category={$cat_slug}") ?>' enctype='application/x-www-form-urlencoded'>
	<div id='contact_info'>
		<p class='first'><label for='company'>Company Name:</label><input type='text' class='txt' name='company' id='company' value='<?php echo $val['company'] ?>' size='25' /></p>
		<p><label for='contact_name'>Contact Name: <span>*</span></label><input type='text' class='txt' name='contact_name' id='contact_name' value='<?php echo $val['contact_name'] ?>' size='25' /></p>
		<p><label for='contact_number'>Contact Number: <span>*</span></label><input type='text' class='txt' name='contact_number' id='contact_number' value='<?php echo $val['contact_number'] ?>' size='25' /></p>
		<p><label for='contact_email'>Contact Email: <span>*</span></label><input type='text' class='txt' name='contact_email' id='contact_email' value='<?php echo $val['contact_email'] ?>' size='25' /></p>
		<p><label for='req_date'>Date Item Required:</label><input type='text' class='txt' name='req_date' id='req_date' value='<?php echo $val['req_date'] ?>' size='25' /></p>
		<p><label for='catalog_number'>Part/Catalog #: <span>*</span></label><input type='text' class='txt' name='catalog_number' id='catalog_number' value='<?php echo $val['catalog_number'] ?>' size='25' /></p>
		<p><label for='notes'>Additional Details:</label><textarea rows='10' cols='25' name='notes' id='notes'><?php echo isset($val['notes']) ? $val['notes'] : ''  ?></textarea></p>
	</div>
	<p><label for='condition'>Does your application require new equipment?</label><input type='radio' class='rdo' name='condition' value='new' <?php echo $val['condition'] == 'new' ? "checked='checked' " : '' ?>/> New &nbsp; <input type='radio' class='rdo' name='condition' value='green' <?php echo $val['condition'] == 'green' ? "checked='checked' " : '' ?>/> Cheapest available</p>
	<p id='sbmt'><input type='submit' class='sbmt' value='Submit RFQ' name='rfq' id='rfq' /></p>
</form>
<?php else : ?>
<form id='rfq_form' name='rfq_form' class='rfq' method='post' action='<?php echo url_for("@rfq?category={$cat_slug}") ?>' enctype='application/x-www-form-urlencoded'>
	<div id='contact_info'>
		<p class='first'><label for='company'>Company Name:</label><input type='text' class='txt' name='company' id='company' value='' size='25' /></p>
		<p><label for='contact_name'>Contact Name: <span>*</span></label><input type='text' class='txt' name='contact_name' id='contact_name' value='' size='25' /></p>
		<p><label for='contact_number'>Contact Number: <span>*</span></label><input type='text' class='txt' name='contact_number' id='contact_number' value='' size='25' /></p>
		<p><label for='contact_email'>Contact Email: <span>*</span></label><input type='text' class='txt' name='contact_email' id='contact_email' value='' size='25' /></p>
		<p><label for='req_date'>Date Item Required:</label><input type='text' class='txt' name='req_date' id='req_date' value='' size='25' /></p>
		<p><label for='catalog_number'>Part/Catalog #: <span>*</span></label><input type='text' class='txt' name='catalog_number' id='catalog_number' value='' size='25' /></p>
		<p><label for='notes'>Additional Details:</label><textarea rows='10' cols='25' name='notes' id='notes'></textarea></p>
	</div>
	<p><label for='condition'>Does your application require new equipment?</label><input type='radio' class='rdo' name='condition' value='new' /> New &nbsp; <input type='radio' class='rdo' name='condition' value='green' checked='checked' /> Cheapest available</p>
	<p id='sbmt'><input type='submit' class='sbmt' value='Submit RFQ' name='rfq' id='rfq' /></p>
</form>
<?php endif; ?>
