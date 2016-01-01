<?php

/**
 * ajax actions.
 *
 * @package    lws
 * @subpackage ajax
 * @author     Morgan Ney <morganney@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ajaxActions extends sfActions
{
	/**
	 * Handles disabling of Layout and browser aggressive caching for all
	 * actions.  Delays setting of Content-type header, and sending of
	 * HTTP headers to allow for variable content types in actions.
	 */
	public function preExecute() {
		if($this->getRequest()->isXmlHttpRequest()) {
			$this->setLayout(false);
	 		$this->getResponse()->addCacheControlHttpHeader('no-cache');
		} else return sfView::NONE;
	}
	
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    return sfView::NONE;
  }
  
  public function executeNsPrice(sfWebRequest $request) {
  	$part_no = rawurldecode($request->getParameter('part_no'));
  	$agent = new CCSearchAgent($part_no);
  	if($data = $agent->fetchStorePricing()) $json = json_encode($data);
  	else $json = NULL;
  	$response = $this->getResponse();
  	$response->setContentType('application/json');
  	$response->sendHttpHeaders();
  	return $this->renderText($json);
  }
  
  public function executeUpdatePassword(sfWebRequest $request) {
  	$form = $request->getPostParameters();
  	if(md5($form['cpw']) == $form['user_pw']) {
  		$dao = new DAO();
  		$dao->query("UPDATE be_user SET password=MD5('{$form['npw']}') WHERE email='{$form['user_email']}'");
  		if($dao->updateOK()) $html = 'Your password has been changed successfully.';
  		else {
  			$err = $dao->getError();
  			$html = "Your password has not been changed.<br />$err";
  		}
  	} else $html = 'Your supplied current password is invalid.  Your password was not changed.';
  	$response = $this->getResponse();
  	$response->setContentType('text/html');
  	$response->sendHttpHeaders();
  	return $this->renderText($html);
  }
  
  public function executePurchaseHistory(sfWebRequest $request) {
  	$part_no = rawurldecode($request->getParameter('part_no'));
  	$agent = new CCSearchAgent($part_no);
  	if($data = $agent->fetchPurchaseHistory()) $json = json_encode($data);
  	else $json = NULL;
  	
  	//TODO: ajax helper for this block? 
  	$response = $this->getResponse();
  	$response->setContentType('application/json');
  	$response->sendHttpHeaders();  	
  	return $this->renderText($json);	
  }
}
