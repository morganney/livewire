<?php
	/**
	 * DAO class for a Customer profile.
	 * Uses the DAO and Observer patterns.
	 * Anticipated observers: ~
	 * 
	 * @author Morgan Ney <morganney@gmail.com>
	 *
	 */
	class Profile extends DAO {
		
		/**
		 * Fetches a customer profile from table Profile by using the name_slug field,
		 * which has an index of UNIQUE.
		 * 
		 * @param String $name_slug, the name slug of a customer who has a profile on the website
		 */
		public function fetchByNameSlug($name_slug) {
			$this->query("SELECT * FROM profile WHERE name_slug='{$name_slug}'");
			if($this->queryOK()) {
				$row = $this->next();
				$profile = array(
					'customer_name' => $row['name'],
					'content' => $row['content'],
					'bg_img' => "/images/profiles/{$row['img']}"
				);
				$this->notifyObserver('default');
				return $profile;
			} else return NULL;
		}
		
	}
