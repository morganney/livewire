<?php use_stylesheet('rfq') ?>
<?php include_partial('global/h1', array('txt' => 'Request a Quote')) ?>
<ul id='categories'>
	<li class='top left cb'><?php echo link_to('CIRCUIT BREAKERS', '@rfq?category=circuit-breakers')?></li>
	<li class='top tr'><?php echo link_to('TRANSFORMERS', '@rfq?category=electrical-transformers')?></li>
	<li class='top mc'><?php echo link_to('MOTOR CONTROL', '@rfq?category=motor-control')?></li>
	<li class='left bu'><?php echo link_to('BUSWAY', '@rfq?category=busway')?></li>
	<li class='fu'><?php echo link_to('FUSES', '@rfq?category=fuses')?></li>
</ul>
<?php slot('sidebar') ?>
	<?php include_partial('quoteSidebar') ?>
<?php end_slot() ?>
