<?php use_stylesheet('be/rfq') ?>
<?php use_javascript('be/rfq') ?>
<?php include_partial('global/userMessages', array('flash_name' => 'rfq_msg')) ?>
<h2>Request For Quote No. <?php echo $ticket['ticket_id'] ?></h2>
<form id='rfq_ticket' method='post' action='' enctype='application/x-www-form-urlencoded'>
	<div class='module ts'>
		<h3>Ticket Summary</h3>
		<div class='mod_data'>
			<table cellpadding='0' cellspacing='0'>
				<tbody>
					<tr class='tags'><td>Status</td><td>Date Openned</td><td>Openned By</td><td>Last Modified</td><td>Last Action</td></tr>
					<tr><td><?php echo ucfirst($ticket['status']) ?></td><td><?php echo date('m/d/Y', $ticket['openned_ts']) ?></td><td><?php echo $ticket['openned_by'] ?></td><td><?php echo date('m/d/Y', $ticket['last_mod_ts']) ?></td><td><?php echo $ticket['action'] ?></td></tr>
				</tbody>
			</table>
		</div>
	</div>
	<?php include_partial('customerSummary', array('c' => $c)) ?>
	<div class='module rq'>
		<h3>Request &amp; Quote</h3>
		<div class='mod_data'>
			<table cellpadding='0' cellspacing='0'>
				<tbody id='rqx_rows'>
					<tr class='tags'><td class='req'>Catalog No.</td><td>Category</td><td>MFR</td><td>Condition</td><td class='req'>QTY</td><td class='qte'>New Quote $</td><td class='qte'>Green Quote $</td><td>Lead Time</td><td class='e'></td></tr>
					<?php $i = -1; foreach($rqx as $row) : $i++ ?>
					<tr class='rqx'>
						<td class='xlg'><input type='text' readonly='readonly' class='txt ns req disabled' name='u:part_no[]' maxlength='50' value="<?php echo $row['part_no'] ?>" /></td>
						<td class='md'><?php include_partial('global/categoryBox', array('ticket' => $row, 'editable' => true)) ?></td>
						<td class='lg'><?php include_partial('global/mfrBox', array('ticket' => $row, 'editable' => true)) ?></td>
						<td class='xms'><?php include_partial('cdtnBox', array('name' => 'condition_req', 'rfq' => $row, 'editable' => true)) ?></td>
						<td class='xxs'><input type='text' readonly='readonly' class='txt qty req disabled' name='u:qty_req[]' size='3' maxlength='6' value="<?php echo $row['qty_req'] ?>" /></td>
						<td class='qte sm'><input type='text' readonly='readonly' class='txt disabled' name='u:quoted_new[]' size='10' maxlength='11' value="<?php echo $row['quoted_new'] ?>" /></td>
						<td class='qte sm'><input type='text' readonly='readonly' class='txt disabled' name='u:quoted_grn[]' size='10' maxlength='11' value="<?php echo $row['quoted_grn'] ?>" /></td>
						<td><input type='text' class='txt disabled' readonly='readonly' name='u:lead_time[]' size='25' maxlength='50' value="<?php echo $row['lead_time'] ?>" /></td>
						<td class='rqx_edit'><a href='<?php echo url_for('@js_disabled') ?>' class="_<?php echo "{$i}:",$row['rfq_idx'] ?>"></a></td>
						<td class='hide'><input type='text' name='u:display[]' value="<?php echo $row['display'] ?>" /></td>
					</tr>
					<tr><td class='tags r'>Notes</td><td colspan='8'><textarea readonly='readonly' class='disabled' cols='25' rows='1' name='u:notes[]'><?php echo $row['notes'] ?></textarea></td></tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<p id='add_rqx'><a href='<?php echo url_for('@js_disabled') ?>'>+</a></p>
			<p id='sub_rqx'><a href='<?php echo url_for('@js_disabled') ?>'>&ndash;</a></p>
		</div>
	</div>
	<div class='module ad'>
		<h3>Additional Details</h3>
		<div class='mod_data'>
			<table cellpadding='0' cellspacing='0'>
				<tbody>
					<tr class='tags'><td>Urgency</td><td>LWS Priority</td><td>Referrer</td><td>Search Phrase</td><td class='e'></td></tr>
					<tr>
						<td class='sm'><?php include_partial('urgencyBox', array('urgency' => $rfq['urgency'], 'editable' => true)) ?></td>
						<td class='sm'><?php include_partial('priorityBox', array('priority' => $rfq['priority'], 'editable' => true)) ?></td>
						<td><?php echo $rfq['referrer'] ?></td>
						<td><?php echo $rfq['search_phrase'] ?></td>
						<td class='rfq_edit'><a href='<?php echo url_for('@js_disabled') ?>'></a></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class='module pu'>
		<h3>Purchasing</h3>
		<div class='mod_data'>
			<table cellpadding='0' cellspacing='0'>
				<tbody id='vmx_rows'>
					<tr class='tags'><td class='req'>Catalog No.</td><td class='req'>Vendor</td><td class='req'>Price $</td><td>Condition</td><td>QTY</td><td>Rep</td><td>Rep Email</td><td>Lead Time</td><td class='e'></td></tr>
					<?php $i = -1; foreach($vmx as $row) : $i++ ?>
					<tr>
						<td class='xlg'><input type='text' readonly='readonly' class='txt req disabled' name='u:vpart_no[]' size='25' maxlength='50' value="<?php echo $row['part_no'] ?>" /></td>
						<td class='lg'><?php include_partial('vendorsBox', array('vendors' => $vendors, 'vmx' => $row, 'editable' => true)) ?></td>
						<td class='xms'><input type='text' readonly='readonly' class='txt req disabled' name='u:purchase_price[]' size='10' maxlength='11' value="<?php echo $row['purchase_price'] ?>" /></td>
						<td class='xms'><?php include_partial('cdtnBox', array('name' => 'cond', 'rfq' => $row, 'editable' => true)) ?></td>
						<td class='xxs'><input type='text' readonly='readonly' class='txt qty disabled' name='u:qty_on_hand[]' size='3' maxlength='6' value="<?php echo $row['qty_on_hand'] ?>" /></td>
						<td><input type='text' class='txt disabled' readonly='readonly' name='u:rep[]' size='25' maxlength='50' value="<?php echo ucwords($row['rep']) ?>" /></td>
						<td><input type='text' class='txt disabled' readonly='readonly' name='u:rep_email[]' size='25' maxlength='100' value="<?php echo $row['rep_email'] ?>" /></td>
						<td><input type='text' class='txt disabled' readonly='readonly' name='u:vlead_time[]' size='25' maxlength='50' value="<?php echo $row['vlead_time'] ?>" /></td>
						<td class='vmx_edit'><a href='<?php echo url_for('@js_disabled') ?>' class="_<?php echo "{$i}:",$row['vmx_idx'] ?>"></a></td>
					</tr>
					<tr><td class='tags r'>Notes</td><td colspan='8'><textarea readonly='readonly' class='disabled' cols='25' rows='1' name='u:vnotes[]'><?php echo $row['vnotes'] ?></textarea></td></tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<p id='add_vmx'><a href='<?php echo url_for('@js_disabled') ?>'>+</a></p>
			<p id='sub_vmx'><a href='<?php echo url_for('@js_disabled') ?>'>&ndash;</a></p>
		</div>
	</div>
	<div class='module nt btm'>
		<h3>Note</h3>
		<div class='mod_data'>
			<table cellpadding='0' cellspacing='0'>
				<tbody id='notepad'>
					<tr><td class='tags r'>Type</td><td class='h' colspan='2'><?php include_partial('noteTypeBox') ?></td></tr>
					<tr class='int'><td class='tags r'>Notify</td><td colspan='2'><?php include_partial('notifyBox', array('be_users' => $be_users)) ?></td></tr>
					<tr class='ext'><td class='tags r'>Template</td><td class='h' colspan='2'><?php include_partial('rfqNoteTemplateBox') ?></td></tr>
					<tr class='ext'><td class='tags req r'>Subject</td><td class='h' colspan='2'><input type='text' class='txt req' name='subject' id='subj' size='25' value='' /></td></tr>
					<tr class='ext tags'><td class='xlg req'>To</td><td class='xlg'>From</td><td class='xlg'>Cc <span>(a@example1.com , b@example2.com , etc.)</span></td></tr>
					<tr class='ext'>
						<td><input type='text' class='txt req' name='to' id='to' size='25' value='<?php echo $c['email'] ?>' /></td>
						<td><input type='text' class='txt disabled' readonly='readonly' name='from' size='25' value='<?php echo $rep['email'] ?>' /></td>
						<td><input type='text' class='txt' name='cc' id='cc' size='25' value='' /></td>
					</tr>
					<tr id='paper'><td colspan='3'><textarea name='note' id='rfq_note' cols='50' rows='10'></textarea></td></tr>
				</tbody>
			</table>
		</div>
	</div>
	<input type='hidden' name='close' value='0' />
	<input type='hidden' name='sent_to' id='sent_to' value="<?php echo $c['email'] ?>" />
	<input type='hidden' name='sent_by' id='sent_by' value="<?php echo $rep['email'] ?>" />
	<input type='hidden' name='ticket_id' value="<?php echo $ticket['ticket_id'] ?>" />
	<input type='hidden' name='rfq_id' value="<?php echo $rfq['rfq_id'] ?>" />
	<input type='hidden' name='rfq_update' value='0' />
	<input type='hidden' name='rqx_keys' value='' />
	<input type='hidden' name='vmx_keys' value='' />
	<input type='hidden' name='customer_name' value="<?php echo ucfirst($c['first_name']), ' ', ucfirst($c['last_name']) ?>" />
	<input type='hidden' name='customer_company' value="<?php echo $c['company'] ?>" />
	<input type='hidden' name='cat_slug' id='cat_slug' value='' />
	<input type='hidden' name='manuf_slug' id='manuf_slug' value='' />
	<p id='btns'><input id='update_close' type='button' class='btn' value='Update &amp; Home' /> <input type='button' class='btn' id='update' value='Update' /></p>
