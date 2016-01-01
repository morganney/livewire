<?php use_stylesheet('cmp') ?>
<?php include_partial('global/h1', array('txt' => 'Circuit Breakers by LiveWire Supply')) ?>
<form class='basic' method='get' action='<?php echo url_for('@part_search') ?>'>
	<h2 id='sh'>Enter your Circuit Breaker Catalog Number Here</h2>
	<p><input type='text' size='26' maxlength='50' value='' class='txt' name='q' /><input type='submit' value='' class='sbmt' /></p>
	<input type='hidden' name='section' value='cb' />
</form>
<div class='manuf_box'>
	<h3><span>OR</span> Select a Circuit Breaker Manufacturer</h3>
	<ul class='manufs'>
		<li class='top left bu'><?php echo link_to('BUI Circuit Breakers', '@cb_manuf?manuf_slug=bui', array('title' => 'Cirucit Breakers by BUI')) ?></li>
		<li class='top ce'><?php echo link_to('Connecticut Electric Circuit Breakers', '@cb_manuf?manuf_slug=connecticut-electric', array('title' => 'Cirucit Breakers by Connecticut Electric')) ?></li>
		<li class='top ch'><?php echo link_to('Cutler Hammer Circuit Breakers', '@cb_manuf?manuf_slug=cutler-hammer', array('title' => 'Cirucit Breakers by Cutler Hammer')) ?></li>
		<li class='left fp'><?php echo link_to('Federal Pacific Circuit Breakers', '@cb_manuf?manuf_slug=federal-pacific', array('title' => 'Cirucit Breakers by Federal Pacific')) ?></li>
		<li class='ge'><?php echo link_to('General Electric Circuit Breakers', '@cb_manuf?manuf_slug=ge', array('title' => 'Cirucit Breakers by General Electric')) ?></li>
		<li class='mu'><?php echo link_to('Murray Circuit Breakers', '@cb_manuf?manuf_slug=murray', array('title' => 'Cirucit Breakers by Murray')) ?></li>
		<li class='left si'><?php echo link_to('Siemens Circuit Breakers', '@cb_manuf?manuf_slug=siemens', array('title' => 'Cirucit Breakers by Siemens')) ?></li>
		<li class='sd'><?php echo link_to('Square D Circuit Breakers', '@cb_manuf?manuf_slug=square-d', array('title' => 'Cirucit Breakers by Square D')) ?></li>
		<li class='tb'><?php echo link_to('Thomas & Betts Circuit Breakers', '@cb_manuf?manuf_slug=thomas-betts', array('title' => 'Cirucit Breakers by Thomas & Betts')) ?></li>
		<li class='left wa'><?php echo link_to('Wadsworth Circuit Breakers', '@cb_manuf?manuf_slug=wadsworth', array('title' => 'Cirucit Breakers by Wadsworth')) ?></li>
		<li class='we'><?php echo link_to('Westinghouse Circuit Breakers', '@cb_manuf?manuf_slug=westinghouse', array('title' => 'Cirucit Breakers by Westinghouse')) ?></li>
		<li class='zi'><?php echo link_to('Zinsco Circuit Breakers', '@cb_manuf?manuf_slug=zinsco', array('title' => 'Cirucit Breakers by Zinsco')) ?></li>
	</ul>
</div>
<p>Circuit Breakers are our specialty.  We carry all major brands of breakers including: Square D, Siemens, Cutler Hammer and General Electric.  Have a huge list of parts, shopping for the best price?  Your search is over.  LiveWire offers new in box, new surplus, and certified green equipment at extremely low prices yet, we make no compromises on quality or lead time.  All circuit breakers we sell carry a minimum 1-year warranty; even the obsolete breakers by Zinsco, Federal Pacific (FPE), Westinghouse or Trilliant.  We carry commercial breakers for industrial applications and we also carry residential equipment for small weekend projects.  To save time and cost, we ship from regional locations across the county and have great prices negotiated with trucking companies to ensure a low total cost of purchase.  Have a unique application, no one else is able to help?  We can help engineer a solution for your unique application!</p>
<p>Circuit breaker experts can help with technical questions or to help you through emergency outages 24 hours per day.  In fact, we put manufacturer's data sheets and tens of thousands of photos right on the site. We carry the parts, big and small to get you back on line quickly and more importantly, at a reasonable price.  We are an authorized distributor for some but not all of the lines listed above.  For example, we carry authentic new surplus Allen Bradly, GE, Cutler Hammer and Square D equipment. When you buy circuit breakers from LiveWire you will see why we are known as the Internet's #1 Electrical Supply House!</p>
<?php slot('sidebar') ?>
	<?php include_partial('global/categoryLevelSidebar', array('category' => 'Circuit Breakers')) ?>
<?php end_slot() ?>
