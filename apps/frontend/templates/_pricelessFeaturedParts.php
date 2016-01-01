
<h4 id='msg2'>Most Popular <img alt='<?php echo $param['manuf'] ?>' src ='/images/manuf/new/<?php echo $param['manuf_slug']?>.png' /> <?php echo $param['category'] ?></h4>

<div id='featured_item'>
 <?php foreach($featured_parts as $id => $arr) : ?>
	<?php if(($id + 1)% 3 == 0) : ?>
	 <div class='item_box r small'>
	 <?php else : ?>
	 <div class='item_box small'>
	 <?php endif; ?>
		<div class ='item_img'>
			<?php echo link_to(image_tag($arr['img_src'], array('alt' => $arr['part_no'])), "@part?cat_slug={$param['cat_slug']}&manuf_slug={$param['manuf_slug']}&part_no=" . LWS::encode($arr['part_no']), array('class' => 'img_a','rel' => 'nofollow')) ?>
			<?php echo link_to($arr['part_no'], "@part?cat_slug={$param['cat_slug']}&manuf_slug={$param['manuf_slug']}&part_no=" . LWS::encode($arr['part_no'])) ?>
		</div>
	</div>
	<?php endforeach; ?>
</div>
