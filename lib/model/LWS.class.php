<?php
	class LWS {
		
		/**
		 * This instance field must be updated when 'manufacturer' table has 
		 * primary key and/or 'manuf_slug' updated.
		 * @var Associative Array $_manuf_map
		 */
		private static $_manuf_map = array(
			'acme' => 8,
			'allen-bradley' => 2,
			'bryant' => 14,
			'bui' => 21,
			'connecticut-electric' => 17,
			'cooper-bussman' => 9,
			'cutler-hammer' => 3,
			'federal-pacific' => 13,
			'ferraz-shawmut' => 7,
			'ge' => 4,
			'hammond-power' => 12,
			'ilsco' => 18,
			'jefferson' => 11,
		 	'joslyn-clark' => 10,
			'littelfuse' => 5,
			'murray' => 15,
			'siemens' => 1,
			'square-d' => 6,
			'thomas-betts' => 20,
			'wadsworth' => 16,
			'westinghouse' => 19,
			'zinsco' => 22,
			'rebuilt' => 23
		);
		
		public static function slugify($text) {
			//replace all non letters or digits by hyphen, i.e. (-)
			$text = preg_replace('/\W+/', '-', $text);
			// trim and lowercase
			return strtolower(trim($text));
		}
		
		public static function unslugify($text, $is_manuf_slug = false, $all_caps = false) {
			$text = str_replace('-', ' ', $text);
			if($all_caps) {
				$text = strtoupper($text);
			} else if($is_manuf_slug && strlen($text) <= 3) $text = strtoupper($text);
			else $text = ucwords($text);
			return $text;
		}
		
		/**
		 * Returns the primary key of a given manufacturer slug from the manufacturer table
		 * in lws_production. Meant to minimize database transactions.
		 * @param String $manuf_slug
		 * @return int, the primary key stored in DB.
		 */
		public static function getManufPk($manuf_slug) {
			// I guess I'll save on db connections and write some code.
			// SQL:  SELECT id FROM manufacturer WHERE manf_slug = '$manuf_slug'
			return self::$_manuf_map[$manuf_slug];
		}
		
		
		public static function getManufSlug($manuf_id) {
			return array_search($manuf_id, self::$_manuf_map);
		}
		
		/**
		 * The 72 characters safe for URLs are:
		 * The 10 digits, 52 letters, and the following 10 special characters:
		 * 033 ! Exclamation
		 * 040 ( Left Paren
		 * 041 ) Right Paren
		 * 042 * Asterisk
		 * 045 - Hyphen
		 * 046 . Period
		 * 095 _ Underscore
		 * 124 | Verticalbar
		 * 
		 * @param String $part_no
		 */
		public static function encode($part_no) {
			return str_replace('/', '!', str_replace('+', '_', $part_no));
		}
		
		/**
		 * Unencode the previous encoding of $part_no for proper display and 
		 * database processing. Inverse of encode().
		 * @param String $part_no
		 */
		public static function unencode($part_no) {
			return str_replace('!', '/', str_replace('_', '+', $part_no));
		}
		
	  /**
	   * Converts a symfony module name or category slug into a LiveWire product category name.
		 * Returns the converted module or category slug name.
		 * Expected to be used with the following modules and categories:
		 * busway, circuit_breakers, fuses, medium_voltage, motor_control, & transformers
	   * @param String $sf_module_name_or_cat_slug, usually $sf_context->getModuleName()
	   * @param Boolean $singular, flag to return singular version of category
	   */
		public static function getCategoryName($sf_module_name_or_cat_slug, $singular = false) {
			$str = ucwords(str_replace('_', ' ', str_replace('-', ' ', $sf_module_name_or_cat_slug)));
			if($singular && substr($str, -1) == 's') {
				$str = substr($str, 0, -1);
			}
			return trim($str);
		}
		
		/**
		 * Returns the primary key of the category table in database given a symfony
		 * module name or category slug.
		 * @param String $sf_module_name_or_cat_slug
		 */
		public static function getCategoryPk($sf_module_name_or_cat_slug) {
			$sf_module_name = str_replace('-', '_', $sf_module_name_or_cat_slug);
			switch($sf_module_name) {
				case 'busway' : $pk = 'bu';
					break;
				case 'circuit_breakers' : $pk = 'cb';
					break;
				case 'fuses' : $pk = 'fu';
					break;
				case 'motor_control' : $pk = 'mc';
					break;
				case 'electrical_transformers' : 
				case 'transformers' : $pk = 'tr';
					break;
				default: $pk = NULL;
					break;
			}
			return $pk;
		}
		
		/**
		 * Extracts the page number from the seo-friendly :page_num variable
		 * in the @pagination route.  Current scheme uses [page-{num}] for :page_num
		 * Used this instead of directory style url for better seo (static file & higher depth).
		 * @param String $pagination_route_var
		 */
		public static function extractPaginationNum($pagination_route_var) {
			$pieces = explode('-', $pagination_route_var);
			return intval($pieces[1]);
		}
		
		public static function dbFieldToLabel($db_field, $upper_case = false) {
			$label = str_replace('_', ' ', $db_field);
			$label = str_replace('grp', 'component', $label);
			$label = str_replace('frame type', 'busway type', $label);
			if($upper_case) {
				$label = ucwords($label);
			}
			return $label;
		}
		
		/**
		 * Returns the subcategory slug used for routing on subcategory 
		 * pagination pages.  Helpful for product categories that may have
		 * a subcategorization scheme that uses more than one database field, 
		 * e.g. Fuses.  This way the subcategory slug can be more specific.
		 * @param Array $param, a nested array containing the 'sections' of the current subcategory
		 * @param Integer $idx, an index (loop counter) for the current section
		 */
		public static function getSubcatSlug($param, $idx) {
			if(isset($param['sections'][$idx]['subcat_slug'])) {
				$subcat_slug = $param['sections'][$idx]['subcat_slug'];
			} else $subcat_slug = $param['subcat_slug'];
			return $subcat_slug;
		}
		
		public static function getSectionName($subcategory, $section) {
			$subcategory = strtolower($subcategory);
			if($subcategory == 'frame types') {
				$section_name = strtoupper($section);
			} else if($subcategory == 'class' || $subcategory == 'type') {
				$section_name = self::unslugify($section, false, true);
			} else $section_name = self::unslugify($section);
			return $section_name;
		}
		
		/**
		 * Converts all 'NULL-like' values into an appropriate response.
		 * 'NULL-like' values depend upon LiveWire business model and
		 * database storage techniches. I hate NULL's but its what I've 
		 * inherited for the moment.
		 * @param Mixed $value, the value of a particluar part no./field combination.
		 */
		public static function formatValue($value, $field_name) {
			if(empty($value) || is_null($value) || (($field_name == 'kva' || $field_name == 'weight') && $value == 0)) {
				return 'N/A';
			} else if($field_name == 'specs') {
				return self::getTxtSnippet($value, 55);
			} else return $value;
		}
		
		public static function getTxtSnippet($text, $max_chars = 255, $end_on_word = true) {
			if(strlen($text) <= $max_chars) {
				$snippet = $text;
			} else {
				$t = substr($text, 0, $max_chars);
				if($end_on_word) {
					$snippet = substr($t, 0, strripos($t, ' ')) . ' ...';
				} else $snippet = $t . ' ...';
			}
			return $snippet;
		}
		
		public static function getImgSrc($img_filename, $type='normal') {
			// mainly here until site goes live
			// trying to keep from transferring all those image files during development.
			switch($type) {
				case 'normal' : $img_dir = sfConfig::get('app_parts_img_dir');
												$img_uri = 'default.png';
					break;
				case 'thumb'  : $img_dir = sfConfig::get('app_thumbs_dir');
												$img_uri = 'thumbs/default.png';
				  break;
				case 'mini'   : $img_dir = sfConfig::get('app_minis_dir');
												$img_uri = 'thumbs/minis/default.png';
				 	break;
				default: $img_dir = sfConfig::get('app_parts_img_dir');
								 $img_uri = 'default.png';
					break;
			}
			
			if(is_null($img_filename) || empty($img_filename) || $img_filename == 'PRODNOTAVAIL.jpg') {
				$src = "/images/parts/{$img_uri}";
			} else {
				// could add a check to see if file_exists() once on the live server
				$src = "{$img_dir}{$img_filename}";
			}
			return $src;
		}
		
		public static function isAvailable($value) {
			return (!is_null($value) && !empty($value));
		}
		
		public static function isOutsideBizHours() {
			$day = date('D');
			if($day == 'Sat' || $day == 'Sun') return true;
			$time = intval(date('Gi'));
			$open = intval(sfConfig::get('app_biz_open'));
			$close = intval(sfConfig::get('app_biz_close'));
			if($time < $open || $time >= $close) return true;
			return false;
		}

	}