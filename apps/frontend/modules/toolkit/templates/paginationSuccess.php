
<?php use_stylesheet('cmp') ?>
<?php use_javascript('pagination') ?>
<?php include_partial('global/h1', array('txt' => "{$param['manuf']} {$param['category']} Catalog ({$param['current_page_num']} of {$param['total_pages']})")) ?>
<p class='pager' style='background-image: url(/images/manuf/<?php echo $sf_params->get('manuf_slug') ?>.gif);'>
<?php if($param['next_page_num'] <= $param['total_pages']) : ?>
<?php 
	echo link_to("{$param['manuf']} {$param['category']} ({$param['next_page_num']} of {$param['total_pages']})", 
	'@pagination?cat_slug=' . $sf_params->get('cat_slug')
	. '&manuf_slug=' . $sf_params->get('manuf_slug')
	. "&page_num=page-{$param['next_page_num']}");
?>
<?php endif; ?>
</p>
<div id='part_list'>
	<ul id='parts'>
	<?php foreach($param['parts'] as $part) : ?>
		<li>
			<?php echo $part['layout']; ?>
		</li>
	<?php endforeach; ?>
	</ul>
</div>
<p class='pager' style='background-image: url(/images/manuf/<?php echo $sf_params->get('manuf_slug') ?>.gif);'>
<?php if($param['next_page_num'] <= $param['total_pages']) : ?>
<?php 
	echo link_to("{$param['manuf']} {$param['category']} ({$param['next_page_num']} of {$param['total_pages']})", 
	'@pagination?cat_slug=' . $sf_params->get('cat_slug')
	. '&manuf_slug=' . $sf_params->get('manuf_slug')
	. "&page_num=page-{$param['next_page_num']}");
?>
<?php endif; ?>
</p>

<form action='http://shopping.netsuite.com/app/site/query/additemtocart.nl?c=502106&amp;ext=T' method='post' enctype='application/x-www-form-urlencoded' id='add_to_cart' name='add_to_cart' class='invisible'>
	<input type='hidden' name='c' id='c' value='502106' />
	<input type='hidden' name='buyid' id='buyid' value='' />
	<input type='hidden' name='add'  id='add'  value='' />
	<input type='hidden' name='showcart' value='true' /> 
	<input type='hidden' name='redirect' value='http://shopping.netsuite.com/s.nl?c=502106&n=1&sc=3&whence=&continue=http%3A%2F%2Flivewiresupply.com%2F' /> 
</form>

<?php slot('sidebar') ?>
	<?php include_partial('paginationSidebar', array('param' => $param)) ?>
<?php end_slot() ?>
