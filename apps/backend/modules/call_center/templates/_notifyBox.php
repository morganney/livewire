
<ul id='be_users'>
	<?php foreach($be_users as $user) : ?>
	<li><input type='checkbox' name='notify[]' value='<?php echo $user['email'],':',$user['name'] ?>' /> <?php echo $user['name'] ?></li>
	<?php endforeach; ?>
</ul>
