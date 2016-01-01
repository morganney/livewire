<?php
	/**
	 * Base DAO class used by all other DAO classes.
	 * Provides basic interfaces for DAO and Observer design patterns.
	 * "State changes" for triggering observer updates are considered 
	 * database edits/writes/updates since these DAO objects don't
	 * necessarily have instance fields with regularly changing states.
	 * 
	 * @author Morgan Ney <morganney@gmail.com>
	 *
	 */
	class DAO implements iObservable {
		
		protected $_db; // Database singleton
		protected $_observers;
		protected $_rs; // current recordset
		protected $_last_insert_id; // last AUTO-INCREMENT value from INSERT INTO statement
		
		/**
		 * Constructor accepts optional array of observers.
		 * 
		 * @param Array $observers, with entry format 'type' => $observer,
		 * e.g. array('analytics' => $ga_agent)
		 */
		public function __construct($observers = array()) {
			// should add check to make sure passed observers implement iObserver
			$this->_db = Database::getInstance();
			$this->_rs = NULL;
			$this->_observers = $observers;
			$this->_last_insert_id = 0; // php returns this if last SQL was not INSERT or UPDATE statement
		}
		
		/**
		 * Wrapper method for $this->_db method's to prevent SQL injection attack.
		 * @param String $text
		 */
		public function getEscapedSQLString($text) {
			return $this->_db->getEscapedSQLString($text);
		}
		
		/**
		 * Attaches an Observer object.
		 * 
		 * @param Object Reference $observer
		 * @param String $type
		 */
		public function attachObserver(iObserver $observer, $type = 'default') {
			$this->_observers[$type][] = $observer;
		}

		/**
		 * Cycle through list of $type Observer's and execute update().
		 * 
		 * @param String $type
		 */
		public function notifyObserver($type = 'default') {
			if(isset($this->_observers[$type])) {
				foreach($this->_observers[$type] as $observer) {
					$observer->update($this);
				}
			}
		}
		
		public function hasError() {
			return $this->_db->hasError();
		}
		
		public function getError() {
			return $this->_db->getLastError();
		}
		
		public function getErrNo() {
			return $this->_db->getLastErrNo();
		}
		
		public function getRs() {
			return $this->_rs;
		}
		
		/**
		 * Wrapper method for Database::query().
		 * Important in that it sets the mysqli result set for this DAO instance.
		 * @param String $sql
		 */
		public function query($sql) {
			$this->_rs = $this->_db->query($sql);
		}
		
		public function setRs(mysqli_result $rs) {
			$this->_rs = $rs;
		}
		
		public function hasRecords() {
			return ($this->_rs->num_rows > 0);
		}
		
		public function queryOK() {
			return (!$this->hasError() && $this->hasRecords());
		}
		
		
		/**
		 * Method to check if last attempt to update a DB record was successful.
		 * mysqli->affected_rows returns integer:
		 *  n > 0 Successful UPDATE to n records
		 *  0 for no records UPDATED (but no error, this is why >= 0 intead of just > 0)
		 *  -1 if query returned an error 
		 */
		public function updateOK() {
			return ($this->_db->affectedRows() >= 0);
		}
		
		/**
		 * 
		 * Mysqli will return TRUE on successful INSERT INTO statements, FALSE otherwise.
		 */
		public function insertOK() {
			// make sure there is not a record set stored there first
			if($this->_rs === TRUE || $this->_rs === FALSE) {
				$this->_last_insert_id = $this->_db->get_insert_id();
				return $this->_rs;
			}
			else return FALSE;
		}
		
		public function getQueryInfo() {
			return $this->_db->getInfo();
		}
		
		public function next($associative = true) {
			if($associative) {
				return $this->_rs->fetch_assoc();
			} else return $this->_rs->fetch_row();
		}
		
		public function getLastInsertId() {
			return $this->_last_insert_id;
		}
		
	}
	