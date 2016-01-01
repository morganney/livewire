<div class='l'>
	<table>
		<tr><td><img src='<?php echo $part['img'] ?>' alt='<?php echo $part['part_no'] ?>' /></td></tr>
	</table>
</div>
<?php if($display == 0) : ?>
<div class='r phone'>
	<div class='desc'>
		<p><?php echo link_to($part['anchor_text'], '@part?cat_slug=' . $sf_params->get('cat_slug') . '&manuf_slug=' . $sf_params->get('manuf_slug') . "&part_no={$part['encoded_part_no']}") ?></p>
		<dl>
			<?php foreach($specs_preview_fields as $field_name) : ?>
			<dt><?php echo LWS::dbFieldToLabel($field_name) ?>:</dt><dd><?php echo LWS::formatValue($part[$field_name], $field_name) ?></dd>
			<?php endforeach; ?>
		</dl>
	</div>
</div>
<?php elseif($display == 1) : ?>
<div class='r'>
	<div class='desc'>
		<p><?php echo link_to($part['anchor_text'], '@part?cat_slug=' . $sf_params->get('cat_slug') . '&manuf_slug=' . $sf_params->get('manuf_slug') . "&part_no={$part['encoded_part_no']}") ?></p>
		<dl>
			<?php foreach($specs_preview_fields as $field_name) : ?>
			<dt><?php echo LWS::dbFieldToLabel($field_name) ?>:</dt><dd><?php echo LWS::formatValue($part[$field_name], $field_name) ?></dd>
			<?php endforeach; ?>
		</dl>
	</div>
	<table >
		<tbody>
			<tr class='new'><td>New</td><td><script type='text/javascript' src='http://shopping.netsuite.com/app/site/query/getitemprice.nl?c=502106&amp;id=<?php echo $part['ns_new_id'] ?>'></script></td><td class='qty'><input type='text' class='txt' size='1' id='_<?php echo $part['part_no'], '_new_qty' ?>' name='_<?php echo $part['part_no'], '_new_qty' ?>' value='1' /></td><td class='cart'><a href='<?php echo url_for('@no_js') ?>' id='_<?php echo $part['part_no'],'_new_', $part['ns_new_id'] ?>' class='add' rel='nofollow'></a></td></tr>
		</tbody>
	</table>	
</div>
<?php elseif($display == 2) : ?>
<div class='r'>
	<div class='desc'>
		<p><?php echo link_to($part['anchor_text'], '@part?cat_slug=' . $sf_params->get('cat_slug') . '&manuf_slug=' . $sf_params->get('manuf_slug') . "&part_no={$part['encoded_part_no']}") ?></p>
		<dl>
			<?php foreach($specs_preview_fields as $field_name) : ?>
			<dt><?php echo LWS::dbFieldToLabel($field_name) ?>:</dt><dd><?php echo LWS::formatValue($part[$field_name], $field_name) ?></dd>
			<?php endforeach; ?>
		</dl>
	</div>
	<table >
		<tbody>
			<tr class='grn'><td>Green</td><td><script type='text/javascript' src='http://shopping.netsuite.com/app/site/query/getitemprice.nl?c=502106&amp;id=<?php echo $part['ns_green_id'] ?>'></script></td><td class='qty'><input type='text' class='txt' size='1' id='_<?php echo $part['part_no'], '_grn_qty' ?>' name='_<?php echo $part['part_no'], '_grn_qty' ?>' value='1' /></td><td class='cart'><a href='<?php echo url_for('@no_js') ?>' id='_<?php echo $part['part_no'],'_grn_', $part['ns_green_id'] ?>' class='add' rel='nofollow'></a></td></tr>
		</tbody>
	</table>	
</div>
<?php elseif($display == 3) : ?>
<div class='r'>
	<div class='desc'>
		<p><?php echo link_to($part['anchor_text'], '@part?cat_slug=' . $sf_params->get('cat_slug') . '&manuf_slug=' . $sf_params->get('manuf_slug') . "&part_no={$part['encoded_part_no']}") ?></p>
		<dl>
			<?php foreach($specs_preview_fields as $field_name) : ?>
			<dt><?php echo LWS::dbFieldToLabel($field_name) ?>:</dt><dd><?php echo LWS::formatValue($part[$field_name], $field_name) ?></dd>
			<?php endforeach; ?>
		</dl>
	</div>
	<table >
		<tbody>
			<tr class='grn'><td>Green</td><td><script type='text/javascript' src='http://shopping.netsuite.com/app/site/query/getitemprice.nl?c=502106&amp;id=<?php echo $part['ns_green_id'] ?>'></script></td><td class='qty'><input type='text' class='txt' size='1' id='_<?php echo $part['part_no'], '_grn_qty' ?>' name='_<?php echo $part['part_no'], '_grn_qty' ?>' value='1' /></td><td class='cart'><a href='<?php echo url_for('@no_js') ?>' id='_<?php echo $part['part_no'],'_grn_', $part['ns_green_id'] ?>' class='add' rel='nofollow'></a></td></tr>
			<tr class='new'><td>New</td><td><script type='text/javascript' src='http://shopping.netsuite.com/app/site/query/getitemprice.nl?c=502106&amp;id=<?php echo $part['ns_new_id'] ?>'></script></td><td class='qty'><input type='text' class='txt' size='1' id='_<?php echo $part['part_no'], '_new_qty' ?>' name='_<?php echo $part['part_no'], '_new_qty' ?>' value='1' /></td><td class='cart'><a href='<?php echo url_for('@no_js') ?>' id='_<?php echo $part['part_no'],'_new_', $part['ns_new_id'] ?>' class='add' rel='nofollow'></a></td></tr>
		</tbody>
	</table>
</div>
<?php else : ?>
<div class='r phone'>
	<div class='desc'>
		<p><?php echo link_to($part['anchor_text'], '@part?cat_slug=' . $sf_params->get('cat_slug') . '&manuf_slug=' . $sf_params->get('manuf_slug') . "&part_no={$part['encoded_part_no']}") ?></p>
		<dl>
			<?php foreach($specs_preview_fields as $field_name) : ?>
			<dt><?php echo LWS::dbFieldToLabel($field_name) ?>:</dt><dd><?php echo LWS::formatValue($part[$field_name], $field_name) ?></dd>
			<?php endforeach; ?>
		</dl>
	</div>
</div>
<?php endif; ?>
