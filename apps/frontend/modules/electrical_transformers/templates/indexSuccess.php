<?php use_stylesheet('cmp') ?>
<?php use_javascript('t') ?>
<?php include_partial('global/h1', array('txt' => 'Electrical Transformers by LiveWire Supply')) ?>
<form id='tr_search' method='get' action='<?php echo url_for('@part_search') ?>'>
	<h2 id='srch'>SEARCH BY PART NUMBER</h2>
	<p class='sp'>Enter your Transformer Catalog Number Here</p>
	<p><input type='text' size='26' maxlength='50' value='' class='txt' name='q' /></p>
	<p><input type='submit' value='' class='sbmt' /></p>
	<input type='hidden' name='section' value='tr' />
</form>
<div id='tr_selection'>
	<h2 id='select'>SELECT THE PART YOU NEED</h2>
	<p class='sp'>Use LiveWire's Selection process to find the right Transformer!</p>
	<p><?php echo link_to(image_tag('start-btn-trans.png'), '@tr_select') ?></p>
</div>
<div class='manuf_box'>
	<h3><span>OR</span> Select a Transformer Manufacturer</h3>
	<ul class='manufs'>
		<li class='top left ac'><?php echo link_to('ACME Transformers', '@tr_manuf?manuf_slug=acme', array('title' => 'Transformers by ACME')) ?></li>
		<li class='top ch'><?php echo link_to('Cutler Hammer Transformers', '@tr_manuf?manuf_slug=cutler-hammer', array('title' => 'Transformers by Cutler Hammer')) ?></li>
		<li class='top ge'><?php echo link_to('General Electric Transformers', '@tr_manuf?manuf_slug=ge', array('title' => 'Transformers by GE')) ?></li>
		<li class='left hp'><?php echo link_to('Hammond Power Solutions Transformers', '@tr_manuf?manuf_slug=hammond-power', array('title' => 'Transformers by HPS')) ?></li>
		<li class='je'><?php echo link_to('Jefferson Electric Transformers', '@tr_manuf?manuf_slug=jefferson', array('title' => 'Transformers by Jefferson Electric')) ?></li>
		<li class='si'><?php echo link_to('Siemens Transformers', '@tr_manuf?manuf_slug=siemens', array('title' => 'Transformers by Siemens')) ?></li>
		<li class='left sd'><?php echo link_to('Square D Transformers', '@tr_manuf?manuf_slug=square-d', array('title' => 'Transformers by Square D')) ?></li>
	</ul>
</div>
<p>Electrical Transformers are one of LiveWire's many stregnths.  We carry all major brands of electrical transformers including: Hammond Power Solutions, Jefferson, ACME, Square D, Siemens, Cutler Hammer and General Electric.  Have a huge list of parts, shopping for the best price?  Your search is over.  LiveWire offers brand new, new surplus, and certified green transformers at extremely low prices yet, we make no compromises on quality or lead time.  Many of the transformers we sell carry a 10-year warranty!  To save time and cost, we ship from regional locations across the county and have great prices negotiated with trucking companies to ensure a low total cost of purchase.  Have a unique application, no one else is able to help?  We can help engineer a solution for your unique application!</p>
<p>We have Electrical Transformer experts that can help with technical questions or to help you through emergency outages 24 hours per day.  In fact, we put manufacturer's data sheets and tens of thousands of photos right on the site. We carry the components, big and small to get you back on line quickly and more importantly, at a reasonable price.  We are an authorized distributor for some but not all of the lines listed above.  For example, we carry authentic new surplus Allen Bradly, GE, Cutler Hammer and Square D equipment. When you buy from LiveWire Supply you will see why we are known as the Internet's #1 Electrical Supply House!</p>
<?php slot('sidebar') ?>
	<?php include_partial('global/categoryLevelSidebar', array('category' => 'Electrical Transformers')) ?>
<?php end_slot() ?>
