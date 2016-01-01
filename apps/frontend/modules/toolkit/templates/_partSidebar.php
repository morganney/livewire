
<div id='social'>
	<p id='btns'><?php echo link_to('Tell a Friend <span>about this part</span>', '@no_js') ?></p>
	<div id='tf_wrap'>
		<form action='<?php echo url_for('@tell_a_friend') ?>' method='get' name='friend_form' id='friend_form'>
		  <p>Share this item with a friend by sending them a brief email with a link back to this web page.</p>
			<p><label for='f_name'>Friend's Name</label><input type='text' name='f_name' id='f_name' class='txt' size='26' value='' /></p>
			<p><label for='f_email'>Friend's Email</label><input type='text' name='f_email' id='f_email' class='txt' size='26' value='' /></p>
			<p><label for='s_name'>Your Name</label><input type='text' name='s_name' id='s_name' class='txt' size='26' value='' /></p>
			<p><label for='s_email'>Your Email</label><input type='text' name='s_email' id='s_email' class='txt' size='26' value='' /></p>
			<p id='l'><input type='checkbox' name='cc_sender' id='cc_sender' value='true' /> Send a copy to me. &nbsp; <input type='submit' name='tf' id='tf' value='Send it!' /></p>
			<input type='hidden' name='part_url' id='part_url' value='<?php echo $sf_request->getUri() ?>' />
			<input type='hidden' name='manuf' id='manuf' value='<?php echo $part['manuf'] ?>' />
			<input type='hidden' name='part_no' id='part_no' value='<?php echo $part['part_no'] ?>' />
		</form>
		<div id='loader' class='invisible'></div>
	</div>
	<div id='fb_like'>
  	<iframe  src="http://www.facebook.com/plugins/like.php?href=<?php echo rawurlencode($sf_request->getUri()) ?>&amp;layout=button_count&amp;show_faces=false&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" style="border:none; overflow:hidden;" allowTransparency="true"></iframe>
  </div>
  <!--
  <script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
  <div id='tweet_btn'>
  	<a href="http://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a>
  </div>
  -->
</div>
<div id='srch_criteria'>
	<h4>Search Criteria</h4>
	<ul>
		<li><?php echo link_to($category, "@{$cat_route}") ?></li>
		<?php if($sf_params->get('manuf_slug') != 'rebuilt') : ?>
		<li><?php echo link_to($part['manuf'], "@{$manuf_route}?manuf_slug=" . $sf_params->get('manuf_slug')) ?></li>
		<?php else : ?>
		<li id='no_lnk'><?php echo $part['manuf'] ?></li>
		<?php endif; ?>
		<?php if(!is_null($part['website'])) : ?>
		<li><?php echo link_to("{$part['manuf']} (Official Site)", $part['website'], array('absolute' => true)) ?></li>
		<?php endif; ?>
		<li id='end'><?php echo $part['part_no'] ?></li>
	</ul>
	<p>Not the part you need? Call 1-800-390-3299 and speak to one of our <?php echo $category ?> experts.</p>
</div>
<div id='ship_regional'>
	<h4>WE SHIP FROM <strong>REGIONAL <span>LOCATIONS</span></strong></h4>
</div>
