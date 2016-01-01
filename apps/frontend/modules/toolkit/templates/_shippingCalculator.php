
<div id='ship_calc'>
	<div>
		<h3>SHIPPING CALCULATOR</h3>
		<form method='get' action='<?php echo url_for('@ship_calculator') ?>' id='ups_calc'>
			<p><input type='text' class='txt' name='ship_qty' id='ship_qty' value='QTY'  size='7' maxlength='5' /></p><!-- IE6 & IE7 require this empty string to make the entire button clickable -->
			<p><input type='text' class='txt' name='zip' id='zip' value='ZIP'  size='7' maxlength='5' /> <input type='submit' class='sbmt' value='          ' /></p>
			<input type='hidden' name='cat_id'  id='cat_id' value='<?php echo $cat_id ?>' />
			<input type='hidden' name='weight' id='weight' value='<?php echo $part['weight'] ?>' />
		</form>
		<table cellpadding='0' cellspacing='0'>
			<tr class='e'><td><strong>METHOD</strong></td><td class='s'><strong>CHARGE</strong></td></tr>
			<tr><td><a href='http://www.ups.com/content/us/en/shipping/time/service/ground.html' rel='nofollow'>Ground</a></td><td class='s' id='_03'>$0.00</td></tr>
			<tr class='e'><td><a href='http://www.ups.com/content/us/en/shipping/time/service/three_day.html' rel='nofollow'>3 Day Select</a></td><td class='s' id='_12'>$0.00</td></tr>
			<tr><td><a href='http://www.ups.com/content/us/en/shipping/time/service/second_day.html' rel='nofollow'>2nd Day Air</a></td><td class='s' id='_02'>$0.00</td></tr>
			<tr class='e'><td><a href='http://www.ups.com/content/us/en/shipping/time/service/next_day_saver.html' rel='nofollow'>Next Day Air Saver</a></td><td class='s' id='_13'>$0.00</td></tr>
			<tr><td><a href='http://www.ups.com/content/us/en/shipping/time/service/next_day_am.html' rel='nofollow'>Next Day Air Early A.M.</a></td><td class='s' id='_14'>$0.00</td></tr>
		</table>
	</div>
	<p class='info ship_timer'><strong>Want <span><?php echo $part['part_no'] ?></span> delivered by <?php echo $receipt_date ?>?</strong> Order it in the next <em><?php echo $hrs_cnt, ' hour', $h_suffix, ' and ', $min_cnt, ' minute', $m_suffix ?></em>, and choose One-Day shipping at checkout. <?php echo link_to('Details','@shipping_options') ?></p>
	<p class='info warranty'><span>1-YEAR WARRANTY</span> <?php echo link_to('Warranty Details', '@returns_warranty') ?></p>
</div>
