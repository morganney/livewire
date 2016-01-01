<?php use_stylesheet('rfq') ?>
<ul id='opening'>
	<li><h1>Request for Quote: <?php echo $category ?></h1></li>
</ul>
<?php if($sf_user->hasFlash('rfq_notice')) : ?>
<div id='flash'><?php echo $sf_user->getFlash('rfq_notice') ?></div>
<?php endif; ?>
<?php include_partial("rfq{$partial}", array('cat_slug' => $cat_slug)) ?>
<?php slot('sidebar') ?>
	<?php include_partial('rfqSidebar') ?>
<?php end_slot() ?>
