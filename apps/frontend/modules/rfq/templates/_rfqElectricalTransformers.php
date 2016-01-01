
<p id='req_fields'>Required fields marked <span>*</span></p>
<?php if($sf_user->hasAttribute('rfq_form_values')) : $val = $sf_user->getAttribute('rfq_form_values'); ?>
<form id='rfq_form' name='rfq_form' class='rfq' method='post' action='<?php echo url_for("@rfq?category={$cat_slug}") ?>' enctype='application/x-www-form-urlencoded'>
	<div id='contact_info'>
		<p class='first'><label for='company'>Company Name:</label><input type='text' class='txt' name='company' id='company' value='<?php echo $val['company'] ?>' size='25' /></p>
		<p><label for='contact_name'>Contact Name: <span>*</span></label><input type='text' class='txt' name='contact_name' id='contact_name' value='<?php echo $val['contact_name'] ?>' size='25' /></p>
		<p><label for='contact_number'>Contact Number: <span>*</span></label><input type='text' class='txt' name='contact_number' id='contact_number' value='<?php echo $val['contact_number'] ?>' size='25' /></p>
		<p><label for='contact_email'>Contact Email: <span>*</span></label><input type='text' class='txt' name='contact_email' id='contact_email' value='<?php echo $val['contact_email'] ?>' size='25' /></p>
		<p><label for='req_date'>Date Item Required:</label><input type='text' class='txt' name='req_date' id='req_date' value='<?php echo $val['req_date'] ?>' size='25' /></p>
	</div>
	<p style='clear: both;'>
		<label for='type'>Select Transformer Type:</label>
		<select name='type' id='type'>
		  <option value='0'>-- Choose --</option>
			<option value='dry' <?php echo $val['type'] == 'dry' ? "selected='selected' " : '' ?>>DRY-Type</option>
			<option value='pad_oil' <?php echo $val['type'] == 'pad_oil' ? "selected='selected' " : '' ?>>Pad-mount oil-cooled</option>
			<option value='pad_sub' <?php echo $val['type'] == 'pad_sub' ? "selected='selected' " : '' ?>>Pad-mount Substitution</option>
		</select>
	</p>
	<p>
		<label for='enclosure'>Select Enclosure Type:</label>
		<select name='enclosure' id='enclosure'>
			<option value='0'>-- Choose --</option>
			<option value='indoor' <?php echo $val['enclosure'] == 'indoor' ? "selected='selected' " : '' ?>>Indoor</option>
			<option value='outdoor' <?php echo $val['enclosure'] == 'outdoor' ? "selected='selected' " : '' ?>>Outdoor</option>
		</select>
	</p>
	<p>
		<label for='hertz'>Select Hertz:</label>
		<select name='hertz' id='hertz'>
		  <option value='0'>-- Choose --</option>
			<option value='60' <?php echo $val['hertz'] == '60' ? "selected='selected' " : '' ?>>60Hz</option>
			<option value='50' <?php echo $val['hertz'] == '50' ? "selected='selected' " : '' ?>>50Hz</option>
		</select>
	</p>
	<p>
		<label for='k_rated'>Do you need a "K"-rated transformer?:</label>
		<select name='k_rated' id='k_rated'>
		  <option value='0'>-- Choose --</option>
			<option value='k_4' <?php echo $val['k_rated'] == 'k_4' ? "selected='selected' " : '' ?>>K-4</option>
			<option value='k_13' <?php echo $val['k_rated'] == 'k_13' ? "selected='selected' " : '' ?>>K-13</option>
		</select>
	</p>
	<p><label for='kva'>Enter KVA Rating: "e.g. 150KVA"</label><input type='text' class='txt' name='kva' id='kva' size='25' value='<?php echo $val['kva'] ?>' /></p>
	<p><label for='pri_voltage'>Enter Primary/Line Voltage: "e.g. 12.470VAC"</label><input type='text' class='txt' name='pri_voltage' id='pri_voltage' size='25' value='<?php echo $val['pri_voltage'] ?>' /></p>
	<p><label for='sec_voltage'>Enter Secondary/Load Voltage: "e.g. 120/208VAC"</label><input type='text' class='txt' name='sec_voltage' id='sec_voltage' size='25' value='<?php echo $val['sec_voltage'] ?>' /></p>
	<p>
		<label for='phase'>Select Phase:</label>
		<select name='phase' id='phase'>
		  <option value='0'>-- Choose --</option>
			<option value='single' <?php echo $val['phase'] == 'single' ? "selected='selected' " : '' ?>>Single Phase</option>
			<option value='three' <?php echo $val['phase'] == 'three' ? "selected='selected' " : '' ?>>Three Phase</option>
		</select>
	</p>
	<p>
		<label for='material'>Select The Appropriate Winding Material to be Used:</label>
		<select name='material' id='material'>
		  <option value='0'>-- Choose --</option>
			<option value='aluminum' <?php echo $val['material'] == 'aluminum' ? "selected='selected' " : '' ?>>Aluminum</option>
			<option value='copper' <?php echo $val['material'] == 'copper' ? "selected='selected' " : '' ?>>Copper</option>
		</select>
	</p>
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
	</div>
	<p style='clear: both;'>
		<label for='type'>Select Transformer Type:</label>
		<select name='type' id='type'>
		  <option value='0'>-- Choose --</option>
			<option value='dry'>DRY-Type</option>
			<option value='pad_oil'>Pad-mount oil-cooled</option>
			<option value='pad_sub'>Pad-mount Substitution</option>
		</select>
	</p>
	<p>
		<label for='enclosure'>Select Enclosure Type:</label>
		<select name='enclosure' id='enclosure'>
			<option value='0'>-- Choose --</option>
			<option value='indoor'>Indoor</option>
			<option value='outdoor'>Outdoor</option>
		</select>
	</p>
	<p>
		<label for='hertz'>Select Hertz:</label>
		<select name='hertz' id='hertz'>
		  <option value='0'>-- Choose --</option>
			<option value='60'>60Hz</option>
			<option value='50'>50Hz</option>
		</select>
	</p>
	<p>
		<label for='k_rated'>Do you need a "K"-rated transformer?:</label>
		<select name='k_rated' id='k_rated'>
		  <option value='0'>-- Choose --</option>
			<option value='k_4'>K-4</option>
			<option value='k_13'>K-13</option>
		</select>
	</p>
	<p><label for='kva'>Enter KVA Rating: "e.g. 150KVA"</label><input type='text' class='txt' name='kva' id='kva' size='25' value='' /></p>
	<p><label for='pri_voltage'>Enter Primary/Line Voltage: "e.g. 12.470VAC"</label><input type='text' class='txt' name='pri_voltage' id='pri_voltage' size='25' value='' /></p>
	<p><label for='sec_voltage'>Enter Secondary/Load Voltage: "e.g. 120/208VAC"</label><input type='text' class='txt' name='sec_voltage' id='sec_voltage' size='25' value='' /></p>
	<p>
		<label for='phase'>Select Phase:</label>
		<select name='phase' id='phase'>
		  <option value='0'>-- Choose --</option>
			<option value='single'>Single Phase</option>
			<option value='three'>Three Phase</option>
		</select>
	</p>
	<p>
		<label for='material'>Select The Appropriate Winding Material to be Used:</label>
		<select name='material' id='material'>
		  <option value='0'>-- Choose --</option>
			<option value='aluminum'>Aluminum</option>
			<option value='copper'>Copper</option>
		</select>
	</p>
	<p><label for='condition'>Does your application require new equipment?</label><input type='radio' class='rdo' name='condition' value='new' /> New &nbsp; <input type='radio' class='rdo' name='condition' value='green' checked='checked' /> Cheapest available</p>
	<p id='sbmt'><input type='submit' class='sbmt' value='Submit RFQ' name='rfq' id='rfq' /></p>
</form>
<?php endif; ?>
