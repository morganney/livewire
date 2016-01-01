<?php use_stylesheet('shipping') ?>
<?php include_partial('global/h1', array('txt' => 'Shipping Options')) ?>
<div class='shipping' id='ups'>
	<div>
		<h2><span>WHAT ARE MY</span> SHIPPING <em>OPTIONS?</em></h2>
		<p>The following shipping options are available:</p>
		<ul>
			<li>UPS Overnight</li>
			<li id='d2'>UPS 2-Day</li>
			<li id='d3'>UPS 3-Day</li>
			<li id='ground'>UPS Ground</li>
		</ul>
	</div>
</div>
<div class='shipping' id='same_day'>
	<div>
	  <h3>SAME DAY!</h3>
		<h4>Same Day Shipping for Cargo and Small Package</h4>
	</div>
	<p>UNITED AIRLINES <span>CARGO</span></p>
</div>
<div class='shipping' id='international'>
	<div>
	<h3>WE SHIP INTERNATIONAL!</h3>
	<p>Discuss these shipping options with your sales rep @ 800.390.3299</p>
	</div>
	<ul>
		<li>FedEx</li>
		<li>DHL</li>
		<li>USPS (United States Postal Service)</li>
		<li>TNT</li>
	</ul>
</div>
<p>LiveWire Supply and our partners fulfill shipments through UPS. Shipping and handling charges are calculated based on the product's travel distance and on the packaged weight of the shipment. LiveWire Supply receives discounted shipping rates and passes those savings on to our customers.</p>
<p>To ensure expedited delivery, place your order on-line before 1 pm EST. Late exceptions and special shipping arrangements may be made, call 1-800-390-3299 to speak with a sales representative. Ground orders may take up to 10 days.</p>
<?php slot('sidebar') ?>
	 <?php include_partial('global/expertBox') ?>
<?php end_slot() ?>
