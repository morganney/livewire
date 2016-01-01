<?php use_stylesheet('cmp') ?>
<?php include_partial('global/h1', array('txt' => 'Motor Control by LiveWire Supply')) ?>
<form class='basic' method='get' action='<?php echo url_for('@part_search') ?>'>
	<h2 id='sh'>Enter your Motor Control Catalog Number Here</h2>
	<p><input type='text' size='26' maxlength='50' value='' class='txt' name='q' /><input type='submit' value='' class='sbmt' /></p>
	<input type='hidden' name='section' value='mc' />
</form>
<div class='manuf_box'>
	<h3><span>OR</span> Select a Motor Control Manufacturer</h3>
	<ul class='manufs'>
		<li class='top left ab'><?php echo link_to('Allen Bradley Motor Controls', '@mc_manuf?manuf_slug=allen-bradley', array('title' => 'Motor Controls by BUI')) ?></li>
		<li class='top ch'><?php echo link_to('Cutler Hammer Motor Controls', '@mc_manuf?manuf_slug=cutler-hammer', array('title' => 'Motor Controls by Connecticut Electric')) ?></li>
		<li class='top ge'><?php echo link_to('General Electric Motor Controls', '@mc_manuf?manuf_slug=ge', array('title' => 'Motor Controls by General Electric')) ?></li>
		<li class='left il'><?php echo link_to('Ilsco Motor Controls', '@mc_manuf?manuf_slug=ilsco', array('title' => 'Motor Controls by Murray')) ?></li>
		<li class='jc'><?php echo link_to('Joslyn Clark Motor Controls', '@mc_manuf?manuf_slug=joslyn-clark', array('title' => 'Motor Controls by Siemens')) ?></li>
		<li class='mu'><?php echo link_to('Murray Motor Controls', '@mc_manuf?manuf_slug=murray', array('title' => 'Motor Controls by Square D')) ?></li>
		<li class='si'><?php echo link_to('Siemens Motor Controls', '@mc_manuf?manuf_slug=siemens', array('title' => 'Motor Controls by Siemens')) ?></li>
		<li class='left sd'><?php echo link_to('Square D Motor Controls', '@mc_manuf?manuf_slug=square-d', array('title' => 'Motor Controls by Square D')) ?></li>
	</ul>
</div>
<p>Motor Control components are one of LiveWire's many stregnths.  We carry all major brands of control components including: General Electric, Allen Bradley, Siemens, Furnas, Telemecanique, Cutler Hammer, Square D, and more.  Have a huge list of parts, shopping for the best price?  Your search is over.  LiveWire offers brand new and certified green motor control at extremely low prices, yet we make no compromises on quality or lead time.  The controls we sell carry a 1-year warranty!  To save time and cost, we ship from regional locations across the county and have great prices negotiated with shipping companies to ensure a low total cost of purchase.  Have a unique application, need an old or rate part, no one else is able to help?  We can help engineer a solution for your unique application!  We offer, push buttons, float switches, starters, heaters, overloads and overload relays, contact kits, contactors and more.</p>
<p>We have motor control experts that can help with technical questions or to help you through emergency outages 24 hours per day.  In fact, we put manufacturer's data sheets and tens of thousands of photos right on the site. We carry the components, big and small to get you back on line quickly and more importantly, at a reasonable price.  We are an authorized distributor for some but not all of the lines listed above.  For example, we carry authentic new surplus Allen Bradly, GE, Cutler Hammer and Square D equipment. When you buy from LiveWire Supply you will see why we are known as the Internet's #1 Electrical Supply House!</p>
<?php slot('sidebar') ?>
	<?php include_partial('global/categoryLevelSidebar', array('category' => 'Motor Controls')) ?>
<?php end_slot() ?>
