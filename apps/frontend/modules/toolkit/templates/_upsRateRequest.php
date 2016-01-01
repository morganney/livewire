<?php echo "<?xml version='1.0'?>\n" ?>
<AccessRequest xml:lang="en-US">
 	<AccessLicenseNumber><?php echo $p['access_key'] ?></AccessLicenseNumber>
	<UserId><?php echo $p['user_id'] ?></UserId>
	<Password><?php echo $p['password'] ?></Password>
</AccessRequest>
<?php echo "<?xml version='1.0'?>\n" ?>
<RatingServiceSelectionRequest xml:lang="en-US">
  <Request>
    <TransactionReference>
      <CustomerContext>Rating and Service</CustomerContext>
      <XpciVersion>1.0</XpciVersion>
    </TransactionReference>
	<RequestAction>Rate</RequestAction>
	<RequestOption><?php echo $p['request_option'] ?></RequestOption>
  </Request>
  <CustomerClassification>
  	<Code>01</Code>
  </CustomerClassification>
  <PickupType>
    <Code>01</Code>
  </PickupType>
  <Shipment>
    <Shipper>
      <Address>
        <PostalCode><?php echo $p['shipper_zip'] ?></PostalCode>
        <CountryCode>US</CountryCode>
      </Address>
    </Shipper>
    <ShipTo>
      <Address>
        <PostalCode><?php echo $p['shipto_zip'] ?></PostalCode> 
        <CountryCode>US</CountryCode>
      </Address>
    </ShipTo>
    <?php if($p['request_option'] == 'Rate') : ?>
  	<Service>
    	<Code><?php echo $p['service_code'] ?></Code>
  	</Service>
  	<?php endif; ?>
  	<?php for($i = 0; $i < $p['pkg_qty']; $i++) : ?>
  	<Package>
      <PackagingType>
	      <Code>02</Code>
      </PackagingType>
      <Dimensions>
      	<UnitOfMeasure>
      		<Code>IN</Code>
      	</UnitOfMeasure>
      	<Length>12</Length>
      	<Width>12</Width>
      	<Height>3</Height>
      </Dimensions>
      <PackageWeight>
      	<UnitOfMeasurement>
      		<Code>LBS</Code>
      	</UnitOfMeasurement>
	      <Weight><?php echo $p['pkg_weight'] ?></Weight>
      </PackageWeight>  
   	</Package>
   	<?php endfor; ?>
  </Shipment>
</RatingServiceSelectionRequest>
