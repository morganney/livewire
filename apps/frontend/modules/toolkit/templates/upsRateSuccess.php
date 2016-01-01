<?php if(isset($ups_error)) : ?>
<p><?php echo $ups_error ?></p>
<?php else : ?>
<pre style='font-size: 1.4em'><?php print_r($rates) ?></pre>
<?php endif; ?>
