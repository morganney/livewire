<?php use_stylesheet('be/sim-custs') ?>
<?php use_javascript('be/save') ?>
<?php $form = $sf_user->getAttribute('new_cust_form') ?>
<h2>Attention: Similar Customers Found In Database!</h2>
<p class='user_msg'>Check If the customer is already listed and click "continue".  Otherwise confirm below that this is a new customer.</p>
<table cellpadding='0' cellspacing='0' class='lws_be'>
	<thead>
		<tr><th>Company</th><th>Phone</th><th>Email</th><th>Contact</th><th>Address</th><th>  </th></tr>
	</thead>
	<tbody>
		<?php $i = 0; foreach($sf_user->getAttribute('similar_customers') as $customer) : $i++ ?>
		<tr<?php echo ($i%2) == 0 ? " class='e'" : '' ?>>
			<td class='c'><?php echo $customer['company'] ?></td>
			<td class='p'><?php echo $customer['phone'] ?></td>
			<td><?php echo $customer['email'] ?></td>
			<td><?php echo ucwords($customer['contact']) ?></td>
			<td class='a'><?php echo ucwords($customer['loc1']), '<br />', ucwords($customer['loc2']) ?></td>
			<td class='v'><?php echo link_to('continue', "@customer?id={$customer['customer_id']}") ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<h3 class='or'><span>OR</span> Yes, I'm Sure This is a <em>New Customer</em></h3>
<table class='cust_rec' cellpadding='0' cellspacing='0'>
	<tbody>
	  <tr><td class='tag'>Company:</td><td><?php echo $form['company'] ?></td></tr>
		<tr><td class='tag'>First Name:</td><td><?php echo !empty($form['c_fn']) ? $form['first_name'] : '<em>NULL</em>' ?></td></tr>
		<tr><td class='tag'>Last Name:</td><td><?php echo !empty($form['c_ln']) ? $form['last_name'] : '<em>NULL</em>' ?></td></tr>
		<tr><td class='tag'>Email:</td><td><?php echo !empty($form['c_email']) ? $form['email'] : '<em>NULL</em>' ?></td></tr>
		<tr><td class='tag'>Phone:</td><td><?php echo !empty($form['p1']) ? "({$form['p1']})-{$form['p2']}-{$form['p3']}" : '<em>NULL</em>' ?></td></tr>
		<tr><td class='tag'>Phone 2:</td><td><?php echo !empty($form['a1']) ? "({$form['a1']})-{$form['a2']}-{$form['a3']}" : '<em>NULL</em>' ?></td></tr>
		<tr><td class='tag'>Fax:</td><td><?php echo !empty($form['f1']) ? "({$form['f1']})-{$form['f2']}-{$form['f3']}" : '<em>NULL</em>' ?></td></tr>
		<tr><td class='tag'>Address 1:</td><td><?php echo !empty($form['address_1']) ? $form['address_1'] : '<em>NULL</em>' ?></td></tr>
		<tr><td class='tag'>Address 2:</td><td><?php echo !empty($form['address_2']) ? $form['address_2'] : '<em>NULL</em>' ?></td></tr>
		<tr><td class='tag'>City:</td><td><?php echo !empty($form['city']) ? $form['city'] : '<em>NULL</em>' ?></td></tr>
		<tr><td class='tag'>State:</td><td><?php echo $form['region'] ?></td></tr>
		<tr><td class='tag'>Zip:</td><td><?php echo !empty($form['postal_code']) ? $form['postal_code'] : '<em>NULL</em>' ?></td></tr>
		<tr><td class='tag'>Country:</td><td><?php echo $form['country'] ?></td></tr>
		<tr><td class='tag'>Notes:</td><td><?php echo !empty($form['personal']) ? BE::formatNote($form['personal']) : '<em>NULL</em>' ?></td></tr>
	</tbody>
</table>
<ul id='actions'>
	<li class='l'><?php echo link_to('Save Customer & Continue', '@confirm_new_cust') ?></li>
</ul>
