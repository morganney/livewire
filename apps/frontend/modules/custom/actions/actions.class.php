<?php

/**
 * custom actions.
 *
 * @package    lws
 * @subpackage custom
 * @author     Morgan Ney <morganney@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class customActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }
  
  public function executeNotFound(sfWebRequest $request) {
  	$this->getResponse()->setSlot('body_id', '_404');
  	return sfView::SUCCESS;
  }
}
