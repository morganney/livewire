<?php use_stylesheet('be/cp') ?>
<?php use_javascript('be/cp') ?>
<?php include_partial('global/userMessages', array('flash_name' => 'cp_msg')) ?>
<div class='mod pw'>
	<h2>Change Password</h2>
	<form id='upw' method='post' action='<?php echo url_for('@update_password') ?>' enctype='application/x-www-form-urlencoded'>
		<p><label>Current Password:</label><input type='password' class='txt' name='cpw' value="" /></p>
		<p><label>New Password:</label><input type='password' class='txt' name='npw' value="" /></p>
		<p><label>Confirm Password:</label><input type='password' class='txt' name='pwc' value="" /></p>
		<p class='low'><input type='button' class='sbmt' id='upw_btn' value='Update Password' /></p>
		<input type='hidden' name='user_email' value="<?php echo $user['email'] ?>" />
		<input type='hidden' name='user_pw' value="<?php echo $user['password'] ?>" />
	</form>
</div>
