<?php
	class ListDisplayDecoratorFactory implements iFactory {
		/**
		 * Returns appropriate object reference based on passed
		 * parameters in $params.
		 * @param Associative Array $params
		 */
		public static function make($params) {
			if(is_null($params['type'])) return NULL;
			else {
				$dec = ucfirst(strtolower($params['type'])) . 'PartListDisplayDecorator';
				$decorator = new $dec($params['specs_preview_fields']);
				if(!($decorator instanceof iListDisplayDecorator)) {
					throw(new Exception('List decorator object is not an instance of iListDisplayDecorator!'));
				} else return $decorator;
			}
		}
	}
	