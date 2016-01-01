<?php

/**
 * toolkit actions.
 *
 * @package    lws
 * @subpackage toolkit
 * @author     Morgan Ney <morganney@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class toolkitActions extends sfActions
{
	protected $_valid_PDFs; // prevents serving of arbitrary system files
	protected $_pdf_directory;
	protected $_categories;
	
	public function __construct($context, $moduleName, $actionName) {
		parent::__construct($context, $moduleName, $actionName);
		$this->_pdf_directory = sfConfig::get('sf_root_dir'). DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR . 'article' . DIRECTORY_SEPARATOR;
		$this->_valid_PDFs = array(
			'livewire-supply-makes-vision-of-a-wired-distribution-industry-a-reality'
		);
	}
	
	protected function getDefaultWeight($cat_id) {
		switch($cat_id) {
			case 'cb' : $w = 10;
				break;
			case 'tr' : $w = 100;
				break;
			case 'bu' : $w = 5;
				break;
			case 'fu' : $w = 1;
				break;
			case 'mc' : $w = 5;
				break;
			default: $w = 5;
				break;
		}
		return $w;
	}
	
  protected function isValidPDF($filename) {
  	return in_array($filename, $this->_valid_PDFs);
  }
  
  protected function getSearchRoutesClass($num_routes) {
  	if($num_routes > intval(sfConfig::get('app_search_max_routes_md'))) {
  		$search_routes_class = ' large';
  	} else if($num_routes > intval(sfConfig::get('app_search_max_routes_sm'))) {
  		$search_routes_class = ' medium';
  	} else {
  		$search_routes_class = '';
  	}
  	return $search_routes_class;
  }
  
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }
  
  /**
   * Method for executing the search engine action.
   * Will redirect to the product landing page if exact math is found.
   * Otherwise, will display paginated list of similar parts if found, or
   * a message stating nothing was found similar to the users query.
   * @param sfWebRequest $request
   */
  public function executeSearch(sfWebRequest $request) {
  	// look into PHP buffering to facilitate with GATC setting before redirecting to exact match
  	$this->getResponse()->setSlot('body_class','search');
  	$this->query = trim($request->getParameter('q'));
  	if(!in_array($this->query, sfConfig::get('app_search_default_queries'))) {
  		$SA = new SearchAgent($this->query);
  		// if exact match is found redirect to the part's route
  		if($route = $SA->search()) $this->redirect($route);
  		else { // otherwise, see if similar parts exist for the user's query
  			if($this->similar_parts = $SA->getSimilarParts()) {
	  			$this->count = $this->similar_parts[0]['count'];
	  			$this->search_routes = $SA->getSearchRoutes();
	  			$this->search_routes_class = $this->getSearchRoutesClass(count($this->search_routes));
	  			$this->num_serps = $this->count <= sfConfig::get('app_search_pagination_max_items') ? 1 : ceil($this->count / sfConfig::get('app_search_pagination_max_items'));
	  			$item_count = count($this->similar_parts);
	  			$rem = $item_count % 2 == 0 ? 2 : 1;
	  			$this->bottom_idx = $item_count - $rem;
	  			$this->getResponse()->setTitle("Product Search: '{$this->query}'");
	  			return sfView::SUCCESS;
  			} else {
  				// there is nothing in the database like the user's query
  				$this->getResponse()->setTitle("Product Search: '{$this->query}'");
  				return sfView::ALERT;
  			}
  		}
  	} else  {
  		// user didn't enter anything into search box
  		$this->getResponse()->setTitle('Product Search: Missing Query Parameter');
  		return sfView::ALERT;
  	}
  }
  
  public function executeSearchPagination(sfWebRequest $request) {
  	$this->query = LWS::unencode(trim($request->getParameter('query'), '"'));
  	$this->page_num = LWS::extractPaginationNum($request->getParameter('page_num'));
  	$SA = new SearchAgent($this->query);
  	$this->data_set = $SA->getNextDataSet($this->page_num);
  	$this->forward404Unless($this->data_set); // Stop URL parameter surfing
  	$this->search_routes = $SA->getSearchRoutes();
  	$this->search_routes_class = $this->getSearchRoutesClass(count($this->search_routes));
	  $item_count = count($this->data_set);
	  $rem = $item_count % 2 == 0 ? 2 : 1;
	  $this->bottom_idx = $item_count - $rem;
  	$this->count = $this->data_set[0]['count'];
  	$this->num_serps = ceil($this->count / sfConfig::get('app_search_pagination_max_items'));
  	$this->getResponse()->setSlot('body_class','search');
  	$this->getResponse()->setTitle("Product Search: '{$this->query}' page {$this->page_num}");
  	return sfView::SUCCESS;
  }
  
  public function executeShippingOptions(sfWebRequest $request) {
  	$this->getResponse()->setTitle('Shipping Options - ' . sfConfig::get('app_biz_name'));
  	$this->getResponse()->setSlot('body_id','shipping');
  	return sfView::SUCCESS;
  }
  
  public function executeCertifiedGreen(sfWebRequest $request) {
  	$this->getResponse()->setSlot('body_id','cert_green');
  	$this->getResponse()->setTitle('Buy Certified Green - ' . sfConfig::get('app_biz_name'));
  	return sfView::SUCCESS;
  }
  
  public function executeWarranty(sfWebRequest $request) {
  	$this->getResponse()->setTitle('Returns & Warranty - ' . sfConfig::get('app_biz_name'));
  	$this->getResponse()->setSlot('body_id','warranty');
  	return sfView::SUCCESS;
  }
  
  public function executeArticle(sfWebRequest $request) {
  	$article = new Article();
  	$this->article = $article->fetchByTitleSlug($request->getParameter('title_slug'));
  	$this->forward404Unless($this->article);
  	$this->getResponse()->setTitle($this->article['title']);
  	$this->getResponse()->setSlot('body_id', 'article');
  	return sfView::SUCCESS;
  }
  
  /**
   * Method to serve pdf articles through controller/action rather than
   * through a subdirectory of web/
   * 
   * @param sfWebRequest $request The current client request object
   */
  public function executeArticlePDF(sfWebRequest $request) {
  	$this->setLayout(false);
  	$filename = $request->getParameter('title_slug');
  	$pdf_path = $this->_pdf_directory . $filename . '.pdf';
  	$this->forward404Unless($this->isValidPDF($filename) && file_exists($pdf_path));
  	$response = $this->getResponse();
  	$response->clearHttpHeaders();
  	$response->setContentType('application/pdf');
  	$response->sendHttpHeaders();
  	$response->setContent(readfile($pdf_path));
  	$response->sendContent();
		return sfView::HEADER_ONLY;
  }
  
  public function executeCanonicalNews(sfWebRequest $request) {
  	// redirect http://livewiresupply.com/news-and-articles/ back to the
  	// same default article linked to by the route @news_awards
  	$this->redirect('@news_awards', 301);
  }

  public function executeOurCustomers(sfWebRequest $request) {
  	$this->getResponse()->setSlot('body_id','our_customers');
  	$this->getResponse()->setTitle('Our Customers - ' .sfConfig::get('app_biz_name'));
  	return sfView::SUCCESS;
  }
  
  public function executeCustomerProfile(sfWebRequest $request) {
		$profile = new Profile();
		$this->profile = $profile->fetchByNameSlug($request->getParameter('name_slug'));
		$this->forward404Unless($this->profile);
		$this->getResponse()->setTitle(sfConfig::get('app_biz_name') . ' Customer Profile - ' . $this->profile['customer_name']);
  	return sfView::SUCCESS;
  }
  
  public function executePagination(sfWebRequest $request) {
  	// eliminated category route to prevent dup. content issues on page-1
  	$manuf_slug = $request->getParameter('manuf_slug');
  	$this->param = array();
  	$this->param['cat_id'] = LWS::getCategoryPk($request->getParameter('cat_slug'));
  	$this->param['manuf'] = LWS::unslugify($manuf_slug, true);
  	$this->param['category'] = LWS::getCategoryName($request->getParameter('cat_slug'));
  	$this->param['current_page_num'] = LWS::extractPaginationNum($request->getParameter('page_num'));
  	$category = CategoryFactory::make(array('cat_id' => $this->param['cat_id'], 'list_decorator_type' => 'basic'));
  	$this->param['parts'] = $category->fetchPartsListByManuf(LWS::getManufPk($manuf_slug), $this->param['current_page_num']);
  	$this->forward404Unless($this->param['parts']);
		$this->param['part_count'] = $this->param['parts'][0]['part_count'];
		$this->param['next_page_num'] = $this->param['current_page_num'] + 1;
		$this->param['total_pages'] = ceil($this->param['part_count'] / intval(sfConfig::get('app_pagination_items_limit', 100)));
		$estimate = number_format(intval(sfConfig::get('app_pagination_items_limit')) * $this->param['total_pages']);
		if($this->param['part_count'] <= 50) {
			$meta_estimate = "Thousands of {$this->param['category']} are available from our online catalogs.";
		} else {
			$meta_estimate = "Over $estimate {$this->param['manuf']} {$this->param['category']} available online.";
		}
		$prefix = $this->param['current_page_num'] > 1 ? "Page {$this->param['current_page_num']} of {$this->param['total_pages']} : " : '';
		$response = $this->getResponse();
		$response->setSlot('body_id', str_replace('-', '_', $request->getParameter('cat_slug')));
		$response->setSlot('body_class','pagination');
		$response->addMeta('description', "{$this->param['manuf']} {$this->param['category']} Catalog - Page {$this->param['current_page_num']} of {$this->param['total_pages']}. $meta_estimate");
  	$response->setTitle("{$prefix}{$this->param['manuf']} {$this->param['category']} Catalog - " . sfConfig::get('app_biz_name'));
  	return sfView::SUCCESS;
  }
  
  public function executeSubpagination(sfWebRequest $request) {
  	// eliminated subcategory route to prevent dup. content issues on page-1
  	$manuf_slug = $request->getParameter('manuf_slug');
  	$this->param = array();
  	$this->param['cat_id'] = LWS::getCategoryPk($request->getParameter('cat_slug'));
  	$this->param['manuf'] = LWS::unslugify($manuf_slug, true);
  	$this->param['category'] = LWS::getCategoryName($request->getParameter('cat_slug'));
  	$this->param['subcategory'] = LWS::unslugify($request->getParameter('subcat_slug'));
  	$this->param['section'] = LWS::getSectionName($this->param['subcategory'], $request->getParameter('section'));
  	$this->param['current_page_num'] = LWS::extractPaginationNum($request->getParameter('page_num'));
  	$category = CategoryFactory::make(array('cat_id' => $this->param['cat_id'], 'list_decorator_type' => 'basic'));
  	$this->param['parts'] = $category->fetchSubcatListByManuf(LWS::getManufPk($manuf_slug), $this->param['section'], $this->param['current_page_num']);
  	$this->forward404Unless($this->param['parts']);
		$this->param['part_count'] = $this->param['parts'][0]['part_count'];
		$this->param['next_page_num'] = $this->param['current_page_num'] + 1;
		$this->param['total_pages'] = ceil($this->param['part_count'] / intval(sfConfig::get('app_pagination_items_limit', 100)));
		$prefix = $this->param['current_page_num'] > 1 ? "Page {$this->param['current_page_num']} of {$this->param['total_pages']} : " : '';
		$response = $this->getResponse();
		$response->setSlot('body_id', str_replace('-', '_', $request->getParameter('cat_slug')));
		$response->setSlot('body_class','pagination');
		$response->addMeta('description', "{$this->param['manuf']} {$this->param['category']} {$this->param['section']} {$this->param['subcategory']} Catalog - $prefix");
  	$response->setTitle("{$prefix}{$this->param['section']} {$this->param['subcategory']} - {$this->param['manuf']} {$this->param['category']} - " . sfConfig::get('app_biz_name'));
  	return sfView::SUCCESS;
  }
  
  public function executeDataError(sfWebRequest $request) {
  	echo $request->getParameter('data_error');
  	return sfView::NONE;
  }
  /**
   * 
   * Retrieves part information using appropriate DAO object for each parts landing page.
   * 
   * IMPORTANT:  Since adding the use of sessions to manage the transformer selection tool
   * 						 voltage swap, I can no longer cache this entire template with layout, but
   * 						 instead only parts of the template.  THIS SUCKS!  Seriously consider refactoring
   * 						 our DB to avoid any sort of hack due to bad planning, or find a hack without
   * 					   using sessions but instead query parameters.
   * @param sfWebRequest $request
   */
  public function executePart(sfWebRequest $request) {
  	$cat_slug = $request->getParameter('cat_slug');
  	$cat_id = LWS::getCategoryPk($cat_slug);
  	$part_no = LWS::unencode($request->getParameter('part_no'));
  	$part = PartFactory::make(array('cat_id' => $cat_id, 'part_no' => $part_no));
  	$this->param = array();
  	$this->param['cat_id'] = $cat_id;
  	$this->param['part'] = $part->getDetails();
  	// If I opt to move this whole piece of TR logic to TRPart by passing in the sfUser object
  	// Then I'd have to update the constructor for all DAO's to include an optional construction
  	// parameter. Unless I can get it from within the TRPart.
  	if($cat_id == 'tr' && (str_replace('/frontend_dev.php','', parse_url($request->getReferer(), PHP_URL_PATH)) == '/electrical-transformers/select')) {
  		/*
  		 * See if user has stored voltages in session (they should unless an error occured).
  		 * Use these instead of DB values since the selection tool allows for reversing 
  		 * input/output voltages.
  		 */
  		if($this->getUser()->hasAttribute('tr_volt_order')) {
  			// session value has form [chosen input]:[chosen output]
  			$volts = explode(':', $this->getUser()->getAttribute('tr_volt_order'));
  			//print_r($volts); die();
  			// Remember that TRPart (and all Part DAO's) uses an Alias to store field values
  			$this->param['part']['Primary Voltage'] = $volts[0];
  			$this->param['part']['Secondary Voltage'] = $volts[1];
  			// removing these does not allow the user to move back and forth in the selection tool
  			//$this->getUser()->getAttributeHolder()->remove('tr_volt_order');
  		}
  	}
  	/*
  	 * Two options for dealing with lowercase part numbers in URLs:
  	 * A:  Just throw a 404 for these requests
  	 * B:  Show the page, but use a <link> canonical tag
  	 */
  	$this->forward404Unless($part_no == strtoupper($part_no)); // Option A
  	/* B:
  	if($part_no != strtoupper($part_no)) {
  		$pn = $request->getParameter('part_no');
  		$url = str_replace($pn, strtoupper($pn), $request->getUri());
  		$this->getResponse()->setSlot('links', "<link rel='canonical' href='{$url}' />");
  	}
  	*/
  	$this->forward404Unless($this->param['part']);
  	$this->param['part']['part_no'] = $part_no;
  	$this->param['part']['db_fields'] = $part->getDbFields();
  	$this->param['h1Txt'] = $part->getH1Txt();
  	$this->param['store'] = $part->getPricing();
  	$this->param['category'] = LWS::getCategoryName($cat_slug);
  	$this->param['manuf_route'] = $cat_id . '_manuf';
  	/*
  	 * doing this for now since changing the route's name would involve updating more files
  	 * this is necessary because at some point adam wanted to change 'transformers'
  	 * to 'electrical-transformers'.  should clean it up later to remove this conditional statement.
  	 */
  	$this->param['cat_route'] = str_replace('-', '_', $cat_slug);
  	$this->param['meta_keywords'] = $part->getMetaKeywords();
  	$this->param['shipping_needed'] = (($this->param['store'] != 'emptyStore') && ($cat_id == 'cb')) ? true : false;
  	$response = $this->getResponse();
    $response->setSlot('body_class', 'part');
    $response->setSlot('body_id', str_replace('-', '_', $cat_slug));
  	$response->setTitle($part->getPageTitle());
  	return sfView::SUCCESS;
  }
  
  /**
   * Method for retrieving UPS shipping rates via UPS Webservice API.
   * Currently only being used by Circuit Breakers, and all rate 
   * requests use the following rules/assumptions:
   * A. No more than 1 package will ship
   * B. That package weighs 1LB, irrespective of quantity (NS default item weight)
   * C. Orders >= $250 have FREE Ground Shipping
   * @param sfWebRequest $request
   */
  public function executeUpsRate(sfWebRequest $request) {
  	$this->setLayout(false);
  	$this->getResponse()->addCacheControlHttpHeader('no-cache, must-revalidate');
  	$this->getResponse()->setHttpHeader('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');
  	$this->getResponse()->setContentType('application/json');
  	$this->getResponse()->sendHttpHeaders();
  	$client = new UPSRateClient($request->getParameter('zip'), $request->getParameter('ship_qty'));
  	$client->queryUPS();
  	if($client->hasError()) {
  		return $this->renderText(json_encode(array('ups_error' => $client->getError())));
  	} else {
  		return $this->renderText(json_encode($client->getRates()));
  	}
  }
  
  public function executeTellFriend(sfWebRequest $request) {
  	if($request->isXmlHttpRequest()) {
  		$this->setLayout(false);
  		//sfProjectConfiguration::getActive()->loadHelpers('Partial');
  		$this->getResponse()->addCacheControlHttpHeader('no-cache');
  		$this->getResponse()->setContentType('text/html');
  		$this->getResponse()->sendHttpHeaders();
  		// Build email message
  		$m_to = ucfirst(rawurldecode($request->getParameter('f_name')));
  		$m_from = ucfirst(rawurldecode($request->getParameter('s_name')));
  		$url = rawurldecode($request->getParameter('part_url'));
  		$part_no = rawurldecode($request->getParameter('part_no'));
  		$to_email = rawurldecode($request->getParameter('f_email'));
  		$manuf = rawurldecode($request->getParameter('manuf'));
  		$subject = "{$manuf} {$part_no} at LiveWire Supply";
  		$to = "{$m_to} <{$to_email}>";
  		$from = $m_from . '<' . rawurldecode($request->getParameter('s_email')) . '>';
  		// NOTE: Qmail replaces LF(\n) with CRLF(\r\n), so only use LF in headers. Not all MUA's can correct the extra line break so headers appear in body of email when full CRLF is used.
  		$headers = "Content-type: text/html; charset=iso-8859-1\nFrom: {$from}\nReply-To: {$from}\n";
  		if($request->getParameter('cc_sender', NULL)) $headers .= "Cc: {$from} \n";
  		$message  = "Dear {$m_to}, <br /><br />";
  		$message .= "I was looking at the <strong>{$manuf} {$part_no}</strong> on the <a href='{$url}'>LiveWire Supply</a> website and thought you might like to know about this part. ";
  		$message .= 'The price is good and they can ship it right away!<br /><br />';
  		$message .= "To look at the product details, visit: <a href='{$url}'>{$url}</a><br /><br />";
  		$message .= 'or <em>Call one of their Electrical Supply Experts</em>: <strong>800-390-3299</strong> <br /><br />';
  		$message .= 'Best Regards, <br /><br />';
  		$message .= "{$m_from} <br /><br />";
  		$message  = wordwrap($message, 90);
  		// Attempt to send email message
  		if( @mail($to, $subject, $message, $headers) ) $text = "An email was sent to {$m_to} at {$to_email}.";
  		else $text = "Sorry, an error occured.  The email was not sent to {$m_to} at {$to_email}.";
  		return $this->renderText($text);
  	} else return sfView::SUCCESS;
  }
  
  /**
   * Method used to dynamically generate thumbnails for pagination lists.
   * Currently not in use since all thumbnails are stored on disk now.
   * Below is the old markup used in _basicListDisplay template that calls this action:
   * (to reuse this, modify the method to check for the disk on file first, then create 
   * thumbnail if necessary)
   * <div class='l'>
			<table>
				<tr><td><?php echo image_tag(url_for("@thumbs?img_file={$part['img_file']}&sf_format={$part['img_mime']}"), array('alt' => "{$part['part_no']}")) ?></td></tr>
			</table>
		</div>
   * @param sfWebRequest $request
   */
  public function executeThumbs(sfWebRequest $request) {
  	// NOTE: All images are now files on disk (6/15/2010)
  	$this->setLayout(false);
  	$response = $this->getResponse();
  	$response->clearHttpHeaders();
  	$etag = '"' . md5($request->getParameter('img_file'))  . '"';
  	$response->setHttpHeader('Etag', $etag);
		if($request->getHttpHeader('IF_NONE_MATCH') == $etag) {
			$response->setStatusCode(304, 'Not Modified');
		} else {
			// GD library uses jpeg not jpg.
			$mime_type = $request->getParameter('sf_format') == 'jpg' ? 'jpeg' : $request->getParameter('sf_format');
			$response->setContentType("image/{$mime_type}");
			$response->sendHttpHeaders();
	  	$thumb = new Thumbnail($request->getParameter('img_file'), $mime_type);
	  	try {
	  		if($binary = $thumb->generate()) {
	  			$response->setContent($binary);
	  		} else {
	  			$response->setContentType('image/png');
	  			$response->setContent(readfile(sfConfig::get('app_thumbs_dir') . 'default-trans.png'));
	  		}
	  	} catch (GDErrorException $gde) {
	  		$response->setContentType('image/png');
	  		$response->setContent(readfile(sfConfig::get('app_thumbs_dir') . 'default-trans.png'));
	  	}
	  	$thumb->freeMemoryResources();
	  	$response->sendHttpHeaders();
	  	$response->sendContent();
		}
    return sfView::HEADER_ONLY;
  }
  
  public function executeTesting(sfWebRequest $request) {
		sfProjectConfiguration::getActive()->loadHelpers('Partial');
    ini_set('display_errors', 1);
    set_time_limit(0);
    error_reporting(E_ALL | E_STRICT);
    $this->setLayout(false);
		$this->_p = array(
			  'access_key' 		=> 'BC645952EAC4DB68',
			  'user_id'			=> 'morganney',
			  'password'		=> 'lw@235!',
			  'shipper_zip'		=> '94080',
			  'shipto_zip'	=> '48103',
			  'ups_account_no'	=> '',
				'pkg_qty'					=>	1,
				'pkg_weight'			=>	1,
			  'request_option'	=> 'Shop', // 'Shop' returns all available services for origin/destination addresses
			  'service_code'	=> '03' // Only used if request_option is changed to 'Rate'
		 );
		 
     if(($ch = curl_init('https://onlinetools.ups.com/ups.app/xml/Rate')) == FALSE) die('hmmm');
     //curl_setopt($ch, CURLOPT_URL, 'https://wwwcie.ups.com/ups.app/xml/Rate');
     curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
     curl_setopt($ch, CURLOPT_HEADER, FALSE);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
     curl_setopt($ch, CURLOPT_TIMEOUT, 60);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
     //curl_setopt($ch, CURLOPT_CAINFO, '/etc/pki/tls/certs/AkamaiSubordinateCA3.crt');
     curl_setopt($ch, CURLOPT_POST, TRUE);
     curl_setopt($ch, CURLOPT_POSTFIELDS, get_partial('upsRateRequestDebugging', array('p' => $this->_p)));
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
     $response = curl_exec($ch);
     if($response === FALSE || !$response) {
        $fh = fopen(sfConfig::get('sf_web_dir') . '/debug.txt','w');
        fwrite($fh, curl_errno($ch) . " : " . curl_error($ch) . "\n");
        foreach(curl_getinfo($ch) as $desc => $info) fwrite($fh, "{$desc} ==> {$info}\n");
        $this->getResponse()->setContentType('text/html');
        die('dead : ' . curl_errno($ch) . " : " . curl_error($ch) . "<br />" . curl_getinfo($ch,CURLINFO_HTTP_CODE));
     } else {
        $fh = fopen(sfConfig::get('sf_web_dir') . '/debug.txt','w');
        foreach(curl_getinfo($ch) as $desc => $info) fwrite($fh, "{$desc} ==> {$info}\n");
        $this->getResponse()->setContentType('text/xml');
     }
     curl_close($ch);
     return $this->renderText($response);
  }
  
  public function executeNojavascript(sfWebRequest $request) {
  	return sfView::SUCCESS;
  }
  
 public function executeFaqs(sfWebRequest $request)
  {
    $this->getResponse()->setTitle('Frequently Asked Questions - ' . sfConfig::get('app_biz_name'));
    $this->getResponse()->setSlot('body_id', 'lws_faq');
    return sfView::SUCCESS;
  }
  
  public function executePlayground(sfWebRequest $request) {
  	
  	return sfView::SUCCESS;
  }
  
  public function executeStopGaTracking(sfWebRequest $request) {
  	$this->setLayout('stopGaTrackingLayout');
  	return sfView::SUCCESS;
  }
  
  public function executePhpInfo(sfWebRequest $request) {
  	$this->setLayout(false);
  	return $this->renderText(phpinfo());
  }
  
  public function executeLiveSearch(sfWebRequest $request) {
  	$query = $request->getParameter('q');
  	$sa = new SearchAgent($query);
  	if(strlen($query) < 3) {
  		$html = $sa->liveSearchLocate();
  	} else {
  		$html = $sa->liveSearchLike();
  	}
 		sfProjectConfiguration::getActive()->loadHelpers('Partial');
   	$this->setLayout(false);
   	//$html = get_partial($partial, array($data_type => $this->serps));
  	$response = $this->getResponse();
 		$response->addCacheControlHttpHeader('no-cache');
  	$response->setContentType('text/html');
  	$response->sendHttpHeaders();
  	return $this->renderText($html);
  }
}
