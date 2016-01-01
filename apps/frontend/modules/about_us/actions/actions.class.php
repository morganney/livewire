<?php

/**
 * about_us actions.
 *
 * @package    lws
 * @subpackage about_us
 * @author     Morgan Ney <morganney@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class about_usActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$response = $this->getResponse();
    $response->setTitle('About Us - ' . sfConfig::get('app_biz_name'));
    $response->setSlot('body_id', 'about_us');
    $response->addMeta('description', "LiveWire Supply was founded in 2005 by Adam Messner. By practicing the core values of innovation and environmental responsibility LiveWire has grown dramatically since 2005 becoming the Internet's #1 electrical supply house. Every day thousands of wholesale suppliers, contractors, industrial end-users and homeowners rely on LiveWire Supply to deliver the electrical parts they need at rock-bottom prices.");
    return sfView::SUCCESS;
  }
}
