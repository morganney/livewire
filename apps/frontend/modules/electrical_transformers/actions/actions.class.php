<?php

/**
 * transformers actions.
 *
 * @package    lws
 * @subpackage transformers
 * @author     Morgan Ney <morganney@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class electrical_transformersActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $response = $this->getResponse();
    $response->addMeta('description', "LiveWire is the Internet's #1 supplier for new or certified green Electrical Transformers. We offer a full 1-year warranty and discounted shipping options with quick turnaround.");
    $response->setTitle('Electrical Transformers - ' . sfConfig::get('app_biz_name'));
    $response->setSlot('body_id','electrical_transformers');
    $response->setSlot('body_class','category');
    return sfView::SUCCESS;
  }
  
  public function executeManuf(sfWebRequest $request) {
  	$this->param = array();
  	$this->param['category'] = 'Electrical Transformers';
  	$this->param['cat_slug'] = 'electrical-transformers';
  	$this->param['manuf_slug'] = $this->getRequestParameter('manuf_slug');
  	$this->param['manuf_id'] = LWS::getManufPk($this->param['manuf_slug']);
  	
  	// No manuf-level page for 'Rebuilt' manufacturer
  	$this->forward404If($this->param['manuf_id'] == 23);
  	
  	$this->param['manuf'] = LWS::unslugify($this->param['manuf_slug'], true);
  	$this->param['subnav_grouping'] = intval(sfConfig::get('app_subnav_grouping_max'));
  	$this->param['subcategory'] = 'KVA Ratings';
  	$this->param['subcat_slug'] = 'kva-rating';
		$category = new TRCategory();
		$this->param['manuf_list'] = $category->fetchManufList($this->param['manuf_id']);
  	$this->param['manuf_list_class'] = 'bottom';
		$this->param['sections'] = $category->fetchSectionsByManuf(LWS::getManufPk($this->param['manuf_slug']));
  	if(!$this->param['sections']) {
  		// do something as a backup indexing/flattening strategy if DAO returned NULL
  		$this->param['subnav_count'] = 0; // no subnav for sections of subcategory
  	} else if(sizeof($this->param['sections']) > $this->param['subnav_grouping']) {
  		$this->param['subnav_count'] = ceil(sizeof($this->param['sections']) / $this->param['subnav_grouping']);
  	} else $this->param['subnav_count'] = 1;
  	$this->featured_parts = $category->fetchFeaturedParts($this->param['manuf_id']);
  	// count number of cycle images for this manufacturer
  	$cycle_img_dir = sfConfig::get('sf_web_dir') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'cycle' . DIRECTORY_SEPARATOR . 'electrical-transformers' . DIRECTORY_SEPARATOR . $this->param['manuf_slug'] . DIRECTORY_SEPARATOR;
  	$this->param['manuf_box_class'] = '_' . count(glob('' . $cycle_img_dir . '*.png'));
  	$response = $this->getResponse();
  	$response->addMeta('description', "LiveWire Supply is the Internet's #1 Supplier for {$this->param['manuf']} Electrical Transformers. We have a massive selection and shipping points across the country.");
  	$response->setSlot('body_class','tr_manuf');
  	$response->setSlot('body_id',$this->param['manuf_slug']);
  	$response->setTitle("{$this->param['manuf']} Transformers - " . sfConfig::get('app_biz_name'));
  	return sfView::SUCCESS;
  }
  
  public function executeSelect(sfWebRequest $request) {
  	if($request->isXmlHttpRequest()) {
  		sfProjectConfiguration::getActive()->loadHelpers('Partial');
  	  $this->setLayout(false);
  	  $response = $this->getResponse();
 			$response->addCacheControlHttpHeader('no-cache');
  		$response->setContentType('text/html');
  		$response->sendHttpHeaders();
  		// might have to pass sfUser instance to TSA here
  		$agent = new TransformerSelectionAgent($request->getGetParameters());
  		if($data = $agent->executeStep()) {
  			$partial = 'filter' . ucfirst($request->getParameter('step')) . 'Step';
  			$html = get_partial(
  				$partial,
  				array(
  					'selection'	=> $request->getParameter($request->getParameter('step')),
  					'data'			=> $data,
  					'back_qs'		=> $agent->getBackQs()
  				)
  			);
  		} else {
  			// Must be nothing in the DB.  This should not occur unless we goofed.
  			$html = "<p id='tech_prob'>Sorry, we our experiencing technical difficulties. Please contact technical support at <a href='mailto:webmaster@livewiresupply.com'>webmaster@livewiresupply.com</a></p>";
  		}
  		return $this->renderText($html);
  		
  	} else {
  		// graceful degradation block for non JS users
  		$response = $this->getResponse();
  		$response->setTitle('Electrical Transformers Selection Tool - ' . sfConfig::get('app_biz_name'));
  		$response->setSlot('body_id', 'tr_select');
			if($request->getParameter('step', NULL)) {
				/*
				 * User has started making selections.
				 * GET parameter 'step' always refers to the previous step for the current request.
				 * FilerOutputStep is simply the landing page results
				 */
				$step = $request->getParameter('step');
				$template = 'Filter' . ucfirst($step) . 'Step';
				$this->selection = $request->getParameter($step);
				if($step == 'output') {
					/*
					 * Both voltage values must be present, so ...
					 * Store the selected order of voltage selections in user session. This will allow
					 * the script rendering the landing page to determine what order to display the
					 * voltages since it cannot be determined from a DB query using part no. only. (As of 12/3/2010)
					 * 
					 * NOTE: removed _volts from query parameters in selection tool
					 */
					$iv = rawurldecode($request->getParameter('input'));
					$ov = rawurldecode($request->getParameter('output'));
					$d_kva = $request->getParameter('kva');
					$d_phase = $request->getParameter('phase');
					$this->getUser()->setAttribute('tr_volt_order', "{$iv}:{$ov}");
					$response->setSlot('body_class', 'results');
					$response->addMeta('description', "LiveWire's Electrical Transformer Tool Results: KVA = {$d_kva}, Phase = {$d_phase}, Input Volts = {$iv}, Output Volts = {$ov}");
				}
				$agent = new TransformerSelectionAgent($request->getGetParameters());
				if($this->data = $agent->executeStep()) {
					$this->found_new = false;
					$this->found_rebuilt = false;
					$this->img_src = sfConfig::get('app_parts_img_dir') . 'default.png';
					// search for any available image in any of the returned parts
					foreach($this->data as $idx => $arr) {
						if(!empty($arr['part']['img'])) $this->img_src = sfConfig::get('app_parts_img_dir') . strtolower(LWS::encode($arr['part']['part_no'])) . '.jpg';
						/*
						 * LWS business model dictates that ONLY 1 refurbished transformer will be
						 * returned for any combination of selection values. Per adam, 8/19/2010.
						 */ 
						// clean this up by removing the rebuilt part data into its own data structure
						if(isset($arr['part']) && $arr['part']['manuf_slug'] == 'rebuilt') {
							$this->found_rebuilt = true;
							$this->rebuilt_idx = $idx;
						} else $this->found_new = true;
					}
					return $template;
				}
				else {
					/**
					 * I get here only if there is some sort of MySQL Error for the current step, 
					 * OR the current step returned an empty result set for the users current selections.
					 * Based on our database, and the SQL queries a user should never get here because
					 * of an empty result set.  So maybe put a 'technical difficulties' message here 
					 * or something...
					 */
					//return sfView::ERROR;
					$this->forward404();
				}
			} else {
				// user has made no selections and is on step 1
				$response->addMeta('description', "Easily find your Electrical Transformer with LiveWire Supply's Transformer tool. Enter KVA, Phase, Primary and Secondary Voltages. 800-390-3299");
				return sfView::SUCCESS;
			}
  	}
  	
  }
  
}
