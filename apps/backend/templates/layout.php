<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_title() ?>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
  </head>
  <body id='<?php echo $sf_params->get('module') ?>' class='<?php echo $sf_params->get('action') ?>'>
  	<div id='shell'><div id='skin'>
  	 	<div id='header'>
  			<?php include_partial('global/header', array('user' => $sf_user->getAttribute('be_user', NULL))) ?>
  		</div>
  		<div id='main'>
    		<?php echo $sf_content ?>
    		<div style='clear: both;'></div>
    	</div>
    	<div id='footer'>
    		<?php include_partial('global/footer') ?>
    	</div>
    </div></div>
    <?php include_javascripts() ?>
    <script type='text/javascript' src='/js/be/global.js'></script>
  </body>
</html>
