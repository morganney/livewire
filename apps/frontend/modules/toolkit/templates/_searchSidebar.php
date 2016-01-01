<?php if(count($search_routes) > intval(sfConfig::get('app_search_max_routes'))) : ?>
<ul class='srch_links<?php echo $search_routes_class ?>'>
	<li><h4>Search items on this page</h4></li>
	<?php for($i = 0; $i < intval(sfConfig::get('app_search_max_routes')); $i++) : ?>
	<li><?php echo link_to($search_routes[$i]['anchor_txt'], $search_routes[$i]['route']) ?></li>
	<?php endfor; ?>
</ul>
<ul id='srch_links_aux'>
	<li><h4>Search items continued ...</h4></li>
	<?php for($i = intval(sfConfig::get('app_search_max_routes')); $i < count($search_routes); $i++) : ?>
	<li><?php echo link_to($search_routes[$i]['anchor_txt'], $search_routes[$i]['route']) ?></li>
	<?php endfor; ?>
</ul>
<?php else : ?>
<ul class='srch_links<?php echo $search_routes_class ?>'>
	<li><h4>Search items on this page</h4></li>
	<?php foreach($search_routes as $route) : ?>
	<li><?php echo link_to($route['anchor_txt'], $route['route']) ?></li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>
<div id='expert_box'>
	<h4>Speak with an Electrical Supply Expert</h4>
	<img src='/images/circuit-breaker-expert-trans.png' alt='electrical circuit breakers expert 800-390-3299' />
</div>
<?php if($item_count > 12) : ?>
<ul id='biz_features'>
	<li class='first'>Sales Support:<br />24 hours a day,<br />365 days a year</li>
	<li>No minimum order quantity</li>
	<li>Overnight Shipping Available</li>
	<li>On-line order tracking</li>
	<li>Bulk discounts available for some items</li>
	<li>Certified Guarantee <br /> on all products</li>
</ul>
<?php endif; ?>
