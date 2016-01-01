<?php use_stylesheet('be/customer') ?>
<?php if($sf_user->hasFlash('cust_info')) : ?>
<p class='user_msg'><?php echo $sf_user->getFlash('cust_info') ?></p>
<?php endif; ?>
<h2><?php echo $c['company'],' ', link_to('edit', "@edit_customer?id={$c['c_id']}") ?></h2>
<div id='dash'>
	<table class='cust_rec' cellspacing='0' cellpadding='0'>
		<tbody>
			<tr><td class='tag'>Company:</td><td><?php echo $c['company'] ?></td></tr>
			<tr><td class='tag'>First Name:</td><td><?php echo ucfirst($c['first_name']) ?></td></tr>
			<tr><td class='tag'>Last Name:</td><td><?php echo ucfirst($c['last_name']) ?></td></tr>
			<tr><td class='tag'>Email:</td><td><?php echo $c['email'] ?></td></tr>
			<tr><td class='tag'>Phone:</td><td><?php echo $c['phone']; echo $c['phone_ext'] ? " x {$c['phone_ext']}" : '' ?></td></tr>
			<tr><td class='tag'>Phone 2:</td><td><?php echo $c['alt_phone']; echo $c['alt_phone_ext'] ? " x {$c['alt_phone_ext']}" : '' ?></td></tr>
			<tr><td class='tag'>Fax:</td><td><?php echo $c['fax'] ?></td></tr>
			<tr><td class='tag'>Address:</td><td><?php echo ucwords($c['address_1']), ' ', ucwords($c['address_2']) ?></td></tr>
			<tr><td class='tag'>City:</td><td><?php echo ucwords($c['city']) ?></td></tr>
			<tr><td class='tag'>State:</td><td><?php echo $c['region'] ?></td></tr>
			<tr><td class='tag'>Zip:</td><td><?php echo $c['postal_code'] ?></td></tr>
			<tr><td class='tag'>Country:</td><td><?php echo $c['country'] ?></td></tr>
			<tr><td class='tag'>Customer Since:</td><td><?php echo date(sfConfig::get('app_formats_date'), $c['customer_since']) ?></td></tr>
			<tr><td class='tag'>Notes:</td><td><?php echo BE::formatNote($c['personal']) ?></td></tr>
		</tbody>
	</table>
	<ul id='actions'>
		<li><?php echo link_to('New RFQ Ticket', "@new_rfq?id={$c['c_id']}") ?></li>
		<li><?php echo link_to('New Return Ticket', "@new_return?id={$c['c_id']}") ?></li>
		<li><?php echo link_to('New Tracking Ticket', "@new_tracking?id={$c['c_id']}") ?></li>
		<li class='l'><?php echo link_to('New Support Ticket', "@new_support?id={$c['c_id']}") ?></li>
	</ul>
</div>
<table cellpadding='0' cellspacing='0' class='lws_be'>
	<caption>Ticket History</caption>
	<thead>
		<tr><th>Ticket ID</th><th>Ticket Type</th><th>Openned</th><th>Last Modified</th><th>Status</th><th>Last Action</th></tr>
	</thead>
	<tbody>
	<?php if($tickets) : $i = 0; ?>
	<?php foreach($tickets as $ticket) : $i++ ?>
	<tr<?php echo ($i%2) == 0 ? " class='e'" : ''?>>
		<td><?php echo link_to($ticket['ticket_id'],"{$ticket['route']}{$ticket['ticket_id']}") ?></td>
		<td><?php echo $ticket['category'] ?></td>
		<td><?php echo date(sfConfig::get('app_formats_date', $ticket['openned_ts'])) ?></td>
		<td><?php echo date(sfConfig::get('app_formats_date', $ticket['last_mod_ts'])) ?></td>
		<td><?php echo ucwords($ticket['status']) ?></td>
		<td><?php echo $ticket['action'] ?></td>
	</tr>
	<?php endforeach; ?>
	<?php else : ?>
	<tr><td colspan='6'>This customer has no ticket history.</td></tr>
	<?php endif; ?>
	</tbody>
</table>