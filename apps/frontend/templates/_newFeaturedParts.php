
<h4 id='msg2'>Most Popular <img alt='<?php echo $param['manuf'] ?>' src ='/images/manuf/new/<?php echo $param['manuf_slug']?>.png' /> <?php echo $param['category'] ?></h4>

<div id='featured_item'>
 <?php foreach($featured_parts as $id => $arr) : ?>
	<?php if($id % 2 != 0) : ?>
	 <div class='item_box r'>
	 <?php else : ?>
	 <div class='item_box'>
	 <?php endif; ?>
		<div class ='item_img'>
			<?php echo link_to(image_tag($arr['img_src'], array('alt' => $arr['part_no'])), "@part?cat_slug={$param['cat_slug']}&manuf_slug={$param['manuf_slug']}&part_no=" . LWS::encode($arr['part_no']), array('class' => 'img_a','rel' => 'nofollow')) ?>
			<?php echo link_to($arr['part_no'], "@part?cat_slug={$param['cat_slug']}&manuf_slug={$param['manuf_slug']}&part_no=" . LWS::encode($arr['part_no'])) ?>
		</div>
		<?php if(!is_null($arr['ns_new_id'])) : //stupid hack because of inconsistent pricing strategy ?>
		<div class='item_price'>
			<p class='new_price only'><strong><script type='text/javascript' src='http://shopping.netsuite.com/app/site/query/getitemprice.nl?c=502106&amp;id=<?php echo $arr['ns_new_id'] ?  $arr['ns_new_id'] : 'xyz'; ?>'></script></strong>Guaranteed Price</p>
			<a class='btn' href='<?php echo url_for('@no_js') ?>' rel='nofollow' id='_<?php echo $arr['ns_new_id'] ?>' name='_<?php echo $arr['ns_new_id'] ?>'>Add to Cart</a>
		</div>
		<?php endif; ?>
	</div>
	<?php endforeach; ?>
</div>

<?php include_partial('global/addToCartForm') ?>
