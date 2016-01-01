<?php

 class BE_DAO extends DAO {
 	
 		protected $_similar_finds;
 		
  	public function __construct() {
 			parent::__construct(); // Call DAO constructor
 			$this->_similar_finds = NULL;
 		}
 		
 		
 		/* 
 		 * Search Related
 		 * 
 		 */
 		public function hasSimilarFinds() {
 			return !is_null($this->_similar_finds);
 		}
 		
 		public function getSimilarFinds() {
 			return $this->_similar_finds;
 		}
 		
 		public function find($part_no) {
 			$this->query("SELECT part_no FROM part WHERE part_no='{$part_no}' LIMIT 1");
 			if($this->queryOK()) {
 				return true;
 			} else {
 				// try using only the first 3 letters
 				$size = strlen($part_no);
 				if($size > 3) $new_pn = substr($part_no, 0, 3);
 				else $new_pn = $part_no;
 				$this->query("SELECT part_no FROM part WHERE part_no LIKE '{$new_pn}%' LIMIT 100");
 				if($this->queryOK()) {
 					$this->_similar_finds = array();
 					while($row = $this->next()) $this->_similar_finds[] = $row['part_no'];
 				}
 				return false;
 			}
 		}
 		/*
 		 * End Search Related Code
 		 */
 		
 		
 }
 