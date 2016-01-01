<?php

/**
 * motor_control actions.
 *
 * @package    lws
 * @subpackage motor_control
 * @author     Morgan Ney <morganney@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class motor_controlActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$response = $this->getResponse();
  	$response->addMeta('description', "LiveWire is the Internet's #1 supplier for new or certified green Motor Controls. We offer a full 1-year warranty and discounted shipping options with quick turnaround.");
    $response->setSlot('body_id','motor_control');
    $response->setSlot('body_class','category');
    $response->setTitle('Motor Control - ' . sfConfig::get('app_biz_name'));
  }
  
  public function executeManuf(sfWebRequest $request) {
  	$this->param = array();
  	$this->param['category'] = 'Motor Control';
  	$this->param['cat_slug'] = 'motor-control';
  	$this->param['manuf_slug'] = $this->getRequestParameter('manuf_slug');
  	$this->param['manuf_id'] = LWS::getManufPk($this->param['manuf_slug']);
  	$this->param['manuf'] = LWS::unslugify($this->param['manuf_slug'], true);
  	$this->param['subnav_grouping'] = intval(sfConfig::get('app_subnav_grouping_max'));
  	$this->param['subcategory'] = NULL;
  	$this->param['subcat_slug'] = NULL;
	  $category = new MCCategory();
  	$this->param['manuf_list'] = $category->fetchManufList($this->param['manuf_id']);
  	$this->param['manuf_list_class'] = 'bottom';	  
  	$this->param['sections'] = NULL; //$category->fetchSectionsByManuf(LWS::getManufPk($this->param['manuf_slug']));
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
  	$response = $this->getResponse();
  	$response->addMeta('description', "LiveWire Supply is the Internet's #1 Supplier for {$this->param['manuf']} Motor Controls. We have a massive selection and shipping points across the country.");
  	$response->setSlot('body_class','mc_manuf');
  	$response->setSlot('body_id', $this->param['manuf_slug']);
  	$response->setTitle("{$this->param['manuf']} Motor Control - " . sfConfig::get('app_biz_name'));
  	return sfView::SUCCESS;
  }
  
}
