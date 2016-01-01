
<div class='module pu'>
	<h3>Purchasing</h3>
	<div class='mod_data'>
		<table cellpadding='0' cellspacing='0'>
			<tbody id='vmx_rows'>
				<tr class='tags'><td class='req'>Catalog No.</td><td class='lg'>Vendor</td><td class='req xms'>Price $</td><td class='xms'>Condition</td><td class='xxs'>QTY</td><td class='mmd'>Rep</td><td class='mmd'>Rep Email</td><td>Lead Time</td></tr>
				<tr>
					<td class='xlg'><input type='text' class='txt req' name='vpart_no[]' size='25' maxlength='50' value='' /></td>
					<td colspan='7' class='tbl_cell'>
						<table cellpadding='0' cellspacing='0' class='inner'>
							<tbody>
							<tr>
								<td class='lg' rowspan='2'><?php include_partial('vendorsBox', array('vendors' => $vendors)) ?></td>
								<td class='xms'><input type='text' class='txt req' name='purchase_price[]' size='10' maxlength='11' value='' /></td>
								<td class='xms c'>New</td>
								<td class='xxs'><input type='text' class='txt qty' name='qty_on_hand[]' size='3' maxlength='6' value='' /></td>
								<td class='mmd'><input type='text' class='txt' name='rep[]' size='25' maxlength='50' value='' /></td>
								<td class='mmd'><input type='text' class='txt' name='rep_email[]' size='25' maxlength='100' value='' /></td>
								<td><input type='text' class='txt' name='vlead_time[]' size='25' maxlength='50' value='' /></td>
							</tr>
							<tr>
								<td class='xms'><input type='text' class='txt req' name='purchase_price[]' size='10' maxlength='11' value='' /></td>
								<td class='xms c'>Green</td>
								<td class='xxs'><input type='text' class='txt qty' name='qty_on_hand[]' size='3' maxlength='6' value='' /></td>
								<td class='mmd'><input type='text' class='txt' name='rep[]' size='25' maxlength='50' value='' /></td>
								<td class='mmd'><input type='text' class='txt' name='rep_email[]' size='25' maxlength='100' value='' /></td>
								<td><input type='text' class='txt' name='vlead_time[]' size='25' maxlength='50' value='' /></td>
							</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr><td class='tags r'>Notes</td><td colspan='7'><textarea cols='25' rows='1' name='vnotes[]'></textarea></td></tr>
			</tbody>
		</table>
		<p id='add_vmx'><a href='<?php echo url_for('@js_disabled') ?>'>+</a></p>
		<p id='sub_vmx'><a href='<?php echo url_for('@js_disabled') ?>'>&ndash;</a></p>
	</div>
</div>

