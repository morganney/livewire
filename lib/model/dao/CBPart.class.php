<?php
	/**
	 * Class for Circuit Breaker part. Primary responsiblity is to allow
	 * dynamic determiniation of what relevant fields to display on a product
	 * landing page based on the category of part. Responsible for building
	 * relevant SQL for this category of part. This class is meant to
	 * be instantiated by a factory class called PartFactory.
	 * 
	 * @author Morgan Ney <morganney@gmail.com>
	 * @see Part.class.php
	 * @see PartFactory.class.php
	 */
	class CBPart extends Part {
		
		public function __construct($part_no) {
			parent::__construct(
				$part_no,
				array(
					'Connection' => 'conn',
					'Frame Type' => 'frame_type',
					'Amperage'	 =>	'amps',
					'Poles'			 => 'poles',
					'Voltage'		 => 'volts'
				)
			);
			
			$this->_details = $this->fetchDetails();
			$this->setPricing($this->_details['display']);
		}
		
		/**
		 * Method to retrieve part details from the database.
		 */
		protected function fetchDetails() {
			$relevant_fields_aliased = $this->getSQLSnippet();
			$this->query(
				"SELECT {$relevant_fields_aliased} specs, weight, img, manuf, manuf_slug, website, ns_new_id, ns_green_id, display, CONCAT('ATTACHMENTS/', subdir, '/', filename) AS catalog_uri 
				 FROM part INNER JOIN manufacturer USING(manuf_id) LEFT JOIN store USING(part_no) LEFT JOIN catalog USING(catalog_id) 
				 WHERE part_no='{$this->_part_no}' 
				 LIMIT 1
				"
			);
			if($this->queryOK()) {
				$this->notifyObserver('default');
				return $this->decorate($this->next());
			} else return NULL;
		}
		
		/**
		 * Method to return page title for this part back to calling action.
		 * PRECONDITION: $this->fetchDetails() must be called first.
		 */
		public function getPageTitle() {
			$sep = sfConfig::get('app_seo_word_sep_title');
			$branding = sfConfig::get('app_biz_name');
			return "{$this->_part_no} {$sep} Circuit Breaker {$sep} {$this->_details['manuf']} | {$branding}";
		}
		
		/**
		 * Method to return text for <h1> tag on parts landing page 
		 * PRECONDITION: $this->fetchDetails() must be called first.
		 */
		public function getH1Txt() {
			$sep = sfConfig::get('app_seo_word_sep_h1');
			$cat_crumb = link_to('Circuit Breaker', '@circuit_breakers');
			$manuf_crumb = link_to($this->_details['manuf'], "@cb_manuf?manuf_slug={$this->_details['manuf_slug']}");
			return "<strong>{$this->_part_no}</strong> {$sep} {$cat_crumb} {$sep} {$manuf_crumb}";
		}
		
		public function getMetaKeywords() {
			return 'circuit breakers,breakers,breaker,circuit breaker,shunt trip,bell alarms,breaker accessories,UVR lugs,trip units,rating plugs,mounting hardware,rebuilt';
		}
		
		/**
		 * Method for editing/extending portions of a parts data.
		 * 
		 * @param Array $part
		 */
		private function decorate($part) {
			// assign proper src attributre for part image
			$part['img'] = is_null($part['img']) ? sfConfig::get('app_parts_img_dir') . 'default.png'
			 																		 : sfConfig::get('app_parts_img_dir') . strtolower(LWS::encode($this->_part_no)) . '.jpg';
			return $part;
		}
		
	}
	