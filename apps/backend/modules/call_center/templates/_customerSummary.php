
<div class='module cs'>
	<h3>Customer Summary</h3>
	<div class='mod_data'>
		<table cellpadding='0' cellspacing='0'>
			<tbody>
				<tr class='tags'><td>Company</td><td>Contact Name</td><td>City</td><td>State</td><td>Country</td></tr>
				<tr><td><?php echo link_to($c['company'], "@customer?id={$c['customer_id']}") ?></td><td><?php echo ucfirst($c['first_name']), ' ', ucfirst($c['last_name']) ?></td><td><?php echo ucwords($c['city']) ?> </td><td><?php echo $c['region'] ?></td><td><?php echo $c['country'] ?></td></tr>
				<tr class='tags'><td>Email</td><td>Phone</td><td>Phone 2</td><td>Fax</td><td>Customer Since</td></tr>
				<tr><td><?php echo $c['email'] ?></td><td><?php echo empty($c['phone_ext']) ? $c['phone'] : "{$c['phone']} x {$c['phone_ext']}" ?></td><td><?php echo empty($c['alt_phone_ext']) ? $c['alt_phone'] : "{$c['alt_phone']} x {$c['alt_phone_ext']}" ?></td><td><?php echo $c['fax'] ?></td><td><?php echo date(sfConfig::get('app_formats_date'), $c['customer_since']) ?></td></tr>
			</tbody>
		</table>
	</div>
</div>
