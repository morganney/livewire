
<div class='store_front new'> 
	<div id='part_img'>
		<table cellpadding='0' cellspacing='0'>
			<tr><td><img src='<?php echo $part['img'] ?>' alt='<?php echo $part['part_no'] ?>' /></td></tr>
		</table>
		<?php if(basename($part['img']) != 'default.png') : ?>
		<p>This photo is for reference purposes. Please see product details.</p>
		<?php endif; ?>
	</div>
	<div id='pricing'>
		<div id='new'>
			<ul>
				<li><strong id='fsp'><script type='text/javascript' src='http://shopping.netsuite.com/app/site/query/getitemprice.nl?c=502106&amp;id=<?php echo $part['ns_new_id'] ?>'></script></strong></li>
				<li>Guaranteed New</li>
				<li><input type='text' class='txt' name='new_qty' id='new_qty' value='QTY' size='4' /></li>
			</ul>
			<p><?php echo link_to('Add To Cart', '@no_js', array('id' => "_{$part['ns_new_id']}_new")) ?> <em> In Stock</em></p>
		</div>
	</div>
</div>
