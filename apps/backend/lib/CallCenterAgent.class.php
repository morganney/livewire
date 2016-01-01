<?php
	class CallCenterAgent extends DAO {
		
	 	protected $_phone_labels;
 		protected $_lowercase_cust_fields;
 		
 		
		public function __construct() {
 			parent::__construct(); // Call DAO constructor
 			$this->_phone_labels = array(
 				'p1', 'p2', 'p3',
 				'a1',	'a2',	'a3',
 				'f1',	'f2',	'f3'
 			);
 			$this->_lowercase_cust_fields = array(
 				'first_name', 'last_name', 'email',
 				'address_1', 'address_2', 'city'
 			);
 		}
 		
	 	/**
 		 * Preconditions:
 		 * 	all values in $rfq have been escaped for DB insertion
 		 * 	$rfq['email_note'] exists as un unescaped version of the note
 		 * 
 		 * Postcondition:
 		 *   the note has been saved to the DB (if not DB error occured)
 		 *   the note has been emailed to recipients if external or notify is set
 		 *  
 		 * @param Mixed Array $rfq
 		 */
 		protected function saveTicketNote($rfq) {
 			if($rfq['type'] == 'external') {
 				try {
 					$note = "'" . $this->sendEmail($rfq) . "'";
 				} catch (Exception $e) {
 					// retrieve the note passed as the error message to store in DB
 					$note = "'" . $e->getMessage() . "'";
 					// @todo save a message in appropriate session varible to inform user of failure
 					
 				}
 				$subject = "'{$rfq['subject']}'";
 				$this->query("
 					INSERT INTO be_ticket_note (ticket_id,type,template,sent_by,sent_to,cc,subject,note,ts)
 					VALUES ({$rfq['ticket_id']}, 'external','{$rfq['template']}','{$rfq['sent_by']}','{$rfq['sent_to']}','{$rfq['cc']}',$subject,$note,UNIX_TIMESTAMP())
 				");
 				if(!$this->insertOK()) return false;
 			} else {
 				$note = "'{$rfq['note']}'";
 				$subject = "'Internal Note'";
 				if(isset($rfq['notify'])) {
 					$notify = '';
 					foreach($rfq['notify'] as $email) $notify .= "{$email},";
 					$notify = "'" . substr($notify, 0, -1) . "'";
 					try {
 						$this->sendNotification($rfq);
 					} catch (Exception $e) { /* @todo save failure message in appropriate session variable */}
 				} else $notify = 'NULL';
 				$this->query("
 					INSERT INTO be_ticket_note (ticket_id,type,template,sent_by,sent_to,notify,subject,note,ts)
 					VALUES ({$rfq['ticket_id']}, 'internal','{$rfq['template']}','{$rfq['sent_by']}','SYSTEM',$notify,$subject,$note,UNIX_TIMESTAMP())
 				");
 				if(!$this->insertOK()) return false;
 			}
 			return true;
 		}
 		
 		protected function sendNotification($rfq) {
 			$notify = '';
 			foreach($rfq['notify'] as $who) {
 				$p = explode(':', $who);
 				$notify .= "{$p[0]},";
 			}
 			$notify = substr($notify, 0, -1);
 			$subject = "Call Center Notification - RFQ #{$rfq['ticket_id']}";
 			$open = "--------------- CALL CENTER ~ NOTIFICATION ---------------<br /><br />";
 			$close = "<br /><br />---------------------- END OF NOTIFICATION ---------------------<br />";
 			$message  = wordwrap($open . $rfq['email_note'] . $close, 70);
  		//qmail replaces LF(\n) with CRLF(\r\n), so only use LF in headers
  		$headers = "Content-type: text/html; charset=iso-8859-1\nFrom: LWS Call Center <{$rfq['sent_by']}>\n";
  		if(sfConfig::get('sf_environment') == 'prod') if(!@mail($notify,$subject,$message,$headers)) throw new Exception('Failed to deliver internal notification.');
 			$action_id = BE::INTERNAL_NOTE_ACTION;
 			$this->query("UPDATE be_ticket SET action_id={$action_id} WHERE ticket_id={$rfq['ticket_id']}");
 		}
 		
 		/**
 		 * I don't like this method.  Feels like a better design strategy is in order,
 		 * but it will have to do for now as time is just not available.
 		 * @param $rfq
 		 */
 		protected function sendEmail($rfq) {
 			if($rfq['template'] != 'None') {
 				$t = "{$rfq['template']}Template";
 				$template = new $t();
 				$template->build($rfq);
 				$db_note = $template->getDbNote();
 				$message = $template->getTemplate();
 				$headers = $template->getEmailHeaders($rfq);
	 			$to = $rfq['to'];
	 			$subject = $rfq['email_subject'];
	  		if(!empty($rfq['cc'])) $headers .= "Cc: {$rfq['cc']}\n";
	  		if(sfConfig::get('sf_environment') == 'prod') if(!@mail($to,$subject,$message,$headers)) throw new Exception($db_note);
 				$template->updateTicketLastAction($this, $rfq['ticket_id']);
 			} else {
 				$db_note = $rfq['note'];
 				$message = $rfq['email_note'];
  			//qmail replaces LF(\n) with CRLF(\r\n), so only use LF in headers
  			$headers = "Content-type: text/html; charset=iso-8859-1\nFrom: {$rfq['user']['full_name']} (LiveWire Supply) <{$rfq['from']}>\nReply-To: {$rfq['from']}\n";
	 			$to = $rfq['to'];
	 			$subject = $rfq['email_subject'];
	  		if(!empty($rfq['cc'])) $headers .= "Cc: {$rfq['cc']}\n";
	  		if(sfConfig::get('sf_environment') == 'prod') if(!@mail($to,$subject,$message,$headers)) throw new Exception($db_note);
	  		$action_id = BE::EXTERNAL_NOTE_ACTION;
 				$this->query("UPDATE be_ticket SET action_id={$action_id} WHERE ticket_id={$rfq['ticket_id']}");
 			}
  		return $db_note;
 		}
 		
	  public function fetchCustomer($cust_id) {
 			$this->query("SELECT * FROM be_customer WHERE customer_id={$cust_id} LIMIT 1");
 			if($this->queryOK()) return $this->next();
 			else return NULL;
 		}

 		/**
 		 * 
 		 * Had to use an alias for be_customer.customer_id to preserve the value from being
 		 * overriden completely by the NULL value in be_ticket.customer_id for new customers
 		 * (who obviusly don't have any tickets yet).
 		 * @param Integer $cust_id, primary key of customer record in DB
 		 */
 		public function fetchCustAndTicketHistory($cust_id) {
 			$this->query("
				SELECT  be_customer.*, be_customer.customer_id AS c_id, be_ticket.*, be_ticket_category.category, be_ticket_category.route, be_action.action FROM be_customer
				LEFT JOIN be_ticket USING (customer_id) LEFT JOIN be_ticket_category USING(ticket_cat_id) LEFT JOIN be_action USING(action_id)
				WHERE customer_id = $cust_id 
				ORDER BY be_ticket.ticket_id DESC
 			");
 			if($this->queryOK()) {
 				$data = array();
 				$data['customer'] = $this->next();
 				if(is_null($data['customer']['ticket_id'])) $data['tickets'] = NULL;
 				else $data['tickets'][] = $data['customer'];
 				while($row = $this->next())	$data['tickets'][] = $row;
 				return $data;
 			} else return NULL;
 		}
 		
  	public function fetchCustAndUsers($cust_id) {
 			$this->query("
				(
					SELECT *
					FROM be_customer
					WHERE customer_id = $cust_id
				)
				UNION 
				(
					SELECT role_id, CONCAT( first_name, ' ', last_name ) , email, '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', ''
					FROM be_user
				)
 			");
 			if($this->queryOK()) {
 				$data = array();
 				$data['users'] = array();
 				$row = $this->next();
				/*
				 * customer_id is never less than 1000 in the DB,
				 * so if the first row has a value less than 1000
				 * then it must be a role_id value for a user and the query
				 * returned no customer for the passed $cust_id
				 */
 				$data['customer'] = $row['customer_id'] < 1000 ? NULL : $row;
 				while($row = $this->next()) $data['users'][] = $row;
 				return $data;
 			} else return NULL;
 		}
 		
 		public function fetchVendors() {
 			$this->query('SELECT * FROM be_vendor ORDER BY name ASC');
 			if($this->queryOK()) {
 				$vendors = array();
 				while($row = $this->next()) $vendors[] = $row;
 				return $vendors;
 			} else return NULL;
 		}
 		
 		public function fetchUsersAndVendors() {
 			$this->query("
 				(
 					SELECT vendor_id,name,phone,email,contact_1,contact_2,contact_3
 					FROM be_vendor
 				)
 				UNION
 				(
 					SELECT role_id,CONCAT(first_name,' ',last_name),phone,email,phone_ext,password,'be_user'
 					FROM be_user
 				)
 				ORDER BY name ASC
 			");
 			if($this->queryOK()) {
 				$data = array();
 				while($row = $this->next()) {
 					if($row['contact_3'] == 'be_user') $data['be_users'][] = $row;
 					else $data['vendors'][] = $row;
 				}
 				return $data;
 			} else return NULL;
 		}
 		
 		public function fetchOpenTicketsQueue($limit = false) {
 			$limit_sql = $limit && ($limit > 0) ? "LIMIT {$limit}" : '';
 			/*
 			 * For now not being specific about selecting the exact fields wanted 
 			 * is ok.  At some point naming the fields explicitly by using table name 
 			 * format with aliases might be required to avoid merging of similar 
 			 * named fields in the php result array. 
 			 * e.g. be_customer.first_name AS c_fn, be_user.first_name AS u_fn, etc.
 			 */
 			$this->query("
 				SELECT be_ticket.*, be_customer.*, be_user.*, be_ticket_category.*
 				FROM be_ticket, be_customer, be_user, be_ticket_category
 				WHERE be_ticket.customer_id = be_customer.customer_id
 				AND be_ticket.openned_by = be_user.email
 				AND be_ticket.ticket_cat_id = be_ticket_category.ticket_cat_id
 				AND status = 'open' 
 				ORDER BY openned_ts DESC $limit_sql
 			");
 			if($this->queryOK()) {
 				$open_tickets = array();
 				while($ticket = $this->next()) $open_tickets[] = $ticket;
 				return $open_tickets;
 			} else return NULL;
 		}
 		
 		public function fetchRfqTicket($ticket_id) {
 			$this->query("
 				SELECT ticket_id,openned_by,openned_ts,last_mod_ts,status,be_action.*,be_customer.*,be_rfq.* FROM be_ticket
 				INNER JOIN be_action USING(action_id) INNER JOIN be_customer USING(customer_id) INNER JOIN be_rfq USING(ticket_id)
 				WHERE ticket_id = $ticket_id LIMIT 1
 			");
 			if($this->queryOK()) {
 				$data = array();
 				$type = 'ticket';
 				foreach($this->next() as $k => $v) {
 					if($k == 'customer_id') $type = 'customer';
 					else if($k == 'rfq_id') $type = 'rfq';
 					$data[$type][$k] = $v;
 				}
 				return $data;
 			} else return NULL;
 		}
 		
 		public function fetchRfqMatrices($ticket_id) {
 			$this->query("SELECT be_rfq_matrix.*, display FROM be_rfq_matrix LEFT JOIN store USING(part_no) WHERE ticket_id = $ticket_id");
 			if($this->queryOK()) {
 				$matrices = array();
 				while($row = $this->next()) $matrices['rqx'][] = $row;
 				$this->query("SELECT be_vendor_matrix.*, name FROM be_vendor_matrix INNER JOIN be_vendor USING(vendor_id) WHERE ticket_id = $ticket_id");
 				if($this->queryOK()) {
 					while($row = $this->next()) $matrices['vmx'][] = $row;
 				}
 				// RFQ's can exist without any VMX rows, e.g. vmx rows are optional on creation of new RFQ
 				return $matrices;
 			} else return NULL;
 		}
 		
 		public function fetchTicketNotes($ticket_id) {
 			$this->query("
				SELECT be_ticket_note.*, CONCAT(first_name,' ',last_name) AS sent_by_name FROM be_ticket_note
				INNER JOIN be_user ON be_ticket_note.sent_by = be_user.email
				WHERE ticket_id = $ticket_id
				ORDER BY ts DESC
 			");
 			if($this->queryOK()) {
 				$notes = array();
 				while($row = $this->next()) {
 					if(!is_null($row['notify'])) {
 						// DB storage is comma delimited values with format = [be_user_email]:[be_user_name]
 						$notify_sets = explode(',', $row['notify']);
 						$notify = '';
 						foreach($notify_sets as $set) {
 							$arr = explode(':', $set);
 							$notify .= "{$arr[1]}, ";
 						}
 						$notify = substr($notify, 0, -2); // remove last space and comma
 						$row['notify'] = $notify;
 					}
 					$notes[] = $row;
 				}
 				return $notes;
 			} else return NULL;
 		}
 		
 		/**
 		 * Method to save new customer to database.
 		 * 
 		 * THIS METHOD SHOULD BE REDONE SO THAT THE FORM FIELDS 
 		 * USE THE SAME NAMES AS THE DATABASE FIELDS!!!!
 		 * 
 		 * @param $c: a customer record array
 		 * @param $entered_by: the logged in user's email
 		 */
 		public function saveNewCustomer($c, $entered_by) {
 			//BE::dump($c,true,__METHOD__);
 			// lowercase relevant fields
 			foreach($this->_lowercase_cust_fields as $f) $c[$f] = strtolower($c[$f]);
 			
 			// cleanup phone numbers
 			foreach($this->_phone_labels as $label) $c[$label] = preg_replace('/[^\d+]/', '', $c[$label]);
 			
 			// escape characters, SQL injection
 			foreach($c as &$f) $f = $this->getEscapedSQLString(trim($f));
 			
 			// build phone numbers from parts
 			$phone = !empty($c['p1']) ? "'{$c['p1']}-{$c['p2']}-{$c['p3']}'" : 'NULL';
 			$alt_phone = !empty($c['a1']) ? "'{$c['a1']}-{$c['a2']}-{$c['a3']}'" : 'NULL';
 			$fax = !empty($c['f1']) ? "'{$c['f1']}-{$c['f2']}-{$c['f3']}'" : 'NULL';
 			
 			// remove labels that don't represent database fields
 			foreach($this->_phone_labels as $label) unset($c[$label]);
 			
 			// prepare rest of fields
 		 	foreach($c as &$v) $v = empty($v) ? 'NULL' : "'{$v}'";

 			//BE::dump($t, true, __METHOD__);
 			$this->query("
 				INSERT INTO be_customer (
 					company,email,phone,phone_ext,alt_phone,alt_phone_ext,fax,first_name,last_name,
 					address_1,address_2,city,region,postal_code,country,customer_since,personal,entered_by
 				) VALUES (
 					{$c['company']},{$c['email']},$phone,{$c['phone_ext']},$alt_phone,{$c['alt_phone_ext']},$fax,{$c['first_name']},{$c['last_name']},
 					{$c['address_1']},{$c['address_2']},{$c['city']},{$c['region']},{$c['postal_code']},{$c['country']},UNIX_TIMESTAMP(),{$c['personal']},'$entered_by'
 				)
 			");
 			if($this->insertOK()) return true;
 			else return false;
 		}
 		
 		/**
 		 * Method to update customer record in database.
 		 * @param $c: customer record array
 		 */
 		public function updateCustomer($c) {
      // lowecase relevant fields
 			foreach($this->_lowercase_cust_fields as $field) $c[$field] = strtolower($c[$field]);
 			
 			// escape characters, SQL injection
 			foreach($c as &$f) $f = $this->getEscapedSQLString(trim($f));
 			
 			// build phone numbers from parts
 			$phone = !empty($c['p1']) ? "'{$c['p1']}-{$c['p2']}-{$c['p3']}'" : 'NULL';
 			$alt_phone = !empty($c['a1']) ? "'{$c['a1']}-{$c['a2']}-{$c['a3']}'" : 'NULL';
 			$fax = !empty($c['f1']) ? "'{$c['f1']}-{$c['f2']}-{$c['f3']}'" : 'NULL';
 			
 			// remove labels that don't represent database fields
 			foreach($this->_phone_labels as $label) unset($c[$label]);
 			
 			// customer_id is last element of array, remove it before building sql
 			$id = array_pop($c);
 			
 			// build SQL for update
 			$update_sql = 'UPDATE be_customer SET ';
 			foreach($c as $f => $v) {
 				$update_val = empty($v) ? 'NULL' : "'{$v}'";
 				$update_sql .= "{$f}={$update_val},";
 			}
 			$update_sql .= "phone={$phone},alt_phone={$alt_phone},fax={$fax} WHERE customer_id={$id}";
 			$this->query($update_sql);
 			if($this->updateOK()) return true;
 			else return false;
 		}
 		
 		public function saveNewRfq($rfq) {
 			/*
 			 * Prevent SQL injection and escpate characters
 			 * after saving original version of general note
 			 * in case it needs to be emailed.
 			 */
 			$unescaped_note = $rfq['note'];
 			$unescaped_subj = $rfq['subject'];
			foreach($rfq as &$f) {
				if(is_array($f)) foreach($f as &$k) $k = $this->getEscapedSQLString(trim($k));
				else $f =  $this->getEscapedSQLString(trim($f));
			}
 			$rfq['email_note'] = $unescaped_note;
 			$rfq['email_subject'] = $unescaped_subj;
 			
 			// save the be_ticket record
 			$this->query("
 				INSERT INTO be_ticket (customer_id, ticket_cat_id, openned_by, last_mod_by, openned_ts, last_mod_ts, action_id) 
 				VALUES ({$rfq['customer_id']}, 1, '{$rfq['openned_by']}',  '{$rfq['openned_by']}', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), 1)
 			");
 			if(!$this->insertOK()) return false;
 			$ticket_id = $this->getLastInsertId();
 			
 			// save be_rfq record
 			$referrer = empty($rfq['referrer']) ? 'NULL' : "'{$rfq['referrer']}'";
 			$search_phrase = empty($rfq['search_phrase']) ? 'NULL' : "'{$rfq['search_phrase']}'";
 			$this->query("
 				INSERT INTO be_rfq (ticket_id, referrer, search_phrase, urgency, priority) 
 				VALUES ($ticket_id, $referrer, $search_phrase,  '{$rfq['urgency']}', '{$rfq['priority']}')
 			");
 			if(!$this->insertOK()) return false;
 			
 			// save be_rfq_matrix record(s)
 			$rqx_cnt = count($rfq['part_no']);
 			$sql = 'INSERT INTO be_rfq_matrix (ticket_id,part_no,category,mfr,condition_req,qty_req,quoted_new,quoted_grn,notes,lead_time,ts) VALUES ';
 			for($i = 0; $i < $rqx_cnt; $i++) {
 				$qty_req = intval($rfq['qty_req'][$i]);
 				$quoted_new = empty($rfq['quoted_new'][$i]) ? 'NULL' : str_replace(',','',str_replace('$','',$rfq['quoted_new'][$i]));
 				if($quoted_new !== 'NULL') $quoted_new = floatval($quoted_new);
 				$quoted_grn = empty($rfq['quoted_grn'][$i]) ? 'NULL' : str_replace(',','',str_replace('$','',$rfq['quoted_grn'][$i]));
 				if($quoted_grn !== 'NULL') $quoted_grn = floatval($quoted_grn);
 				$part_no = strtoupper(trim($rfq['part_no'][$i]));
 				$lead_time = empty($rfq['lead_time'][$i]) ? 'NULL' : "'{$rfq['lead_time'][$i]}'";
 				$notes = empty($rfq['notes'][$i]) ? 'NULL' : "'{$rfq['notes'][$i]}'";
 				$sql .= "($ticket_id,'{$part_no}','{$rfq['category'][$i]}','{$rfq['mfr'][$i]}','{$rfq['condition_req'][$i]}',$qty_req,$quoted_new,$quoted_grn,$notes,$lead_time,UNIX_TIMESTAMP()),";
 			}
 			$sql = substr($sql, 0, -1);
 			$this->query($sql);
 			if(!$this->insertOK()) return false;
 			
 			/*
 			 * VMX records are optional on creation of new RFQ.
 			 * However, client side validation guarantees a complete
 			 * record if at least the Catalog No. field has a value.
 			 * Hence the check below on the firsr record before 
 			 * insertion into DB.
 			 */
 			if(!empty($rfq['vpart_no'][0])) {
 				$vmx_cnt = count($rfq['vpart_no']);
	 			$sql = 'INSERT INTO be_vendor_matrix (ticket_id,vendor_id,cond,part_no,purchase_price,qty_on_hand,rep,rep_email,vnotes,vlead_time,ts) VALUES ';
	 			for($i = 0; $i < $vmx_cnt; $i++) {
	 				$qty_on_hand = empty($rfq['qty_on_hand'][$i]) ? 'NULL' : intval($rfq['qty_on_hand'][$i]);
	 				$rep = empty($rfq['rep'][$i]) ? 'NULL' : strtolower("'{$rfq['rep'][$i]}'");
	 				$rep_email = empty($rfq['rep_email'][$i]) ? 'NULL' : strtolower("'{$rfq['rep_email'][$i]}'");
	 				$vnotes = empty($rfq['vnotes'][$i]) ? 'NULL' : "'{$rfq['vnotes'][$i]}'";
	 				$purchase_price = str_replace(',','',str_replace('$','',$rfq['purchase_price'][$i]));
	 				$purchase_price = floatval($purchase_price);
	 				$vpart_no = strtoupper(trim($rfq['vpart_no'][$i]));
	 				$vlead_time = empty($rfq['vlead_time'][$i]) ? 'NULL' : "'{$rfq['vlead_time'][$i]}'";
	 				$sql .= "($ticket_id,{$rfq['vendor_id'][$i]},'{$rfq['cond'][$i]}','{$vpart_no}',$purchase_price,$qty_on_hand,$rep,$rep_email,$vnotes,$vlead_time,UNIX_TIMESTAMP()),";
	 			}
	 			$sql = substr($sql, 0, -1);
	 			$this->query($sql);
	 			if(!$this->insertOK()) return false;
 			}
 			
 		 	// save be_ticket_note record
 			if($rfq['type'] != 'none') {
 				$rfq['ticket_id'] = $ticket_id;
 				if(!$this->saveTicketNote($rfq)) return false;
 			}
 			
 			return $ticket_id;
 		}// end saveNewRFQ()
 		
 		/**
 		 * Update a previously saved RFQ.  At this point,
 		 * all updating is optional so check for presence 
 		 * of form values first.
 		 * 
 		 * @param Mixed Array $rfq, the submitted form values
 		 */
 		public function updateRfq($rfq) {
 			/*
 			 * Prevent SQL injection and escpate characters
 			 * after saving original version of general note
 			 * in case it needs to be emailed.
 			 */
 			$unescaped_note = $rfq['note'];
 			$unescaped_subj = $rfq['subject'];
			foreach($rfq as &$f) {
				if(is_array($f)) foreach($f as &$k) $k = $this->getEscapedSQLString(trim($k));
				else $f =  $this->getEscapedSQLString(trim($f));
			}
 			$rfq['email_note'] = $unescaped_note;
 			$rfq['email_subject'] = $unescaped_subj;
 			
 			// Handle any necessary updates first
 			if(!empty($rfq['rqx_keys'])) {
 				$ru_sql = 'REPLACE INTO be_rfq_matrix (rfq_idx,ticket_id,part_no,category,mfr,condition_req,qty_req,quoted_new,quoted_grn,notes,lead_time,ts) VALUES ';
 				$rqx_keys = explode('_', $rfq['rqx_keys']);
 				foreach($rqx_keys as $key) {
 					list($row_idx, $rfq_idx) = explode(':', $key);
	 				$qty_req = intval($rfq['u:qty_req'][$row_idx]);
	 				$quoted_new = empty($rfq['u:quoted_new'][$row_idx]) ? 'NULL' : str_replace(',','',str_replace('$','',$rfq['u:quoted_new'][$row_idx]));
	 				if($quoted_new !== 'NULL') $quoted_new = floatval($quoted_new);
	 				$quoted_grn = empty($rfq['u:quoted_grn'][$row_idx]) ? 'NULL' : str_replace(',','',str_replace('$','',$rfq['u:quoted_grn'][$row_idx]));
	 				if($quoted_grn !== 'NULL') $quoted_grn = floatval($quoted_grn);
	 				$part_no = strtoupper($rfq['u:part_no'][$row_idx]);
	 				$lead_time = empty($rfq['u:lead_time'][$row_idx]) ? 'NULL' : "'{$rfq['u:lead_time'][$row_idx]}'";
	 				$notes = empty($rfq['u:notes'][$row_idx]) ? 'NULL' : "'{$rfq['u:notes'][$row_idx]}'";
	 				$ru_sql .= "($rfq_idx,{$rfq['ticket_id']},'$part_no','{$rfq['u:category'][$row_idx]}','{$rfq['u:mfr'][$row_idx]}','{$rfq['u:condition_req'][$row_idx]}',$qty_req,$quoted_new,$quoted_grn,$notes,$lead_time,UNIX_TIMESTAMP()),";
 				}
 				$ru_sql = substr($ru_sql,0,-1);
				$this->query($ru_sql);
				if(!$this->updateOK()) return false;
 			}
 			if(!empty($rfq['vmx_keys'])) {
 				$vu_sql = 'REPLACE INTO be_vendor_matrix (vmx_idx,ticket_id,vendor_id,cond,part_no,purchase_price,qty_on_hand,rep,rep_email,vnotes,vlead_time,ts) VALUES ';
 				$vmx_keys = explode('_', $rfq['vmx_keys']);
 				foreach($vmx_keys as $key) {
 					list($row_idx, $vmx_idx) = explode(':', $key);
	 				$qty_on_hand = empty($rfq['u:qty_on_hand'][$row_idx]) ? 'NULL' : intval($rfq['u:qty_on_hand'][$row_idx]);
	 				$rep = empty($rfq['u:rep'][$row_idx]) ? 'NULL' : strtolower("'{$rfq['u:rep'][$row_idx]}'");
	 				$rep_email = empty($rfq['u:rep_email'][$row_idx]) ? 'NULL' : strtolower("'{$rfq['u:rep_email'][$row_idx]}'");
	 				$vnotes = empty($rfq['u:vnotes'][$row_idx]) ? 'NULL' : "'{$rfq['u:vnotes'][$row_idx]}'";
	 				$purchase_price = str_replace(',','',str_replace('$','',$rfq['u:purchase_price'][$row_idx]));
	 				$purchase_price = floatval($purchase_price);
	 				$vpart_no = strtoupper($rfq['u:vpart_no'][$row_idx]);
	 				$vlead_time = empty($rfq['u:vlead_time'][$row_idx]) ? 'NULL' : "'{$rfq['u:vlead_time'][$row_idx]}'";
	 				$vu_sql .= "($vmx_idx,{$rfq['ticket_id']},{$rfq['u:vendor_id'][$row_idx]},'{$rfq['u:cond'][$row_idx]}','{$vpart_no}',$purchase_price,$qty_on_hand,$rep,$rep_email,$vnotes,$vlead_time,UNIX_TIMESTAMP()),";
 				}
 				$vu_sql = substr($vu_sql,0,-1);
				$this->query($vu_sql);
				if(!$this->updateOK()) return false;
 			}
 			if($rfq['rfq_update']) {
 				$this->query("
 					UPDATE be_rfq 
 					SET priority='{$rfq['priority']}', urgency='{$rfq['urgency']}' 
 					WHERE rfq_id = {$rfq['rfq_id']}
 				");
 				if(!$this->updateOK()) return false;
 			}
 			
 			// Now process any new insertions. RQX, VMX, or note
 			if(isset($rfq['part_no'])) {
 				// new RQX rows being inserted
	 			$rqx_cnt = count($rfq['part_no']);
	 			$ri_sql = 'INSERT INTO be_rfq_matrix (ticket_id,part_no,category,mfr,condition_req,qty_req,quoted_new,quoted_grn,notes,lead_time,ts) VALUES ';
	 			for($i = 0; $i < $rqx_cnt; $i++) {
	 				$qty_req = intval($rfq['qty_req'][$i]);
	 				$quoted_new = empty($rfq['quoted_new'][$i]) ? 'NULL' : str_replace(',','',str_replace('$','',$rfq['quoted_new'][$i]));
	 				if($quoted_new !== 'NULL') $quoted_new = floatval($quoted_new);
	 				$quoted_grn = empty($rfq['quoted_grn'][$i]) ? 'NULL' : str_replace(',','',str_replace('$','',$rfq['quoted_grn'][$i]));
	 				if($quoted_grn !== 'NULL') $quoted_grn = floatval($quoted_grn);
	 				$part_no = strtoupper($rfq['part_no'][$i]);
	 				$notes = empty($rfq['notes'][$i]) ? 'NULL' : "'{$rfq['notes'][$i]}'";
	 				$lead_time = empty($rfq['lead_time'][$i]) ? 'NULL' : "'{$rfq['lead_time'][$i]}'";
	 				$ri_sql .= "({$rfq['ticket_id']},'{$part_no}','{$rfq['category'][$i]}','{$rfq['mfr'][$i]}','{$rfq['condition_req'][$i]}',$qty_req,$quoted_new,$quoted_grn,$notes,$lead_time,UNIX_TIMESTAMP()),";
	 			}
	 			$ri_sql = substr($ri_sql, 0, -1);
	 			$this->query($ri_sql);
	 			if(!$this->insertOK()) return false;
 			}
 			if(isset($rfq['vpart_no'])) {
 				// new VMX rows being inserted
 				$vmx_cnt = count($rfq['vpart_no']);
	 			$vi_sql = 'INSERT INTO be_vendor_matrix (ticket_id,vendor_id,cond,part_no,purchase_price,qty_on_hand,rep,rep_email,vnotes,vlead_time,ts) VALUES ';
	 			for($i = 0; $i < $vmx_cnt; $i++) {
	 				$qty_on_hand = empty($rfq['qty_on_hand'][$i]) ? 'NULL' : intval($rfq['qty_on_hand'][$i]);
	 				$rep = empty($rfq['rep'][$i]) ? 'NULL' : strtolower("'{$rfq['rep'][$i]}'");
	 				$rep_email = empty($rfq['rep_email'][$i]) ? 'NULL' : strtolower("'{$rfq['rep_email'][$i]}'");
	 				$vnotes = empty($rfq['vnotes'][$i]) ? 'NULL' : "'{$rfq['vnotes'][$i]}'";
	 				$purchase_price = str_replace(',','',str_replace('$','',$rfq['purchase_price'][$i]));
	 				$purchase_price = floatval($purchase_price);
	 				$vpart_no = strtoupper($rfq['vpart_no'][$i]);
	 				$vlead_time = empty($rfq['vlead_time'][$i]) ? 'NULL' : "'{$rfq['vlead_time'][$i]}'";
	 				$vi_sql .= "({$rfq['ticket_id']},{$rfq['vendor_id'][$i]},'{$rfq['cond'][$i]}','{$vpart_no}',$purchase_price,$qty_on_hand,$rep,$rep_email,$vnotes,$vlead_time,UNIX_TIMESTAMP()),";
	 			}
	 			$vi_sql = substr($vi_sql, 0, -1);
	 			$this->query($vi_sql);
	 			if(!$this->insertOK()) return false;
 			}
 			
 			// save be_ticket_note record
 			if($rfq['type'] != 'none') {
 				if(!$this->saveTicketNote($rfq)) return false;
 			}
 			/*
 			BE::dump($ru_sql);
 			BE::dump($vu_sql);
 			BE::dump($sql);
 			BE::dump($ri_sql);
 			BE::dump($vi_sql);
 			BE::dump($rfq, true, __METHOD__);
 			*/
 			return true;
 		}
 		
	}