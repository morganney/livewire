<?php if(isset($form)) : ?>
<p>
	<?php if(!isset($no_label)) : ?>
	<label for='region'>State:</label>
	<?php endif; ?>
	<select name='region' size='1'>
		<option value=''>----</option>
		<option value='AK' <?php echo $form['region'] == 'AK' ? "selected='selected'" : '' ?>>AK</option>
		<option value='AL' <?php echo $form['region'] == 'AL' ? "selected='selected'" : '' ?>>AL</option>
		<option value='AR' <?php echo $form['region'] == 'AR' ? "selected='selected'" : '' ?>>AR</option>
		<option value='AZ' <?php echo $form['region'] == 'AZ' ? "selected='selected'" : '' ?>>AZ</option>
		<option value='CA' <?php echo $form['region'] == 'CA' ? "selected='selected'" : '' ?>>CA</option>
		<option value='CO' <?php echo $form['region'] == 'CO' ? "selected='selected'" : '' ?>>CO</option>
		<option value='CT' <?php echo $form['region'] == 'CT' ? "selected='selected'" : '' ?>>CT</option>
		<option value='DC' <?php echo $form['region'] == 'DC' ? "selected='selected'" : '' ?>>DC</option>
		<option value='DE' <?php echo $form['region'] == 'DE' ? "selected='selected'" : '' ?>>DE</option>
		<option value='FL' <?php echo $form['region'] == 'FL' ? "selected='selected'" : '' ?>>FL</option>
		<option value='GA' <?php echo $form['region'] == 'GA' ? "selected='selected'" : '' ?>>GA</option>
		<option value='HI' <?php echo $form['region'] == 'HI' ? "selected='selected'" : '' ?>>HI</option>
		<option value='IA' <?php echo $form['region'] == 'IA' ? "selected='selected'" : '' ?>>IA</option>
		<option value='ID' <?php echo $form['region'] == 'ID' ? "selected='selected'" : '' ?>>ID</option>
		<option value='IL' <?php echo $form['region'] == 'IL' ? "selected='selected'" : '' ?>>IL</option>
		<option value='IN' <?php echo $form['region'] == 'IN' ? "selected='selected'" : '' ?>>IN</option>
		<option value='KS' <?php echo $form['region'] == 'KS' ? "selected='selected'" : '' ?>>KS</option>
		<option value='KY' <?php echo $form['region'] == 'KY' ? "selected='selected'" : '' ?>>KY</option>
		<option value='LA' <?php echo $form['region'] == 'LA' ? "selected='selected'" : '' ?>>LA</option>
		<option value='MA' <?php echo $form['region'] == 'MA' ? "selected='selected'" : '' ?>>MA</option>
		<option value='MD' <?php echo $form['region'] == 'MD' ? "selected='selected'" : '' ?>>MD</option>
		<option value='ME' <?php echo $form['region'] == 'ME' ? "selected='selected'" : '' ?>>ME</option>
		<option value='MI' <?php echo $form['region'] == 'MI' ? "selected='selected'" : '' ?>>MI</option>
		<option value='MN' <?php echo $form['region'] == 'MN' ? "selected='selected'" : '' ?>>MN</option>
		<option value='MO' <?php echo $form['region'] == 'MO' ? "selected='selected'" : '' ?>>MO</option>
		<option value='MS' <?php echo $form['region'] == 'MS' ? "selected='selected'" : '' ?>>MS</option>
		<option value='MT' <?php echo $form['region'] == 'MT' ? "selected='selected'" : '' ?>>MT</option>
		<option value='NC' <?php echo $form['region'] == 'NC' ? "selected='selected'" : '' ?>>NC</option>
		<option value='ND' <?php echo $form['region'] == 'ND' ? "selected='selected'" : '' ?>>ND</option>
		<option value='NE' <?php echo $form['region'] == 'NE' ? "selected='selected'" : '' ?>>NE</option>
		<option value='NH' <?php echo $form['region'] == 'NH' ? "selected='selected'" : '' ?>>NH</option>
		<option value='NJ' <?php echo $form['region'] == 'NJ' ? "selected='selected'" : '' ?>>NJ</option>
		<option value='NM' <?php echo $form['region'] == 'NM' ? "selected='selected'" : '' ?>>NM</option>
		<option value='NV' <?php echo $form['region'] == 'NV' ? "selected='selected'" : '' ?>>NV</option>
		<option value='NY' <?php echo $form['region'] == 'NY' ? "selected='selected'" : '' ?>>NY</option>
		<option value='OH' <?php echo $form['region'] == 'OH' ? "selected='selected'" : '' ?>>OH</option>
		<option value='OK' <?php echo $form['region'] == 'OK' ? "selected='selected'" : '' ?>>OK</option>
		<option value='OR' <?php echo $form['region'] == 'OR' ? "selected='selected'" : '' ?>>OR</option>
		<option value='PA' <?php echo $form['region'] == 'PA' ? "selected='selected'" : '' ?>>PA</option>
		<option value='RI' <?php echo $form['region'] == 'RI' ? "selected='selected'" : '' ?>>RI</option>
		<option value='SC' <?php echo $form['region'] == 'SC' ? "selected='selected'" : '' ?>>SC</option>
		<option value='SD' <?php echo $form['region'] == 'SD' ? "selected='selected'" : '' ?>>SD</option>
		<option value='TN' <?php echo $form['region'] == 'TN' ? "selected='selected'" : '' ?>>TN</option>
		<option value='TX' <?php echo $form['region'] == 'TX' ? "selected='selected'" : '' ?>>TX</option>
		<option value='UT' <?php echo $form['region'] == 'UT' ? "selected='selected'" : '' ?>>UT</option>
		<option value='VA' <?php echo $form['region'] == 'VA' ? "selected='selected'" : '' ?>>VA</option>
		<option value='VT' <?php echo $form['region'] == 'VT' ? "selected='selected'" : '' ?>>VT</option>
		<option value='WA' <?php echo $form['region'] == 'WA' ? "selected='selected'" : '' ?>>WA</option>
		<option value='WI' <?php echo $form['region'] == 'WI' ? "selected='selected'" : '' ?>>WI</option>
		<option value='WV' <?php echo $form['region'] == 'WV' ? "selected='selected'" : '' ?>>WV</option>
		<option value='WY' <?php echo $form['region'] == 'WY' ? "selected='selected'" : '' ?>>WY</option>
		<option value='X' <?php echo $form['region'] == 'X' ? "selected='selected'" : '' ?>>Other</option>
	</select>
