<?php

	class BUCategory extends DAO {
		protected $_specs_preview_fields;
		protected $_list_display_decorator;
		protected $_subcat_strategy;
		protected $_id;
		
		public function __construct($list_decorator_type = NULL) {
			parent::__construct();
			$this->_id = 'bu';
			$this->_specs_preview_fields = array('grp', 'amps', 'frame_type');
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
		 * Method for retrieving busway parts details for a particular manufacturer
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
				 ORDER BY display DESC, has_img DESC, part_no ASC, {$specs_preview_sql} ASC 
				 LIMIT {$offset}, {$limit}"
			);
			if($this->queryOK()) {
				$parts = array();
				while($row = $this->next()) {
					foreach($row as $k => $v) {
						$part[$k] = $v;
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
		 * creating busway subcategories.
		 * 
		 * @param Integer $manuf_id, the primary key from a record in the 'manufacturer' table.
		 * @param String $section, the section being paginated for the current subcategory.
		 * @param Integer $page_num, the current pagination number.
		 */
		public function fetchSubcatListByManuf($manuf_id, $section, $page_num) {
			$sql_snippet = $section == 'Other' ? 'grp IS NULL ' : "grp = '{$section}' ";
			list($limit, $offset, $specs_preview_sql) = $this->buildSQLVars($page_num);
			$this->query(
				"SELECT part_no, {$specs_preview_sql}, manuf, img, ns_new_id, ns_green_id, display, (
				 	SELECT count(*) 
				 	FROM part 
				 	WHERE cat_id='{$this->_id}' AND manuf_id={$manuf_id} AND {$sql_snippet} 
				 ) AS part_count 
				 FROM part INNER JOIN manufacturer USING(manuf_id) LEFT JOIN store USING(part_no)   
				 WHERE cat_id='{$this->_id}' AND manuf_id={$manuf_id} AND {$sql_snippet}  
				 ORDER BY display DESC, part_no ASC, {$specs_preview_sql} ASC
				 LIMIT {$offset}, {$limit}"
			);
			if($this->queryOK()) {
				$parts = array();
				while($row = $this->next()) {
					foreach($row as $k => $v) {
						$part[$k] = $v;
					}
					$parts[] = $this->extendPartData($part);
				}
				$this->notifyObserver('default');
				return $parts;
			} else return NULL;
		}
		
		/**
		 * Method for executing busway subcategory creation logic.
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
			$this->query(
				"SELECT grp, count(part_no) AS count
				 FROM part
				 WHERE cat_id = '{$this->_id}' AND manuf_id={$manuf_id} 
				 GROUP BY grp
				 ORDER BY count(part_no) DESC
				"
			);
			if(!($this->_subcat_strategy instanceof iSubcatStrategy)) {
				// subcategorization logic can be handled without a strategy
				if($this->queryOK()) {
					$sections = array();
					$other = array();
					$has_other = false;
					while($row = $this->next()) {
						if(is_null($row['grp'])) {
							$other['section'] = 'Other';
							$other['section_slug'] = 'other';
							$other['count'] = $row['count'];
							$has_other = true;
							continue;
						} else {
							$sections[] = array(
								'section' 		 => $row['grp'],
								'section_slug' => LWS::slugify($row['grp']),
								'count'  			 => $row['count']
							);
						}
					}
					if($has_other) $sections[] = $other;
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
		
		public function fetchSelectionCriteriaByManuf($manuf_id, $choices_made = array()) {
			$choices_sql = $this->getChoicesSQL($choices_made);
			// the odd label values help with the ordering/sorting process
			$this->query(
				"SELECT DISTINCT(grp) AS value, 'a' AS label 
				 FROM part 
				 WHERE cat_id='{$this->_id}' AND manuf_id={$manuf_id}{$choices_sql}
				 UNION 
				 SELECT DISTINCT(frame_type) AS value, 'b' AS label 
				 FROM part 
				 WHERE cat_id='{$this->_id}' AND manuf_id={$manuf_id}{$choices_sql} 
				 UNION 
				 SELECT DISTINCT(amps) AS value, 'c' AS label 
				 FROM part 
				 WHERE cat_id='{$this->_id}' AND manuf_id={$manuf_id}{$choices_sql}
				 ORDER BY label ASC, value ASC
				"
			);
			if($this->queryOK()) {
				$criteria = array();
				while($row = $this->next()) {
					switch($row['label']) {
						case 'a' : if(LWS::isAvailable($row['value'])) $criteria['group'][] = $row['value'];
							break;
						case 'b' : if(LWS::isAvailable($row['value'])) $criteria['type'][] = $row['value'];
							break;
						case 'c' : if(LWS::isAvailable($row['value'])) $criteria['amperage'][] = $row['value'];
							break;
						default: break;
					}
				}
				return $criteria;
			} else return NULL;// should never get here!! should always have a result set to return.
		}
		
		/**
		 * Method for fetching the featured busway parts for a given manufacturer.
		 * @param Integer $manuf_id, the primary key of some manufacturer.
		 */
		public function fetchFeaturedParts($manuf_id) {
			$this->query(
				"SELECT part_no, img, display, ns_new_id, ns_green_id 
				 FROM part 
				 LEFT JOIN store USING (part_no) 
				 WHERE is_featured > 0 AND manuf_id={$manuf_id} AND cat_id = '{$this->_id}'     
				 ORDER BY is_featured DESC, part_no ASC  
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
		
		public function fetchMatchingParts($manuf_id, $choices_made = array()) {
			sfProjectConfiguration::getActive()->loadHelpers('Url');
			$choices_sql = $this->getChoicesSQL($choices_made);
			$this->query(
				"SELECT part_no, grp, frame_type, amps, manuf_slug 
				 FROM part INNER JOIN manufacturer USING(manuf_id) 
				 WHERE cat_id='{$this->_id}' AND manuf_id={$manuf_id}{$choices_sql}
				 ORDER BY part_no ASC 
				"
			);
			if($this->queryOK()) {
				$matching_parts = array();
				while($row = $this->next()) {
					$part = array();
					foreach($row as $k => $v) {
						$part[$k] = $v;
					}
					$part['url'] = url_for("@part?cat_slug=busway&manuf_slug={$part['manuf_slug']}&part_no={$part['part_no']}");
					$matching_parts['parts'][] = $part;
				}
				return $matching_parts;
			} else die('not working');//return NULL; // should never get here!! should always have a result set to return.
		}

			public function fetchManufList($manuf_id) {
				$this->query("
				SELECT manuf, manuf_slug
				FROM cat_manuf_map
				INNER JOIN manufacturer
				USING ( manuf_id )
				WHERE cat_id = 'bu'
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
		 * Extends the busway parts array for a given manufacturer by adding
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
		 * Responsible for building necessary SQL variables for busway
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
		
		protected function getChoicesSQL($choices_made) {
			$sql = '';
			foreach($choices_made as $db_field => $value) {
				$sql .= " AND {$db_field}='{$value}'";
			}
			return $sql;
		}
		
	}
	
	