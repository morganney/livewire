
<?php use_stylesheet('home') ?>
<?php use_javascript('jquery.cycle.lite.js') ?>
<?php use_javascript('h') ?>
<h1 id='h1_home'>Circuit Breakers, Transformers, and Switchgear</h1>
<div id='slideshow'>
	<ul id='slides'>
		<li id='slide_0'>
			<div class='slide_text'>
				<h2>Meeting the Needs of Global Industry</h2>
				<?php echo link_to('Industrial End-Users','@our_customers', array('anchor' => 'industrial-end-users')) ?>
			</div>
		</li>
		<li id='slide_1'>
			<div class='slide_text'>
				<h2>Emergency Repair and Replacement</h2>
				<?php echo link_to('Homeowners','@our_customers', array('anchor' => 'homeowners')) ?>
			</div>
		</li>
		<li id='slide_2'>
			<div class='slide_text'>
				<h2>Massive Inventory &amp; National Distribution</h2>
				<?php echo link_to('Wholesale Suppliers','@our_customers', array('anchor' => 'wholesale-suppliers')) ?>
			</div>
		</li>
		<li id='slide_3'>
			<div class='slide_text'>
				<h2>Meeting the Needs of Commerical Contractors</h2>
				<?php echo link_to('Contractors','@our_customers', array('anchor' => 'contractors')) ?>
			</div>
		</li>
	</ul>
</div>
<div id='mid_modules'>
	<form id='stock_search' class='module' name='stock_search' method='get' action='<?php echo url_for('@part_search') ?>'>
		<p class='first'><input type='text' class='txt' value='' name='q' maxlength='50' /></p>
		<p><input type='submit' value='' class='sbmt' /></p>
		<div id='product_categories'>
			<strong>PRODUCT CATEGORIES</strong>
			<ul id='categories'>
				<li id='circuit_breakers'><h3><?php echo link_to('CIRCUIT BREAKERS', '@circuit_breakers', array('title' => '')) ?></h3></li>
				<li id='transformers' class='right'><h3><?php echo link_to('TRANSFORMERS', '@electrical_transformers', array('title' => '')) ?></h3></li>
				<li id='busway'><h3><?php echo link_to('BUSWAY', '@busway', array('title' => '')) ?></h3></li>
				<li id='fuses' class='right'><h3><?php echo link_to('FUSES', '@fuses', array('title' => '')) ?></h3></li>
				<li id='motor_control'><h3><?php echo link_to('MOTOR CONTROL', '@motor_control', array('title' => '')) ?></h3></li>
				<li id='medium_voltage' class='right'><h3><?php echo link_to('MEDIUM VOLTAGE', '@medium_voltage', array('title' => '')) ?></h3></li>
			</ul>
		</div>
	</form>
	<div id='rotate' class='module'>
		<div class='slide' id='s_0'>
			 <h4>LiveWire<br /><em>in the News</em></h4>
			 <p><span>SAN FRANCISCO &ndash; January 23, 2008 &ndash; LiveWire Supply</span>, the Internet's No. 1 electrical supply house, today announced it provided a critical circuit breaker to one of the country's leading ski resorts after its main lift suffered a failure. The breaker provided by LiveWire Supply, a Siemens 1600 amp, enabled the resort to quickly restore power to its main ski lift after it failed to work for thousands of paying resort guests.</p>
			 <p>Vacation was almost ruined for thousands of skiers and snowboarders at Vail Mountain Ski Resort in central Colorado. The circuit breaker powering the main chair lift chauffeuring guests ...</p>
			 <a href='<?php echo url_for('@news_awards') ?>'><img src='/images/h/livewire-news-trans.png' alt='LiveWire Press' /></a>
		</div>
		<div class='slide invisible' id='s_1'>
			<h4>Low Price Leader</h4>
			<p>Price Match Policy</p>
		</div>
		<div class='slide invisible' id='s_2'>
			<h4>Same Day Shipping Available</h4>
		</div>
		<div class='slide invisible' id='s_3'>
			<h4><a href='<?php echo url_for('@our_customers') ?>'>Customer Profiles</a></h4>
		</div>
	</div>
	<div class='module' id='e_expert'>
		<h4>Speak with an Electrical Supply Expert</h4>
	</div>
</div>
<?php if(LWS::isOutsideBizHours()) : ?>
	<?php slot('after_hours') ?>
		<?php include_partial('global/afterHoursMessage') ?>
	<?php end_slot() ?>
<?php endif;?>