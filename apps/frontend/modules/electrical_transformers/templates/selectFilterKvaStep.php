
<?php use_stylesheet('select') ?>

<?php include_partial('global/h1', array('txt' => 'Electrical Transformers Selection Process')) ?>
<div id='step_box'>
	<h3>You've selected <span><?php echo $selection ?></span> for your KVA rating</h3>
	<div class='step two'><!-- sorry markup purists, prevents loading a new img during ajax requests --></div>
	<div id='step'>
		<h2 class='two'>Select Your Phase</h2>
		<div id='phase'>
			<ul class='simple'>
			<?php foreach($data as $arr) : ?>
			  <li><?php echo link_to($arr['AT'], '@tr_select', array('query_string' => $arr['QS'])) ?></li>
			<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
<?php slot('sidebar') ?>
	<?php include_partial('global/selectToolSidebar', array('category' => 'Electrical Transformers')) ?>
<?php end_slot() ?>
