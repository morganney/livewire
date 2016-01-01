<?php
	class PartFactory implements iFactory {
		
		public static function make($params) {
			$part = strtoupper($params['cat_id']) . 'Part';
			return new $part($params['part_no']);
		}
		
	}
	