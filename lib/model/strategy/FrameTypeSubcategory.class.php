<?php
	/*
	 * Strategy for creating sections within subcategories of a part by using 
	 * the 'frame_type' field as a subcategory. 
	 * 
	 */
	class FrameTypeSubcategory implements iSubcatStrategy {
		
		private $_subcat_field;
		
		public function __construct($subcat_field = 'frame_type') {
			$this->_subcat_field = $subcat_field;
		}
		
		public function createSections(DAO $dao) {
			if($dao->queryOK()) {
				$sections = array();
				$row = $dao->next();
				$count = $row['cnt'];
				$letter = $row[$this->_subcat_field][0];
				$first_section = $last_section = $row[$this->_subcat_field];
				while($row = $dao->next()) {
					if($row[$this->_subcat_field][0] == $letter) {
						// aggregating mode
						$count += $row['cnt'];
						$last_section = $row[$this->_subcat_field];
					} else {
						// section assignment mode
						$section = $first_section == $last_section ? $first_section : "{$first_section}-{$last_section}";
						$sections[] = array(
							'section' 		 => $section,
							'section_slug' => LWS::slugify($section),
							'count'				 => $count
						);
						// update loop values for next section
						$count = $row['cnt'];
						$letter = $row[$this->_subcat_field][0];
						$first_section = $last_section = $row[$this->_subcat_field];
					}
				}// end while()
				// add last section aggregated
				$section = $first_section == $last_section ? $first_section : "{$first_section}-{$last_section}";
				$sections[] = array(
					'section' 		 => $section,
					'section_slug' => LWS::slugify($section),
					'count'				 => $count
				);
			} else $sections = NULL;
			
			return $sections;
		}
	
	}
	