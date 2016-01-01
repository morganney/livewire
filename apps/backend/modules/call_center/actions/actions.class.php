<?php

/**
 * call_center actions.
 * Relying heavily on JavaScript for all form validation, so there
 * is no form value restoration performed here.  Although there is
 * some validation code to preserve database integrity.
 *
 * @package    lws
 * @subpackage call_center
 * @author     Morgan Ney <morganney@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class call_centerActions extends sfActions
{
	protected $_comp_suffix;
	
	public function __construct($context, $moduleName, $actionName) {
		parent::__construct($context, $moduleName, $actionName);
		$this->_comp_suffix = array(
			'Inc.',
			'Incorporated',
			'LLC',
			'Co.',
			'Ltd',
			'Corp',
			'Corporation',
			'Company'
		);
	}
	
	protected function normalizeCompany($company) {
		foreach($this->_comp_suffix as $sfx) {
			$company = str_ireplace($sfx, '', $company);
		}
		$company = str_replace('.', '', str_replace(',', '', $company));
		$half = ceil(strlen($company) / 2);
		$company = substr($company, 0, -$half);
		return trim(strtolower($company));
	}
	
	protected function RfqFormIsValid($form, $is_new = true) {
		$is_valid = true;
		$errs = array();
		if(isset($form['part_no'])) {
			foreach($form['part_no'] as $part_no) {
				if(empty($part_no)) {
					$errs[] = '<em>Catalog No.</em> is required for all Request &amp; Quote rows.';
					break;
				}
			}
		}
		if(isset($form['qty_req'])) {
			foreach($form['qty_req'] as $qty_req) {
				if(empty($qty_req) || intval($qty_req) <= 0) {
					$errs[] = '<em>QTY</em> is required as a positive number for all Request &amp; Quote rows.';
					break;
				}
			}
		}
		if(!$is_new) { 
			// all vmx rows must be complete on non-new RFQ's, 
			// BUT there may actually be zero vmx rows so we have to check for their existence
			if(isset($form['vpart_no'], $form['u:vpart_no'])) $vpart_nos = array_merge($form['u:vpart_no'], $form['vpart_no']);
			else if(isset($form['u:vpart_no'])) $vpart_nos = $form['u:vpart_no'];
			else if(isset($form['vpart_no'])) $vpart_nos = $form['vpart_no'];
			else $vpart_nos = array();
			foreach($vpart_nos as $vpart_no) {
				if(empty($vpart_no)) {
					$errs[] = '<em>Catalog No.</em> is required for all Purchasing rows.';
					break;
				}
			}
			if(isset($form['purchase_price'], $form['u:purchase_price'])) $purchase_prices = array_merge($form['u:purchase_price'], $form['purchase_price']);
			else if(isset($form['u:purchase_price'])) $purchase_prices = $form['u:purchase_price'];
			else if(isset($form['purchase_price'])) $purchase_prices = $form['purchase_price'];
			else $purchase_prices = array();
			foreach($purchase_prices as $price) {
				if(empty($price) || !is_numeric($price)) {
					$errs[] = '<em>Price</em> is required as a dollar amount for all Purchasing rows.';
					break;
				}
			}
		}
		if($form['type'] == 'external') {
			if(empty($form['subject'])) {
				$errs[] = '<em>Subject</em> is required for external notes.';
			}
			if(!preg_match(sfConfig::get('app_regex_email'), $form['sent_to'])) {
				$errs[] = '<em>To</em> is an invalid email address.';
			}
			/* fix this for comma delimited list
			if(!empty($form['cc']) && !preg_match(sfConfig::get('app_regex_email'), $form['cc'])) {
				$errs[] = '<em>Cc</em> is an invalid email address.';
			}
			*/
		}
		if($form['type'] != 'none' && $form['template'] == 'None' && empty($form['note'])) {
			$errs[] = 'The <em>note</em> is empty, there is no message.';
		}
		if(!empty($errs)) {
			$is_valid = false;
			array_unshift($errs, 'ERROR(S):');
			// currently relying on JavaScript to catch errors, so no form value restoration
			$flash_name = $is_new ? 'rfq_errs' : 'rfq_msg';
			$this->getUser()->setFlash($flash_name, $errs);
		}
		return $is_valid;
	}
	
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$agent = new CallCenterAgent();
  	$this->open_tickets = $agent->fetchOpenTicketsQueue(50);
    return sfView::SUCCESS;
  }
  
  public function executeSearch(sfWebRequest $request) {
  	$sa = new CCSearchAgent($request->getParameter('q'));
  	// currently both searches use the same normalize strategy since SQL is similar
    $sa->normalizeQuery($this->_comp_suffix);
    $is_ajax = $request->isXmlHttpRequest();
	  if($request->getParameter('for') == 'customer') {
  		$this->serps = $sa->searchCustomers($is_ajax);
  		$partial = 'quickCustSearchBox';
  		$data_type = 'customers';
  	} else {
  		$this->serps = $sa->searchTickets($request->getParameter('category'), $is_ajax);
  		$partial = 'quickTicketSearchBox';
  		$data_type = 'tickets';
  	}
  	if($is_ajax) {
  		sfProjectConfiguration::getActive()->loadHelpers('Partial');
 	  	$this->setLayout(false);
 	  	$html = get_partial($partial, array($data_type => $this->serps));
	  	$response = $this->getResponse();
	 		$response->addCacheControlHttpHeader('no-cache');
	  	$response->setContentType('text/html');
	  	$response->sendHttpHeaders();
	  	return $this->renderText($html);
  	} else return sfView::SUCCESS;
  }
  
  public function executeNewCustomer(sfWebRequest $request) {
  	if($request->isMethod('POST')) {
  		$user = $this->getUser();
  		$company = $request->getPostParameter('company');
  		if(empty($company)) {
  			$user->setAttribute('new_cust_form', $request->getPostParameters());
  			$user->setFlash('new_cust_err', array('<em>Company</em> is a required field.','Use First and Last Name if necessary.'));
  			$this->redirect('@new_customer');
  		} else {
  			$norm_comp = $this->normalizeCompany($company);
  			$agent = new CallCenterAgent();
  			$agent->query("
  				SELECT customer_id, company, phone, email, CONCAT_WS(' ', first_name, last_name) AS contact, CONCAT_WS(', ', address_1, address_2) AS loc1, CONCAT_WS(' ', city, region, postal_code) AS loc2  
  				FROM be_customer WHERE LOCATE('{$norm_comp}', LOWER(company)) != 0 
  			");
  			if($agent->queryOK()) {
  				// customers with similar company names found
  				$similar_customers = array();
  				while($row = $agent->next()) $similar_customers[] = $row;
	  			$user->setAttribute('similar_customers', $similar_customers);
	  			$user->setAttribute('new_cust_form', $request->getPostParameters());
	  			$this->redirect('@similar_customers');
  			} else {
  				// insert new customer into DB
  				$customer = $request->getPostParameters();
  				$be_user = $user->getAttribute('be_user');
  				if($agent->saveNewCustomer($customer, $be_user['email'])) {
  					if($user->hasAttribute('new_cust_form')) $user->getAttributeHolder()->remove('new_cust_form');
  					$insert_id = $agent->getLastInsertId();
  					$user->setFlash('cust_info', 'New customer successfully created.');
  					$this->redirect("@customer?id={$insert_id}");
  				} else {
  					$user->setAttribute('new_cust_form', $customer);
		  			$user->setFlash('new_cust_err', array(sfConfig::get('app_db_err_msg'), $agent->getError()));
  					$this->redirect('@new_customer');
  				}
  			}
  		}
  	} else return sfView::SUCCESS;
  }
  
  public function executeConfirmNewCustomer(sfWebRequest $request) {
  	$user = $this->getUser();
  	$be_user = $user->getAttribute('be_user');
  	$agent = new CallCenterAgent();
  	if($agent->saveNewCustomer($user->getAttribute('new_cust_form'), $be_user['email'])) {
  		$user->getAttributeHolder()->remove('new_cust_form');
  		$user->getAttributeHolder()->remove('similar_customers');
  		$insert_id = $agent->getLastInsertId();
  		$user->setFlash('cust_info', 'New customer successfully created!');
  		$this->redirect("@customer?id={$insert_id}");
  	} else {
		  $user->setFlash('new_cust_err', array(sfConfig::get('app_db_err_msg'), $agent->getError()));
  		$this->redirect('@new_customer');
  	}
  }
  
  public function executeSimilarCustomers(sfWebRequest $request) {
  	return sfView::SUCCESS;
  }
  
  /**
   * 
   * All templates related to this action will need to use the 
   * array key 'c_id' for customer_id.  This alias was created by
   * CallCenterAgent::fetchCustAndTicketHistory()
   *  
   * @param sfWebRequest $request
   */
  public function executeCustomer(sfWebRequest $request) {
  	/*
  	 * User could get here after entering values in the new customer form,
  	 * and then clicking 'continue' if similar customers were found. In this
  	 * case we should remove the 'new_cust_form' attribute from the user's 
  	 * session.
  	 */
  	if($this->getUser()->hasAttribute('new_cust_form')) $this->getUser()->getAttributeHolder()->remove('new_cust_form');
  	$agent = new CallCenterAgent();
  	$data = $agent->fetchCustAndTicketHistory($request->getParameter('id'));
  	$this->forward404Unless($data);
  	$this->c = $data['customer'];
  	$this->tickets = $data['tickets'];
  	return sfView::SUCCESS;
  }
  
  public function executeEditCustomer(sfWebRequest $request) {
  	$agent = new CallCenterAgent();
  	if($request->isMethod('POST')) {
  		$user = $this->getUser();
  		$this->c = $request->getPostParameters();
  		// some minor validating
  		if(empty($this->c['company'])) {
  			$user->setFlash('edit_cust_err', '<em>Company</em> is a required field. Use First and Last Name if necessary.');
  			$this->redirect("@edit_customer?id={$this->c['customer_id']}");
  		} else {
  			// update the customer record in DB
				$msg = $agent->updateCustomer($this->c) ? 'Customer record updated!' : "Database error! Unable to save new customer. Contact administrator at <a href='mailto:webmaster@livewiresupply.com'>webmater@livewiresupply.com</a>";
				$user->setFlash('cust_info', $msg);
				$this->redirect("@customer?id={$this->c['customer_id']}");
  		}
  	} else {
	  	$this->c = $agent->fetchCustomer($request->getParameter('id'));
	  	$this->forward404Unless($this->c);
	  	// handle phone number formatting
	  	foreach(array('phone', 'alt_phone', 'fax') as $field) {
	  		$char = substr($field, 0, 1);
	  		$_1 = "{$char}1";
	  		$_2 = "{$char}2";
	  		$_3 = "{$char}3";
	  		if(!empty($this->c[$field])) {
	  			$p = explode('-', $this->c[$field]);
	  			$this->c[$_1] = $p[0];
	  			$this->c[$_2] = $p[1];
	  			$this->c[$_3] = $p[2];
	  		} else {
	  			$this->c[$_1] = NULL;
	  			$this->c[$_2] = NULL;
	  			$this->c[$_3] = NULL;
	  		}
	  	}
	  	return sfView::SUCCESS;
  	}
  }
  
  public function executeNewRfq(sfWebRequest $request) {
  	$sess = $this->getUser();
  	$user = $sess->getAttribute('be_user');
  	$agent = new CallCenterAgent();
  	if($request->isMethod('POST')) {
  		$rfq = $request->getPostParameters();
  		if($this->RfqFormIsValid($rfq)) {
  			$rfq['user'] = $user;
  			if(($ticket_id = $agent->saveNewRfq($rfq))) {
  				if($sess->hasAttribute('rfq')) $sess->getAttributeHolder()->remove('rfq');
	  			if(intval($rfq['continue'])) {
	  				$sess->setFlash('rfq_msg', array('New RFQ saved successfully!'));
	  				$this->redirect("@rfq?ticket_id={$ticket_id}");
	  			} else {
	  				$sess->setFlash('cc_msg', 'New RFQ saved successfully!');
	  				$this->redirect('@call_center');
	  			}
  			} else {
		  		$sess->setFlash('rfq_errs', array(sfConfig::get('app_db_err_msg'), $agent->getError()));
		  		$this->redirect("@new_rfq?id={$rfq['customer_id']}");
  			}
  		} else {
  			$customer_id = $rfq['customer_id'];
  			$data = $agent->fetchUsersAndVendors();
		  	$this->c = $agent->fetchCustomer($customer_id);
		  	// no need for 404 forward here ??
		  	$this->be_users = $data['be_users'];
		  	$this->vendors = $data['vendors'];
		  	$this->rep = $sess->getAttribute('be_user');
		  	$sess->setAttribute('rfq', $rfq);
  			// session error messages set by validator method
  			$this->redirect("@new_rfq?id={$customer_id}");
  		}
  	} else {
	  	$data = $agent->fetchUsersAndVendors();
	  	$this->c = $agent->fetchCustomer($request->getParameter('id'));
	  	$this->forward404Unless($this->c && $data);
	  	$this->rep = $sess->getAttribute('be_user');
	  	$this->be_users = $data['be_users'];
	  	$this->vendors = $data['vendors'];
	  	return sfView::SUCCESS;
  	}
  }
  
  public function executeNewReturn(sfWebRequest $request) {
  	return sfView::SUCCESS;
  }
  
  public function executeNewTracking(sfWebRequest $request) {
  	return sfView::SUCCESS;
  }
  
  public function executeNewSupport(sfWebRequest $request) {
  	return sfView::SUCCESS;
  }
  
  public function executeRfq(sfWebRequest $request) {
  	$ticket_id = $request->getParameter('ticket_id');
  	$sess = $this->getUser();
  	$user = $sess->getAttribute('be_user');
  	$agent = new CallCenterAgent();
  	if($request->isMethod('POST')) {
  		$rfq = $request->getPostParameters();
  		if($this->rfqFormIsValid($rfq, false)) {
  			$rfq['user'] = $user;
  			if($agent->updateRfq($rfq)) {
  				if(intval($rfq['close'])) {
	  				$sess->setFlash('cc_msg', 'New RFQ updated successfully!');
	  				$this->redirect('@call_center');
  				} else {
	  				$sess->setFlash('rfq_msg', 'New RFQ updated successfully!');
	  				$this->redirect("@rfq?ticket_id=$ticket_id");
  				}
  			} else {
		  		$sess->setFlash('rfq_msg', array(sfConfig::get('app_db_err_msg'), $agent->getError()));
		  		$this->redirect("@rfq?ticket_id=$ticket_id");
  			}
  		} else {
  			// Relying on JavaScript validation, no form value restoration
  			$this->redirect("@rfq?ticket_id={$ticket_id}");
  		}
  	}
  	$ticket_info = $agent->fetchRfqTicket($ticket_id);
  	$matrices = $agent->fetchRfqMatrices($ticket_id);
  	$this->forward404Unless($ticket_info && $matrices);
  	$this->notes = $agent->fetchTicketNotes($ticket_id);
  	$lists = $agent->fetchUsersAndVendors();
  	if(!$lists) die($agent->getError());
  	$this->ticket = $ticket_info['ticket'];
  	$this->c = $ticket_info['customer'];
  	$this->rfq = $ticket_info['rfq'];
  	$this->rqx = $matrices['rqx'];
  	
  	// adding purchasing rows is optional on creation of new RFQ
  	$this->vmx = isset($matrices['vmx']) ? $matrices['vmx'] : array();
  	
  	$this->vendors = $lists['vendors'];
  	$this->be_users = $lists['be_users'];
  	$this->rep = $sess->getAttribute('be_user');
  	return sfView::SUCCESS;
  }
  
}
