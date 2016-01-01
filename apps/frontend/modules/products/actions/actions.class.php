<?php

/**
 * products actions.
 *
 * @package    lws
 * @subpackage products
 * @author     Morgan Ney <morganney@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$response = $this->getResponse();
  	$response->addMeta('description', "Massive inventory of electrical supplies including Circuit Breakers and Transformers from brand names like Cutler Hammer, Eaton, GE, Siemens, Acme, and Square D.");
    $response->setTitle('Our Products - ' . sfConfig::get('app_biz_name'));
    return sfView::SUCCESS;
  }
}