</form>
<?php if(!is_null($notes)) : ?>
<h3 id='nh'>Note History</h3>
<div id='notes'>
	<?php foreach($notes as $note) : ?>
	<?php include_partial("{$note['type']}Note", array('note' => $note)) ?>
	<?php endforeach; ?>
</div>
<?php endif; ?>
<table id='rqx_clone' class='hide'>
	<tr>
		<td class='xlg'><input type='text' class='txt border ns req' name='part_no[]' size='25' maxlength='50' value='' /></td>
		<td class='md'><?php include_partial('global/categoryBox') ?></td>
		<td class='lg'><?php include_partial('global/mfrBox') ?></td>
		<td class='xms'><?php include_partial('cdtnBox', array('name' => 'condition_req')) ?></td>
		<td class='xxs'><input type='text' class='txt border qty req' name='qty_req[]' size='3' maxlength='6' value='' /></td>
		<td class='qte sm'><input type='text' class='txt border' name='quoted_new[]' size='10' maxlength='11' value='' /></td>
		<td class='qte sm'><input type='text' class='txt border' name='quoted_grn[]' size='10' maxlength='11' value='' /></td>
		<td colspan='2'><input type='text' class='txt' name='lead_time[]' size='25' maxlength='50' value='' /></td>
		<td class='hide'><input type='text' name='display[]' value="0" /></td>
	</tr>
	<tr><td class='tags r'>Notes</td><td colspan='8'><textarea cols='25' rows='1' name='notes[]'></textarea></td></tr>
</table>
<table id='vmx_clone' class='hide'>
	<tr>
		<td class='xlg'><input type='text' class='txt border req' name='vpart_no[]' size='25' maxlength='50' value='' /></td>
		<td class='lg'><?php include_partial('vendorsBox', array('vendors' => $vendors)) ?></td>
		<td class='xms'><input type='text' class='txt border req' name='purchase_price[]' size='10' maxlength='11' value='' /></td>
		<td class='xms'><?php include_partial('cdtnBox', array('name' => 'cond')) ?></td>
		<td class='xxs'><input type='text' class='txt border qty' name='qty_on_hand[]' size='3' maxlength='6' value='' /></td>
		<td><input type='text' class='txt border' name='rep[]' size='25' maxlength='50' value='' /></td>
		<td><input type='text' class='txt border' name='rep_email[]' size='25' maxlength='100' value='' /></td>
		<td colspan='2'><input type='text' class='txt' name='vlead_time[]' size='25' maxlength='50' value='' /></td>
	</tr>
	<tr><td class='tags r'>Notes</td><td colspan='8'><textarea class='border' cols='25' rows='1' name='vnotes[]'></textarea></td></tr>
</table>
