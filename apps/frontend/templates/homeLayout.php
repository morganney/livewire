<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
		<!--[if IE]>
		<link rel='stylesheet' type='text/css' href='/css/ie.css' />
		<![endif]-->
		<!--[if lt IE 8]>
		<script src='http://ie7-js.googlecode.com/svn/version/2.1(beta3)/IE8.js'></script>
		<![endif]-->
  </head>
  <body id='<?php include_slot('body_id', 'default') ?>'>
    <?php include_slot('after_hours', '') ?>
  	<div id='container'>
  	<div id='wrap'>
  		<div id='mast_head'>
  			<?php include_partial('global/header') ?>
  		</div>
  		<div id='main'>
  			<?php echo $sf_content ?>
  			<!-- ensure #main will contain children elements -->
  			<div style='clear: both;'></div>
  		</div>
  		<div id='footer'>
  			<?php include_partial('global/footer') ?>
  			<div style='clear: both;'></div>
  		</div>
  	</div>
  	</div>
    <?php include_javascripts() ?>
		<script type='text/javascript'>
			// search box text overlay script (no http request for this simple piece)
			$(document).ready(function() {
				$('#search input.txt').val('Search by Part Number').click(function() { $(this).val('').css({'text-align' : 'left'}); });
			});
		</script>
  </body>
</html>
