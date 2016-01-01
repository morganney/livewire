<?php

/**
 * sell_to_livewire actions.
 *
 * @package    lws
 * @subpackage sell_to_livewire
 * @author     Morgan Ney <morganney@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sell_to_livewireActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
	
	protected $_errors;
	
	public function __construct($context, $moduleName, $actionName) {
		parent::__construct($context, $moduleName, $actionName);
		$this->_errors = array();
	}
	
  public function executeIndex(sfWebRequest $request)
  {
  	if($request->isMethod('POST')) {
  		sfProjectConfiguration::getActive()->loadHelpers('Partial');
 			$req_fields = array($request->getParameter('preferred'), 'contact_name', 'description');
  		if($this->formIsValid($request, $req_fields)) {
  			// remove any saved form values from previous erroneous submission attempts
  			$this->getUser()->getAttributeHolder()->remove('form_values');
  			// build email message
  			$form_values = $request->getPostParameters();
  			$preferred = $form_values['preferred'];
  			$to = 'Sell-to Offer <sellto@livewiresupply.com>';
  			//$to = 'Morgan Ney <morganney@gmail.com>';
  			$message  = "--------------- SELL TO LIVEWIRE ~ SUBMISSION ---------------<br /><br />";
  			$message .= "<strong>Company Name:</strong> &nbsp; {$form_values['company']}<br />";
  			$message .= "<strong>Contact Name:</strong> &nbsp; {$form_values['contact_name']}<br />";
  			$message .= "<strong>Preferred Contact:</strong> &nbsp; {$preferred}<br />";
  			$message .= "<strong>Contact Info:</strong> &nbsp; {$form_values[$preferred]}<br />";
  			$message .= "<strong>Type of Equipment:</strong> &nbsp; {$form_values['type']}<br />";
  			$message .= "<strong>Message:</strong><br />{$form_values['description']}<br />";
  			$message .= "<br />--------------------- END OF SUBMISSION ---------------------<br />";
  			$message  = wordwrap($message, 70);
  			//qmail replaces LF(\n) with CRLF(\r\n), so only use LF in headers
  			$headers = "Content-type: text/html; charset=iso-8859-1\nFrom: Sell To LWS <sellto@livewiresupply.com>\n";
  			if( @mail($to, 'SELL TO LIVEWIRE - FORM SUBMISSION', $message, $headers) ) {
  				$this->getUser()->setFlash('notice', get_partial('formSuccess'));
  			} else $this->getUser()->setFlash('notice', get_partial('emailError'));
  			$this->redirect('@sell_to_lws');
  		} else {
  			// save form values to restore
  			$this->getUser()->setAttribute('form_values', $request->getPostParameters());
  			$this->getUser()->setFlash('notice', get_partial('formError', array('errors' => $this->_errors)));
  		}
  	}
    $this->getResponse()->setTitle('Sell To LiveWire Electrical Supply');
    return sfView::SUCCESS;
  }
  
  /**
   * Method to see if form is valid.
   * 
   * @param sfWebRequest $request
   * @param Array $req_fields, $req_fields[0] has the value associated with the preferred contact method
   */
  protected function formIsValid(sfWebRequest $request, $req_fields) {
  	$is_valid = true;
  	foreach($req_fields as $field) {
  		if(!$val = $request->getParameter($field)) {
  			$this->_errors[] = '<em>' . ucwords(str_replace('_', ' ', $field)) . '</em> is required.';
  		}
  	}
  	if(count($this->_errors)) $is_valid = false;
  	else {
  		// validate the preferred contact number/email
  		$pattern = $req_fields[0] == 'email' ? '/^[^@]+@[^@]+\.[^@]+$/' : '/\(?\d{3}\)?[-. ]?\d{3}[-. ]?\d{4}/';
  		if(!preg_match($pattern, $request->getParameter($req_fields[0]))) {
  			$is_valid = false;
  			$this->_errors[] = '<em>Invalid ' . ucfirst($req_fields[0]) . '</em>';
  		}
  	}
  	return $is_valid;
  }
  
}
