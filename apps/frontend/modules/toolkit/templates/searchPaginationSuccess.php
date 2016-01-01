<?php use_stylesheet('search') ?>
<?php include_partial('global/h1', array('txt' => "Searching: '{$query}' page {$page_num} of {$num_serps}")) ?>
<ul class='desc'>
	<li>showing page: <strong><?php echo $page_num ?> of <?php echo $num_serps ?></strong></li>
	<li class='b'>max items per page: <strong><?php echo sfConfig::get('app_search_pagination_max_items') ?></strong></li>
	<li>sorted by: <strong>part no. ascending</strong></li>
</ul>
<p class='pager'>
	<?php for($i = 1; $i < $page_num; $i++) : ?>
		<?php echo link_to($i, '@search_pagination?query=' . $sf_params->get('query') . '&page_num=page-' . $i ) ?>
	<?php endfor; ?>
	<span><?php echo $page_num ?></span>
	<?php for($i = $page_num + 1; $i <= $num_serps; $i++) : ?>
		<?php echo link_to($i, '@search_pagination?query=' . $sf_params->get('query') . '&page_num=page-' . $i ) ?>
	<?php endfor; ?>
</p>
<ul id='srch_results'>
	<?php $i = 0; foreach($data_set as $part) : ?>
	<li<?php echo $i >= $bottom_idx ? " class='b'" : '' ?>>
		<table cellpadding='0' cellspacing='0'>
			<tr>
				<td class='thumb'><img src='<?php echo $part['img'] ?>' alt='<?php echo $part['part_no'] ?>' /></td>
				<td><?php echo link_to($part['part_no'], "@part?cat_slug={$part['cat_slug']}&manuf_slug={$part['manuf_slug']}&part_no={$part['encoded_part_no']}") ?> <?php echo $part['manuf'] ?> &mdash; <?php echo $part['category'] ?></td>
			</tr>
		</table>
	</li>
	<?php $i++; endforeach; ?>
</ul>
<ul class='desc'>
	<li>showing page: <strong><?php echo $page_num ?> of <?php echo $num_serps ?></strong></li>
	<li class='b'>max items per page: <strong><?php echo sfConfig::get('app_search_pagination_max_items') ?></strong></li>
	<li>sorted by: <strong>part no. ascending</strong></li>
</ul>
<p class='pager'>
	<?php for($i = 1; $i < $page_num; $i++) : ?>
		<?php echo link_to($i, '@search_pagination?query=' . $sf_params->get('query') . '&page_num=page-' . $i ) ?>
	<?php endfor; ?>
	<span><?php echo $page_num ?></span>
	<?php for($i = $page_num + 1; $i <= $num_serps; $i++) : ?>
		<?php echo link_to($i, '@search_pagination?query=' . $sf_params->get('query') . '&page_num=page-' . $i ) ?>
	<?php endfor; ?>
</p>
<?php slot('sidebar') ?>
	<?php include_partial('searchSidebar', array('search_routes' => $search_routes, 'search_routes_class' => $search_routes_class, 'item_count' => count($data_set))) ?>
<?php end_slot() ?>
