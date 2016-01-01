<?php use_stylesheet('cmp') ?>
<?php use_javascript('manuf') ?>
<?php include_partial('global/h1', array('txt' => "{$param['manuf']} {$param['category']}")) ?>

<?php include_partial('global/manufBox', array('param' => $param)) ?>

<?php if(!is_null($featured_parts)) : ?>
<?php include_partial('global/newFeaturedParts', array('param' => $param, 'featured_parts' => $featured_parts)) ?>
<?php endif; ?>
<p>LiveWire also offers push buttons, relays, contactors, coils, heaters, Nema size 00 - 6 starters, din rail mount, enclosed starters, motor control center, feeder bucket, and auxilary switches.</p>
<p id='legal_copy'>LiveWire is a surplus supplier of <?php echo $param['manuf'],' ' ,$param['category'] ?>. The <?php echo $param['manuf'] ?> Logo and Tradename are registered trademarks of <?php echo $param['manuf'] ?>.</p>

<?php slot('sidebar') ?>
	<?php include_partial('global/manufLevelSidebar', array('param' => $param)) ?>
<?php end_slot() ?>

<?php if(LWS::isOutsideBizHours()) : ?>
	<?php slot('after_hours') ?>
		<?php include_partial('global/afterHoursMessage') ?>
	<?php end_slot() ?>
<?php endif;?>
