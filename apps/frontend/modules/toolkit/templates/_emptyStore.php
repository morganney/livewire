
<div class='store_front empty'> 
	<div id='part_img'>
		<table cellpadding='0' cellspacing='0'>
			<tr><td><img src='<?php echo $part['img'] ?>' alt='<?php echo $part['part_no'] ?>' /></td></tr>
		</table>
		<?php if(basename($part['img']) != 'default.png') : ?>
		<p>This photo is for reference purposes. Please see product details.</p>
		<?php endif; ?>
	</div>
	<div id='pricing'>
		<p><em>Call 1-800-390-3299</em> For Current Price and Availability <span>Item might be available to ship today</span></p>
		<p id='bulk'>Need pricing information? Call us at 1-800-390-3299</p>
	</div>
</div>
