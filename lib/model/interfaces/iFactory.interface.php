<?php
	interface iFactory {
		/**
		 * Returns appropriate object reference based on passed
		 * parameters in $params.
		 * @param Associative Array $params
		 */
		public static function make($params);
	}
	