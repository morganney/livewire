
<?php use_stylesheet('custom') ?>
<?php include_partial('global/h1', array('txt' => 'Page Not Found')) ?>
<h2>Oops! We couldn't find this page for you.</h2>
<h3>404 Error : page not found</h3>
<p>Sorry, but the page you are looking for is no longer here, at least not at the address you requested.  You may have followed a bad external link, or mis-typed a URL. If you reached this page from another part of <em>this</em> site, please email us at <a href='mailto:webmaster@livewiresupply.com'>webmaster@livewiresupply.com</a> so we can correct our mistake.</p>
<div>
<p>Some options you can take from here:</p>
	<ul>
		<li>Visit our <?php echo link_to('home', '@homepage') ?> page</li>
		<li>View our <?php echo link_to('products', '@products') ?></li>
		<li>Learn more <?php echo link_to('about us', '@about_us')?></li>
	</ul>
</div>
<p style='margin-top: 0'>Or you can simply <a href='javascript:history.go(-1)'>go back a page</a> and start over.</p>
<?php slot('sidebar') ?>
	<?php include_partial('global/expertBox') ?>
<?php end_slot() ?>
