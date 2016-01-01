<?php use_stylesheet('search') ?>
<?php include_partial('global/h1', array('txt' => 'No Results Found', 'hide_phone_num' => true)) ?>

<h2>Your search did not match any products. You should either:</h2>
<div id='nosearch'>
	<p>1) <a href="javascript:history.go(-1)">Go Back</a> to your previous search and <span> BE SURE TO REMOVE </span>'empty spaces' in your part number search.</p>
	<p>2) Call an electrical supply expert at <strong> 800-390-3299 </strong>. Let them know you searched for a part and couldn't find it on our website. We will update it so the next time you search for it, you'll find it.</p>
</div>
<?php slot('sidebar') ?>
<ul id= 'product_srch'>
	<li><a href='<?php echo url_for('@circuit_breakers') ?>'>CIRCUIT BREAKERS</a></li>
	<li><a class='trans' href='<?php echo url_for('@electrical_transformers') ?>'>TRANSFORMERS</a></li>
	<li><a class='motor_c' href='<?php echo url_for('@motor_control') ?>'>MOTOR CONTROLS</a></li>
	<li><a class='bus' href='<?php echo url_for('@busway') ?>'>BUSWAY</a></li>
	<li><a class='fuses' href='<?php echo url_for('@fuses') ?>'>FUSES</a></li>
	<li><a  class='med_v' href='<?php echo url_for('@medium_voltage') ?>'>MEDIUM VOLTAGE</a></li>
</ul>
<?php end_slot() ?>
