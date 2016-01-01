<?php $n = isset($editable) ? 'u:category[]' : 'category[]' ?>
<select name='<?php echo $n ?>' <?php echo isset($ticket) ? "disabled='disabled' class='disabled'" : '' ?>>
<?php if(isset($ticket)) : ?>
	<option value='Circuit Breakers' <?php echo $ticket['category'] == 'Circuit Breakers' ? "selected='selected'" : '' ?>>Circuit Breaker</option>
	<option value='Electrical Transformers' <?php echo $ticket['category'] == 'Electrical Transformers' ? "selected='selected'" : '' ?>>Transformer</option>
	<option value='Motor Control' <?php echo $ticket['category'] == 'Motor Control' ? "selected='selected'" : '' ?>>Motor Control</option>
	<option value='Fuses' <?php echo $ticket['category'] == 'Fuses' ? "selected='selected'" : '' ?>>Fuse</option>
	<option value='Busway' <?php echo $ticket['category'] == 'Busway' ? "selected='selected'" : '' ?>>Busway</option>
<?php else: ?>
	<option value='Circuit Breakers'>Circuit Breaker</option>
	<option value='Electrical Transformers'>Transformer</option>
	<option value='Motor Control'>Motor Control</option>
	<option value='Fuses'>Fuse</option>
	<option value='Busway'>Busway</option>
<?php endif; ?>
</select>
