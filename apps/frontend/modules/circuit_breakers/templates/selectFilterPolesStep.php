
<?php use_stylesheet('cmp') ?>
<?php use_stylesheet('select') ?>

<?php include_partial('global/h1', array('txt' => "{$manuf} Circuit Breakers Selection Process")) ?>

<h2 class='manuf_label'><img src='/images/manuf/new/<?php echo $manuf_slug ?>.png' alt='<?php echo $manuf ?>' /> Circuit Breakers Selection Tool</h2>
<div id='step_box'>
	<h3>You've selected <span><?php echo $selection ?></span> Pole</h3>
	<div class='step three'><!-- sorry markup purists --></div>
	<div id='step'>
		<h2>Select Your Amperage</h2>
		<div id='av'>
			<ul class='amp_volt'>
			<?php foreach($data as $idx => $arr) : ?>
				<li><?php echo link_to($arr['AT'], '@cb_select', array('query_string' => $arr['QS'], 'class' => 'ajax', 'rel' => 'nofollow')) ?></li>
				<?php if($idx % 6 == 0) : ?>
				</ul>
				<ul class='amp_volt'>
				<?php endif; ?>
			<?php endforeach; ?>
			</ul>
		</div>
		
		<?php include_partial('matchingResults', array('results_so_far' => $results_so_far, 'search_params' => $search_params)) ?>
		
		<div style='clear: both;'></div>
	</div>
</div>

<?php slot('sidebar') ?>
	<?php include_partial('global/selectToolSidebar', array('category' => 'Circuit Breakers')) ?>
<?php end_slot() ?>