</p>
<?php else : ?>
<p>
	<?php if(!isset($no_label)) : ?>
	<label for='region'>State:</label>
	<?php endif; ?>
	<select name='region' size='1'>
		<option value=''>----</option>
		<option value='AK'>AK</option>
		<option value='AL'>AL</option>
		<option value='AR'>AR</option>
		<option value='AZ'>AZ</option>
		<option value='CA'>CA</option>
		<option value='CO'>CO</option>
		<option value='CT'>CT</option>
		<option value='DC'>DC</option>
		<option value='DE'>DE</option>
		<option value='FL'>FL</option>
		<option value='GA'>GA</option>
		<option value='HI'>HI</option>
		<option value='IA'>IA</option>
		<option value='ID'>ID</option>
		<option value='IL'>IL</option>
		<option value='IN'>IN</option>
		<option value='KS'>KS</option>
		<option value='KY'>KY</option>
		<option value='LA'>LA</option>
		<option value='MA'>MA</option>
		<option value='MD'>MD</option>
		<option value='ME'>ME</option>
		<option value='MI'>MI</option>
		<option value='MN'>MN</option>
		<option value='MO'>MO</option>
		<option value='MS'>MS</option>
		<option value='MT'>MT</option>
		<option value='NC'>NC</option>
		<option value='ND'>ND</option>
		<option value='NE'>NE</option>
		<option value='NH'>NH</option>
		<option value='NJ'>NJ</option>
		<option value='NM'>NM</option>
		<option value='NV'>NV</option>
		<option value='NY'>NY</option>
		<option value='OH'>OH</option>
		<option value='OK'>OK</option>
		<option value='OR'>OR</option>
		<option value='PA'>PA</option>
		<option value='RI'>RI</option>
		<option value='SC'>SC</option>
		<option value='SD'>SD</option>
		<option value='TN'>TN</option>
		<option value='TX'>TX</option>
		<option value='UT'>UT</option>
		<option value='VA'>VA</option>
		<option value='VT'>VT</option>
		<option value='WA'>WA</option>
		<option value='WI'>WI</option>
		<option value='WV'>WV</option>
		<option value='WY'>WY</option>
		<option value='X'>Other</option>
	</select>
</p>
<?php endif; ?>

<!-- regions spelled out in full

<select name="region" size="1">
	<option value="AL">Alabama</option>
	<option value="AK">Alaska</option>
	<option value="AZ">Arizona</option>
	<option value="AR">Arkansas</option>
	<option value="CA">California</option>
	<option value="CO">Colorado</option>
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="DC">Dist of Columbia</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="HI">Hawaii</option>
	<option value="ID">Idaho</option>
	<option value="IL">Illinois</option>
	<option value="IN">Indiana</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="MT">Montana</option>
	<option value="NE">Nebraska</option>
	<option value="NV">Nevada</option>
	<option value="NH">New Hampshire</option>
	<option value="NJ">New Jersey</option>
	<option value="NM">New Mexico</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="ND">North Dakota</option>
	<option value="OH">Ohio</option>
	<option value="OK">Oklahoma</option>
	<option value="OR">Oregon</option>
	<option value="PA">Pennsylvania</option>
	<option value="RI">Rhode Island</option>
	<option value="SC">South Carolina</option>
	<option value="SD">South Dakota</option>
	<option value="TN">Tennessee</option>
	<option value="TX">Texas</option>
	<option value="UT">Utah</option>
	<option value="VT">Vermont</option>
	<option value="VA">Virginia</option>
	<option value="WA">Washington</option>
	<option value="WV">West Virginia</option>
	<option value="WI">Wisconsin</option>
	<option value="WY">Wyoming</option>
</select>

 -->
