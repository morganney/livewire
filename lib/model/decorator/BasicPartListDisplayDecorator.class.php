<?php 
	class BasicPartListDisplayDecorator implements iListDisplayDecorator {
	  /**
	   * Method for building display of an item on pagination lists.
	   * Currently just calles symfony template after building up some
	   * parameters to pass along.  Might not be most effecient method.
	   * I think building an html string would be better on resources,
	   * but a pain to construct, even as a HEREDOC.
	   * @param Array $part, passed by reference for updating/appending
	   * @param Array $specs_preview_fields, the fields most relevant for the current part category
	   */
		public function buildDisplay(&$part, $specs_preview_fields) {
			// load 'Partial' helper from symfony library
			sfProjectConfiguration::getActive()->loadHelpers('Partial');
			//$cat_singular = LWS::getCategoryName($part['cat_slug'], true);
			$part['anchor_text'] = "{$part['part_no']}"; // might want to change it for seo reasons, etc.
			$part['layout'] = 
			get_partial(
				'toolkit/basicListDisplay', 
				array(
					'part' => $part, 
					'display' => $part['display'], // what shopping options (if any) are available
					'specs_preview_fields' =>  $specs_preview_fields
				)
			);
		}
	}
	