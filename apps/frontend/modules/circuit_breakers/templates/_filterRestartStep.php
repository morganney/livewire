
	<div class='step one'></div>
	<div id='step'>
		<h2>Select Your Frame Type</h2>
		<table id='frame_types' cellspacing='0' cellpadding='0'>
			<tbody>
				<tr>
				<?php foreach($data as $idx => $arr) : ?>
					<?php if($idx != 0 && $idx % 10 == 0) : ?>
					</tr><tr>
					<?php endif; ?>
					<td>
						<?php echo link_to(image_tag($arr['img_src'], array('alt' => $arr['AT'])) ,'@cb_select', array('query_string' => $arr['QS'], 'class' => 'ajax', 'rel' => 'nofollow')) ?>
						<?php echo link_to($arr['AT'], '@cb_select', array('query_string' => $arr['QS'], 'class' => 'ajax', 'rel' => 'nofollow')) ?>
					</td>
				<?php endforeach; ?>
				</tr>
			</tbody>
		</table>
	</div>