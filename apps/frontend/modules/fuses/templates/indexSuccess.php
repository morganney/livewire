<?php use_stylesheet('cmp') ?>
<?php include_partial('global/h1', array('txt' => 'Fuses by LiveWire Supply')) ?>
<form class='basic' method='get' action='<?php echo url_for('@part_search') ?>'>
	<h2 id='sh'>Enter your Fuse Catalog Number Here</h2>
	<p><input type='text' size='26' maxlength='50' value='' class='txt' name='q' /><input type='submit' value='' class='sbmt' /></p>
	<input type='hidden' name='section' value='fu' />
</form>
<div class='manuf_box'>
	<h3><span>OR</span> Select a Fuse Manufacturer</h3>
	<ul class='manufs'>
		<li class='top left cb'><?php echo link_to('Cooper Bussman Fuses', '@fu_manuf?manuf_slug=cooper-bussman', array('title' => 'Fuses by Cooper Bussman')) ?></li>
		<li class='top ch'><?php echo link_to('Cutler Hammer Fuses', '@fu_manuf?manuf_slug=cutler-hammer', array('title' => 'Fuses by Cutler Hammer')) ?></li>
		<li class='top fs'><?php echo link_to('Ferraz Shawmut Fuses', '@fu_manuf?manuf_slug=ferraz-shawmut', array('title' => 'Fuses by Ferraz Shawmut')) ?></li>
		<li class='left lf'><?php echo link_to('Littelfuse Fuses', '@fu_manuf?manuf_slug=littelfuse', array('title' => 'Fuses by Littelfuse')) ?></li>
	</ul>
</div>
<p>Fuses are one of LiveWire's many stregnths.  We carry all major brands of fuses including: Ferraz Shawmut, Edison, Bussman (Buss / BUS), LittelFuse and Cutler Hammer.  Have a huge list of parts, shopping for the best price?  Your search is over.  LiveWire offers brand new and used Fuses at extremely low prices yet, we make no compromises on quality or lead time.  The fuses we sell carry a 1-year warranty!  To save time and cost, we ship from regional locations across the county and have great prices negotiated with trucking companies to ensure a low total cost of purchase.  Have a unique application, no one else is able to help?  We can help engineer a solution for your unique application!  We offer, Fuses, Fuse Holders, Fuse Blocks, Dummy Fuses, and power distribution blocks.  We carry glass, square body, semiconductor, medium voltage and fast acting fuses.  We also carry time-delay or slo-blo fuses.</p>
<p>We have Fuse experts that can help with technical questions or to help you through emergency outages 24 hours per day.  In fact, we put manufacturer's data sheets and tens of thousands of photos right on the site. We carry the components, big and small to get you back on line quickly and more importantly, at a reasonable price. We are an authorized distributor for some but not all of the lines listed above.  For example, we carry authentic new surplus Allen Bradly, GE, Cutler Hammer and Square D equipment. When you buy from LiveWire Supply you will see why we are known as the Internet's #1 Electrical Supply House!</p>
<?php slot('sidebar') ?>
	<?php include_partial('global/categoryLevelSidebar', array('category' => 'Fuses')) ?>
<?php end_slot() ?>
