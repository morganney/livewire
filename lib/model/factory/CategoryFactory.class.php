<?php 
	class CategoryFactory implements iFactory {
		
		public static function make($params) {
			$category = strtoupper($params['cat_id']) . 'Category';
			return new $category($params['list_decorator_type']);
		}
		
	}