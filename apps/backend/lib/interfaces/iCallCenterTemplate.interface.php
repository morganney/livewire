<?php
	interface iCallCenterTemplate {
		/**
		 * 
		 * Responsible for building an HTML template out of details from an RFQ.
		 * Stores the HTML template as a string instance field in the implementing class.
		 * Stores a database version of template as a string instance field of implementing class.
		 * 
		 * @param Mixed Array $rfq, the request for quote details
		 */
		public function build($rfq);
		/**
		 * 
		 * Returns the HTML template stored as a string to the client
		 * 
		 * @return String, the HTML template build by build($rfq)
		 */
		public function getTemplate();
		
		/**
		 * Returns the string version of the template for storage in a database.
		 * 
		 * @return String, a database version of the template
		 */
		public function getDbNote();
		
		/**
		 * Responsible for updating the be_ticket table with the tickets action_id value.
		 * This value indicates the tickets last action: Ticket Openned, Emailed Quote, etc.
		 * 
		 * @param DAO.class.php $dao, and instance of a DAO object to access the database.
		 * @param Integer $ticket_id, the tickets ticket_id value in be_ticket table, i.e. Primary Key.
		 */
		public function updateTicketLastAction($dao, $ticket_id);
		
		public function getEmailHeaders($rfq);
	}
	