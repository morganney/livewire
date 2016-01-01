<?php
	/**
	 * Database abstraction layer for project.
	 * Currently only supports MySQL DBMS.
	 * Singleton pattern used.
	 * @author morgan ney
	 *
	 */
	class Database {
		
		protected static $_instance;
		protected $_mysqli;
		protected $_err;
		protected $_errno;
		
		private function __construct() {
			if(sfConfig::get('sf_app') == 'frontend') {
				$this->_mysqli = @new mysqli('localhost', 'foo', 'bar', 'baz');
			} else {
				$this->_mysqli = @new mysqli('localhost', 'foo', 'bar', 'baz');
			}
			if($this->_mysqli->connect_errno) {
				// log the mysql error to the default logger file with 'err' priority
				sfContext::getInstance()->getLogger()->err($this->_mysqli->connect_error);
				die('Sorry, our database is temporarily down for repairs. Contact the sites webmaster morgan@livewiresupply.com');
			}
			$this->_err = NULL;
			$this->_errno = 0;
		}
		
		private function setErr($value) {
			$this->_err = $value;
		}
		
		private function setErrNo($number) {
			$this->_errno = $number;
		}
		
		private function __clone() {}
	
		public function getEscapedSQLString($text) {
			return $this->_mysqli->real_escape_string($text);
		}
		
		public function __destruct() {
			if(!$this->_mysqli->connect_errno) $this->_mysqli->close();
		}
		
		public static function getInstance() {
			if(!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}
		
		/**
		 * To program the mysqli API directly from a controller/action
		 * rather from this abstraction layer class. Remember to assign
		 * variables using this method by reference.
		 */
		public function &getConnection() {
			return $this->_mysqli;
		}
		
		public function getLastError() {
			return $this->_err;
		}
		
		public function getLastErrNo() {
			return $this->_errno;
		}

		public function hasError() {
			if(is_null($this->_err)) return false;
			else return true;
		}
		
		public function getInfo() {
			return $this->_mysqli->info;
		}
		
		public function affectedRows() {
			return $this->_mysqli->affected_rows;
		}
		
		public function get_insert_id() {
			return $this->_mysqli->insert_id;
		}
		
		public function query($sql) {
			$rs = $this->_mysqli->query($sql);
			if($this->_mysqli->errno) {
				$rs = NULL;
				$this->setErr($this->_mysqli->errno . ' : ' . $this->_mysqli->error);
				$this->setErrNo($this->_mysqli->errno);
			} else {
				$this->setErr(NULL);
			}
			return $rs;
		}
		
	}
