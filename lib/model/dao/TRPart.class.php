<?php
	/**
	 * Class for Transformer part. Primary responsiblity is to allow
	 * dynamic determiniation of what relevant fields to display on a product
	 * landing page based on the category of part. Responsible for building
	 * relevant SQL for this category of part. This class is meant to
	 * be instantiated by a factory class called PartFactory.
	 * 
	 * @author Morgan Ney <morganney@gmail.com>
	 * @see Part.class.php
	 * @see PartFactory.class.php
	 */
	class TRPart extends Part {
		
		public function __construct($part_no) {
			parent::__construct(
				$part_no,
				array(
					'KVA' 							=> 'kva',
					'Weight' 						=> 'weight',
					'Primary Voltage'	 	=> 'input_volts',
					'Secondary Voltage'	=> 'output_volts'
				)
			);
			
			$this->_details = $this->fetchDetails();
			$this->setPricing($this->_details['display']);
		}
		
		/**
		 * Method to retrieve part details from the database. Part
		 * manufacturer is being appended by the calling action (available
		 * via a route parameter) to minimize table joins in the SQL.
		 */
		protected function fetchDetails() {
			$relevant_fields_aliased = $this->getSQLSnippet();
			$this->query(
				"SELECT {$relevant_fields_aliased} specs, weight, img, manuf, manuf_slug, website, ns_new_id, ns_green_id, display, CONCAT('ATTACHMENTS/', subdir, '/', filename) AS catalog_uri 
				 FROM part INNER JOIN manufacturer USING(manuf_id) LEFT JOIN tr_meta USING(part_no) LEFT JOIN store USING(part_no) LEFT JOIN catalog USING(catalog_id) 
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
			return "{$this->_part_no} {$sep} {$this->_details['manuf']} {$sep} Electrical Transformer | {$branding}";
		}
		
		/**
		 * Method to return text for <h1> tag on parts landing page 
		 * PRECONDITION: $this->fetchDetails() must be called first.
		 */
		public function getH1Txt() {
			$sep = sfConfig::get('app_seo_word_sep_h1');
			$cat_crumb = link_to('Electrical Transformers', '@electrical_transformers');
			// No Manuf-level landing page for 'Rebuilt' manufacturer, so don't link to one
			if($this->_details['manuf_slug'] == 'rebuilt') $manuf_crumb = $this->_details['manuf'];
			else $manuf_crumb = link_to($this->_details['manuf'], "@tr_manuf?manuf_slug={$this->_details['manuf_slug']}");
			return "<strong>{$this->_part_no}</strong> {$sep} {$cat_crumb} {$sep} {$manuf_crumb}";
		}
		
		public function getMetaKeywords() {
			return 'transformers,buck-boost transformers,power distribution transformers,new transformers,acme power solutions,control power transformers,primary and secondary fuse clips,wall mount,floor mount,potted transformers,silicon filled transformers';
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
	