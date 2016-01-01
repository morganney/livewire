<?php use_stylesheet('profile') ?>
<?php include_partial('global/h1', array('txt' => "LiveWire Customer Profile: {$profile['customer_name']}")) ?>
<div id='profile' style='background-image: url(<?php echo $profile['bg_img'] ?>);'>
<?php echo $profile['content'] ?>
</div>
<?php slot('sidebar') ?>
	<ul id='profile_nav'>
		<li class='first'><?php echo link_to('Tom Boyle', '@customer_profiles?name_slug=tom-boyle') ?>CES Electric</li>
		<li><?php echo link_to('Nick Abbot', '@customer_profiles?name_slug=nick-abbot') ?>All Industrial Electrical Supply</li>
		<li><?php echo link_to('Kyle Kroner', '@customer_profiles?name_slug=kyle-kroner') ?>Pettus Services</li>
		<li><?php echo link_to('Joseph Ianni', '@customer_profiles?name_slug=joseph-ianni') ?>Redriven Corporation</li>
		<li class='xtra_bottom'><?php echo link_to('Bill Minich', '@customer_profiles?name_slug=bill-minich') ?>Hull Electric</li>
		<li class='xtra_top'><?php echo link_to('Who buys from LiveWire?', '@our_customers') ?></li>
	</ul>
<?php end_slot() ?>
