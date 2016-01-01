<?php
	/**
	 * DAO class for a LiveWire press release or news article.
	 * Uses the DAO and Observer patterns.
	 * Anticipated observers: ~
	 * 
	 * @author Morgan Ney <morganney@gmail.com>
	 *
	 */
	class Article extends DAO {
		
		/**
		 * Fetches an article from table Article by using the title_slug field,
		 * which has an index of UNIQUE.
		 * 
		 * @param String $title_slug, the title slug of the article
		 */
		public function fetchByTitleSlug($title_slug) {
			$this->query("SELECT * FROM article WHERE title_slug='{$title_slug}'");
			if($this->queryOK()) {
				$row = $this->next();
				$article = array(
					'pub_date' => date('F jS, Y', strtotime($row['pub_date'])),
					'content' => $row['content'],
					'affiliate_img' => $row['affiliate_img'],
					'title' => $row['title']
				);
				$this->notifyObserver('default');
				return $article;
			} else return NULL;
		}
		
	}
