<?php include_partial('global/h1', array('txt' => 'Our Product Offerings')) ?>
<div id='lws_products'>
	<div class='product cb'>
		<a href='<?php echo url_for('@circuit_breakers') ?>'>CIRCUIT BREAKERS</a>
		<p>Under pressure to replace a circuit breaker? Starting a new project on a budget? LiveWire stocks new and used circuit breakers that are certified and guaranteed.</p>
	</div>
	<div class='product tr'>
		<a href='<?php echo url_for('@electrical_transformers') ?>'>TRANSFORMERS</a>
		<p>1 KVA to 25MVA. 1 volt to 46 KV. Buy dry-type and liquid filled transformers from over 25 manufacturers. We specialize in quick turn-around and custom builds.</p>
	</div>
	<div class='product mc last'>
		<a href='<?php echo url_for('@motor_control') ?>'>MOTOR CONTROLS</a>
		<p>Mechanical problems? Buy replacement parts or have your equipment repaired. Need a heater or a medium voltage contactor? LiveWire can help get you back on-line.</p>
	</div>
	<div class='product bu bottom'>
		<a href='<?php echo url_for('@busway') ?>'>BUSWAY</a>
		<p>Expanding existing busway? Replacing a burnt out busplug? Need a custom-made part? LiveWire supplies obsolete and current model busway plugs and busduct.</p>
	</div>
	<div class='product fu bottom'>
		<a href='<?php echo url_for('@fuses') ?>'>FUSES</a>
		<p>Same day shipments, technical support and easy on-line ordering are available for Bussman, Littlefuse and Ferraz Shawmut. You can buy new and obsolete fuses.</p>
	</div>
	<div class='product mv last bottom'>
		<a href='<?php echo url_for('@medium_voltage') ?>'>MEDIUM VOLTAGE</a>
		<p>LiveWire Medium Voltage Equipment has made its name known by delivering Certified Equipment on a quick turnaround. Switchgear, breakers, contactors and more.</p>
	</div>
</div>
<?php slot('sidebar') ?>
	<?php include_partial('global/expertBox') ?>
<?php end_slot() ?>
