
<h3>You've selected <span><?php echo $selection ?></span> for your Frame Type</h3>
<div class='step two'><!-- sorry markup purists --></div>
<div id='step'>
	<h2>Select Your Pole Number</h2>
	<p id='ajax_back'><?php echo link_to(image_tag('arrow-back.png', array('alt' => 'Go Back')), '@cb_select', array('query_string' => $back_qs, 'class' => 'ajax', 'rel' => 'nofollow')) ?></p>
	<div id='poles'>
		<?php foreach($data as $idx => $arr) : ?>
			<p class='<?php echo $arr['class'] ?>'><?php echo link_to("{$arr['AT']}-Pole", '@cb_select', array('query_string' => $arr['QS'], 'class' => 'ajax')) ?></p>
		<?php endforeach; ?>
	</div>
	
	<?php include_partial('matchingResults', array('results_so_far' => $results_so_far, 'search_params' => $search_params)) ?>
	
	<div style='clear: both;'></div>
</div>
