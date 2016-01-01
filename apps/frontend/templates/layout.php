<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <?php include_slot('links', '') ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
		<!--[if IE]>
		<link rel='stylesheet' type='text/css' href='/css/ie.css' />
		<![endif]-->
		<!--[if lt IE 8]>
		<script src='http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js'></script>
		<![endif]-->
  </head>
  <body id='<?php include_slot('body_id', 'default') ?>' class='<?php include_slot('body_class', 'default') ?>'>
    <?php include_slot('after_hours', '') ?>
  	<div id='container'>
  	<div id='wrap'>
  		<div id='mast_head'>
  			<?php include_partial('global/header') ?>
  		</div>
  		<div id='main'>
  			<div id='l_main'>
  				<?php echo $sf_content ?>
  			</div>
  			<div id='r_main'>
  				<?php include_slot('sidebar') ?>
  			</div>
  			<?php include_partial('global/customerOptions') ?>
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
			$(document).ready(function() {
				 if($('body').hasClass('category')) { $('form.basic input.txt').val('Enter Part or Catalog Number').click(function() { $(this).val('') }); }
				 if($('body').attr('id') == 'transformers') { $('#tr_search input.txt').val('Enter Part or Catalog Number').click(function() { $(this).val('') }); }
				 $('#opt_shipping,#opt_green').css('cursor','pointer').click(function(){window.location=$('#'+this.id+' a').attr('href');});
			});
		</script>
  </body>
</html>
