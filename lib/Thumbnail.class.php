<?php
	class Thumbnail {
		
		private $_mime_type;
		private $_src_img_filepath;
		private $_src_img;
		private $_thb_img;
		private $_max_width;
		private $_max_height;
		
		public function __construct($src_img_file, $mime_type) {
			$this->_mime_type = $mime_type;
			$img_dir =  $src_img_file == 'default-trans' ? sfConfig::get('app_thumbs_dir') : sfConfig::get('app_parts_img_dir');
			// all img files on server use jpg instead of jpeg, but GD uses jpeg
			$this->_src_img_filepath = $mime_type == 'jpeg' ? "{$img_dir}{$src_img_file}.jpg" : "{$img_dir}{$src_img_file}.{$mime_type}";
			$this->_max_width = sfConfig::get('app_thumbs_max_width', 100);
			$this->_max_height = sfConfig::get('app_thumbs_max_height', 100);
			$this->_src_img = $this->_thb_img = NULL;
		}
		
		public function getSrcImg() {
			return $this->_src_img;
		}
		
		public function getThbImg() {
			return $this->_thb_img;
		}
		
		/**
		 * 
		 */
		public function generate() {
			// setup the preliminary variables, $width, $height, $scale_ratio
			list($width, $height) = getimagesize($this->_src_img_filepath);
			if($width <= $this->_max_width && $height <= $this->_max_height) $scale_ratio = 1;
			else $scale_ratio = $width > $height ? $this->_max_width/$width : $this->_max_height/$height;
			$imgcreatefrom_func = "imagecreatefrom{$this->_mime_type}";
			if($this->_src_img = $imgcreatefrom_func($this->_src_img_filepath)) {
				$thumb_width = round($width * $scale_ratio);
				$thumb_height = round($height * $scale_ratio);
				if($this->_thb_img = imagecreatetruecolor($thumb_width, $thumb_height)) {
					if(imagecopyresampled($this->_thb_img, $this->_src_img, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height)) {
						$image_func = "image{$this->_mime_type}";
						return $image_func($this->_thb_img);
					} else {
						throw new GDErrorException('Cannot copy and resize source image into thumb image!');
					}
				} else {
					throw new GDErrorException('Cannot create thumb image resource!');
				}
			} else {
				throw new GDErrorException('Cannot create source image resource!');
			}
		} // end generate()
		
		public function freeMemoryResources() {
			unset($this->_src_img);
			unset($this->_thb_img);
		}
		
	}
	