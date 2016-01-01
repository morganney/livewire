<?php

/**
 * circuit_breakers actions.
 *
 * @package    lws
 * @subpackage circuit_breakers
 * @author     Morgan Ney <morganney@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class circuit_breakersActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$response = $this->getResponse();
  	$response->addMeta('description', "LiveWire is the Internet's #1 supplier for new or certified green Circuit Breakers. We offer a full 1-year warranty and discounted shipping options with quick turnaround.");
    $response->setSlot('body_id','circuit_breakers');
    $response->setSlot('body_class','category');
    $response->setTitle('Circuit Breakers - ' . sfConfig::get('app_biz_name'));
    return sfView::SUCCESS;
  }
  
  /**
   * Method to prepare circuit breaker tool selection process for a
   * particular manufacturer.  
   * @param sfWebRequest $request
   */
  public function executeManuf(sfWebRequest $request) {
  	$this->param = array();
  	$this->param['category'] = 'Circuit Breakers';
  	$this->param['cat_slug'] = 'circuit-breakers';
  	$this->param['manuf_slug'] = $this->getRequestParameter('manuf_slug');
  	$this->param['manuf_id'] = LWS::getManufPk($this->param['manuf_slug']);
  	$this->param['manuf'] = LWS::unslugify($this->param['manuf_slug'], true);
  	$this->param['subnav_grouping'] = intval(sfConfig::get('app_cb_max_subcat_grouping'));
  	$this->param['subcategory'] = 'Frame Types';
  	$this->param['subcat_slug'] = 'frame-types';

  	
		$category = new CBCategory();		
  	$category->setSubcatStrategy(new FrameTypeSubcategory());
  	$this->param['manuf_list'] = $category->fetchManufList($this->param['manuf_id']);
  	$this->param['manuf_list_class'] = 'top';
  	$this->param['sections'] = $category->fetchSectionsByManuf(LWS::getManufPk($this->param['manuf_slug']));
  	if(!$this->param['sections']) {
  		// do something as a backup indexing/flattening strategy if DAO returned NULL
  		// besides throwing a 404!
  		$this->param['subnav_count'] = 0; // no subnav for sections of subcategory
  	} else if(sizeof($this->param['sections']) > $this->param['subnav_grouping']) {
  		$this->param['subnav_count'] = ceil(sizeof($this->param['sections']) / $this->param['subnav_grouping']);
  	} else $this->param['subnav_count'] = 1;
  	$landing_data = $category->fetchManufLandingData($this->param['manuf_id']);
  	if($landing_data) {
  		// filter featured parts vs. frame types
  		$this->featured_parts = isset($landing_data['featured_parts']) ? $landing_data['featured_parts'] : NULL;
  		$this->frame_types = $landing_data['frame_types'];
  		
  	} else {
  		// need backup plan
  		
  	}
  	// count number of cycle images for this manufacturer
  	$cycle_img_dir = sfConfig::get('sf_web_dir') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'cycle' . DIRECTORY_SEPARATOR . $this->param['cat_slug'] . DIRECTORY_SEPARATOR . $this->param['manuf_slug'] . DIRECTORY_SEPARATOR;
  	$this->param['manuf_box_class'] = '_' . count(glob('' . $cycle_img_dir . '*.png'));
  	$response = $this->getResponse();
  	$response->addMeta('description', "LiveWire Supply is the Internet's #1 Supplier for {$this->param['manuf']} Circuit Breakers. We have a massive selection and shipping points across the country.");
  	$response->setSlot('body_class','cb_manuf');
  	$response->setSlot('body_id',$this->param['manuf_slug']);
  	$response->setTitle("{$this->param['manuf']} Circuit Breakers - " . sfConfig::get('app_biz_name'));
  	return sfView::SUCCESS;
  }
  
  public function executeSelect(sfWebRequest $request) {
    if($request->isXmlHttpRequest()) {
    	// steps 1-3 requests & restart
    	$this->setLayout(false);
    	sfProjectConfiguration::getActive()->loadHelpers('Partial');
  		$agent = new CircuitBreakerSelectionAgent($request->getGetParameters());
  		if($data = $agent->executeStep()) {
		  	$partial = 'filter' . ucfirst($request->getParameter('step')) . 'Step';
		  	$html = get_partial(
		  		$partial,
		  		array(
		  			'selection' 			=> $request->getParameter($request->getParameter('step'), NULL),
		  			'back_qs'					=> $data['back_qs'],
		  			'data'						=> $data['data'],
		  			'results_so_far'	=> $data['results_so_far'],
		  			'search_params'		=> $agent->getSearchParameters()
		  		)
		  	);
  		} else {
  			/*
  			 * Would only get here if LWS DB is incomplete.
  			 * In this case we need to use the query string to retrieve the relevant
  			 * data set from teh DB and then fill in the missing values.
  			 * 
  			 * Do not throw 404 from Ajax request, 
  			 * just send error messgae back to user.
  			 * 
  			 * !! I should log the query string in these cases to facilitate
  			 * updating of DB.
  			 */
  			$html = "<p id='tech_prob'>Sorry, we our experiencing technical difficulties. Please contact technical support at <a href='mailto:webmaster@livewiresupply.com'>webmaster@livewiresupply.com</a></p>";
  		}
  		$response = $this->getResponse();
  		$response->addCacheControlHttpHeader('no-cache');
  		$response->setContentType('text/html');
  		$response->sendHttpHeaders();
  		return $this->renderText($html);
  	} else {
  		// ONLY FOR VOLTS/LAST STEP, or graceful degradation for non JavaScript enabled browsers
  		$this->manuf_slug = LWS::getManufSlug($request->getParameter('manuf_id'));
  		$this->manuf = LWS::unslugify($this->manuf_slug, true);
  		$template = 'Filter' . ucfirst($request->getParameter('step')) . 'Step';
 			$this->selection = $request->getParameter($request->getParameter('step'));
			$agent = new CircuitBreakerSelectionAgent($request->getGetParameters());
			/*
			 * $agent would not return data only if LWS DB is incomplete.
			 * Sequence of steps dictate that once LWS DB is complete,
			 * server should throw a 404.  User may have be url surfing.
			 * 
			 * !!! be sure to update DB if necessary.
			 */
			$this->forward404Unless($this->data = $agent->executeStep());
  		if($request->getParameter('step') == 'volts') {
				$this->redirect("@part?cat_slug=circuit-breakers&manuf_slug={$this->manuf_slug}&part_no=" . LWS::encode($this->data[0]['part']['part_no']));
			} else {
				// remove unecessary ajax 'back a step' query string from end of data array
				unset($this->data['back_qs']);
				$this->results_so_far = $this->data['results_so_far'];
				$this->data = $this->data['data'];
				$this->search_params = $agent->getSearchParameters();
				$response = $this->getResponse();
				$response->setTitle("{$this->manuf} Circuit Breakers Selection Process");
				$response->setSlot('body_class','cb_manuf');
				return $template;
			}
  	}
  }
  
}
