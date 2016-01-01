
<?php use_stylesheet('select') ?>
<?php use_javascript('tr-select') ?>
<?php include_partial('global/h1', array('txt' => 'Electrical Transformers Selection Process')) ?>
<div id='step_box'>
	<div class='step one'><img id='indy_1st' src='/images/industry-first-trans.png' alt="Industry's first transformer selection tool" /></div>
	<div id='step'>
		<h2 class='one'>Select Your KVA Rating <img id='tooltip' src='/images/help.png' alt='kVA Help' /></h2>
		

		
		<div id='tip' class='invisible'>
			<p class='_1st q'><span>Q)</span> What's the difference between KVA and VA rating?</p>
			<p><span>A)</span> 1 KVA = 1000 Volt Amps.  Therefore a 2500 VA transformer would be listed as 2.5 KVA.</p>
			<p class='q'><span>Q)</span> I don't see my specific KVA listed?</p>
			<p><span>A)</span> We have listed the most common KVA requirements.  It is commonly acceptable to oversize your transformer to the next largest size listed.  For example, if you require a 2.5 KVA transformer you should select a 3 KVA transformer, or if you require a 40 KVA transformer you should select 45 KVA. Make sure to size the associated circuit breaker appropriately.</p>
		</div>
		<div id='kva'>
			<div class='mod sm'>
				<p>0.25 &ndash; 1 KVA</p>
				<ul>
					<li class='m'><?php echo link_to('0.05', '@tr_select', array('query_string' => 'kva=0.05&step=kva', 'class' => 'ajax')) ?></li>
					<li><?php echo link_to('0.08', '@tr_select', array('query_string' => 'kva=0.08&step=kva', 'class' => 'ajax')) ?></li>
					<li class='m'><?php echo link_to('0.1', '@tr_select', array('query_string' => 'kva=0.1&step=kva', 'class' => 'ajax')) ?></li>
					<li><?php echo link_to('0.15', '@tr_select', array('query_string' => 'kva=0.15&step=kva', 'class' => 'ajax')) ?></li>
					<li class='m'><?php echo link_to('0.2', '@tr_select', array('query_string' => 'kva=0.2&step=kva', 'class' => 'ajax')) ?></li>
					<li><?php echo link_to('0.25', '@tr_select', array('query_string' => 'kva=0.25&step=kva', 'class' => 'ajax')) ?></li>
					<li class='m'><?php echo link_to('0.35', '@tr_select', array('query_string' => 'kva=0.35&step=kva', 'class' => 'ajax')) ?></li>
					<li><?php echo link_to('0.5', '@tr_select', array('query_string' => 'kva=0.5&step=kva', 'class' => 'ajax')) ?></li>
					<li class='m'><?php echo link_to('0.75', '@tr_select', array('query_string' => 'kva=0.75&step=kva', 'class' => 'ajax')) ?></li>
					<li><?php echo link_to('1', '@tr_select', array('query_string' => 'kva=1&step=kva', 'class' => 'ajax')) ?></li>
				</ul>
			</div>
			<div class='mod md'>
				<p>1.5 &ndash; 10 KVA</p>
				<ul>
					<li class='m'><?php echo link_to('1.5', '@tr_select', array('query_string' => 'kva=1.5&step=kva', 'class' => 'ajax')) ?></li>
					<li><?php echo link_to('2', '@tr_select', array('query_string' => 'kva=2&step=kva', 'class' => 'ajax')) ?></li>
					<li class='m'><?php echo link_to('3', '@tr_select', array('query_string' => 'kva=3&step=kva', 'class' => 'ajax')) ?></li>
					<li><?php echo link_to('5', '@tr_select', array('query_string' => 'kva=5&step=kva', 'class' => 'ajax')) ?></li>
					<li class='m'><?php echo link_to('6', '@tr_select', array('query_string' => 'kva=6&step=kva', 'class' => 'ajax')) ?></li>
					<li><?php echo link_to('7.5', '@tr_select', array('query_string' => 'kva=7.5&step=kva', 'class' => 'ajax')) ?></li>
					<li class='m'><?php echo link_to('9', '@tr_select', array('query_string' => 'kva=9&step=kva', 'class' => 'ajax')) ?></li>
					<li><?php echo link_to('10', '@tr_select', array('query_string' => 'kva=10&step=kva', 'class' => 'ajax')) ?></li>
				</ul>
			</div>
			<div class='mod lg'>
				<p>15 &ndash; 440 KVA</p>
				<ul>
					<li class='m'><?php echo link_to('15', '@tr_select', array('query_string' => 'kva=15&step=kva', 'class' => 'ajax')) ?></li>
					<li><?php echo link_to('25', '@tr_select', array('query_string' => 'kva=25&step=kva', 'class' => 'ajax')) ?></li>
					<li class='m'><?php echo link_to('30', '@tr_select', array('query_string' => 'kva=30&step=kva', 'class' => 'ajax')) ?></li>
					<li><?php echo link_to('37.5', '@tr_select', array('query_string' => 'kva=37.5&step=kva', 'class' => 'ajax')) ?></li>
					<li class='m'><?php echo link_to('45', '@tr_select', array('query_string' => 'kva=45&step=kva', 'class' => 'ajax')) ?></li>
					<li><?php echo link_to('50', '@tr_select', array('query_string' => 'kva=50&step=kva', 'class' => 'ajax')) ?></li>
					<li class='m'><?php echo link_to('75', '@tr_select', array('query_string' => 'kva=75&step=kva', 'class' => 'ajax')) ?></li>
					<li><?php echo link_to('100', '@tr_select', array('query_string' => 'kva=100&step=kva', 'class' => 'ajax')) ?></li>
					<li class='m'><?php echo link_to('112.5', '@tr_select', array('query_string' => 'kva=112.5&step=kva', 'class' => 'ajax')) ?></li>
					<li><?php echo link_to('150', '@tr_select', array('query_string' => 'kva=150&step=kva', 'class' => 'ajax')) ?></li>
					<li class='m'><?php echo link_to('167', '@tr_select', array('query_string' => 'kva=167&step=kva', 'class' => 'ajax')) ?></li>
					<li><?php echo link_to('225', '@tr_select', array('query_string' => 'kva=225&step=kva', 'class' => 'ajax')) ?></li>
					<li class='m'><?php echo link_to('300', '@tr_select', array('query_string' => 'kva=300&step=kva', 'class' => 'ajax')) ?></li>
					<li><?php echo link_to('500', '@tr_select', array('query_string' => 'kva=500&step=kva', 'class' => 'ajax')) ?></li>
				</ul>
			</div>
			<div class='mod xl'>
				<p>500+ KVA</p>
				<ul>
					<li class='m'><?php echo link_to('750', '@tr_select', array('query_string' => 'kva=750&step=kva', 'class' => 'ajax')) ?></li>
					<li><?php echo link_to('1000', '@tr_select', array('query_string' => 'kva=1000&step=kva', 'class' => 'ajax')) ?></li>
				</ul>
			</div>
		</div>
		<p>Different KVA rating? Call <strong style='color: #30A2C7;'>800-390-3299</strong> for more options.</p>
		<p id='csr' class='kva'>I don't see my KVA rating?</p>
		
		<a id='kva_calc_btn' href=''>KVA Calculator</a>
		<form id='kva_calc' method='get' action='' class='invisible'>
			<p id='kva_close'><a href=''>x</a></p>
			<table cellspacing='0' cellpadding='0'>
				<tbody>
					<tr>
						<td class='rb'>Choose your phase:</td>
						<td colspan='2'><input type='radio' name='phase' value='1' checked='checked' /> Single Phase <br /> <input type='radio' name='phase' value='3' /> Three Phase</td>
					</tr>
					<tr>
						<td rowspan='3' class='rb'>Enter <strong>TWO</strong> known values:</td>
						<td class='v rb'><strong>Volts</strong></td>
						<td><input type='text' class='txt' id='v' value='0' /></td>
					</tr>
					<tr>
						<td class='v rb'><strong>Amps</strong></td>
						<td><input type='text' class='txt' id='a' value='0' /></td>
					</tr>
					<tr>
						<td class='v rb'><strong>KVA</strong></td>
						<td><input type='text' class='txt' id='k' value='0' /></td>
					</tr>
					<tr>
						<td class='rb'>&nbsp;</td>
						<td colspan='2'><input type='reset' value='Reset' /> <input type='button' name='compute' id='compute' value='Calculate' /></td>
					</tr>
				</tbody>
			</table>
		</form>
		
	</div>
</div>
<?php slot('sidebar') ?>
	<?php include_partial('global/selectToolSidebar', array('category' => 'Electrical Transformers')) ?>
<?php end_slot() ?>
