
<div id='pre_nav'>
	<h1><?php echo link_to('Control Panel', '@control_panel') ?> <em><?php echo sfConfig::get('app_company'),' ',sfConfig::get('app_branding') ?></em></h1>
	<div id='user_portal'>
		<?php if($user) : ?>
		<ul class='hot_links'>
			<li><strong><?php echo $user['full_name'] ?></strong></li>
			<li><strong>Last login:</strong> <?php echo $user['last_login'] ?></li>
			<li class='l'><?php echo link_to('logout', '@logout') ?></li>
		</ul>
		<?php endif; ?>
		<div id='find_box'>
			<form id='search' action='<?php echo url_for('@find') ?>' method='get'>
				<p><input type='text' class='txt' id='q' name='q' value='' /> <input type='submit' class='sbmt' id='srch_btn' value='Find' /></p>
			</form>
		</div>
	</div>
</div>
<ul id='nav'>
	<li>
		<?php echo link_to('Control Panel', '@control_panel', array('id' => 'nav_cp')) ?>
	</li>
	<li>
		<?php echo link_to('CMS', '@cms', array('id' => 'nav_cms')) ?>
	</li>
	<li>
		<?php echo link_to('Call Center', '@call_center', array('id' => 'nav_cc')) ?>
	</li>
</ul>
<?php if($sf_params->get('module') != 'ajax') include_partial($sf_params->get('module') . '/nav') ?>
