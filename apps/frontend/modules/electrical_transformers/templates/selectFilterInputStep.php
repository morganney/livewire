
<?php use_stylesheet('select') ?>
<?php include_partial('global/h1', array('txt' => 'Electrical Transformers Selection Process')) ?>
<div id='step_box'>
	<h3>You've selected <span><?php echo $selection ?></span> for your Input Voltage</h3>
	<div class='step four'><!-- sorry markup purists, prevents loading a new img during ajax requests --></div>
	<div id='step'>
		<h2 class='four'>Select Your Output(Secondary) Voltage</h2>
		<div id='output_volts'>
			<ul class='simple'>
			<?php foreach($data as $arr) : ?>
			  <li>
			  	<?php echo link_to($arr['AT'], '@tr_select', array('query_string' => $arr['QS'])) ?>
			  	<?php if($arr['VV']) : ?>
			  		<?php for($i = 0, $s = count($arr['VV']); $i < $s; $i++) : ?>
			  		<?php if($i >= 1) : echo "<span class='m'>/</span>"; endif; ?>
			  		<span>(<?php echo $arr['VV'][$i] ?>)</span>
			  		<?php endfor; ?>
			  	<?php endif; ?>
			  </li>
			<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
<?php slot('sidebar') ?>
	<?php include_partial('global/selectToolSidebar', array('category' => 'Electrical Transformers')) ?>
<?php end_slot() ?>
