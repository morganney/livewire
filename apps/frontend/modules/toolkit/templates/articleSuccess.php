<?php use_stylesheet('article') ?>
<?php include_partial('global/h1', array('txt' => 'LiveWire in the Press')) ?>
<h2 id='news_awards'>News and Awards</h2>
<div class='article'>
	<p id='pub_date'><?php echo $article['pub_date'] ?></p>
	<h3><?php echo $article['title'] ?></h3>
	<?php if(!empty($article['affiliate_img'])) : ?>
	<img src='/images/affiliates/<?php echo $article['affiliate_img'] ?>' alt='LiveWire Supply affiliate' class='affiliate' />
	<?php endif; ?>
	<?php echo $article['content'] ?>
</div>
<?php slot('sidebar') ?>
	<ul class='articles_nav'>
		<li id='lowes'><?php echo link_to('Advice to contractors in a down economy', '@news_awards?title_slug=livewire-ceo-offers-advice-to-lowes-customers') ?></li>
		<li id='ted'><?php echo link_to('tED Magazine Best of the Best', '@news_awards?title_slug=livewire-awarded-ted-magazine-best-of-the-best-2009')?></li>
		<li id='vail'><?php echo link_to('LiveWire saves Vail', '@news_awards?title_slug=livewire-supply-saves-vail-resort-vacation-restores-power-to-main-chair-lift') ?></li>
		<li id='best'><?php echo link_to('LiveWire awarded Best Electrical Supply Company', '@news_awards?title_slug=livewire-supply-awarded-best-electrical-supply-company-san-francisco') ?></li>
		<li><?php echo link_to('CEO Adam Messner featured', '@news_pdf?title_slug=livewire-supply-makes-vision-of-a-wired-distribution-industry-a-reality') ?></li>
	</ul>
	<!-- 
	<ul class='articles_nav low'>
		<li class='lws'><?php echo link_to('LiveWire steps up during blackout', '@news_awards?title_slug=livewire-supply-steps-up-serves-northern-californians-affected-by-blackout') ?></li>
		<li id='waste'><?php echo link_to('LiveWire recognized by WRAP', '@news_awards?title_slug=livewire-recognized-by-state-for-outstanding-commitment-to-waste-reduction') ?></li>
		<li class='lws'><?php echo link_to('LiveWire serving all 50 states', '@news_awards?title_slug=livewire-supply-announces-customers-in-all-50-states')?></li>
		<li class='lws'><?php echo link_to('Our new online link tools', '@news_awards?title_slug=livewire-supply-announces-new-online-circuit-breaker-transformer-busway-tools') ?></li>
	</ul>
	-->
<?php end_slot() ?>
