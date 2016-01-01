
<div class='internal note'>
	<ul>
		<li><span>By:</span> <?php echo $note['sent_by_name'] ?></li>
		<li class='l'><span>Notified:</span> <?php echo $note['notify'] ? $note['notify'] : 'Nobody' ?></li>
	</ul>
	<p><?php echo BE::formatNote($note['note']) ?></p>
	<p class='meta'><?php echo date(sfConfig::get('app_formats_ext_date'), $note['ts']) ?></p>
</div>