
<?php use_stylesheet('cmp') ?>
<?php use_stylesheet('select') ?>

<?php include_partial('global/h1', array('txt' => "{$manuf} Circuit Breakers Selection Process")) ?>

<h2 class='manuf_label'><img src='/images/manuf/new/<?php echo $manuf_slug ?>.png' alt='<?php echo $manuf ?>' /> Circuit Breakers Selection Tool</h2>
<div id='step_box'>
	<h3>You've selected <span><?php echo $selection ?></span> for your Frame Type</h3>
	<div class='step two'><!-- sorry markup purists --></div>
	<div id='step'>
		<h2>Select Your Pole Number</h2>
		<div id='poles'>
			<?php foreach($data as $idx => $arr) : ?>
				<p class='<?php echo $arr['class'] ?>'><?php echo link_to("{$arr['AT']}-Pole", '@cb_select', array('query_string' => $arr['QS'], 'class' => 'ajax')) ?></p>
			<?php endforeach; ?>
		</div>
		
		<?php include_partial('matchingResults', array('results_so_far' => $results_so_far, 'search_params' => $search_params)) ?>
		
		<div style='clear: both;'></div>
	</div>
</div>

<?php slot('sidebar') ?>
	<?php include_partial('global/selectToolSidebar', array('category' => 'Circuit Breakers')) ?>
<?php end_slot() ?>

