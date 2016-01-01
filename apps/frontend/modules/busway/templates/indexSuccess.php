<?php use_stylesheet('cmp') ?>
<?php include_partial('global/h1', array('txt' => 'Busway by LiveWire Supply')) ?>
<form class='basic' method='get' action='<?php echo url_for('@part_search') ?>'>
	<h2 id='sh'>Enter your Busway Catalog Number Here</h2>
	<p><input type='text' size='26' maxlength='50' value='' class='txt' name='q' /><input type='submit' value='' class='sbmt' /></p>
	<input type='hidden' name='section' value='bu' />
</form>
<div class='manuf_box'>
	<h3><span>OR</span> Select a Busway Manufacturer</h3>
	<ul class='manufs'>
		<li class='top left ch'><?php echo link_to('Cutler Hammer Busway', '@bu_manuf?manuf_slug=cutler-hammer', array('title' => 'Busway by Cutler Hammer')) ?></li>
		<li class='top si'><?php echo link_to('Siemens Busway', '@bu_manuf?manuf_slug=siemens', array('title' => 'Busway by Siemens')) ?></li>
		<li class='top sd'><?php echo link_to('Square D Busway', '@bu_manuf?manuf_slug=square-d', array('title' => 'Busway by Square D')) ?></li>
		<li class='left ge'><?php echo link_to('General Electric Busway', '@bu_manuf?manuf_slug=ge', array('title' => 'Busway by GE')) ?></li>
	</ul>
</div>
<p>Busway and bus system components are one of LiveWire's many strengths.  We carry all major brands of busway including: Bulldog, ITE, Square D, General Electric (GE), Siemens, Cutler Hammer and Westinghouse.  Have a huge list of parts, shopping for the best price?  Your search is over.  LiveWire offers brand new and certified green bus plugs at extremely low prices; yet, we make no compromises on quality or lead time.  The busway we sell carry a 1-year warranty!  To save time and cost, we ship from regional locations across the county and have great prices negotiated with shipping companies to ensure a low total cost of purchase.  Have a unique application, need an old or rate busway component, no one else is able to help?  We can help engineer a solution for your unique application!  We offer, bus sections in 10, 6, and 4 foot lengths.  We can even custom build elbows, joints, and tap boxes.  We offer, bus plugs in all makes and amperages - give us a call, you will be impressed by our product knowledge and availability of parts.</p>
<p>We have motor busway system experts that can help with technical questions or to help you through emergency outages 24 hours per day.  In fact, we put manufacturer's data sheets and tens of thousands of photos right on the site. We carry the components, big and small to get you back on line quickly and more importantly, at a reasonable price.  We are an authorized distributor for some but not all of the lines listed above.  For example, we carry authentic new surplus Allen Bradly, GE, Cutler Hammer and Square D equipment. When you buy from LiveWire Supply you will see why we are known as the Internet's #1 Electrical Supply House!</p>
<?php slot('sidebar') ?>
	<?php include_partial('global/categoryLevelSidebar', array('category' => 'Busway')) ?>
<?php end_slot() ?>
