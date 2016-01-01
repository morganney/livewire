<?php

/**
 * rfq actions.
 *
 * @package    lws
 * @subpackage rfq
 * @author     Morgan Ney <morganney@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class rfqActions extends sfActions
{
  protected $_req_fields;
	protected $_errors;
	
	public function __construct($context, $moduleName, $actionName) {
		parent::__construct($context, $moduleName, $actionName);
		$this->_req_fields = array('contact_name', 'contact_number', 'contact_email', 'catalog_number');
		$this->_errors = array();
	}

  protected function rfqIsValid(sfWebRequest $request) {
   	$is_valid = true;
  	foreach($this->_req_fields as $field) {
  		if(!$request->getParameter($field)) {
  			$this->_errors[] = '<em>' . ucwords(str_replace('_', ' ', $field)) . '</em> is required.';
  		}
  	}
  	if(count($this->_errors)) $is_valid = false;
  	else {
  		// validate the required contact information
  		if(!preg_match('/\(?\d{3}\)?[-. ]?\d{3}[-. ]?\d{4}/', $request->getParameter('contact_number'))) {
  			$is_valid = false;
  			$this->_errors[] = '<em>Invalid Phone Number</em>';
  		}
  	  if(!preg_match('/^[^@]+@[^@]+\.[^@]+$/', $request->getParameter('contact_email'))) {
  			$is_valid = false;
  			$this->_errors[] = '<em>Invalid Email</em>';
  		}
  	}
  	return $is_valid;
  }
  
  protected function buildOtherEmail($form_values) {
  	$message  = "--------------- REQUEST FOR QUOTE ~ {$this->category} ---------------<br /><br />";
  	$message .= "<strong>Company:</strong> &nbsp; {$form_values['company']}<br />";
  	$message .= "<strong>Contact Name:</strong> &nbsp; {$form_values['contact_name']}<br />";
  	$message .= "<strong>Contact Number:</strong> &nbsp; {$form_values['contact_number']}<br />";
  	$message .= "<strong>Contact Email:</strong> &nbsp; {$form_values['contact_email']}<br />";
  	$message .= "<strong>Required Date:</strong> &nbsp; {$form_values['req_date']}<br />";
  	$message .= "<strong>Catalog No.:</strong> &nbsp; {$form_values['catalog_number']}<br />";
  	$message .= "<strong>Desired Condition:</strong> &nbsp; {$form_values['condition']}<br />";
  	$message .= "<strong>Additional Details:</strong><br />{$form_values['notes']}<br />";
  	$message .= "<br />--------------------- END OF REQUEST ---------------------<br />";
  	return $message;
  }
  
  protected function buildTrEmail($form_values) {
  	$message  = "--------------- REQUEST FOR QUOTE ~ {$this->category} ---------------<br /><br />";
  	$message .= "<strong>Company:</strong> &nbsp; {$form_values['company']}<br />";
  	$message .= "<strong>Contact Name:</strong> &nbsp; {$form_values['contact_name']}<br />";
  	$message .= "<strong>Contact Number:</strong> &nbsp; {$form_values['contact_number']}<br />";
  	$message .= "<strong>Contact Email:</strong> &nbsp; {$form_values['contact_email']}<br />";
  	$message .= "<strong>Required Date:</strong> &nbsp; {$form_values['req_date']}<br />";
  	$message .= "<strong>Desired Condition:</strong> &nbsp; {$form_values['condition']}<br />";
  	// In PHP the strings '0' and '' (empty string) are considered FALSE
  	if($form_values['type']) $message .= "<strong>Type:</strong> &nbsp; {$form_values['type']}<br />";
  	if($form_values['enclosure']) $message .= "<strong>Enclosure:</strong> &nbsp; {$form_values['enclosure']}<br />";
  	if($form_values['hertz']) $message .= "<strong>Hertz:</strong> &nbsp; {$form_values['hertz']}<br />";
  	if($form_values['k_rated']) $message .= "<strong>'K'-rated:</strong> &nbsp; {$form_values['k_rated']}<br />";
  	if($form_values['kva']) $message .= "<strong>KVA:</strong> &nbsp; {$form_values['kva']}<br />";
  	if($form_values['pri_voltage']) $message .= "<strong>Primary Voltage:</strong> &nbsp; {$form_values['pri_voltage']}<br />";
  	if($form_values['sec_voltage']) $message .= "<strong>Secondary Voltage:</strong> &nbsp; {$form_values['sec_voltage']}<br />";
  	if($form_values['phase']) $message .= "<strong>Phase:</strong> &nbsp; {$form_values['phase']}<br />";
  	if($form_values['material']) $message .= "<strong>Winding Material:</strong> &nbsp; {$form_values['material']}<br />";
  	$message .= "<br />--------------------- END OF REQUEST ---------------------<br />";
  	return $message;
  }
  
  public function executeIndex(sfWebRequest $request)
  {
  	$sep = sfConfig::get('app_seo_word_sep_title');
  	$biz_name = sfConfig::get('app_biz_name');
  	$this->getResponse()->setTitle("Request a Quote {$sep} {$biz_name}");
  	$this->getResponse()->setSlot('body_id', 'quote');
    return sfView::SUCCESS;
  }
  
  public function executeRfq(sfWebRequest $request) {
  	$this->cat_slug = $request->getParameter('category');
  	$this->category = strtoupper(LWS::unslugify($this->cat_slug));
  	if($request->isMethod('POST')) {
  		sfProjectConfiguration::getActive()->loadHelpers('Partial');
  		if($this->cat_slug == 'electrical-transformers') array_pop($this->_req_fields);
  		if($this->rfqIsValid($request)) {
  			// remove any saved form values from previous erroneous submission attempts
  			$this->getUser()->getAttributeHolder()->remove('rfq_form_values');
  			// build email message
  			if($this->cat_slug == 'electrical-transformers') $message = $this->buildTrEmail($request->getPostParameters());
  			else $message = $this->buildOtherEmail($request->getPostParameters());
  			$to = 'Napoleon Esparrago <po@livewiresupply.com>';
  			//$to = 'Morgan Ney <morganney@gmail.com>';
  			//qmail replaces LF(\n) with CRLF(\r\n), so only use LF in headers
  			$headers = "Content-type: text/html; charset=iso-8859-1\nFrom: RFQ Form <sales@livewiresupply.com>\nCc: adam@livewiresupply.com\n";
  			if( @mail($to, "REQUEST FOR QUOTE - {$this->category}", $message, $headers) ) {
  				$this->getUser()->setFlash('rfq_notice', get_partial('formSuccess'));
  			} else $this->getUser()->setFlash('rfq_notice', get_partial('emailError'));
  			$this->redirect("@rfq?category={$this->cat_slug}");
  		} else {
  			// save form values to restore
  			$this->getUser()->setAttribute('rfq_form_values', $request->getPostParameters());
  			$this->getUser()->setFlash('rfq_notice', get_partial('formError', array('errors' => $this->_errors)));
  		}
  	}
		$this->partial = ($this->cat_slug == 'electrical-transformers') ? 'ElectricalTransformers' : 'Other';
		$this->getResponse()->setSlot('body_id', str_replace('-', '_', $this->cat_slug));
  	return sfView::SUCCESS;
  }
  
}
