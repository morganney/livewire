<?php

/**
 * login actions.
 *
 * @package    lws
 * @subpackage login
 * @author     Morgan Ney <morganney@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class loginActions extends sfActions
{
 /**
  * Performs the logic for logging into the LWS backend CMS.
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$this->setLayout('login'); 
  	if($request->isMethod('POST')) {
  		$dao = new DAO();
  		$pw = md5($dao->getEscapedSQLString(trim($request->getPostParameter('pw'))));
  		$email = $dao->getEscapedSQLString(trim(strtolower($request->getPostParameter('email'))));
  		$dao->query("
  			SELECT be_user.*, role 
  			FROM be_user INNER JOIN be_role USING(role_id) 
  			WHERE email='{$email}' AND password='{$pw}' LIMIT 1
  		");
  		if($dao->queryOK()) {
  			$user = $dao->next();
				$dao->query("SELECT last_login_ts FROM be_user WHERE email='{$user['email']}'");
  			// I know that there is a record in the DB with this email, so no need to check
  			$ts_row = $dao->next();
  			$last_login = is_null($ts_row['last_login_ts']) ? 'N/A' : date('M jS Y @ g:i A', $ts_row['last_login_ts']);
  			$dao->query("UPDATE be_user SET last_login_ts=UNIX_TIMESTAMP() WHERE email='{$user['email']}'");
  			$this->getUser()->setAttribute(
  				'be_user', 
  				array(
  					'first_name' 	=> $user['first_name'],
  					'last_name'		=> $user['last_name'],
  					'full_name'		=> "{$user['first_name']} {$user['last_name']}", 
  					'email'				=> $user['email'],
  					'role' 				=> $user['role'],
  					'phone'				=> $user['phone'],
  					'phone_ext'		=> $user['phone_ext'],
  					'last_login'	=> $last_login,
  					'password'		=> $user['password']
  				)
  			);
  			$this->getUser()->setAuthenticated(true);
  			$this->getUser()->addCredential($user['role']);
  		} else {
  			if($this->getUser()->hasAttribute('be_user')) $this->getUser()->getAttributeHolder()->remove('be_user');
  			$this->getUser()->setAuthenticated(false);
  			$this->getUser()->setFlash('login_error', 'Invalid email and/or password!');
  		}
			// allows users to go directly to requested page after login
  		$uri = $this->getContext()->getRouting()->getCurrentInternalUri(true);
  		$this->redirect($uri);
  	}
    return sfView::SUCCESS;
  }
  
  public function executeLogout(sfWebRequest $request) {
  	$sess = $this->getUser();
  	$sess->setAuthenticated(false);
  	$sess->getAttributeHolder()->clear();
  	$sess->setFlash('login_error', 'Goodbye!');
  	$this->redirect('@control_panel');
  }
}
