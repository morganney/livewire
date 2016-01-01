<?php
	class BE {
		const DIE_MSG = 'script killed by --> ';
		
		// refer to be_action table in lws_prod
		const TICKET_CREATED_ACTION = 1;
		const QUOTE_EMAILED_ACTION = 2;
		const PURCHASED_ACTION = 3;
		const EXTERNAL_NOTE_ACTION = 5;
		const INTERNAL_NOTE_ACTION = 6;
		const TICKET_UPDATED_ACTION = 7;
		
		public static function dump($data, $die = false, $func_ref = NULL) {
			if(is_array($data)) {
				echo "<pre style='font-size: 14px; font-family: Courier, Arial, sans-serif'>";print_r($data);echo '</pre>';
			} else {
				var_dump($data);
				echo '<br />';
			}
			if($die && !is_null($func_ref)) die(self::DIE_MSG . $func_ref);
			else if($die) die(self::DIE_MSG . __METHOD__);
		}
		
		public static function formatNote($note) {
			return nl2br(htmlentities($note));
		}
	}