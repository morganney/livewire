
<?php use_stylesheet('select') ?>
<?php use_javascript('add-to-cart') ?>
<?php include_partial('global/h1', array('txt' => 'Electrical Transformers Selection Process Results')) ?>
<div id='part_details'>
	<div id='part_img'>
		<img src='<?php echo $img_src ?>' alt='Transformer' />
	</div>
	<div id='part_specs'>
		<table cellspacing='10' cellpadding='0'>
			<tbody>
				<tr><td class='label'>KVA:</td><td><?php echo $sf_params->get('kva') ?></td></tr>
				<tr><td class='label'>Phase:</td><td><?php echo $sf_params->get('phase') ?></td></tr>
				<tr><td class='label'>Input:</td><td><?php echo rawurldecode($sf_params->get('input')) ?></td></tr>
				<tr><td class='label'>Output:</td><td><?php echo rawurldecode($sf_params->get('output')) ?></td></tr>
				<tr><td class='label'>In Stock:</td><td id='stock'>YES</td></tr>
			</tbody>
		</table>
		<p id='pay_info'><span>1-YEAR WARRANTY</span><?php echo link_to('Warranty Details', '@returns_warranty') ?></p>
	</div>
</div>
<?php if($found_rebuilt) : ?>
<div id='green_part'>
	<h3>BUY REFURBISHED <?php echo link_to("What's This?", '@go_green', array('id' => 'what')) ?></h3>
	<div class='line_item'>
		<div class='pic'>
			<img src='/images/like-new-low-price.png' alt='Low Priced Transformers' />
			<?php echo link_to($data[$rebuilt_idx]['part']['part_no'], '@part?cat_slug=electrical-transformers&manuf_slug=rebuilt&part_no=' . LWS::encode($data[$rebuilt_idx]['part']['part_no']), array('class' => 'part_lnk')) ?>
		</div>
		<div class='price'>
			<p><strong><script type='text/javascript' src='http://shopping.netsuite.com/app/site/query/getitemprice.nl?c=502106&amp;id=<?php echo $data[$rebuilt_idx]['part']['ns_green_id'] ?  $data[$rebuilt_idx]['part']['ns_green_id'] : -1; ?>'></script></strong></p>
			<p><input type='text' class='txt' size='4' name='_<?php echo $data[$rebuilt_idx]['part']['part_no'] ?>_qty' id='_<?php echo $data[$rebuilt_idx]['part']['part_no'] ?>_qty' /></p>
		</div>
		<div class='btn'><a href='<?php echo url_for('@no_js') ?>' id='_<?php echo $data[$rebuilt_idx]['part']['part_no'], '_', $data[$rebuilt_idx]['part']['ns_green_id'] ?>' rel='nofollow'>Add To Cart</a></div>
	</div>
</div>
<?php endif; ?>
<?php if($found_new) : ?>
<div id='new_parts'>
	<h3>BUY NEW</h3>
	<?php foreach($data as $idx => $arr) : ?>
		<?php if($arr['part']['manuf_slug'] == 'rebuilt')  continue ; // this should be moved to action/model ?>
		<div class='line_item'>
			<div class='pic'>
				<img src='/images/manuf/rect/<?php echo $arr['part']['manuf_slug'] ?>.jpg' alt='<?php echo $arr['part']['manuf_slug'] ?>' />
				<?php echo link_to($arr['part']['part_no'], '@part?cat_slug=electrical-transformers&manuf_slug=' . $arr['part']['manuf_slug'] . '&part_no=' . LWS::encode($arr['part']['part_no']), array('class' => 'part_lnk')) ?>
			</div>
			<div class='price'>
				<p><strong><script type='text/javascript' src='http://shopping.netsuite.com/app/site/query/getitemprice.nl?c=502106&amp;id=<?php echo $arr['part']['ns_new_id'] ?  $arr['part']['ns_new_id'] : 123; ?>'></script></strong></p>
				<p><input type='text' class='txt' size='4' name='_<?php echo $arr['part']['part_no'] ?>_qty' id='_<?php echo $arr['part']['part_no'] ?>_qty' /></p>
			</div>
			<div class='btn'><a href='<?php echo url_for('@no_js') ?>' id='_<?php echo $arr['part']['part_no'], '_', $arr['part']['ns_new_id'] ?>' rel='nofollow'>Add To Cart</a></div>
		</div>
	<?php endforeach; ?>
</div>
<?php endif; ?>

<?php include_partial('global/addToCartForm') ?>

<?php slot('sidebar') ?>
	<?php include_partial('global/selectToolSidebar', array('category' => 'Electrical Transformers')) ?>
<?php end_slot() ?>
