<?php

 class CircuitBreakerSelectionAgent extends DAO {
		
	protected $_step;
	protected $_selections;
	protected $_data;
	protected $_search_parameters;
	 	
	public function __construct($selections) {
	 	parent::__construct();
 		$this->_selections = $selections;
 		$this->_step = $this->_selections['step'];
 		$this->_data = array();
 		$this->_search_parameters = array();
	}

	/**
	 * Method to go back to first step in Ajax requests.
	 */
	private function filterForRestart() {
		$this->query("
			SELECT frame_type, img 
			FROM frame_types
			WHERE manuf_id={$this->_selections['manuf_id']} 
			ORDER BY frame_type ASC
		");
		if($this->queryOK()) {
			$this->notifyObserver('default');
			while($row = $this->next()) {
				$this->_data['data'][] = array(
					'AT' 			=> $row['frame_type'], 
					'QS' 			=> "manuf_id={$this->_selections['manuf_id']}&frame={$row['frame_type']}&step=frame",
					'img_src'	=> "/images/frames/{$row['img']}"
				);
			}
			$this->_data['results_so_far'] = NULL;
			$this->_data['back_qs'] = '';
			return $this->_data;
		} else return NULL;
		
	}
	
	private function filterForFrame() {
		$this->_search_parameters['Frame Type'] = $this->_selections['frame'];
		$this->query("
			(
			SELECT DISTINCT(poles) AS data, 'data' AS label
			FROM part 
			WHERE cat_id='cb' AND manuf_id={$this->_selections['manuf_id']} AND frame_type='{$this->_selections['frame']}' AND poles IS NOT NULL 
			)
			UNION
			(
			SELECT part.part_no, 'results_so_far' AS label FROM part
			WHERE cat_id='cb' AND manuf_id={$this->_selections['manuf_id']} AND frame_type='{$this->_selections['frame']}' AND poles IS NOT NULL
			)
			ORDER BY label ASC, data ASC
		");
		if($this->queryOK()) {
			$this->notifyObserver('default');
			while($row = $this->next()) {
				if($row['label'] == 'data') {
					$this->_data['data'][] = array(
						'AT' => $row['data'], 
						'QS' => "manuf_id={$this->_selections['manuf_id']}&frame={$this->_selections['frame']}&poles={$row['data']}&step=poles", 
						'class' => "n_{$row['data']}" // IE6 didn't recognize a class that started with an underscore "_"
					);
				} else { // should always be at least 1 'result so far' unless LWS DB is incomplete!
					$this->_data['results_so_far'][] = array(
						'part_no' 		=> $row['data'],
						'manuf_slug'	=>	LWS::getManufSlug($this->_selections['manuf_id'])
					);
				} 
			}
			// add class to last element of 'data'
			$this->_data['data'][count($this->_data['data']) - 1]['class'] .= ' last';
			$this->_data['back_qs'] = "manuf_id={$this->_selections['manuf_id']}&step=restart";
			return $this->_data;
		} else return NULL;
	}
	
	private function filterForPoles() {
		$this->_search_parameters['Frame Type'] = $this->_selections['frame'];
		$this->_search_parameters['Poles'] = $this->_selections['poles'];
		$this->query("
			(
			SELECT DISTINCT(amps) AS data, 'data' AS label
			FROM part
			WHERE cat_id='cb' AND manuf_id ={$this->_selections['manuf_id']} AND frame_type='{$this->_selections['frame']}' AND poles='{$this->_selections['poles']}' 
			)
			UNION 
			(
			SELECT part.part_no, 'results_so_far' AS label
			FROM part
			WHERE cat_id='cb' AND manuf_id={$this->_selections['manuf_id']} AND frame_type='{$this->_selections['frame']}' AND poles='{$this->_selections['poles']}' 
			)
			ORDER BY label ASC, data ASC 
		");
		if($this->queryOK()) {
			$this->notifyObserver('default');
			/*
			 * Using 1-based counting facilitates corresponding template development.
			 * SQL ORDER BY statement dictates 'data' item is first record in result set.
			 * Use this first record to initilialize array at 1 instead of 0.
			 */
			$row = $this->next();
			$this->_data['data'][1] = array(
				'AT' => $row['data'], 
				'QS' => "manuf_id={$this->_selections['manuf_id']}&frame={$this->_selections['frame']}&poles={$this->_selections['poles']}&amps=" . rawurlencode($row['data']) . '&step=amps'
			);
			while($row = $this->next()) {
				if($row['label'] == 'data') {
					$this->_data['data'][] = array(
						'AT' => $row['data'], 
						'QS' => "manuf_id={$this->_selections['manuf_id']}&frame={$this->_selections['frame']}&poles={$this->_selections['poles']}&amps=" . rawurlencode($row['data']) . '&step=amps'
					);
				} else {// should always be at least 1 'result so far' unless LWS DB is incomplete!
					$this->_data['results_so_far'][] = array(
						'part_no' 		=> $row['data'],
						'manuf_slug'	=>	LWS::getManufSlug($this->_selections['manuf_id'])
					);
				}
			}
			$this->_data['back_qs'] = "manuf_id={$this->_selections['manuf_id']}&frame={$this->_selections['frame']}&step=frame";
			return $this->_data;
		} else return NULL;
	}
	
	private function filterForAmps() {
		$this->_search_parameters['Frame Type'] = $this->_selections['frame'];
		$this->_search_parameters['Poles'] = $this->_selections['poles'];
		$this->_search_parameters['Amperage'] = $amps = rawurldecode($this->_selections['amps']);
		$this->query("
			(
			SELECT DISTINCT(volts) AS data, 'data' AS label
			FROM part
			WHERE cat_id='cb' AND manuf_id ={$this->_selections['manuf_id']} AND frame_type='{$this->_selections['frame']}' AND poles='{$this->_selections['poles']}' AND amps='{$amps}' AND volts IS NOT NULL 
			)
			UNION 
			(
			SELECT part.part_no, 'results_so_far' AS label
			FROM part
			WHERE cat_id='cb' AND manuf_id ={$this->_selections['manuf_id']} AND frame_type='{$this->_selections['frame']}' AND poles='{$this->_selections['poles']}' AND amps='{$amps}' AND volts IS NOT NULL  
			)
			ORDER BY label ASC, data ASC 
		");
		if($this->queryOK()) {
			$this->notifyObserver('default');
					/*
			 * Using 1-based counting facilitates corresponding template development.
			 * SQL ORDER BY statement dictates 'data' item is first record in result set.
			 * Use this first record to initilialize array at 1 instead of 0.
			 */
			$row = $this->next();
			$this->_data['data'][1] = array(
				'AT' => $row['data'], 
				'QS' => "manuf_id={$this->_selections['manuf_id']}&frame={$this->_selections['frame']}&poles={$this->_selections['poles']}&amps={$this->_selections['amps']}&volts=" . rawurlencode($row['data']) . '&step=volts'
			);
			while($row = $this->next()) {
				if($row['label'] == 'data') {
					$this->_data['data'][] = array(
						'AT' => $row['data'], 
						'QS' => "manuf_id={$this->_selections['manuf_id']}&frame={$this->_selections['frame']}&poles={$this->_selections['poles']}&amps={$this->_selections['amps']}&volts=" . rawurlencode($row['data']) . '&step=volts'
					);
				} else {// should always be at least 1 'result so far' unless LWS DB is incomplete!
					$this->_data['results_so_far'][] = array(
						'part_no' 		=> $row['data'],
						'manuf_slug'	=>	LWS::getManufSlug($this->_selections['manuf_id'])
					);
				}
			}
			$this->_data['back_qs'] = "manuf_id={$this->_selections['manuf_id']}&frame={$this->_selections['frame']}&poles={$this->_selections['poles']}&step=poles";
			return $this->_data;
		} else return NULL;
	}
	
	private function filterForVolts() {
		$this->_search_parameters['Frame Type'] = $this->_selections['frame'];
		$this->_search_parameters['Poles'] = $this->_selections['poles'];
		$this->_search_parameters['Amperage'] = $amps = rawurldecode($this->_selections['amps']);
		$this->_search_parameters['Voltage'] = $volts = rawurldecode($this->_selections['volts']);
		$this->query("
			SELECT part.part_no, img, manuf_slug, ns_new_id, ns_green_id  
			FROM part INNER JOIN manufacturer USING(manuf_id) LEFT JOIN store USING(part_no) 
			WHERE cat_id='cb' AND manuf_id={$this->_selections['manuf_id']} AND frame_type='{$this->_selections['frame']}' AND poles='{$this->_selections['poles']}' AND amps='{$amps}' AND volts='{$volts}'  
			ORDER BY part_no ASC
			LIMIT 1
		");
		if($this->queryOK()) {
			$this->notifyObserver('default');
			// result set should only have 1 record
			$this->_data[] = array('part' => $this->next());
			return $this->_data;
		} else return NULL;
	}
	
	public function executeStep() {
 		$step = ucfirst($this->_step);
 		$method = "filterFor{$step}";
 		return $this->$method();
 	}
 	
 	public function getSearchParameters() {
 		return $this->_search_parameters;
 	}
}