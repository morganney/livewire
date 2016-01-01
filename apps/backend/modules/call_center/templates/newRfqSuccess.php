<?php use_stylesheet('be/rfq') ?>
<?php use_javascript('be/new-rfq') ?>
<?php $rfq = $sf_user->getAttribute('rfq', NULL) ?>
<?php include_partial('global/userMessages', array('flash_name' => 'rfq_errs')) ?>
<h2><?php echo $c['company'] ?> / New RFQ</h2>
<form id='new_rfq' method='post' action='<?php echo url_for("@new_rfq?id={$c['customer_id']}") ?>' enctype='application/x-www-form-urlencoded'>
<?php include_partial('customerSummary', array('c' => $c)) ?>
	<div class='module rq'>
		<h3>Request &amp; Quote</h3>
		<div class='mod_data'>
			<table cellpadding='0' cellspacing='0'>
				<tbody id='rqx_rows'>
					<tr class='tags'><td class='req'>Catalog No.</td><td>Category</td><td>MFR</td><td>Condition</td><td class='req'>QTY</td><td class='qte'>New Quote $</td><td class='qte'>Green Quote $</td><td>Lead Time</td></tr>
					<tr>
						<td class='xlg'><input type='text' class='txt req ns' name='part_no[]' size='25' maxlength='50' value='' /></td>
						<td class='md'><?php include_partial('global/categoryBox') ?></td>
						<td class='lg'><?php include_partial('global/mfrBox') ?></td>
						<td class='xms'><?php include_partial('cdtnBox', array('name' => 'condition_req')) ?></td>
						<td class='xxs'><input type='text' class='txt qty req' name='qty_req[]' size='3' maxlength='6' value='' /></td>
						<td class='qte sm'><input type='text' class='txt' name='quoted_new[]' size='10' maxlength='11' value='' /></td>
						<td class='qte sm'><input type='text' class='txt' name='quoted_grn[]' size='10' maxlength='11' value='' /></td>
						<td><input type='text' class='txt' name='lead_time[]' size='25' maxlength='50' value='' /></td>
						<td class='hide'><input type='text' name='display[]' value="0" /></td>
					</tr>
					<tr><td class='tags r'>Notes</td><td colspan='7'><textarea cols='25' rows='1' name='notes[]'></textarea></td></tr>
				</tbody>
			</table>
			<p id='add_rqx'><a href='<?php echo url_for('@js_disabled') ?>'>+</a></p>
			<p id='sub_rqx'><a href='<?php echo url_for('@js_disabled') ?>'>&ndash;</a></p>
		</div>
	</div>
	<div class='module ad' id='add_details'>
		<h3>Additional Details</h3>
		<div class='mod_data'>
			<table cellpadding='0' cellspacing='0'>
				<tbody>
					<tr class='tags'><td>Urgency</td><td>LWS Priority</td><td>Referrer</td><td>Search Phrase</td></tr>
					<tr>
						<td class='sm'><?php include_partial('urgencyBox') ?></td>
						<td class='sm'><?php include_partial('priorityBox') ?></td>
						<td><input type='text' class='txt' name='referrer' size='25' maxlength='50' value='' /></td>
						<td><input type='text' class='txt' name='search_phrase' size='25' maxlength='100' value='' /></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<!--  PUT CRAP HERE!  -->
	<div class='module pu'>
		<h3>Purchasing</h3>
		<div class='mod_data'>
			<table cellpadding='0' cellspacing='0'>
				<tbody id='vmx_rows'>
					<tr class='tags'><td class='req'>Catalog No.</td><td class='req'>Vendor</td><td class='req'>Price $</td><td>Condition</td><td>QTY</td><td>Rep</td><td>Rep Email</td><td>Lead Time</td></tr>
				</tbody>
			</table>
			<p id='add_vmx'><a href='<?php echo url_for('@js_disabled') ?>'>+</a></p>
			<p id='sub_vmx'><a href='<?php echo url_for('@js_disabled') ?>'>&ndash;</a></p>
		</div>
	</div>
	<?php include_partial('note', array('c' => $c, 'be_users' => $be_users, 'rep' => $rep)) ?>
	<input type='hidden' name='continue' id='continue' value='1' />
	<input type='hidden' name='sent_to' id='sent_to' value="<?php echo $c['email'] ?>" />
	<input type='hidden' name='sent_by' id='sent_by' value="<?php echo $rep['email'] ?>" />
	<input type='hidden' name='openned_by' value="<?php echo $rep['email'] ?>" />
	<input type='hidden' name='customer_id' value="<?php echo $c['customer_id'] ?>" />
	<input type='hidden' name='customer_name' value="<?php echo ucfirst($c['first_name']), ' ', ucfirst($c['last_name']) ?>" />
	<input type='hidden' name='customer_company' value="<?php echo $c['company'] ?>" />
	<input type='hidden' name='cat_slug' id='cat_slug' value='' />
	<input type='hidden' name='manuf_slug' id='manuf_slug' value='' />
	<p id='btns'><input id='save_close' type='button' class='btn' value='Save &amp; Home' /> <input type='button' class='btn' id='save' value='Save' /></p>
</form>
<table id='vmx_clone' class='hide'>
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
	<tr><td class='tags r'></td><td colspan='7'><textarea class="grey" cols='25' rows='1' name='vnotes[]'>Notes...</textarea></td></tr>
</table>



