<?php
 class CCSearchAgent extends DAO {
 	
 	protected $_query;
 	
 	public function __construct($query) {
 		parent::__construct();
 		$this->_query = $this->getEscapedSQLString(trim($query));
 	}
 	

 	
 	
 	public function normalizeQuery($remove_chars = array()) {
 		foreach($remove_chars as $chars) {
 			$this->_query = str_ireplace($chars, '', $this->_query);
 		}
 		// remove common chars in phone numbers and company names
 		$this->_query = preg_replace('/[[:space:])(,\.-]/', '', $this->_query);
 		// if it looks like a phone number, then only use the first 10 chars
 		if(is_numeric($this->_query)) $this->_query = substr($this->_query, 0, 10);
 	}
 	
 	public function searchCustomers($ajax = true) {
 		$limit = $ajax ? sfConfig::get('app_serps_ajax') : sfConfig::get('app_serps_default');
 		$this->query("
			SELECT be_customer.* FROM be_customer
			WHERE LOCATE('{$this->_query}', LOWER(REPLACE(company,' ',''))) != 0
			OR LOCATE('{$this->_query}', LOWER(REPLACE(phone,'-',''))) != 0
			OR LOCATE('{$this->_query}', LOWER(REPLACE(alt_phone,'-',''))) != 0
			OR LOCATE('{$this->_query}', LOWER(REPLACE(CONCAT(first_name,last_name),' ',''))) != 0
			ORDER BY company, first_name, phone ASC
			LIMIT $limit
 		");
 		if($this->queryOK()) {
 			$customers = array();
 			while($row = $this->next()) {
 				$city = ucwords($row['city']);
 				$geo = "$city, {$row['region']} {$row['country']}";
 				$route = "@customer?id={$row['customer_id']}";
 				$customers[] = array(
 					'company'	=>	$row['company'],
 					'contact'	=>	ucwords("{$row['first_name']} {$row['last_name']}"),
 					'geo'			=>	$geo,
 					'phone'		=>	$row['phone'],
 					'email'		=>	$row['email'],
 					'id'			=>	$row['customer_id'],
 					'route'		=>	$route
 				);
 			}
 			return $customers;
 		} else return NULL;
 	}
 	
 	public function searchTickets($ticket_cat_id = 1, $ajax = true) {
 		$limit = $ajax ? sfConfig::get('app_serps_ajax') : sfConfig::get('app_serps_default');
 		$int_val = intval($this->_query);
 		$this->query("
			SELECT be_ticket.*, be_customer.*,be_ticket_category.* FROM be_ticket
			INNER JOIN be_customer USING(customer_id) INNER JOIN be_ticket_category USING (ticket_cat_id)
			WHERE ticket_cat_id = $ticket_cat_id 
			AND
			(
				LOCATE('$int_val', ticket_id) != 0
				OR LOCATE('{$this->_query}', openned_by) != 0
				OR LOCATE('{$this->_query}', LOWER(REPLACE(company,' ',''))) != 0
				OR LOCATE('{$this->_query}', LOWER(REPLACE(phone,'-',''))) != 0
				OR LOCATE('{$this->_query}', LOWER(REPLACE(alt_phone,'-',''))) != 0
				OR LOCATE('{$this->_query}', LOWER(REPLACE(CONCAT(first_name,last_name),' ',''))) != 0
			)
			ORDER BY ticket_id DESC, company, first_name, phone 
			LIMIT $limit
 		");
 		if($this->queryOK()) {
 			$tickets = array();
 			while($row = $this->next()) {
 				$city = ucwords($row['city']);
 				$geo = "$city, {$row['region']} {$row['country']}";
 				$cat = strtolower($row['category']);
 				$route = "@{$cat}?ticket_id={$row['ticket_id']}";
 				$tickets[] = array(
 					'id'					=>	$row['ticket_id'],
 					'company'			=>	$row['company'],
 					'contact'			=>	ucwords("{$row['first_name']} {$row['last_name']}"),
 					'geo'					=>	$geo,
 					'phone'				=>	$row['phone'],
 					'email'				=>	$row['email'],
 					'customer_id'	=>	$row['customer_id'],
 					'category'		=>	$row['category'],
 					'openned'			=>	date(sfConfig::get('app_formats_date'), $row['openned_ts']),
 					'status'			=>	ucwords($row['status']),
 					'route'				=>	$route
 				);
 			}
 			return $tickets;
 		} else return NULL;
 	}
 	
 	public function fetchStorePricing() {
 		$this->query("
			SELECT part.part_no,category,manuf,display,ns_new_id,ns_green_id
			FROM part INNER JOIN category USING (cat_id) INNER JOIN manufacturer USING (manuf_id) LEFT JOIN store USING (part_no)
			WHERE part_no = '{$this->_query}' LIMIT 1
 		");
 		if($this->queryOK()) {
 			$data = $this->next();
 			if($data['display'] == '3') {
 				$new = file_get_contents("http://shopping.netsuite.com/app/site/query/getitemprice.nl?c=502106&id={$data['ns_new_id']}");
 				$grn = file_get_contents("http://shopping.netsuite.com/app/site/query/getitemprice.nl?c=502106&id={$data['ns_green_id']}");
 			} else if($data['display'] == '2') {
 				$new = '';
 				$grn = file_get_contents("http://shopping.netsuite.com/app/site/query/getitemprice.nl?c=502106&id={$data['ns_green_id']}");
 			} else if($data['display'] == '1') {
 				$new = file_get_contents("http://shopping.netsuite.com/app/site/query/getitemprice.nl?c=502106&id={$data['ns_new_id']}");
 				$grn = '';
 			} else $new = $grn = ''; 
 			
 			/*
 			 * This is not a robust solution, just a proof of concept!! Better to use NetSuite Suite Talk Web Services!
 			 * Just alert() the raw $new or $grn varible with JS to see why the regular expressions
 			 * are used.  NetSuite, returns lots of other text that is meant to be HTML comments.
 			 */
 			$patterns = array('/<!--.*?-->/','/document.write/','/[^[:digit:],$,\.]/');
 			$data['new_price'] = preg_replace($patterns,'',$new);
 			$data['grn_price'] = preg_replace($patterns,'',$grn);
 			return $data;
 		} else return NULL;
 	}

 	 	public function fetchPurchaseHistory() { 
 	 			$this->query("
					(SELECT `name`, `ts`, `purchase_price`, `cond`
					FROM be_vendor_matrix
					INNER JOIN be_vendor
					USING ( vendor_id )
					WHERE `part_no` = '{$this->_query}' and `cond` = 'new'
					order by `ts` DESC
					LIMIT 0 , 3)
						UNION
					(SELECT `name`, `ts`, `purchase_price`, `cond`
					FROM be_vendor_matrix
					INNER JOIN be_vendor
					USING ( vendor_id )
					WHERE `part_no` = '{$this->_query}' and `cond` = 'Green'
					order by `ts` DESC
					LIMIT 0 , 3)
 	 			");
 	 			
 	 			if( !$this->queryOK() ) return NULL;
 	 			
 	 			 $purchases = array();
		     while( $row = $this->next() ) { 
				    $purchases[$row['cond']][] = array(
				 			'name'			 		 => $row['name'] ,
				 			'ts' 						 => date("m/y", $row['ts']),
							'purchase_price' => '$'.$row['purchase_price'],

				    );
		     }
 	 			
 	 			
 	 	 	 	return $purchases;	 			

 	 	}
 	
 }