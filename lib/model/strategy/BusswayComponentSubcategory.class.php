<?php

	class BusswayComponentSubcategory implements iSubcatStrategy {
		
		private $_subcat_field;
		
		public function __construct($subcat_field = 'grp') {
			$this->_subcat_field = $subcat_field;
		}
		
		public function createSections(DAO $dao) {
			
		}
	}
	