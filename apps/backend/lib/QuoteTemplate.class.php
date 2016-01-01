<?php
	class QuoteTemplate implements iCallCenterTemplate {
		
		protected $_body;
		protected $_db_note;
		protected $_action_id;
		
		public function __construct() {
			sfProjectConfiguration::getActive()->loadHelpers('Partial');
			$this->_body = $this->_db_note = NULL;
			$this->_action_id = BE::QUOTE_EMAILED_ACTION;
		}
		
		public function build($rfq) {
			$email = array();
			$email['ticket_id'] = $rfq['ticket_id'];
			$email['emp_email'] = $rfq['from'];
			$email['emp_name'] = $rfq['user']['full_name'];
			$email['emp_phone'] = $rfq['user']['phone'];
			$email['emp_ext'] = $rfq['user']['phone_ext'];
			$email['date'] = date(sfConfig::get('app_formats_date_email'));
			// prepare email openning
			if(!empty($rfq['customer_name'])) {
				$email['customer'] = $rfq['customer_name'];
				if(strtolower($rfq['customer_name']) == strtolower($rfq['customer_company'])) {
					$email['openning'] = "Hello {$rfq['customer_name']},<br />Based on your inquiry, we have prepared this quote for you.";
				} else {
					$email['openning'] = "Hello {$rfq['customer_name']},<br />Based on your inquiry, we have prepared this quote for {$rfq['customer_company']}.";
				}
			} else {
				$email['customer'] = $rfq['customer_company'];
				$email['openning'] = "Based on your inquiry, we have prepared this quote for {$rfq['customer_company']}.";
			}
			
			// initialize quoted parts array, and variable to hold database version of template
			$email['parts'] = array();
			$db_note = '';
			$parts_cnt = 1;
			
			// check if previously entered parts are being used for the email quote
			if(!empty($rfq['rqx_keys'])) {
				$p = explode('_', $rfq['rqx_keys']);
				foreach($p as $v) {
					$keys = explode(':', $v);
					$row_idx = $keys[0];
					// should be at least 1 quoted price
					if(empty($rfq['u:quoted_new'][$row_idx])) $display = 'grn';
					else if(empty($rfq['u:quoted_grn'][$row_idx])) $display = 'new';
					else $display = 'both';
					$img_file = strtolower($rfq['u:part_no'][$row_idx]) . '.jpg';
					if(file_exists("/var/www/vhosts/livewiresupply.com/httpdocs/web/images/thumbs/$img_file")) {
						$img = "http://livewiresupply.com/images/thumbs/$img_file";
					} else $img = 'http://livewiresupply.com/images/thumbs/default.png';
					$part_no = strtoupper($rfq['u:part_no'][$row_idx]);
					$part_desc = empty($rfq['u:notes'][$row_idx]) ? $part_no : $part_no . "<span style='display: block;font-weight: normal;color:#000;'>{$rfq['u:notes'][$row_idx]}</span>";
					$new = '$' . number_format(floatval(str_replace(',','',str_replace('$','',$rfq['u:quoted_new'][$row_idx]))),2);
					$grn = '$' . number_format(floatval(str_replace(',','',str_replace('$','',$rfq['u:quoted_grn'][$row_idx]))),2);
					$qty = intval($rfq['u:qty_req'][$row_idx]);
					$inventory = empty($rfq['u:lead_time'][$row_idx]) ? 'Yes' : stripslashes($rfq['u:lead_time'][$row_idx]);
					$pne = LWS::encode($part_no);
					// better to change the html and use the ajax price lookup request to build a url. don't have the patience right now.
					$url = $rfq['u:mfr'][$row_idx] == 'Not Chosen' ? 'http://livewiresupply.com/' : 'http://livewiresupply.com/' . LWS::slugify($rfq['u:category'][$row_idx]) . '/' . LWS::slugify($rfq['u:mfr'][$row_idx]) . "/{$pne}.html";
					$btn = isset($rfq['u:display'][$row_idx]) && intval($rfq['u:display'][$row_idx]) > 0 ? 'buy-btn.gif' : 'call-btn.gif';
					$btn_txt = isset($rfq['u:display'][$row_idx]) && intval($rfq['u:display'][$row_idx]) > 0 ? '' : "<br /><span style='font-size: 9px;'>800.390.3299</span>";
					$email['parts'][] = array(
						'part_no' 		=> $part_no,
						'part_desc'		=> $part_desc,
						'img'					=> $img,
						'display'			=> $display,
						'new'					=> $new,
						'grn'					=> $grn,
						'qty'					=> $qty,
						'inventory'		=> $inventory,
						'url'					=> $url,
						'btn'					=> $btn,
						'btn_txt'			=> $btn_txt
					);
					if($grn == '$0.00') $grn = 'Not Quoted';
					if($new == '$0.00') $new = 'Not Quoted';
					$db_note .= "{$parts_cnt}. {$part_no} - New = {$new}, Green = {$grn}\n";
					$parts_cnt++;
				}
			}
			
			// check if newly entered parts are being used for the email quote
			if(!empty($rfq['part_no'])) {
				$count = count($rfq['part_no']);
				for($i = 0; $i < $count; $i++) {
					// should be at least 1 quoted price
					if(empty($rfq['quoted_new'][$i])) $display = 'grn';
					else if(empty($rfq['quoted_grn'][$i])) $display = 'new';
					else $display = 'both';
					$img_file = strtolower($rfq['part_no'][$i]) . '.jpg';
					if(file_exists("/var/www/vhosts/livewiresupply.com/httpdocs/web/images/thumbs/$img_file")) {
						$img = "http://livewiresupply.com/images/thumbs/$img_file";
					} else $img = 'http://livewiresupply.com/images/thumbs/default.png';
					$part_no = strtoupper($rfq['part_no'][$i]);
					$part_desc = empty($rfq['notes'][$i]) ? $part_no : $part_no . "<span style='display: block;font-weight: normal;color:#000;'>{$rfq['notes'][$i]}</span>";
					$new = '$' . number_format(floatval(str_replace(',','',str_replace('$','',$rfq['quoted_new'][$i]))),2);
					$grn = '$' . number_format(floatval(str_replace(',','',str_replace('$','',$rfq['quoted_grn'][$i]))),2);
					$qty = intval($rfq['qty_req'][$i]);
					$inventory = empty($rfq['lead_time'][$i]) ? 'Yes' : stripslashes($rfq['lead_time'][$i]);
					$pne = LWS::encode($part_no);
					// better to change the html and use the ajax price lookup request to build a url.
					$url = $rfq['mfr'][$i] == 'Not Chosen' ? 'http://livewiresupply.com/' : 'http://livewiresupply.com/' . LWS::slugify($rfq['category'][$i]) . '/' . LWS::slugify($rfq['mfr'][$i]) . "/{$pne}.html";
					$btn = isset($rfq['display'][$i]) && intval($rfq['display'][$i]) > 0 ? 'buy-btn.gif' : 'call-btn.gif';
					$btn_txt = isset($rfq['display'][$i]) && intval($rfq['display'][$i]) > 0 ? '' : "<br /><span style='font-size: 9px;'>800.390.3299</span>";
					$email['parts'][] = array(
						'part_no' 		=> $part_no,
						'part_desc'		=> $part_desc,
						'img'					=> $img,
						'display'			=> $display,
						'new'					=> $new,
						'grn'					=> $grn,
						'qty'					=> $qty,
						'inventory'		=> $inventory,
						'url'					=> $url,
						'btn'					=> $btn,
						'btn_txt'			=> $btn_txt
					);
					if($grn == '$0.00') $grn = 'Not Quoted';
					if($new == '$0.00') $new = 'Not Quoted';
					$db_note .= "{$parts_cnt}. {$part_no} - New = {$new}, Green = {$grn}\n";
					$parts_cnt++;
				}
			}
			
			$this->_body = get_partial('call_center/emailQuote', array('email' => $email));
			$this->_db_note = "[" . sfConfig::get('app_company') . " Quote]\n {$db_note}";
		}
		
		public function getTemplate() {
			return $this->_body;
		}
		
		public function getDbNote() {
			return $this->_db_note;
		}
		
		public function updateTicketLastAction($dao, $ticket_id) {
			$dao->query("UPDATE be_ticket SET action_id={$this->_action_id} WHERE ticket_id={$ticket_id}");
		}
		
		public function getEmailHeaders($rfq) {
			//qmail replaces LF(\n) with CRLF(\r\n), so only use LF in headers
  		$headers = "Content-type: text/html; charset=iso-8859-1\nFrom: Adam Messner - LiveWire Supply <adam@livewiresupply.com>\nReply-To: {$rfq['from']}\n";
  		return $headers;
		}
		
	}
	