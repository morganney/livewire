	
<h3>You've selected <span><?php echo $selection ?></span> for your Amperage</h3>
<div class='step four'><!-- sorry markup purists --></div>
<div id='step'>
	<h2>Select Your Voltage</h2>
	<p id='ajax_back'><?php echo link_to(image_tag('arrow-back.png', array('alt' => 'Go Back')), '@cb_select', array('query_string' => $back_qs, 'class' => 'ajax')) ?></p>
	<div id='av'>
		<ul class='amp_volt'>
		<?php foreach($data as $idx => $arr) : ?>
			<li><?php echo link_to($arr['AT'], '@cb_select', array('query_string' => $arr['QS'], 'rel' => 'nofollow')) ?></li>
			<?php if($idx % 4 == 0) : ?>
			</ul>
			<ul class='amp_volt'>
			<?php endif; ?>
		<?php endforeach; ?>
		</ul>
	</div>
	
	<?php include_partial('matchingResults', array('results_so_far' => $results_so_far, 'search_params' => $search_params)) ?>
	
	<div style='clear: both;'></div>
</div>