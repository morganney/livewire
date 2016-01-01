<?php

/**
 * medium_voltage actions.
 *
 * @package    lws
 * @subpackage medium_voltage
 * @author     Morgan Ney <morganney@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class medium_voltageActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$response = $this->getResponse();
    $response->setSlot('body_id','medium_voltage');
    //$response->setSlot('body_class','category');
    $response->setTitle('Medium Voltage Equipment - ' . sfConfig::get('app_biz_name'));
    return sfView::SUCCESS;
  }
}
