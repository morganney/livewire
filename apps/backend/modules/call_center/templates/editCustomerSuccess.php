<?php use_stylesheet('be/customer-form') ?>
<?php if($sf_user->hasFlash('edit_cust_err')) : ?>
<p class='user_msg'><?php echo $sf_user->getFlash('edit_cust_err') ?></p>
<?php endif; ?>
<h2><?php echo $c['company'] ?> / Editing</h2>
<form id='edit' method='post' action='<?php echo url_for("@edit_customer?id={$c['customer_id']}") ?>' enctype='application/x-www-form-urlencoded'>
<table class='cust_rec' cellpadding='0' cellspacing='0'>
	<tbody>
	  <tr><td class='tag'>Company:</td><td><input type='text' class='txt' name='company' id='company' maxlength='100' value="<?php echo $c['company'] ?>" /></td></tr>
		<tr><td class='tag'>First Name:</td><td><input type='text' class='txt' name='first_name' id='first_name' maxlength='50' value="<?php echo ucfirst($c['first_name']) ?>" /></td></tr>
		<tr><td class='tag'>Last Name:</td><td><input type='text' class='txt' name='last_name' id='last_name' maxlength='50' value="<?php echo ucfirst($c['last_name']) ?>" /></td></tr>
		<tr><td class='tag'>Email:</td><td><input type='text' class='txt' name='email' id='email' maxlength='100' value="<?php echo $c['email'] ?>" /></td></tr>
		<tr><td class='tag'>Phone:</td><td class='phone'>( <input type='text' class='txt' name='p1' id='p1' maxlength='3' size='2' value="<?php echo $c['p1'] ?>" /> ) <input type='text' class='txt' name='p2' id='p2' maxlength='3' size='2' value='<?php echo $c['p2'] ?>' /> &ndash; <input type='text' class='txt' name='p3' id='p3' maxlength='4' size='3' value='<?php echo $c['p3'] ?>' /> X <input type='text' class='txt' name='phone_ext' id='phone_ext' maxlength='5' size='2' value='<?php echo $c['phone_ext'] ?>' /></td></tr>
		<tr><td class='tag'>Phone 2:</td><td class='phone'>( <input type='text' class='txt' name='a1' id='a1' maxlength='3' size='2' value="<?php echo $c['a1'] ?>" /> ) <input type='text' class='txt' name='a2' id='a2' maxlength='3' size='2' value='<?php echo $c['a2'] ?>' /> &ndash; <input type='text' class='txt' name='a3' id='a3' maxlength='4' size='3' value='<?php echo $c['a3'] ?>' /> X <input type='text' class='txt' name='alt_phone_ext' id='alt_phone_ext' maxlength='5' size='2' value='<?php echo $c['alt_phone_ext'] ?>' /></td></tr>
		<tr><td class='tag'>Fax:</td><td class='phone'>( <input type='text' class='txt' name='f1' id='f1' maxlength='3' size='2' value="<?php echo $c['f1'] ?>" /> ) <input type='text' class='txt' name='f2' id='f2' maxlength='3' size='2' value='<?php echo $c['f2'] ?>' /> &ndash; <input type='text' class='txt' name='f3' id='f3' maxlength='4' size='3' value='<?php echo $c['f3'] ?>' /></td></tr>
		<tr><td class='tag'>Address 1:</td><td><input type='text' class='txt' name='address_1' id='address_1' maxlength='255' value="<?php echo ucwords($c['address_1']) ?>" /></td></tr>
		<tr><td class='tag'>Address 2:</td><td><input type='text' class='txt' name='address_2' id='address_2' maxlength='255' value="<?php echo ucwords($c['address_2']) ?>" /></td></tr>
		<tr><td class='tag'>City:</td><td><input type='text' class='txt' name='city' id='city' maxlength='100' value="<?php echo ucwords($c['city']) ?>" /></td></tr>
		<tr><td class='tag'>State:</td><td><?php include_partial('global/stateBox', array('form' => $c, 'no_label' => true)) ?></td></tr>
		<tr><td class='tag'>Zip:</td><td><input type='text' class='txt' name='postal_code' id='postal_code' maxlength='15' value="<?php echo strtoupper($c['postal_code']) ?>" /></td></tr>
		<tr><td class='tag'>Country:</td><td><?php include_partial('global/countryBox', array('form' => $c, 'no_label' => true)) ?></td></tr>
		<tr><td class='tag'>Notes:</td><td><textarea name='personal' id='personal' cols='25' rows='3'><?php echo $c['personal'] ?></textarea></td></tr>
	</tbody>
</table>
<input type='hidden' name='customer_id' value='<?php echo $c['customer_id'] ?>' />
<p id='cust_btns'><input type='submit' value='Update Customer' /></p>
</form>
<ul id='actions'>
	<li class='l'><?php echo link_to('Return to Customer', "@customer?id={$c['customer_id']}") ?></li>
</ul>
