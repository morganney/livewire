<?php //echo "<h1>{$param['subnav_count']}</h1>";?>
<p id='rfq_box'><?php echo link_to("{$param['category']} RFQ", '@rfq?category=' . LWS::slugify($param['category']), array('title' => "{$param['category']} request for quote")) ?></p>
<h4 id='catalog'><?php echo link_to("{$param['manuf']} {$param['category']} Catalog", "@pagination?cat_slug={$param['cat_slug']}&manuf_slug={$param['manuf_slug']}&page_num=page-1") ?></h4>

<ul class='manuf_subnav <?php echo $param['manuf_list_class'] ?>'>
<?php foreach ($param['manuf_list'] as $arr): ?>
<li><?php echo link_to($arr['manuf'], $arr['route']); ?></li>
<?php endforeach; ?>
</ul>

<?php for($j = 0; $j < $param['subnav_count']; $j++) : ?>
<?php $limit = $j == ($param['subnav_count']-1) ? count($param['sections']) : ($param['subnav_grouping'] * ($j+1)); ?>
<?php // most of the complex logic is just for finding the right background image and padding, etc. not super important ?>
<?php $subnav_class = $j > 0 ? ($j == ($param['subnav_count']-1) ? (($limit - ($j * $param['subnav_grouping'])) <= sfConfig::get('app_subnav_grouping_bottom') ? ' bottom' :' middle' ) : ' middle') : ' top'; ?>
<ul class='manuf_subnav<?php echo $subnav_class ?>'>
	<?php if($j == 0) : ?>
	<li><h4 id='divider'><?php echo $param['manuf'], ' ', $param['subcategory']?></h4></li>
	<?php endif; ?>
	<?php for($i = $j * $param['subnav_grouping']; $i < $limit; $i++) : ?>
	<?php $subcat_slug = LWS::getSubcatSlug($param, $i); ?>
	<?php $cls = $i == ($j * $param['subnav_grouping']) ? " class='first'" : ''?>
	<li<?php echo $cls ?>><?php
			echo link_to(
				"{$param['sections'][$i]['section']}", 
				"@sub_pagination?cat_slug={$param['cat_slug']}&manuf_slug={$param['manuf_slug']}&subcat_slug={$subcat_slug}&section={$param['sections'][$i]['section_slug']}&page_num=page-1",
				array('title' => "{$param['manuf']} {$param['subcategory']} {$param['sections'][$i]['section']}")
				);
			echo " ({$param['sections'][$i]['count']})";
		?>
	</li>
	<?php endfor; ?>
</ul>
<?php endfor; ?>

<div id='expert_box'>
	<h4>Speak with an Electrical Supply Expert</h4>
	<img src='/images/circuit-breaker-expert-trans.png' alt='electrical circuit breakers expert 800-390-3299' />
</div>
