<?php
	/**
	 * Base class for more specific categories of parts. Class is not really
	 * meant to be instantiated, but rather used solely as a base for extending
	 * other categories of parts.  Child class is responsible for passing
	 * relevant $_db_fields in its own constructor.
	 * 
	 * @author Morgan Ney <morganney@gmail.com>
	 * @example LWS/lib/model/dao/CBPart.class.php
	 * @internal If constructor() gets overly complex, consider using builder pattern
	 */
	class Part extends DAO {
		
		protected $_part_no;
		protected $_db_fields;
		protected $_details;
		protected $_pricing;
		
		public function __construct($part_no, $db_fields = array()) {
			parent::__construct(); // Call DAO constructor
			$this->_part_no = $part_no;
			$this->_db_fields = $db_fields;
			$this->_details = NULL;
			$this->_pricing = NULL;
			// for building breadcrumbs on a part's landing page
			sfProjectConfiguration::getActive()->loadHelpers(array('Url', 'Tag'));
		}
		
		/**
		 * Method for returning the pricing information back to the 
		 * calling action to pass along to the corresponding view.  The view will
		 * use this value to pull in the correct template for the store based
		 * on the pricing level.
		 */
		public function getPricing() {
			return $this->_pricing;
		}
		
		public function getDbFields() {
			return $this->_db_fields;
		}
		
		/**
		 * Method to return associative array of part details back to the calling action.
		 */
		public function getDetails() {
			return $this->_details;
		}
		
		/**
		 * Method for setting the pricing level of part. Values are template
		 * names without the underscore.
		 * @param String $display, value of 'display' field from 'store' table in DB
		 */
		protected function setPricing($display) {
			switch($display) {
				case 0 : $this->_pricing = 'emptyStore';
					break;
				case 1 : $this->_pricing = 'newStore';
					break;
				case 2 : $this->_pricing = 'greenStore';
					break;
				case 3 : $this->_pricing = 'completeStore';
					break;
				default: $this->_pricing = 'emptyStore';
					break;
			}
		}
		
		/**
		 * Method for building the appropriate SQL for this particular parts
		 * relevant database fields. The returned SQL snippet includes the trailing ',' 
		 * if necessary (i.e. !empty($this->_db_field)) and is intended to be the first
		 * part of a SELECT clause, e.g. "SELECT {$relevant_fields_aliased} x, y, z FROM ..."
		 * @see fetchDetails()
		 */
		protected function getSQLSnippet() {
			$relevant_fields_aliased = '';
			foreach($this->_db_fields as $alias => $db_field) {
				$relevant_fields_aliased .= "{$db_field} AS '{$alias}', ";
			}
			return $relevant_fields_aliased;
		}
		
	}
	