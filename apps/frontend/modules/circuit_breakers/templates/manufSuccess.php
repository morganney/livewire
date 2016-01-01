
<?php use_stylesheet('cmp') ?>
<?php use_stylesheet('select') ?>
<?php use_javascript('jquery.cycle.all.min.js') ?>
<?php use_javascript('cb-select') ?>
<?php include_partial('global/h1', array('txt' => "{$param['manuf']} Circuit Breakers")) ?>
<?php include_partial('global/manufBox', array('param' => $param)) ?>

<p id='or'><span>OR</span></p>
<h2 class='manuf_label'><img src='/images/manuf/new/<?php echo $param['manuf_slug'] ?>.png' alt='<?php echo $param['manuf'] ?>' /> <?php echo link_to('Circuit Breaker Selection Tool', "@cb_manuf?manuf_slug={$param['manuf_slug']}", array('id' => 'step_focus', 'anchor' => 'circuit-breaker-selection-tool', 'rel' => 'nofollow')) ?></h2>
<div id='step_box'>
	<div class='step one'></div>
	<div id='step'>
		<h2>Select Your Frame Type</h2>
		<table id='frame_types' cellspacing='0' cellpadding='0'>
			<tbody>
				<tr>
				<?php foreach($frame_types as $idx => $arr) : ?>
					<?php if($idx != 0 && $idx % 10 == 0) : ?>
					</tr><tr>
					<?php endif; ?>
					<td>
						<?php echo link_to(image_tag($arr['img_src'], array('alt' => $arr['frame_type'])) ,'@cb_select', array('query_string' => "manuf_id={$param['manuf_id']}&frame={$arr['frame_type']}&step=frame", 'class' => 'ajax', 'rel' => 'nofollow')) ?>
						<?php echo link_to($arr['frame_type'], '@cb_select', array('query_string' => "manuf_id={$param['manuf_id']}&frame={$arr['frame_type']}&step=frame", 'class' => 'ajax', 'rel' => 'nofollow')) ?>
					</td>
				<?php endforeach; ?>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php if(!is_null($featured_parts)) : ?>
<?php include_partial('global/featuredParts', array('param' => $param, 'featured_parts' => $featured_parts)) ?>
<?php endif; ?>
<p>We carry all types of circuit breakers.  From shunt trip breakers to breakers with bell alarms.  We carry all kinds of breaker accessories like UVR Lugs, trip units, rating plugs and mounting hardware.  We are also able to test and rebuild circuit breakers.</p>
<p id='legal_copy'>LiveWire is a surplus supplier of <?php echo $param['manuf'],' ' ,$param['category'] ?>. The <?php echo $param['manuf'] ?> Logo and Tradename are registered trademarks of <?php echo $param['manuf'] ?>.</p>
<?php slot('sidebar') ?>
	<?php include_partial('global/manufLevelSidebar', array('param' => $param)) ?>
<?php end_slot() ?>

<?php if(LWS::isOutsideBizHours()) : ?>
	<?php slot('after_hours') ?>
		<?php include_partial('global/afterHoursMessage') ?>
	<?php end_slot() ?>
<?php endif;?>
