<?php

/**
 * contact_us actions.
 *
 * @package    lws
 * @subpackage contact_us
 * @author     Morgan Ney <morganney@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class contact_usActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$response = $this->getResponse();
    $response->setSlot('body_id','contact');
    $response->setTitle('Contact Us - ' . sfConfig::get('app_biz_name'));
    $response->addMeta('description', "Our normal business hours are 6:30am &mdash 4:30pm (PST), but a sales representative is available 24 hours a day, 7 days a week at 1-800-390-3299. Quotes and credit applications are available upon request, or by visiting our websites quotes page.");
    return sfView::SUCCESS;
  }
}
