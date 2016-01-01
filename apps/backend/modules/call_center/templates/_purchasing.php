
<div class='module pu'>
	<h3>Purchasing</h3>
	<div class='mod_data'>
		<table cellpadding='0' cellspacing='0'>
			<tbody id='vmx_rows'>
				<tr class='tags'><td class='req'>Catalog No.</td><td class='req'>Vendor</td><td class='req'>Price $</td><td>Condition</td><td>QTY</td><td>Rep</td><td>Rep Email</td><td>Lead Time</td></tr>
				<tr>
					<td class='xlg'><input type='text' class='txt req' name='vpart_no[]' size='25' maxlength='50' value='' /></td>
					<td class='lg'><?php include_partial('vendorsBox', array('vendors' => $vendors)) ?></td>
					<td class='xms'><input type='text' class='txt req' name='purchase_price[]' size='10' maxlength='11' value='' /></td>
					<td class='xms'><?php include_partial('cdtnBox', array('name' => 'cond')) ?></td>
					<td class='xxs'><input type='text' class='txt qty' name='qty_on_hand[]' size='3' maxlength='6' value='' /></td>
					<td><input type='text' class='txt' name='rep[]' size='25' maxlength='50' value='' /></td>
					<td><input type='text' class='txt' name='rep_email[]' size='25' maxlength='100' value='' /></td>
					<td><input type='text' class='txt' name='vlead_time[]' size='25' maxlength='50' value='' /></td>
				</tr>
				<tr><td class='tags r'>Notes</td><td colspan='7'><textarea cols='25' rows='1' name='vnotes[]'></textarea></td></tr>
			</tbody>
		</table>
		<p id='add_vmx'><a href='<?php echo url_for('@js_disabled') ?>'>+</a></p>
		<p id='sub_vmx'><a href='<?php echo url_for('@js_disabled') ?>'>&ndash;</a></p>
	</div>
</div>
