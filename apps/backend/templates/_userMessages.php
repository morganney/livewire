<?php if($sf_user->hasFlash($flash_name)) : $msgs = $sf_user->getFlash($flash_name) ?>
<p class='user_msg'>
<?php if(is_array($msgs)) : ?>
<?php foreach($msgs as $msg) : ?>
<?php echo $msg, '<br />'; ?>
<?php endforeach; ?>
<?php else : ?>
<?php echo $msgs ?>
<?php endif; ?>
</p>
<?php endif; ?>