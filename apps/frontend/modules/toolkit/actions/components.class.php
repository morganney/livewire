<?php

	class toolkitComponents extends sfComponents {
		
		/**
		 * Method to set the remaining number of hours and minutes before the 
		 * cutoff time to order next day shipping.
		 * 
		 * @todo: add logic to set appropriate '$receipt_date' when users view 
		 * 			  the page on Friday (post cutoff), Saturday & Sunday.
		 */
		public function executeShippingCalculator() {
			// get date, hours, & minutes values for next day shipping option
		  date_default_timezone_set('America/Los_Angeles');
		  $current_time = intval(date('Gis'));
		  $cutoff_time = intval(sfConfig::get('app_next_day_shipping_cutoff'));
			if($current_time < $cutoff_time) {
				// current work day still ongoing
				$this->receipt_date = date('F jS', strtotime('+1 day'));
				$within_cutoff = true;
			} else {
				// current work day is over
				$this->receipt_date = date('F jS', strtotime('+2 day'));
				$within_cutoff = false;
			}
			list($this->hrs_cnt, $this->min_cnt) = $this->getCounterValues(
				intval(sfConfig::get('app_next_day_shipping_cutoff_hour')),
				intval(sfConfig::get('app_next_day_shipping_cutoff_min')),
				$within_cutoff
			);
			$this->h_suffix = $this->hrs_cnt != 1 ? 's' : '';
			$this->m_suffix = $this->min_cnt != 1 ? 's' : '';
		}
		
		protected function getCounterValues($cutoff_hr, $cutoff_min, $within_cutoff = true) {
			$cur_hr = intval(date('G'));
			$cur_min = intval(date('i'));
			if($within_cutoff) $hrs_cnt = $cutoff_hr - $cur_hr;
			else $hrs_cnt = 24 - $cur_hr + $cutoff_hr;
			$min_cnt = $cutoff_min - $cur_min;
			if($min_cnt < 0) {
				$hrs_cnt -= 1;
				$min_cnt = (60 - $cur_min) + $cutoff_min;
			}
			return array($hrs_cnt, $min_cnt);
		}
	}
