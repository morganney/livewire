<?php

/**
 * home actions.
 *
 * @package    lws
 * @subpackage home
 * @author     Morgan Ney <morganney@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$this->setLayout('homeLayout');
  	$this->getResponse()->setSlot('body_id','home');
  	$this->getResponse()->setTitle('Circuit Breakers, Transformers, Fuses - ' . sfConfig::get('app_biz_name'));
  	return sfView::SUCCESS;
  }
}
