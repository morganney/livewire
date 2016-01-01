
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
					<td><input type='text' class='txt' readonly='readonly' name='from' size='25' value='<?php echo $rep['email'] ?>' /></td>
					<td><input type='text' class='txt' name='cc' id='cc' size='25' value='' /></td>
				</tr>
				<tr id='paper'><td colspan='3'><textarea name='note' id='rfq_note' cols='50' rows='10'></textarea></td></tr>
			</tbody>
		</table>
	</div>
</div>
