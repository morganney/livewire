<?php $n = isset($editable) ? 'u:mfr[]' : 'mfr[]' ?>
<select name='<?php echo $n ?>' <?php echo isset($ticket) ? "disabled='disabled' class='disabled'" : '' ?>>
<?php if(isset($ticket)) : ?>
	<option value='Not Chosen' <?php echo $ticket['mfr'] == 'Not Chosen' ? "selected='selected'" : '' ?>>Not Chosen</option>
	<option value='ACME' <?php echo $ticket['mfr'] == 'ACME' ? "selected='selected'" : '' ?>>ACME</option>
	<option value='Allen Bradley' <?php echo $ticket['mfr'] == 'Allen Bradley' ? "selected='selected'" : '' ?>>Allen Bradley</option>
	<option value='Bryant' <?php echo $ticket['mfr'] == 'Bryant' ? "selected='selected'" : '' ?>>Bryant</option>
	<option value='BUI' <?php echo $ticket['mfr'] == 'BUI' ? "selected='selected'" : '' ?>>BUI</option>
	<option value='Connecticut Electric' <?php echo $ticket['mfr'] == 'Connecticut Electric' ? "selected='selected'" : '' ?>>Connecticut Electric</option>
	<option value='Cooper Bussman' <?php echo $ticket['mfr'] == 'Cooper Bussman' ? "selected='selected'" : '' ?>>Cooper Bussman</option>
	<option value='Cutler Hammer' <?php echo $ticket['mfr'] == 'Cutler Hammer' ? "selected='selected'" : '' ?>>Cutler Hammer</option>
	<option value='Federal Pacific' <?php echo $ticket['mfr'] == 'Federal Pacific' ? "selected='selected'" : '' ?>>Federal Pacific</option>
	<option value='Ferraz Shawmut' <?php echo $ticket['mfr'] == 'Ferraz Shawmut' ? "selected='selected'" : '' ?>>Ferraz Shawmut</option>
	<option value='GE' <?php echo $ticket['mfr'] == 'GE' ? "selected='selected'" : '' ?>>GE</option>
	<option value='Hammond Power' <?php echo $ticket['mfr'] == 'Hammond Power' ? "selected='selected'" : '' ?>>Hammond Power</option>
	<option value='ILSCO' <?php echo $ticket['mfr'] == 'ILSCO' ? "selected='selected'" : '' ?>>ILSCO</option>
	<option value='Jefferson' <?php echo $ticket['mfr'] == 'Jefferson' ? "selected='selected'" : '' ?>>Jefferson</option>
	<option value='Joslyn Clark' <?php echo $ticket['mfr'] == 'Joslyn Clark' ? "selected='selected'" : '' ?>>Joslyn Clark</option>
	<option value='Littelfuse' <?php echo $ticket['mfr'] == 'Littelfuse' ? "selected='selected'" : '' ?>>Littelfuse</option>
	<option value='Murray' <?php echo $ticket['mfr'] == 'Murray' ? "selected='selected'" : '' ?>>Murray</option>
	<option value='Siemens' <?php echo $ticket['mfr'] == 'Siemens' ? "selected='selected'" : '' ?>>Siemens</option>
	<option value='Square D' <?php echo $ticket['mfr'] == 'Square D' ? "selected='selected'" : '' ?>>Square D</option>
	<option value='Thomas Betts' <?php echo $ticket['mfr'] == 'Thomas Betts' ? "selected='selected'" : '' ?>>Thomas Betts</option>
	<option value='Wadsworth' <?php echo $ticket['mfr'] == 'Wadsworth' ? "selected='selected'" : '' ?>>Wadsworth</option>
	<option value='Westinghouse' <?php echo $ticket['mfr'] == 'Westinghouse' ? "selected='selected'" : '' ?>>Westinghouse</option>
	<option value='Zinsco' <?php echo $ticket['mfr'] == 'Zinsco' ? "selected='selected'" : '' ?>>Zinsco</option>
	<option value='Other' <?php echo $ticket['mfr'] == 'Other' ? "selected='selected'" : '' ?>>Other</option>
<?php else: ?>
	<option value='Not Chosen'>Not Chosen</option>
	<option value='ACME'>ACME</option>
	<option value='Allen Bradley'>Allen Bradley</option>
	<option value='Bryant'>Bryant</option>
	<option value='BUI'>BUI</option>
	<option value='Connecticut Electric'>Connecticut Electric</option>
	<option value='Cooper Bussman'>Cooper Bussman</option>
	<option value='Cutler Hammer'>Cutler Hammer</option>
	<option value='Federal Pacific'>Federal Pacific</option>
	<option value='Ferraz Shawmut'>Ferraz Shawmut</option>
	<option value='GE'>GE</option>
	<option value='Hammond Power'>Hammond Power</option>
	<option value='ILSCO'>ILSCO</option>
	<option value='Jefferson'>Jefferson</option>
	<option value='Joslyn Clark'>Joslyn Clark</option>
	<option value='Littelfuse'>Littelfuse</option>
	<option value='Murray'>Murray</option>
	<option value='Siemens'>Siemens</option>
	<option value='Square D'>Square D</option>
	<option value='Thomas Betts'>Thomas Betts</option>
	<option value='Wadsworth'>Wadsworth</option>
	<option value='Westinghouse'>Westinghouse</option>
	<option value='Zinsco'>Zinsco</option>
	<option value='Other'>Other</option>
<?php endif; ?>
</select>
