
<?php if($serps) : $i = 0 ?>
	<table class='lws_be' cellpadding='0' cellspacing='0'>
		<caption>Search results for query: "<?php echo $sf_request->getParameter('q') ?>"</caption>
		<?php if($sf_request->getParameter('for') == 'customer') : ?>
		<thead><tr><th>Company</th><th>Contact</th><th>Location</th><th>Phone</th><th>Email</th></tr></thead>
		<tbody>
		<?php foreach($serps as $serp) : $i++ ?>
		<tr<?php echo ($i%2) == 0 ? " class='e'" : ''?>>
			<td><?php echo link_to($serp['company'], $serp['route']) ?></td>
			<td><?php echo $serp['contact'] ?></td>
			<td><?php echo $serp['geo'] ?></td>
			<td><?php echo $serp['phone'] ?></td>
			<td><?php echo $serp['email'] ?></td>
		</tr>
		<?php endforeach; ?>
		<?php else : ?>
		<thead><tr><th>Ticket No.</th><th>Type</th><th>Company</th><th>Openned</th><th>Status</th></tr></thead>
		<tbody>
		<?php foreach($serps as $serp) : $i++ ?>
		<tr<?php echo ($i%2) == 0 ? " class='e'" : ''?>>
			<td><?php echo link_to($serp['id'], $serp['route']) ?></td>
			<td><?php echo $serp['category'] ?></td>
			<td><?php echo link_to($serp['company'], "@customer?id={$serp['customer_id']}") ?></td>
			<td><?php echo $serp['openned'] ?></td>
			<td><?php echo $serp['status'] ?></td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
<?php else : ?>
<h2>Search results for query: "<?php echo $sf_request->getParameter('q') ?>"</h2>
<p>There were no results for your entered query.</p>
<?php endif; ?>
