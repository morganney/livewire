<?php

/**
 * fuses actions.
 *
 * @package    lws
 * @subpackage fuses
 * @author     Morgan Ney <morganney@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class fusesActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $response = $this->getResponse();
    $response->addMeta('description', "LiveWire is the Internet's #1 supplier for new or certified green Fuses. We offer a full 1-year warranty and discounted shipping options with quick turnaround.");
    $response->setTitle('Fuses - ' . sfConfig::get('app_biz_name'));
    $response->setSlot('body_id','fuses');
    $response->setSlot('body_class', 'category');
  }
  
  public function executeManuf(sfWebRequest $request) {
  	$this->param = array();
  	$this->param['category'] = 'Fuses';
  	$this->param['cat_slug'] = 'fuses';
  	$this->param['manuf_slug'] = $this->getRequestParameter('manuf_slug');
  	$this->param['manuf_id'] = LWS::getManufPk($this->param['manuf_slug']);
  	$this->param['manuf'] = LWS::unslugify($this->param['manuf_slug'], true);
  	$this->param['subnav_grouping'] = intval(sfConfig::get('app_cb_max_subcat_grouping'));
  	$this->param['subcategory'] = 'Classes/Types';
  	$this->param['subcat_slug'] = 'class-type'; // should be overwritten for each section
		$category = new FUCategory();
  	$this->param['manuf_list'] = $category->fetchManufList($this->param['manuf_id']);
  	$this->param['manuf_list_class'] = 'bottom'; 		
  	$this->param['sections'] = $category->fetchSectionsByManuf(LWS::getManufPk($this->param['manuf_slug']));
  	if(!$this->param['sections']) {
  		// do something as a backup indexing/flattening strategy if DAO returned NULL
  		$this->param['subnav_count'] = 0; // no subnav for sections of subcategory
  	} else if(count($this->param['sections']) > $this->param['subnav_grouping']) {
  		$this->param['subnav_count'] = ceil(sizeof($this->param['sections']) / $this->param['subnav_grouping']);
  		// just experimenting with various ways to control the subnav grouping etc.
  		// so far it is too much work for the results.  only edge cases matter so far.
			/*$xtra = count($this->param['sections']) - intval(sfConfig::get('app_subnav_grouping_top'));
  		$mids = ceil($xtra / intval(sfConfig::get('app_subnav_grouping_middle')));
  		$rem = $xtra % intval(sfConfig::get('app_subnav_grouping_middle'));
  		$lows = ceil($rem / intval(sfConfig::get('app_subnav_grouping_bottom')));
  		$this->param['subnav_count'] = $mids + $lows;*/
  	} else $this->param['subnav_count'] = 1;
  	$this->featured_parts = $category->fetchFeaturedParts($this->param['manuf_id']);
  	// count number of cycle images for this manufacturer
  	$cycle_img_dir = sfConfig::get('sf_web_dir') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'cycle' . DIRECTORY_SEPARATOR . $this->param['cat_slug'] . DIRECTORY_SEPARATOR . $this->param['manuf_slug'] . DIRECTORY_SEPARATOR;
  	$this->param['manuf_box_class'] = '_' . count(glob('' . $cycle_img_dir . '*.png'));
  	if(!$this->featured_parts) {
  		// what to do if there are no featured parts found. we are missing data.
  		
  	}
  	$response = $this->getResponse();
  	$response->addMeta('description', "LiveWire Supply is the Internet's #1 Supplier for {$this->param['manuf']} Fuses. We have a massive selection and shipping points across the country.");
  	$response->setSlot('body_class','fu_manuf');
  	$response->setSlot('body_id',$this->param['manuf_slug']);
  	$response->setTitle("{$this->param['manuf']} Fuses - " . sfConfig::get('app_biz_name'));
  	return sfView::SUCCESS;
  }
  
}
