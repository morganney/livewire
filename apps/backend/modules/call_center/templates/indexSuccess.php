<?php use_stylesheet('be/cc') ?>
<?php use_javascript('be/cc') ?>
<?php if($sf_user->hasFlash('cc_msg')) : ?>
<p class='user_msg'><?php echo $sf_user->getFlash('cc_msg') ?></p>
<?php endif; ?>
<h2>Quick Customer Search <?php echo link_to('new customer+', '@new_customer') ?></h2>
<form class='search' method='get' action='<?php echo url_for('@cc_search') ?>'>
	<input type='hidden' name='for' value='customer' />
	<p><input type='text' class='txt' id='cust_cell' size='35' name='q' value='' /> <input class='srch_btn' type='submit' value='Go' /></p>
	<div id='cust_serps' class='serps'></div>	
</form>
<form class ='search' method='get' action='<?php echo url_for('@cc_search') ?>'>
	<h2>
  	Quick Ticket Search
  	<input type='hidden' name='for' value='ticket' />
		<input type='radio' class='rdo' name='category' checked='checked' value='1' /> <span>RFQ /</span> 
		<input type='radio' class='rdo' name='category' value='2' /> <span>Technical Support /</span> 
		<input type='radio' class='rdo' name='category' value='3' /> <span>Return /</span>
		<input type='radio' class='rdo' name='category' value='4' /> <span>Tracking</span>
	</h2>
	<p><input type='text' class='txt' id='tick_cell' size='35' name='q' value='' /> <input class='srch_btn' type='submit' value='Go' /></p>
	<div id='tick_serps' class='serps'></div>
</form>
<table cellpadding='0' cellspacing='0' class='lws_be'>
	<caption>Open Tickets Queue <?php echo link_to('filter+', '@call_center') ?></caption>
	<colgroup>
		<col id='col_1' />
		<col id='col_2' />
		<col id='col_3' />
		<col id='col_4' />
		<col id='col_5' />
		<col id='col_6' />
	</colgroup>
	<thead>
		<tr><th scope='col'>Ticket ID</th><th scope='col'>Ticket Type</th><th scope='col'>Openned By</th><th scope='col'>Open Date</th><th scope='col'>Customer</th></tr>
	</thead>
	<tbody>
	<?php if($open_tickets) : $i = 0 ?>
		<?php foreach($open_tickets as $ticket) : $i++ ?>
		<tr<?php echo ($i%2) == 0 ? " class='e'" : '' ?>>
			<td><?php echo link_to($ticket['ticket_id'], "{$ticket['route']}{$ticket['ticket_id']}") ?></td>
			<td><?php echo $ticket['category'] ?></td>
			<td><?php echo $ticket['first_name'],' ', $ticket['last_name'] ?></td>
			<td><?php echo date(sfConfig::get('app_formats_date'), $ticket['openned_ts']) ?></td>
			<td><?php echo link_to($ticket['company'],"@customer?id={$ticket['customer_id']}") ?></td>
		</tr>
		<?php endforeach; ?>
	<?php else : ?>
		<tr><td colspan='5'>There are no open tickets in the system</td></tr>
	<?php endif; ?>
	</tbody>
</table>
<pre style='font-size: 14px'><?php //print_r($open_tickets) ?></pre>