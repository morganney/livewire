<?php use_stylesheet('customers') ?>
<?php include_partial('global/h1', array('txt' => 'Our Customers')) ?>
	<div class='box main'>
		<h2>WHO BUYS FROM LIVEWIRE SUPPLY?</h2>
		<p>Every day thousands of wholesale suppliers, contractors, industrial end-users and homeowners rely on LiveWire Supply to deliver the electrical parts they need at rock-bottom prices.</p>
	</div>
	<p id='wholesale-suppliers'><strong>Wholesale Suppliers:</strong> We sell to practically all of the Nation's electrical wholesalers. To meet their needs, we carry equipment that is brand new and in factory packaging. These customers care about our multi-million dollar insurance policy and benefit from our ultra-fast lead times.</p>
	<div class='box wholesale'>
		<dl>
			<dt>LiveWire Wholesale Suppliers</dt>
			<dd>Fastenal</dd>
			<dd>Grainger</dd>
			<dd>Graybar</dd>
			<dd>Cesco</dd>
			<dd>Blazer</dd>
			<dd>Crescent Electric Supply Company</dd>
		</dl>
	</div>
	<p id='contractors'><strong>Contractors:</strong> From family-run-shops to big-name contractors, LiveWire Supply meets the supply needs of electrical contractors that keep America powered. Contractors work with LiveWire because of our extensive product knowledge, stock of obsolete equipment and our ultra-fast lead times.</p>
	<div class='box contractors'>
		<dl>
			<dt>LiveWire Contractors</dt>
			<dd>Solar Monkey</dd>
			<dd>Advent Electric</dd>
			<dd>Pettus Services</dd>
			<dd>Kirkwood Electric</dd>
			<dd>SunEdison</dd>
		</dl>
	</div>
	<p id='industrial-end-users'><strong>Industrial End-Users:</strong> We work with facility managers, purchasing agents and in-house electricians at some of the country's largest corporations. In a world where business is run via telephone and e-mail, these customers appreciate that LiveWire is big enough to deliver and small enough to care.</p>
	<div class='box industrial'>
		<dl>
			<dt>LiveWire Industrial End-Users</dt>
			<dd>Disney</dd>
			<dd>Lockheed Martin</dd>
			<dd>Juniper Networks</dd>
			<dd>Boeing</dd>
			<dd>Cox</dd>
			<dd>General Electric (GE)</dd>
		</dl>
	</div>
	<p id='homeowners'><strong>Home Owners:</strong> A lot of our customers only call once to fix the breaker in their home or replace a small fuse for their TV for example. One-time buyers appreciate that we don't have handling fees or minimums on stock items.</p>
	<div class='box home'>
	</div>
<?php slot('sidebar') ?>
	<ul id='customer_nav'>
		<li class='first'><strong>CUSTOMERS</strong></li>
		<li><a href='#wholesale-suppliers'>Wholesale Suppliers</a></li>
		<li><a href='#contractors'>Contractors</a></li>
		<li><a href='#industrial-end-users'>Industrial End-Users</a></li>
		<li class='xtra_bottom'><a href='#homeowners'>Homeowners</a></li>
		<li class='xtra_top'><?php echo link_to('Case Studies', '@customer_profiles?name_slug=bill-minich')?></li>
	</ul>
<?php end_slot() ?>