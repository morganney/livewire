<?php use_stylesheet('search') ?>
<?php include_partial('global/h1', array('txt' => "Results: {$count} Parts Similar to '<em>{$query}</em>'")) ?>
<ul class='desc'>
	<li>showing page: <strong>1 of <?php echo $num_serps ?></strong></li>
	<li class='b'>max items per page: <strong><?php echo sfConfig::get('app_search_pagination_max_items') ?></strong></li>
	<li>sorted by: <strong>part no. ascending</strong></li>
</ul>
<?php if($num_serps > 1) : ?>
<p class='pager'>
	<span>1</span>
	<?php for($i = 2; $i <= $num_serps; $i++) : ?>
		<?php echo link_to($i, '@search_pagination?query=' . LWS::encode($query) . '&page_num=page-' . $i ) ?>
	<?php endfor; ?>
</p>
<?php endif;?>
<ul id='srch_results'>
	<?php $i = 0; foreach($similar_parts as $part) : ?>
	<li<?php echo $i >= $bottom_idx ? " class='b'" : '' ?>>
		<table cellpadding='0' cellspacing='0'>
			<tr>
				<td class='thumb'><?php echo link_to(image_tag($part['img'], array('alt' => $part['part_no'])), "@part?cat_slug={$part['cat_slug']}&manuf_slug={$part['manuf_slug']}&part_no={$part['encoded_part_no']}") ?></td>
				<td><?php echo link_to($part['part_no'], "@part?cat_slug={$part['cat_slug']}&manuf_slug={$part['manuf_slug']}&part_no={$part['encoded_part_no']}") ?> <?php echo $part['manuf'] ?> &mdash; <?php echo $part['category'] ?></td>
			</tr>
		</table>
	</li>
	<?php $i++; endforeach; ?>
</ul>
<ul class='desc'>
	<li>showing page: <strong>1 of <?php echo $num_serps ?></strong></li>
	<li class='b'>max items per page: <strong><?php echo sfConfig::get('app_search_pagination_max_items') ?></strong></li>
	<li>sorted by: <strong>part no. ascending</strong></li>
</ul>
<?php if($num_serps > 1) : ?>
<p class='pager'>
	<span>1</span>
	<?php for($i = 2; $i <= $num_serps; $i++) : ?>
		<?php echo link_to($i, '@search_pagination?query=' . LWS::encode($query) . '&page_num=page-' . $i ) ?>
	<?php endfor; ?>
</p>
<?php endif;?>
<?php slot('sidebar') ?>
	<?php include_partial('searchSidebar', array('search_routes' => $search_routes, 'search_routes_class' => $search_routes_class, 'item_count' => count($similar_parts))) ?>
<?php end_slot() ?>
