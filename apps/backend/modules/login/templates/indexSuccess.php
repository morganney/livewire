
<h1>LWS BFG</h1>
<div id='lgn'>
  <?php if($sf_user->hasFlash('login_error')) : ?>
	<p id='msg'><?php echo $sf_user->getFlash('login_error') ?></p>
	<?php endif; ?>
	<form action='' method='post' enctype='application/x-www-form-urlencoded'>
		<p class='top'><label for='email'>Email:</label><input id='email' name='email' type='text' size='25' value='' class='txt' /></p>
		<p><label for='pw'>Password:</label><input id='pw' name='pw' type='password' size='25' value='' class='txt' /></p>
		<p class='btm'><input type='submit' value='Login' name='log_in' id='log_in' /></p>
	</form>
	<div style='clear: both;'></div>
</div>
