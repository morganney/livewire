<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html style='background-color: #F3F3F3 !important;'>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<title></title>
</head>
<body style='font-family: Verdana,Arial,Helvetica,sans-serif;'>
	<div id='shell' style='width: 600px;margin:0 auto;background-color:#fff;'><div id='skin' style='padding: 10px;'>
		<table cellpadding='0' cellspacing='0' id='header' style='width: 100%;'>
			<tbody>
				<tr><td><a style='font-size: 12px;color: #30A2C7;' href='http://livewiresupply.com/'>LiveWire Electrical Supply</a></td><td style='text-align:right;font-size: 20px;color: #082732;font-weight: bold;font-family: Arial,sans-serif;'>800.390.3299</td></tr>
			</tbody>
		</table>
		<table cellpadding='0' cellspacing='0' style='width: 100%'>
			<tbody>
			<tr><td><h1 style='color:#464646; font-size:18px;margin: 30px 0 0 0;font-weight:normal;'>Here's the quote you requested.</h1></td><td rowspan='3' style='vertical-align: bottom; '><img src='http://livewiresupply.com/images/be/adam.jpg' alt='' /></td></tr>
			<tr><td><p style='line-height: 20px; font-size: 11px; margin: 20px 0 30px 0;'><?php echo $email['openning'] ?></p></td></tr>
			<tr><td style='font-size: 12px;padding: 0 0 2px 0;'><span style='padding: 0 195px 0 10px'>You Requested</span> Price</td></tr>
			<tr>
				<td id='left_col' style='width: 379px; border-right: 1px solid #00bff3; vertical-align: top;'>
					<div id='quotes' style='padding: 0 5px;border-top: 1px solid black;'>
					<?php foreach($email['parts'] as $r) : ?>
						<?php if($r['display'] == 'both') : ?>
						<div class='quote' style='padding: 50px 0;border-bottom: 2px dashed #8b8c90;font-size: 11px; font-weight: bold;vertical-align: top;'>
						<table cellpadding='0' cellspacing='0' style='width: 100%;'>
							<tbody>
								<tr>
									<td rowspan='3' style='width: 105px; text-align: center;vertical-align:top;'><img src='<?php echo $r['img'] ?>' alt='<?php echo $r['part_no'] ?>' /></td>
									<td style='color: #92278f; font-weight: bold; vertical-align:top;'><?php echo $r['part_desc'] ?></td>
									<td style='width:80px;'><?php echo $r['new'] ?><br /><span style='color: #00aeef; font-size: 8px;vertical-align:top;'>Guaranteed New</span></td>
								</tr>
								<tr>
									<td style='padding: 5px 0;'><p style='margin:0;padding:0;vertical-align:top;'>Requested: <span style='font-weight: normal;'><?php echo $r['qty'] ?></span></p><p style='margin:0;padding:0;'>Inventory: <span style='font-weight: normal; color: #39b54a;'><?php echo $r['inventory'] ?></span></p><p style='font-weight: normal; margin:0;padding:0;'>1 Year Warranty</p></td>
									<td style='padding: 5px 0; vertical-align: middle;width:80px;'><?php echo $r['grn'] ?><br /><span style='color:#8dc63f; font-size: 8px;'>Certified Green</span></td>
								</tr>
								<tr>
									<td style='vertical-align: middle;'><img src='http://livewiresupply.com/images/be/payment.jpg' alt='' /></td>
									<td><a href='<?php echo $r['url'] ?>'><img src='http://livewiresupply.com/images/be/<?php echo $r['btn'] ?>' alt='' style='border:none;' /></a><?php echo $r['btn_txt'] ?></td>
								</tr>
							</tbody>
						</table>
						</div>
						<?php elseif($r['display'] == 'new') : ?>
						<div class='quote' style='padding: 50px 0;border-bottom: 2px dashed #8b8c90;font-size: 11px; font-weight: bold;'>
						<table cellpadding='0' cellspacing='0' style='width: 100%;'>
							<tbody>
								<tr>
									<td rowspan='3' style='width: 105px; text-align: center;vertical-align:top;'><img src='<?php echo $r['img'] ?>' alt='<?php echo $r['part_no'] ?>' /></td>
									<td style='color: #92278f; font-weight: bold;vertical-align:top;'><?php echo $r['part_desc'] ?></td>
									<td style='width:80px;'><?php echo $r['new'] ?><span style='display:block;color:#00aeef; font-size: 8px;'>Guaranteed New</span><a href='<?php echo $r['url'] ?>'><img src='http://livewiresupply.com/images/be/<?php echo $r['btn'] ?>' alt='' style='padding-top: 10px; border:none;' /></a><?php echo $r['btn_txt'] ?></td>
								</tr>
								<tr>
									<td colspan='2' style='padding: 5px 0;vertical-align:top;'><p style='margin:0;padding:0;'>Requested: <span style='font-weight: normal;'><?php echo $r['qty'] ?></span></p><p style='margin:0;padding:0;'>Inventory: <span style='font-weight: normal; color: #39b54a;'><?php echo $r['inventory'] ?></span></p><p style='font-weight: normal;margin:0;padding:0;'>1 Year Warranty</p></td>
								</tr>
								<tr>
									<td colspan='2' style='vertical-align: middle;'><img src='http://livewiresupply.com/images/be/payment.jpg' alt='' /></td>
								</tr>
							</tbody>
						</table>
						</div>
						<?php else : ?>
						<div class='quote' style='padding: 50px 0;border-bottom: 2px dashed #8b8c90;font-size: 11px; font-weight: bold;'>
						<table cellpadding='0' cellspacing='0' style='width: 100%;'>
							<tbody>
								<tr>
									<td rowspan='3' style='width: 105px; text-align: center;vertical-align:top;'><img src='<?php echo $r['img'] ?>' alt='<?php echo $r['part_no'] ?>' /></td>
									<td style='color: #92278f; font-weight: bold;vertical-align:top;'><?php echo $r['part_desc'] ?></td>
									<td style='width:80px;'><?php echo $r['grn'] ?><span style='display:block;color:#8dc63f; font-size: 8px;'>Certified Green</span><a href='<?php echo $r['url'] ?>'><img src='http://livewiresupply.com/images/be/<?php echo $r['btn'] ?>' alt='' style='padding-top: 10px; border:none;' /></a><?php echo $r['btn_txt'] ?></td>
								</tr>
								<tr>
									<td colspan='2' style='padding: 5px 0;vertical-align:top;'><p style='margin:0;padding:0;'>Requested: <span style='font-weight: normal;'><?php echo $r['qty'] ?></span></p><p style='margin:0;padding:0;'>Inventory: <span style='font-weight: normal; color: #39b54a;'><?php echo $r['inventory'] ?></span></p><p style='font-weight: normal;margin:0;padding:0;'>1 Year Warranty</p></td>
								</tr>
								<tr>
									<td colspan='2' style='vertical-align: middle;'><img src='http://livewiresupply.com/images/be/payment.jpg' alt='' /></td>
								</tr>
							</tbody>
						</table>
						</div>
						<?php endif; ?>
					<?php endforeach; ?>
					</div><!-- end quotes -->
					<div id='note' style='margin: 30px 0 0 0;padding: 5px;'>
						<p style='font-size: 12px; margin: 0 0 10px 0;padding:0 0 1px 0;'><img style='vertical-align: middle;' src='http://livewiresupply.com/images/be/notepad.gif' alt='' /> &nbsp; <?php echo $email['customer'] ?>,</p>
						<p style='margin:0;font-size:10px;padding:0 0 1px 40px;'>Thanks for calling in.  If you need me to modify this<br /> quote or quote anything else, please call or e-mail<br /> me back and I will get right on it. It was a pleasure speaking with you.</p>
						<p style='margin:10px 0 15px 0;font-size:10px;padding:0 0 1px 40px;'>I hope you decide to place this order with LiveWire.</p>
						<p style='margin:0;font-size:12px;padding-left:40px;'>~ <?php echo $email['emp_name'] ?> <?php echo $email['emp_phone'] ?> x <?php echo $email['emp_ext'] ?></p>
					</div>
				</td>
				<td id='right_col' style='vertical-align: top;'>
					<img src='http://livewiresupply.com/images/be/email-rec.jpg' alt='' />
					<div class='item' style='text-align: center; font-size: 11px; color: black; padding: 30px 10px 10px 10px;'>
						<img src='http://livewiresupply.com/images/be/email-tr.jpg' alt='' />
						<p><a style='color: black;' href='http://livewiresupply.com/electrical-transformers/'>LiveWire is a supplier of Acme and Hammond Transformers</a></p>
					</div>
					<div class='item' style='text-align: center; font-size: 11px; color: black; padding: 30px 10px 10px 10px;'>
						<img src='http://livewiresupply.com/images/be/email-fu.jpg' alt='' />
						<p><a style='color: black;' href='http://livewiresupply.com/fuses/'>LiveWire is a supplier of Bussman and Ferraz Shawmut Fuses</a></p>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan='2' id='bottom' style='padding: 30px 0 0 0; font-size:12px;'>
					<img style='display: block;' src='http://livewiresupply.com/images/be/how-to-order.jpg' alt='' />
					<ol style='padding-top: 10px;padding-bottom:30px;border-bottom:1px solid black;'>
						<li>Call 800.390.3299 and ask for me, <?php echo $email['emp_name'] ?>. If I'm not here when you call, you can speak with anyone in sales. They will be able to pull up this estimate.</li>
						<li>Provide your estimate number. Your estimate number is <strong>#<?php echo $email['ticket_id'] ?></strong>.</li>
						<li>You can also reach me by email: <?php echo $email['emp_email'] ?></li>
					</ol>
					<div class='meta' style='margin: 40px 0 0 0;'>
						<p style='margin:0;'><img src='http://livewiresupply.com/images/be/keep-in-mind.jpg' alt='' /> </p>
						<p style='padding: 0 0 0 35px; margin:0;font-size:10px'>This estimate is valid for 7 days from today, <?php echo $email['date'] ?> unless otherwise stated. If we are out of stock when you call to place your order, I will do my best to meet your needs as quickly as possible at the best price possible.</p>
					</div>
					<div class='meta' style='margin: 20px 0;'>
						<p style='margin:0;'><img src='http://livewiresupply.com/images/be/price-matching.jpg' alt='' /> </p>
						<p style='padding: 0 0 0 35px; margin:0;font-size:10px'>Just like everyone else out there, we want your business. We price match whenever possible.</p>
					</div>
					<div class='meta' style='margin: 0 0 40px 0;'>
						<p style='margin:0;'><a href='http://www.facebook.com/LiveWireSupply'><img style='border:none;' src='http://livewiresupply.com/images/be/on-facebook.jpg' alt='' /></a></p>
					</div>
					<p style='margin:0 0 10px 0;padding:20px 0;text-align:center; border-top: 1px solid #898989;border-bottom:1px solid #898989;'><img src='http://livewiresupply.com/images/be/partners.jpg' alt='' /></p>
					<p style='margin:0;text-align:center;font-size:8px;color:#898989;'>
						Call toll free at 1-800-390-3299 
						<a style='color:#898989;' href='http://livewiresupply.com/circuit-breakers/'>Circuit Breakers</a> 
						<a style='color:#898989;' href='http://livewiresupply.com/electcrical-transformers/'>Transformers</a> 
						<a style='color:#898989;' href='http://livewiresupply.com/motor-control/'>Motor Control</a> 
						<a style='color:#898989;' href='http://livewiresupply.com/busway/'>Busway</a> 
						<a style='color:#898989;' href='http://livewiresupply.com/fuses/'>Fuses</a> 
						<a style='color:#898989;' href='http://livewiresupply.com/medium-voltage/'>Medium Voltage Equipment</a>
					</p>
					<p style='margin:0;padding:0 0 20px 0;text-align:center;font-size:8px;color:#898989;'>Copyright &copy; 2011 LiveWire Supply, Inc. All rights reserved. <a style='color:#898989;' href='http://privacy-policy.truste.com/verified-policy/livewiresupply.com'>Privacy Policy</a> <a style='color:#898989;' href='http://livewiresupply.com/pdf/credit-application.pdf'>Credit Application</a> <a style='color:#898989;' href='http://livewiresupply.com/returns-and-warranty.html'>Warranty</a> <a style='color:#898989;' href='http://livewiresupply.com/pdf/line-card.pdf'>Line Card</a></p>
				</td>
			</tr>
			</tbody>
		</table>
	</div></div>
</body>
</html>
