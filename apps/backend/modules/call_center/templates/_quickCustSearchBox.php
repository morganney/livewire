<?php if(is_array($customers)) : ?>
<?php foreach($customers as $customer) : ?>
<div class='qx_serp'>
	<h3><?php echo link_to($customer['company'], $customer['route']) ?></h3>
	<p><strong>Contact:</strong> <?php echo $customer['contact'] ?></p>
	<p><strong>Geo:</strong> <?php echo $customer['geo'] ?></p>
</div>
<?php endforeach; ?>
<?php endif; ?>