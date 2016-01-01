
	<h3>You've selected <span><?php echo $selection ?></span> for your KVA rating</h3>
	<div class='step two'><img id='indy_1st' src='/images/industry-first-trans.png' alt="Industry's first transformer selection tool" /></div>
	<div id='step'>
	  <p id='ajax_back'><?php echo link_to(image_tag('arrow-back.png', array('alt' => 'Go Back')),'@tr_select') ?></p>
		<h2 class='two'>Select Your Phase</h2>
		<div id='phase'>
			<ul class='simple'>
			<?php foreach($data as $arr) : ?>
			  <li><?php echo link_to($arr['AT'], '@tr_select', array('query_string' => $arr['QS'], 'class' => 'ajax')) ?></li>
			<?php endforeach; ?>
			</ul>
		</div>
	</div>

