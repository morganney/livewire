<div id='results_wrap'>
	<h3 id='rsf'><?php echo count($results_so_far) ?> Matching Results For </h3>
	<ul id='search_params'>
	<?php while(list($label, $value) = each($search_params)) : ?>
		<li<?php echo current($search_params) === FALSE ? " class='last'" : '' ?>><?php echo $label, ": <span>{$value}</span>" ?></li>
	<?php endwhile; ?>
	</ul>
	<ul id='results'>
		<li>
			<table class='result_set' cellspacing='0' cellpadding='0'>
				<tr>
				<?php foreach($results_so_far as $idx => $part) : ?>
					<td><?php echo link_to($part['part_no'], "@part?cat_slug=circuit-breakers&manuf_slug={$part['manuf_slug']}&part_no=" . LWS::encode($part['part_no'])) ?></td>
					<?php if(($idx + 1) % 5 == 0 && ($idx + 1) % 30 != 0) : // close out current sets row ?>
					</tr><tr>
					<?php endif; ?>
					<?php if(($idx + 1) % 30 == 0) : // close out current set ?>
					</tr></table></li><li><table class='result_set' cellspacing='0' cellpadding='0'><tr>
					<?php endif; ?>
				<?php endforeach; ?>
				</tr>
			</table>
		</li><!-- close out last result_set -->
	</ul><!-- close out results -->
</div><!-- close out results_wrap -->
