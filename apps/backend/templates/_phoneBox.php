<p>
	<?php if($type === 'phone') : ?>
	<label for='phon1'>Phone Number:</label> ( <input name='phon1' id='phon1' type='text' class='txt' value='<?php echo isset($form) ? $form['phon1'] : '' ?>' size='2' maxlength='3' /> )  <input name='phon2' id='phon2' type='text' class='txt' value='<?php echo isset($form) ? $form['phon2'] : '' ?>' size='2' maxlength='3' /> - <input name='phon3' id='phon3' type='text' class='txt' value='<?php echo isset($form) ? $form['phon3'] : '' ?>' size='3' maxlength='4' />
	<?php if(isset($ext)) : ?>
	x <input name='phon_ext' id='phon_ext' type='text' class='txt' value='<?php echo isset($form) ? $form['phon_ext'] : '' ?>' size='3' maxlength='4' /> 
	<?php endif; ?>
	<?php elseif ($type === 'alt'): ?>
	<label for='alt_phon1'>Phone Number 2:</label> ( <input name='alt_phon1' id='alt_phon1' type='text' class='txt' value='<?php echo isset($form) ? $form['alt_phon1'] : '' ?>' size='2' maxlength='3' /> )  <input name='alt_phon2' id='alt_phon2' type='text' class='txt' value='<?php echo isset($form) ? $form['alt_phon2'] : '' ?>' size='2' maxlength='3' /> - <input name='alt_phon3' id='alt_phon3' type='text' class='txt' value='<?php echo isset($form) ? $form['alt_phon3'] : '' ?>' size='3' maxlength='4' />
	<?php if(isset($ext)) : ?>
	x <input name='alt_phon_ext' id='alt_phon_ext' type='text' class='txt' value='<?php echo isset($form) ? $form['alt_phon_ext'] : '' ?>' size='3' maxlength='4' /> 
	<?php endif; ?>
	<?php else : ?>
	<label for='fax1'> Fax Number:</label> ( <input name='fax1' id='fax1' type='text' class='txt' value='<?php echo isset($form) ? $form['fax1'] : '' ?>' size='2' maxlength='3' /> )  <input name='fax2' id='fax2' type='text' class='txt' value='<?php echo isset($form) ? $form['fax2'] : '' ?>' size='2' maxlength='3' /> - <input name='fax3' id='fax3' type='text' class='txt' value='<?php echo isset($form) ? $form['fax3'] : '' ?>' size='3' maxlength='4' />
	<?php endif; ?>
</p>
