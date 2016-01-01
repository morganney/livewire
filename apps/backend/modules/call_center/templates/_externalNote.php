
<div class='external note'>
	<ul>
		<li><span>From:</span> <?php echo $note['sent_by_name'] ?></li>
		<li><span>To:</span> <?php echo $note['sent_to'] ?></li>
		<li><span>Subject:</span> <?php echo $note['subject'] ?></li>
		<li class='l'><span>Cc:</span> <?php echo $note['cc'] ?></li>
	</ul>
	<p><?php echo BE::formatNote($note['note']) ?></p>
	<p class='meta'><?php echo date(sfConfig::get('app_formats_ext_date'), $note['ts']) ?></p>
</div>
