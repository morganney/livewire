<?php $sf_response->addMeta('description', "LiveWire is the Internet's #1 Supplier for ({$param['part']['part_no']} {$param['category']} by {$param['part']['manuf']}). Ships same-day with 1-year warranty. {$param['part']['part_no']} available."); ?>
<?php $sf_response->addMeta('keywords', $param['meta_keywords']) ?>
<?php use_stylesheet('cmp') ?>
<?php use_javascript('part') ?>
<?php include_partial('global/h1', array('txt' => $param['h1Txt'])) ?>
<div id='shopping'>
	<h2 style='background-image: url(/images/manuf/<?php echo $sf_params->get('manuf_slug') ?>.gif);'><?php echo $param['part']['part_no'] ?></h2>
	<div id='store'>
		<?php include_partial($param['store'], array('part' => $param['part'])) ?>
	</div>
	<?php if($param['shipping_needed']) : ?>
		<?php include_component('toolkit', 'shippingCalculator', array('part' => $param['part'], 'cat_id' => $param['cat_id'])) ?>
	<?php endif; ?>
	<div id='part_specs'>
		<h3>Product Details</h3>
		<dl>
			<dt>Catalog Number:</dt>
			<dd><?php echo $param['part']['part_no'] ?></dd>
			<dt>Manufacturer:</dt>
			<dd><?php echo $param['part']['manuf'] ?></dd>
			<?php foreach($param['part']['db_fields'] as $alias => $db_field) : ?>
			<dt><?php echo $alias, ':' ?></dt>
			<dd><?php echo LWS::formatValue($param['part'][$alias], $db_field) ?></dd>
			<?php endforeach; ?>
		</dl>
		<dl id='desc'>
			<dt>Full Description:</dt>
			<dd><?php echo trim($param['part']['specs'], '"') ?></dd>
			<?php if(!is_null($param['part']['catalog_uri'])) : ?>
			<dd><?php echo link_to('Download the Catalog Data-Sheet PDF', "https://images.tradeservice.com/{$param['part']['catalog_uri']}", array('absolute' => true)) ?></dd>
			<?php endif; ?>
		</dl>
	</div>
	<p id='closer'>The <?php echo $param['part']['part_no'] ?> is guaranteed authentic, may be new surplus and will carry a 1-year warranty.</p>
</div>

<?php include_partial('global/addToCartForm') ?>

<?php slot('sidebar') ?>
	<?php include_partial('partSidebar', array('part' => $param['part'], 'manuf_route' => $param['manuf_route'], 'category' => $param['category'], 'cat_route' => $param['cat_route'])) ?>
<?php end_slot() ?>

<?php if(LWS::isOutsideBizHours()) : ?>
	<?php slot('after_hours') ?>
		<?php include_partial('global/afterHoursMessage') ?>
	<?php end_slot() ?>
<?php endif;?>

