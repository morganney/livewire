<?php

	class TRCategory extends DAO {
		protected $_specs_preview_fields;
		protected $_list_display_decorator;
		protected $_subcat_strategy;
		protected $_id;
		
		public function __construct($list_decorator_type = NULL) {
			parent::__construct();
			$this->_id = 'tr';
			$this->_specs_preview_fields = array('kva', 'weight');
			$this->_subcat_strategy = NULL; // not all methods require a strategy
			try {// ListDisplayDecoratorFactory will throw an exception if created object is not an instance of iListDisplayDecorator
				$this->_list_display_decorator = ListDisplayDecoratorFactory::make(array('type' => $list_decorator_type, 'specs_preview_fields' => $this->_specs_preview_fields));
			} catch (Exception $e) {die($e->getMessage());}
		}
		
		public function setSubcatStrategy(iSubcatStrategy $strategy_object) {
			$this->_subcat_strategy = $strategy_object;
		}
		
		public function getSpecsPreviewFields() {
			return $this->_specs_preview_fields;
		}
		
		/**
		 * Method for retrieving transformers parts details for a particular manufacturer
		 * on pagination lists.  SQL contains logic necessary to return seo-optimized result 
		 * set based on LiveWire Supply business model.
		 * @param Integer $manuf_id
		 * @param Integer $page_num, of the pagination. always >= 1.
		 */
		public function fetchPartsListByManuf($manuf_id, $page_num) {
			list($limit, $offset, $specs_preview_sql) = $this->buildSQLVars($page_num);
			$this->query(
				"SELECT part_no, {$specs_preview_sql}, manuf, img, ns_new_id, ns_green_id, display, (
				 	SELECT count(*) 
				 	FROM part 
				 	WHERE cat_id='{$this->_id}' AND manuf_id={$manuf_id} 
				 ) AS part_count, IF(ISNULL(img), 0, 1) AS has_img
				 FROM part INNER JOIN manufacturer USING(manuf_id) LEFT JOIN store USING(part_no)   
				 WHERE cat_id='{$this->_id}' AND manuf_id={$manuf_id} 
				 ORDER BY display DESC, has_img DESC, kva ASC, part_no ASC 
				 LIMIT {$offset}, {$limit}"
			);
			if($this->queryOK()) {
				$parts = array();
				while($row = $this->next()) {
					foreach($row as $k => $v) {
						$part[$k] = $v;
						if($k == 'weight') $part[$k] .= ' LBS';
					}
					$parts[] = $this->extendPartData($part);
				}
				$this->notifyObserver('default');
				return $parts;
			} else return NULL;
			
		}
		
		/**
		 * Method for retrieving and processing subcategory pagination sets.
		 * Returns an associative array of a processed set of subcategory records.
		 * Of course the records returned depend upon the current scheme used for
		 * creating transformers subcategories.
		 * 
		 * @param Integer $manuf_id, the primary key from a record in the 'manufacturer' table.
		 * @param String $section, the section being paginated for the current subcategory.
		 * @param Integer $page_num, the current pagination number.
		 */
		public function fetchSubcatListByManuf($manuf_id, $section, $page_num) {
			list($limit, $offset, $specs_preview_sql) = $this->buildSQLVars($page_num);
			$this->query(
				"SELECT part_no, {$specs_preview_sql}, manuf, img, ns_new_id, ns_green_id, display, (
				 	SELECT count(*) 
				 	FROM part 
				 	WHERE cat_id='{$this->_id}' AND manuf_id={$manuf_id} AND kva={$section} 
				 ) AS part_count 
				 FROM part INNER JOIN manufacturer USING(manuf_id) LEFT JOIN store USING(part_no)   
				 WHERE cat_id='{$this->_id}' AND manuf_id={$manuf_id} AND kva={$section}   
				 ORDER BY display DESC, part_no ASC, {$specs_preview_sql} DESC
				 LIMIT {$offset}, {$limit}"
			);
			if($this->queryOK()) {
				$parts = array();
				while($row = $this->next()) {
					foreach($row as $k => $v) {
						$part[$k] = $v;
						if($k == 'weight') $part[$k] .= ' LBS';
					}
					$parts[] = $this->extendPartData($part);
				}
				$this->notifyObserver('default');
				return $parts;
			} else return NULL;
		}
		
		/**
		 * Method for executing transformers subcategory creation logic.
		 * Method may use a Strategy object if logic becomes sufficiently complex.
		 * !!!	_manufLevelSidebar global template expects each array in $sections
		 * !!!	to have the following elements:
		 * !!!	section, section_slug, & count
		 * Possible fields for subcategorization:
		 *   grp, & frame_type
		 * Currently only using grp for a subcategory.
		 * @param Integer $manuf_id
		 */
		public function fetchSectionsByManuf($manuf_id) {
			// added 'LEFT JOIN store USING(part_no) &&& display > 0 to limit results: 10/1/2010
			// remove them if necessary
			$this->query(
				"SELECT count(*) AS count, TRIM(TRAILING '.00' FROM kva) AS kva_t
				 FROM part LEFT JOIN store USING(part_no)
				 WHERE cat_id = '{$this->_id}' AND manuf_id={$manuf_id} AND kva > 0 
				 GROUP BY kva 
				 HAVING count(*) > 4 
				 ORDER BY kva ASC 
				"
			);
			if(!($this->_subcat_strategy instanceof iSubcatStrategy)) {
				// subcategorization logic can be handled without a strategy
				if($this->queryOK()) {
					$sections = array();
					while($row = $this->next()) {
						$sections[] = array(
							'section'			 => "{$row['kva_t']} kVA",
							'section_slug' => $row['kva_t'],
							'count'				 => $row['count']
						);
					}
					/*
					 * No point in having subcategory pagination if there is only 1 section.
					 * It will just be a duplicate of the catalog.
					 */
					if(count($sections) == 1) $sections = NULL;
				} else $sections = NULL;
			} else $sections = $this->_subcat_strategy->createSections($this);
			$this->notifyObserver('default');
			return $sections;
		}
		
		/**
		 * Method for fetching the featured transformer parts for a given manufacturer.
		 * @param Integer $manuf_id, the primary key of some manufacturer.
		 */
		public function fetchFeaturedParts($manuf_id) {
			$this->query(
				"SELECT part_no, img, display, ns_new_id, ns_green_id 
				 FROM part 
				 LEFT JOIN store USING (part_no) 
				 WHERE is_featured > 0 AND manuf_id={$manuf_id} AND cat_id = '{$this->_id}'     
				 ORDER BY is_featured DESC, display DESC, part_no ASC  
				 LIMIT 6
				"
			);
			if($this->queryOK()) {
				$featured_parts = array();
				while($row = $this->next()) {
					$img_src = is_null($row['img']) ? sfConfig::get('app_thumbs_dir') . 'default.png'
																					: sfConfig::get('app_thumbs_dir') . strtolower(LWS::encode($row['part_no'])) . '.jpg';
					$featured_parts[] = array(
						'part_no'			=>	$row['part_no'],
						'img_src'			=>	$img_src,
						'display'			=> 	$row['display'],
						'ns_new_id'		=>	$row['ns_new_id'],
						'ns_green_id'	=>	$row['ns_green_id']
					);
				}
			} else {
				// there are no featured parts for this category/manuf combination.
				// we are missing data somewhere, so for now just make something up.
				$featured_parts = NULL;
			}
			return $featured_parts;
		}
		
			public function fetchManufList($manuf_id) {
				$this->query("
				SELECT manuf, manuf_slug
				FROM cat_manuf_map
				INNER JOIN manufacturer
				USING ( manuf_id )
				WHERE cat_id = 'tr'
				AND manuf_id <>{$manuf_id}
				ORDER BY manuf ASC
				");
				
				if($this->queryOK()) {
					$data = array();
					while($row = $this->next()) {
						$row['route'] = "@cb_manuf?manuf_slug={$row['manuf_slug']}";
						$data[] = $row;
					}
					return $data;
				} else {
					return NULL;
				}
		
		}		
		
		
		/**
		 * Extends the transformers parts array for a given manufacturer by adding
		 * fields useful for processing by the corresponding view (pagination list).
		 * 
		 * @param Mixed Array $parts, passed by reference
		 */
		protected function extendPartData($part = array()) {
				$part['encoded_part_no'] = LWS::encode($part['part_no']);
				$part['img'] = is_null($part['img']) ? sfConfig::get('app_thumbs_dir') . 'default.png'
																						 : sfConfig::get('app_thumbs_dir') . strtolower($part['encoded_part_no']) . '.jpg';
				// could just load $part['layout'] with calls to partials from here, 
				// but wanted to decouple logic from this class in case I bypass the php include
				// mechanism in favor of generating the HTML 'layout' snippet as a PHP string
				// variable. (Less overhead with php string variable, maybe ??)
				$this->_list_display_decorator->buildDisplay($part, $this->_specs_preview_fields);
				return $part;
		}
		
		/**
		 * Responsible for building necessary SQL variables for transformers
		 * category based on current business logic and/or website
		 * structure and applications.
		 * 
		 * Currently returns pagination values to support SQL LIMIT statement,
		 * and an SQL snippet to retrieve the categories current preview fields
		 * on pagination lists.
		 */
		protected function buildSQLVars($page_num) {
			$limit = sfConfig::get('app_pagination_items_limit');
			$offset = ($page_num - 1) * $limit;
			$sql_snippet = '';
			foreach($this->_specs_preview_fields as $field) $sql_snippet .= "{$field},";
			$sql_snippet = substr($sql_snippet, 0, -1); // remove the last ',' comma
			return array($limit, $offset, $sql_snippet);
		}
	}
	
