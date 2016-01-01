
<?php use_stylesheet('select') ?>
<?php use_javascript('tr-select') ?>
<?php include_partial('global/h1', array('txt' => 'Electrical Transformers Selection Process')) ?>
<div id='step_box'>
	<h3>You've selected <span><?php echo $selection ?></span> for your Phase</h3>
	<div class='step three'><!-- sorry markup purists, prevents loading a new img during ajax requests --></div>
	<div id='step'>
		<h2 class='three'>Select Your Input(Primary) Voltage <img id='tooltip' src='/images/help.png' alt='Voltage Help' /></h2>
		<div id='tip' class='invisible'>
			<p class='_1st q'><span>Q)</span> I have an uncommon voltage supply/requirement thats not listed, what should I do?</p>
			<p><span>A)</span> Most electrical equipment manufacturers allow a 5-10% voltage variance from the specific voltage on the name plate of the item being powered.  For example, if your equipment requires 110 volts, check your true incoming voltage and size the transformer accordingly. <em>In almost all cases, the following voltages are universally interchangeable</em>:</p>
			<ul>
					<li><strong>group 1 :</strong> (110, 115, 120, 125, 130)</li>
				 	<li><strong>group 2 :</strong> (215, 220, 230, 240)</li>
				 	<li><strong>group 3 :</strong> (430, 440, 450, 460, 470, 490, 500)</li>
				 	<li><strong>group 4 :</strong> (380, 400)</li>
			</ul>
			<p class='q'><span>Q)</span> My line voltage reading is somewhere between 110 and 130; it's not exactly 120 but the transformer I want to purchase is labeled with a 120 volt input - is this going to work for me?</p>
			<p><span>A)</span> Most electrical equipment manufacturers allow a 5-10% voltage variance from the specific voltage on the name plate.  For example, if your equipment requires 110 volts, check your true incoming voltage and size the transformer accordingly.  <em>In almost all cases, the following voltages are universally interchangeable</em>:</p>
			<ul>
					<li><strong>group 1 :</strong> (110, 115, 120, 125, 130)</li>
				 	<li><strong>group 2 :</strong> (215, 220, 230, 240)</li>
				 	<li><strong>group 3 :</strong> (430, 440, 450, 460, 470, 490, 500)</li>
				 	<li><strong>group 4 :</strong> (380, 400)</li>
			</ul>
		</div>
		<div id='input_volts'>
			<ul class='simple'>
			<?php foreach($data as $arr) : ?>
			  <li>
			  	<?php echo link_to($arr['AT'], '@tr_select', array('query_string' => $arr['QS'], 'class' => 'ajax')) // NOTE: added tooltip info and ajax class for users arriving from a goodle adwords impression that do have JS enabled ?>
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
