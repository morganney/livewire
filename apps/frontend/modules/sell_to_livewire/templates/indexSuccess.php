<?php use_javascript('sell') ?>
<?php include_partial('global/h1', array('txt' => 'Sell to LiveWire Electrical Supply')) ?>
<?php if($sf_user->hasFlash('notice')) : ?>
<div id='flash'><?php echo $sf_user->getFlash('notice') ?></div>
<?php endif; ?>
<div class='section' style='border-top: none;'>
	<p>We have a national distribution network -- there's tens of millions in inventory immediately available to ship even during weekend emergencies.  While we are set up with a few select manufacturers via direct distributor relationships, we do buy surplus inventory direct from our customers.</p>
	<p class='last'>We pay cash or can offer credit toward a future purchase.  We are particularly interested in new and used Square D, Cutler Hammer, Siemens, General Electric, Federal Pacific, and Zinsco Circuit Breakers.  We are also currently purchasing Fuses from Ferraz Shawmut, Bussman, Littllefuse, and Bussman.  We also purchase new in box and new surplus Allen Brdley, Siemens, Furnas and General Electric Motor Control.  Just fill in the form below to turn your surplus inventory into cash!</p>
</div>
<?php if($sf_user->hasAttribute('form_values')) : $val = $sf_user->getAttribute('form_values'); ?>
<form class='section sell' method='post' action='<?php echo url_for('@sell_to_lws') ?>' enctype='application/x-www-form-urlencoded'>
	<h2>Sell Equipment Form:</h2>
	<p>Required fields marked <span style='color: #ff0000;'>*</span></p>
	<p><label for='company'>Company Name</label><input type='text' class='txt' name='company' id='company' value='<?php echo $val['company'] ?>' size='30' /></p>
	<p><label for='contact_name'>Contact Name <span>*</span></label><input type='text' class='txt' name='contact_name' id='contact_name' value='<?php echo $val['contact_name'] ?>' size='30' /></p>
	<p><label for='preferred'>Preferred Contact Method</label><input type='radio' class='rdo' name='preferred' value='phone' <?php echo $val['preferred'] == 'phone' ? "checked='checked' " : '' ?>/> Phone &nbsp; <input type='radio' class='rdo' name='preferred' value='email' <?php echo $val['preferred'] == 'email' ? "checked='checked' " : '' ?>/> Email &nbsp; <input type='radio' class='rdo' name='preferred' value='fax' <?php echo $val['preferred'] == 'fax' ? "checked='checked' " : '' ?>/> Fax </p>
	<p id='xtr_bottom'><label id='toggle'>Contact Number <span>*</span></label><input type='text' class='txt' name='phone' id='phone' value='<?php echo isset($val['phone']) ? $val['phone'] : ''  ?>' size='30' /><input type='text' class='txt invisible' name='email' id='email' value='<?php echo $val['email'] ?>' size='30' /><input type='text' class='txt invisible' name='fax' id='fax' value='<?php echo $val['fax'] ?>' size='30' /></p>
	<p id='xtr_top'>
		<label for='type' style='float: none;'>Type of equipment selling:</label>
		<select name='type' id='type'>
			<option value='cb'>Circuit Breakers</option>
			<option value='tr'>Transformers</option>
			<option value='mc'>Motor Controls</option>
			<option value='bu'>Busway</option>
			<option value='fu'>Fuses</option>
		</select>
	</p>
	<p>
		<label for='description' style='float: none; width: 475px; margin-bottom: 15px;'>Describe the equipment you are selling (provide an itemized list with catalog numbers if you are selling more than one item. <span>*</span></label>
		<textarea class='txt' name='description' id='msg' rows='13' cols='50'><?php echo isset($val['description']) ? $val['description'] : ''  ?></textarea>
	</p>
	<p><input type='submit' value='Submit' class='sbmt' name='lead' id='lead' /></p>
</form>
<?php else : ?>
<form class='section sell' method='post' action='<?php echo url_for('@sell_to_lws') ?>' enctype='application/x-www-form-urlencoded'>
	<h2>Sell Equipment Form:</h2>
	<p>Required fields marked <span style='color: #ff0000;'>*</span></p>
	<p><label for='company'>Company Name</label><input type='text' class='txt' name='company' id='company' value='' size='30' /></p>
	<p><label for='contact_name'>Contact Name <span>*</span></label><input type='text' class='txt' name='contact_name' id='contact_name' value='' size='30' /></p>
	<p><label for='preferred'>Preferred Contact Method</label><input type='radio' class='rdo' name='preferred' value='phone' checked='checked' /> Phone &nbsp; <input type='radio' class='rdo' name='preferred' value='email' /> Email &nbsp; <input type='radio' class='rdo' name='preferred' value='fax' /> Fax </p>
	<p id='xtr_bottom'><label id='toggle'>Contact Number <span>*</span></label><input type='text' class='txt' name='phone' id='phone' value='' size='30' /><input type='text' class='txt invisible' name='email' id='email' value='' size='30' /><input type='text' class='txt invisible' name='fax' id='fax' value='' size='30' /></p>
	<p id='xtr_top'>
		<label for='type' style='float: none;'>Type of equipment selling:</label>
		<select name='type' id='type'>
			<option value='cb'>Circuit Breakers</option>
			<option value='tr'>Transformers</option>
			<option value='mc'>Motor Controls</option>
			<option value='bu'>Busway</option>
			<option value='fu'>Fuses</option>
		</select>
	</p>
	<p>
		<label for='description' style='float: none; width: 475px; margin-bottom: 15px;'>Describe the equipment you are selling (provide an itemized list with catalog numbers if you are selling more than one item. <span>*</span></label>
		<textarea class='txt' name='description' id='msg' rows='13' cols='50'></textarea>
	</p>
	<p><input type='submit' value='Submit' class='sbmt' name='lead' id='lead' /></p>
</form>
<?php endif; ?>
<?php slot('sidebar') ?>
	 <?php include_partial('global/expertBox') ?>
<?php end_slot() ?>
