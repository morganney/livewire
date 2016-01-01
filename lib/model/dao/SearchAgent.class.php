<?php
	class SearchAgent extends DAO {
		
		private $_query; // users entered query
		private $_insert_sql; // add user query to db
		private $_exact_sql; // search for exact part number in db
		private $_limit; // max items on paginated search results
		private $_search_routes;
		private $_cat_manuf_map; // prevents assigning invalid search routes
		
		public function __construct($query) {
			parent::__construct();
			$query = trim($query);
			$this->_query = $this->getEscapedSQLString($query);
			$query = strtoupper($this->_query);
			$this->_insert_sql = "INSERT INTO customer_search_query (query) VALUES ('{$query}') ON DUPLICATE KEY UPDATE count=count+1";
			$this->_exact_sql = "SELECT part_no, cat_slug, manuf_slug 
			FROM part INNER JOIN category USING(cat_id) INNER JOIN manufacturer USING(manuf_id) 
			WHERE part_no='{$this->_query}' 
			ORDER BY part_no 
			LIMIT 1";
			$this->_limit = sfConfig::get('app_search_pagination_max_items');
			$this->_search_routes = NULL;
			$this->_cat_manuf_map = array(
				'Circuit Breakers:BUI',
				'Circuit Breakers:Connecticut Electric',
				'Circuit Breakers:Cutler Hammer',
				'Circuit Breakers:Federal Pacific',
				'Circuit Breakers:GE',
				'Circuit Breakers:Murray',
				'Circuit Breakers:Siemens',
				'Circuit Breakers:Square D',
				'Circuit Breakers:Thomas Betts',
				'Circuit Breakers:Wadsworth',
				'Circuit Breakers:Westinghouse',
				'Circuit Breakers:Zinsco',
				'Motor Control:Allen Bradley',
				'Motor Control:Cutler Hammer',
				'Motor Control:GE',
				'Motor Control:ILSCO',
				'Motor Control:Joslyn Clark',
				'Motor Control:Murray',
				'Motor Control:Siemens',
				'Motor Control:Square D',
				'Electrical Transformers:ACME',
				'Electrical Transformers:Bryant',
				'Electrical Transformers:Cutler Hammer',
				'Electrical Transformers:GE',
				'Electrical Transformers:Hammond Power',
				'Electrical Transformers:Jefferson',
				'Electrical Transformers:Siemens',
				'Electrical Transformers:Square D',
				'Fuses:Cooper Bussman',
				'Fuses:Cutler Hammer',
				'Fuses:Ferraz Shawmut',
				'Fuses:Littlefuse',
				'Busway:Cutler Hammer',
				'Busway:GE',
				'Busway:Siemens',
				'Busway:Square D'
			);
		}
		
		/**
		 * Method for determining helpful search routes based on the current
		 * derived similar parts result set.  Should really calculate the running time
		 * for this algorithm.  Right now the largest input array has 
		 * sfConfig::get('app_search_max_pagination_items') items.
		 * @param Array $similar_parts
		 */
		protected function setSearchRoutes($similar_parts = array()) {
			$manuf_slugs = $cat_slugs = $routes = array();
			foreach($similar_parts as $part) {
				$manuf_slugs[$part['manuf']] = $part['manuf_slug'];
				$cat_slugs[$part['category']] = $part['cat_slug'];
			}
			foreach($cat_slugs as $category => $cat_slug) {
				foreach($manuf_slugs as $manuf => $manuf_slug) {
					if(in_array($category . ':' . $manuf, $this->_cat_manuf_map)) {
						$routes[] = array(
							'anchor_txt' => $manuf . ' ' . $category,
							'route'			 => '@' . LWS::getCategoryPk($cat_slug) . '_manuf?manuf_slug=' . $manuf_slug
						);
					}
						//$routes[$manuf . ' ' . $category] = '@' . LWS::getCategoryPk($cat_slug) . '_manuf?manuf_slug=' . $manuf_slug;
				}
			}
			$this->_search_routes = $routes;
		}
		
		public function getSearchRoutes() {
			return $this->_search_routes;
		}
		
		public function search() {
			// log user query
			$this->query($this->_insert_sql);
			// check for errors in logging, and send email to webmaster if necesary
			if(!$this->updateOK()) {
				// send an email or something
				
			}
			$this->query($this->_exact_sql);
			if($this->queryOK()) {
				// match found so build and return the route
				$part = $this->next();
				$route = "@part?cat_slug={$part['cat_slug']}&manuf_slug={$part['manuf_slug']}&part_no=" . LWS::encode($part['part_no']);
				return $route;
			} else return NULL; // no exact match found
		}
		
		public function getSimilarParts($offset = 0) {
			$this->query(
			"SELECT part_no, img, manuf, manuf_slug, category, cat_slug, (
			  SELECT count(*) 
			  FROM part
			  WHERE part_no LIKE '{$this->_query}%' 
			) AS count  
			FROM part INNER JOIN manufacturer USING (manuf_id) INNER JOIN category USING (cat_id)  
			WHERE part_no LIKE '{$this->_query}%' 
			ORDER BY part_no ASC 
			LIMIT {$offset}, {$this->_limit} "
			);
			if($this->queryOK()) {
				$similar_parts = array();
				while($row = $this->next()) {
					foreach($row as $k => $v) {
						if($k == 'img') {
							$part[$k] = is_null($v) ? sfConfig::get('app_thumbs_dir') . 'default.png' 
																			: sfConfig::get('app_thumbs_dir') . strtolower(LWS::encode($row['part_no'])) . '.jpg';
						}
						else $part[$k] = $v;
					}
					$part['encoded_part_no'] = LWS::encode($part['part_no']);
					$similar_parts[] = $part;
				}
				$this->setSearchRoutes($similar_parts);
				return $similar_parts;
			} else {
				return NULL; // lazy solution for now
			}
		}
		
		public function getNextDataSet($page_num) {
			$offset = ($page_num - 1) * $this->_limit;
			return $this->getSimilarParts($offset);
		}
		
		public function liveSearchLocate() {
			$this->query("
				SELECT part_no, img, category, cat_slug, manuf, manuf_slug FROM part
				INNER JOIN category USING (cat_id) INNER JOIN manufacturer USING (manuf_id)
				WHERE LOCATE('{$this->_query}', part_no) != 0
				ORDER BY part_no ASC
				LIMIT 5
			");
			if($this->queryOK()) {
				$serp = array();
				while($row = $this->next()) {
					$pne = LWS::encode($row['part_no']);
					$minis_dir = sfConfig::get('app_minis_dir');
					$route = "@part?cat_slug={$row['cat_slug']}&manuf_slug={$row['manuf_slug']}&part_no={$pne}";
					$img = is_null($row['img']) ? "{$minis_dir}default.png" : "{$minis_dir}{$pne}.jpg";
					$serp[] = array(
						'part_no'				=>	$row['part_no'],
						'category'			=>	$row['category'],
						'mfr'						=>	$row['manuf'],
						'img'						=>	$img,
						'route'					=>	$route
					);
				}
				return $serp;
			} else return NULL;
		}
		
		public function liveSearchLike() {
			return ' %';
		}
		
	}
	