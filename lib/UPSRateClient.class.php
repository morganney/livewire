<?php
	class UPSRateClient {
	
	  protected $_p; // array of parameters
	  protected $_request;
	  protected $_service_code_map;
	  protected $_rates;
	  protected $_error_msg;
	  protected $_markup;
	  
	  // Netsuite Default weight on items with no weight set on item record is 1LB
	  public function __construct($shipto_zip, $pkg_qty, $pkg_weight = 1, $params = array()) {
	  	sfProjectConfiguration::getActive()->loadHelpers('Partial');
			// load default parameters
			$this->_p = array(
			  'access_key' 		=> 'BC645952EAC4DB68',
			  'user_id'			=> 'morganney',
			  'password'		=> 'lw@235!',
			  'shipper_zip'		=> '94080',
			  'shipto_zip'	=> $shipto_zip,
			  'ups_account_no'	=> '05RR19',
				'pkg_qty'					=>	1,
				'pkg_weight'			=>	1,
			  'request_option'	=> 'Shop', // 'Shop' returns all available services for origin/destination addresses
			  'service_code'	=> '03' // Only used if request_option is changed to 'Rate'
			);
			
			// override defaults with user supplied values
			foreach($params as $key => $value) {
			  if(array_key_exists($key, $this->_p)) $this->_p[$key] = $value;
			}
			
			$this->_request = get_partial('toolkit/upsRateRequest', array('p' => $this->_p));
			// ups services that livewire offers customers
			$this->_service_code_map = array(
				'03'	=>	'Ground',
				'12'	=>	'3 Day Select',
				'02'	=>	'2nd Day Air',
				'13'	=>	'Next Day Air Saver',
				'14'	=>	'Next Dair Air Early A.M.'
			);
			$this->_markup = 1.2;
			$this->_rates = NULL;
			$this->_error_msg = NULL;
		}// end __construct()
	  
		public function queryUPS() {
			$this->parseUPSResponseForRates($this->requestUPSRate());
		}
		
		public function getRates() {
			return $this->_rates;
		}
		
		public function getRequest() {
			return $this->_request;
		}
		
		public function getError() {
			return $this->_error_msg;
		}
		
		public function hasError() {
			return !is_null($this->_error_msg);
		}
		
		private function parseUPSResponseForRates($response_xml) {
			$sxe = new SimpleXMLElement($response_xml);
			if(!$sxe || $sxe->Response->ResponseStatusDescription == 'Failure') {
				/*
				 * Should handle errors approriately.
				 * Log errors which can be accessed with libxml_get_errors() : foreach(libxml_get_errors() as $err)
				 * Return appropriate message back to calculator
				 * 
				 */
				$this->_error_msg = $sxe->Response->Error->ErrorDescription == 'No packages in shipment' ? 'Please enter a non-zero integer for QTY' : 'UPS does not provide service to the entered ZIP';
			} else {
				$this->_rates = array();
				foreach($sxe->RatedShipment as $shipment) {
					if(array_key_exists((string)$shipment->Service->Code, $this->_service_code_map)) {
						$shipping_charges = round($this->_markup * floatval((string)$shipment->TotalCharges->MonetaryValue), 2);
						$this->_rates[] = array((string)$shipment->Service->Code => $shipping_charges);
					}
				}
			}
		}
		
		private function requestUPSRate() {
			$curl_options = array(
				CURLOPT_URL							=>	'https://onlinetools.ups.com/ups.app/xml/Rate',
				CURLOPT_HTTP_VERSION		=>	CURL_HTTP_VERSION_1_1,
				CURLOPT_FOLLOWLOCATION	=> 	TRUE,
				CURLOPT_HEADER					=>	FALSE,
				CURLOPT_CONNECTTIMEOUT	=>	30,
				CURLOPT_TIMEOUT					=> 	60,
				CURLOPT_SSL_VERIFYHOST	=>	FALSE,
				CURLOPT_SSL_VERIFYPEER	=>	FALSE,
				CURLOPT_POST						=>	TRUE,
				CURLOPT_POSTFIELDS			=>	$this->_request,
				CURLOPT_RETURNTRANSFER	=>	TRUE
			);
			$ch = curl_init();
			curl_setopt_array($ch, $curl_options);
			$response_xml = curl_exec($ch);
			/* 
   		$err     = curl_errno($ch);
    	$errmsg  = curl_error($ch) ;
   	 	$header  = curl_getinfo($ch);
   	 	*/
    	curl_close($ch);
    	return $response_xml;
		}
		
  }// end UPSRateClilent
?>