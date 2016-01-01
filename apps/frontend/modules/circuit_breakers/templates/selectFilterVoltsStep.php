<!-- Should never need this template because the CB tool should always return 1 result -->
<?php use_stylesheet('cmp') ?>
<?php use_stylesheet('select') ?>

<?php include_partial('global/h1', array('txt' => "{$manuf} Circuit Breakers Selection Process")) ?>



<?php slot('sidebar') ?>
	<?php include_partial('global/selectToolSidebar', array('category' => 'Circuit Breakers')) ?>
<?php end_slot() ?>
