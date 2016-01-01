
<div class='store_front grn'> 
	<div id='part_img'>
		<table cellpadding='0' cellspacing='0'>
			<tr><td><img src='<?php echo $part['img'] ?>' alt='<?php echo $part['part_no'] ?>' /></td></tr>
		</table>
		<?php if(basename($part['img']) != 'default.png') : ?>
		<p>This photo is for reference purposes. Please see product details.</p>
		<?php endif; ?>
	</div>
	<div id='pricing'>
		<div id='grn'>
			<ul>
				<li><strong id='fsp'><script type='text/javascript' src='http://shopping.netsuite.com/app/site/query/getitemprice.nl?c=502106&amp;id=<?php echo $part['ns_green_id'] ?>'></script></strong></li>
				<li>Certified Green</li>
				<li><?php echo link_to('Whats This?', '@go_green', array('id' => 'about_grn')) ?></li>
				<li><input type='text' class='txt' name='grn_qty' id='grn_qty' value='QTY' size='4' /></li>
			</ul>
			<p><?php echo link_to('Add To Cart', '@no_js', array('id' => "_{$part['ns_green_id']}_grn")) ?> <em>In Stock</em></p>
		</div>
	</div>
</div>
