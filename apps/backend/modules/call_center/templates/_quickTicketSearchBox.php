<?php if(is_array($tickets)) : ?>
<?php foreach($tickets as $ticket) : ?>
<div class='qx_serp'>
	<h3><?php echo link_to("{$ticket['id']} / {$ticket['category']}", $ticket['route']) ?></h3>
	<p><strong>Openned:</strong> <?php echo $ticket['openned'] ?></p>
	<p><strong>Company:</strong> <?php echo $ticket['company'] ?></p>
</div>
<?php endforeach; ?>
<?php endif; ?>