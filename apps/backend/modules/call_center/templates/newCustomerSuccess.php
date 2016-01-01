<?php use_stylesheet('be/customer-form') ?>
<?php use_javascript('be/new-customer') ?>
<?php $form = $sf_user->getAttribute('new_cust_form', NULL) ?>
<?php include_partial('global/userMessages', array('flash_name' => 'new_cust_err')) ?>
<h2>New Customer Form</h2>
<form id='new_cust' method='post' action='<?php echo url_for('@new_customer') ?>' enctype='application/x-www-form-urlencoded'>
<table class='cust_rec' cellpadding='0' cellspacing='0'>
	<tbody>
	  <tr><td class='tag reg'>Company:</td><td><input type='text' class='txt req' name='company' id='company' maxlength='100' value="" /></td></tr>
		<tr><td class='tag'>First Name:</td><td><input type='text' class='txt' name='first_name' id='first_name' maxlength='50' value="" /></td></tr>
		<tr><td class='tag'>Last Name:</td><td><input type='text' class='txt' name='last_name' id='last_name' maxlength='50' value="" /></td></tr>
		<tr><td class='tag'>Email:</td><td><input type='text' class='txt' name='email' id='email' maxlength='100' value="" /></td></tr>
		<tr><td class='tag'>Phone:</td><td class='phone'>( <input type='text' class='txt' name='p1' id='p1' maxlength='3' size='2' value="" /> ) <input type='text' class='txt' name='p2' id='p2' maxlength='3' size='2' value='' /> &ndash; <input type='text' class='txt' name='p3' id='p3' maxlength='4' size='3' value='' /> X <input type='text' class='txt' name='phone_ext' id='phone_ext' maxlength='5' size='2' value='' /></td></tr>
		<tr><td class='tag'>Phone 2:</td><td class='phone'>( <input type='text' class='txt' name='a1' id='a1' maxlength='3' size='2' value="" /> ) <input type='text' class='txt' name='a2' id='a2' maxlength='3' size='2' value='' /> &ndash; <input type='text' class='txt' name='a3' id='a3' maxlength='4' size='3' value='' /> X <input type='text' class='txt' name='alt_phone_ext' id='alt_phone_ext' maxlength='5' size='2' value='' /></td></tr>
		<tr><td class='tag'>Fax:</td><td class='phone'>( <input type='text' class='txt' name='f1' id='f1' maxlength='3' size='2' value="" /> ) <input type='text' class='txt' name='f2' id='f2' maxlength='3' size='2' value='' /> &ndash; <input type='text' class='txt' name='f3' id='f3' maxlength='4' size='3' value='' /></td></tr>
		<tr><td class='tag'>Address 1:</td><td><input type='text' class='txt' name='address_1' id='address_1' maxlength='255' value="" /></td></tr>
		<tr><td class='tag'>Address 2:</td><td><input type='text' class='txt' name='address_2' id='address_2' maxlength='255' value="" /></td></tr>
		<tr><td class='tag'>City:</td><td><input type='text' class='txt' name='city' id='city' maxlength='100' value="" /></td></tr>
		<tr><td class='tag'>State:</td><td><?php include_partial('global/stateBox', array('no_label' => true)) ?></td></tr>
		<tr><td class='tag'>Zip:</td><td><input type='text' class='txt' name='postal_code' id='postal_code' maxlength='15' value="" /></td></tr>
		<tr><td class='tag'>Country:</td><td><?php include_partial('global/countryBox', array('no_label' => true)) ?></td></tr>
		<tr><td class='tag'>Notes:</td><td><textarea name='personal' id='personal' cols='25' rows='3'></textarea></td></tr>
	</tbody>
</table>
<p id='cust_btns'><input type='reset' value='Reset' /> <input id='save_cust' type='submit' value='Save Customer' /></p>
</form>
<ul id='actions'>
	<li class='l'><?php echo link_to('Cancel', '@call_center') ?></li>
</ul>
