<?php

/**
 * busway actions.
 *
 * @package    lws
 * @subpackage busway
 * @author     Morgan Ney <morganney@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class buswayActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$response = $this->getResponse();
  	$response->addMeta('description', "LiveWire is the Internet's #1 supplier for new or certified green Busway systems. We offer a full 1-year warranty and discounted shipping options with quick turnaround.");
    $response->setSlot('body_id','busway');
    $response->setSlot('body_class','category');
    $response->setTitle('Busway - ' . sfConfig::get('app_biz_name'));
    return sfView::SUCCESS;
  }

  public function executeManuf(sfWebRequest $request) {
  	$this->param = array();
  	$this->param['category'] = 'Busway';
  	$this->param['cat_slug'] = 'busway';
  	$this->param['manuf_slug'] = $this->getRequestParameter('manuf_slug');
  	$this->param['manuf_id'] = LWS::getManufPk($this->param['manuf_slug']);
  	$this->param['manuf'] = LWS::unslugify($this->param['manuf_slug'], true);
  	$this->param['subnav_grouping'] = intval(sfConfig::get('app_cb_max_subcat_grouping'));
  	$this->param['subcategory'] = 'Busway Components';
  	$this->param['subcat_slug'] = 'component';
		$category = new BUCategory();
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
  	$cycle_img_dir = sfConfig::get('sf_web_dir') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'cycle' . DIRECTORY_SEPARATOR . $this->param['cat_slug'] . DIRECTORY_SEPARATOR . $this->param['manuf_slug'] . DIRECTORY_SEPARATOR;
  	$this->param['manuf_box_class'] = '_' . count(glob('' . $cycle_img_dir . '*.png'));
  	
		// start preload logic
		$num_cycle_imgs = count(glob('' . $cycle_img_dir . '*.png'));
		$this->param['cycle_imgs'] = array();
		for($i = 0; $i < $num_cycle_imgs; $i++) {
			$this->param['cycle_imgs'][] = "/images/cycle/busway/{$this->param['manuf_slug']}/cycle-{$i}-trans.png";
		}
		// end preload logic
		
		$response = $this->getResponse();
		$response->addMeta('description', "LiveWire Supply is the Internet's #1 Supplier for {$this->param['manuf']} Busway. We have a massive selection and shipping points across the country.");
  	$response->setSlot('body_class','bu_manuf');
  	$response->setSlot('body_id',$this->param['manuf_slug']);
  	$response->setTitle("{$this->param['manuf']} Busway - " . sfConfig::get('app_biz_name'));
  	return sfView::SUCCESS;
  }
  
  /**
   * Ajax method. Returns JSON data.
   * @param sfWebRequest $request
   */
  public function executeSelect(sfWebRequest $request) {
  	$this->getResponse()->addCacheControlHttpHeader('no-cache');
  	$this->getResponse()->setContentType('application/json');
  	$this->getResponse()->sendHttpHeaders();
  	$group = $request->getParameter('group');
  	$type = $request->getParameter('type');
  	$amps = $request->getParameter('amps');
		$choices_made = array();
		if(intval($group) != -1) $choices_made['grp'] = $group;
		if(intval($type) != -1) $choices_made['frame_type'] = $type;
		if(intval($amps) != -1) $choices_made['amps'] = $amps;
  	$manuf_id = intval($request->getParameter('manuf_id'));
  	$category = new BUCategory();
  	$dependent_dropdowns = $category->fetchSelectionCriteriaByManuf($manuf_id, $choices_made);
  	$matching_parts = $category->fetchMatchingParts($manuf_id, $choices_made);
  	$json_data = json_encode(array_merge($dependent_dropdowns, $matching_parts));
  	return $this->renderText($json_data);
  }
  
}
