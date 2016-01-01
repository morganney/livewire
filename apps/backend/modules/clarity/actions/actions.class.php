<?php

/**
 * clarity actions.
 *
 * @package    lws
 * @subpackage clarity
 * @author     Morgan Ney <morganney@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class clarityActions extends sfActions
{
 /**
  * Executes method for Control Panel.
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
  	$sess = $this->getUser();
  	if($sess->hasAttribute('be_user')) {
  		$this->user = $sess->getAttribute('be_user');
  		return sfView::SUCCESS;
  	} else return sfView::ERROR;
  }
  
  public function executeFind(sfWebRequest $request) {
  	
  	$dao = new BE_DAO();
  	$part_no = trim(strtoupper($request->getParameter('q')));
  	if($dao->find($part_no)) {
  		$this->redirect("@view?part_no={$part_no}");
  	} else if($dao->hasSimilarFinds()) {
  		$this->similar_finds = $dao->getSimilarFinds();
  		return sfView::SUCCESS;
  	} else {
  		return sfView::ALERT;
  	}
  }
  
  public function executeView(sfWebRequest $request) {
  	$dao = new BE_DAO();
  	$part_no = $request->getParameter('part_no');
  	$dao->query("SELECT part.*, display  FROM part LEFT JOIN store USING(part_no) WHERE part_no='{$part_no}'");
  	$this->forward404Unless($dao->queryOK());
  	$this->part = $dao->next();
  	if($this->part['img']) {
  		$this->part['img_src'] = 'http://livewiresupply.com/images/parts/' . LWS::encode(strtolower($this->part['part_no'])) . '.jpg';
  	} else $this->part['img_src'] = 'http://livewiresupply.com/images/parts/default.png';
  	return sfView::SUCCESS;
  }
  
  public function executePriceUpdate(sfWebRequest $request) {
  	if($request->isMethod('POST')) {
	  	$display = $request->getPostParameter('display');
	  	$part_no = $request->getPostParameter('part_no');
	  	$dao = new BE_DAO();
	  	$dao->query("UPDATE store set display={$display} WHERE part_no='{$part_no}'");
	  	if($dao->UpdateOK()) {
	  		$cp_msg = "{$part_no} pricing has been updated successfully.";
	  	} else {
	  		$err = $dao->getError();
	  		$cp_msg = "There was an error trying to update the price for {$part_no}.<br />MySQL Error: {$err}";
	  	}
	  	$this->getUser()->setFlash('cp_msg', $cp_msg);
	  	$this->redirect('@control_panel');
  	}
  	return sfView::NONE;
  }
  
  public function executeNoJSMsg(sfWebRequest $request) {
  	return sfView::SUCCESS;
  }
  
  public function executeTesting(sfWebRequest $request) {
  	$this->setLayout(false);
  	return sfView::SUCCESS;
  }
  
}
