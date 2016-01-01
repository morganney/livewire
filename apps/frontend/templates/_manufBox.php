
<div id='manuf_box' class='<?php echo $param['manuf_box_class'] ?>' style='background-image: url(/images/manuf/box/<?php echo $param['manuf_slug'] ?>.png)'>
	<div id='left'>
	  <?php if($param['manuf_box_class'] != '_0') : ?>
		<img id='cycle_img' class='_0' src='/images/cycle/<?php echo $param['cat_slug'], '/', $param['manuf_slug'] ?>/cycle-0-trans.png' alt='<?php echo $param['category'] ?>' />
		<?php endif; ?>
	</div>
	<div id='right'>
		<div id='top'>
			<h2>The #1 Source for <span><?php echo $param['manuf'] ?></span> <?php echo $param['category'] ?></h2>
			<p>LiveWire Supply is the Internet's #1 Supplier for <?php echo $param['manuf'], ' ', $param['category'] ?>.  We have a massive selection and shipping points across the country.  Many of the Nation's largest corporations, most respected contractors and diligent do-it-yourselfers trust us to supply the <?php echo $param['manuf'], ' ', strtolower($param['category']) ?> you need quickly and accurately.</p>
		</div>
		<div id='bottom'>
			<p>If you know the <img id='manuf_img' alt='<?php echo $param['manuf'] ?>' src='/images/manuf/new/<?php echo $param['manuf_slug']?>.png' /> part number you are looking for, enter it below and click search.</p>
			<form id='manuf_search' method='get' action='<?php echo url_for('@part_search') ?>'>
				<input class='txt' type='text' value='' name='q' maxlength='50' size='26'/>
				<input class='sbmt' type='submit' value='' />
			</form>
		</div>
	</div>
</div>
