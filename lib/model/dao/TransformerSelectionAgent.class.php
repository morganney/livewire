<?php

 class TransformerSelectionAgent extends DAO {
 	
 	/**
 	 * 
 	 * Added 'LEFT JOIN store USING(part_no) ... & WHERE display > 0' to SQL on 1/31/2011
 	 * so that when pricing was turned off for a Transformer, it wouldn't show up in the 
 	 * selection tool either.  Consider adding a flag to tr_meta table so that using a 
 	 * join is not necessary for this purpose.
 	 */
 	protected $_step;
 	protected $_selections;
 	protected $_data;
 	protected $_back_qs;
 	
 	protected $_volt_vary_map = array(
 		'12/24'			=>	NULL,
 		'120/208'		=>	'110, 115, 120, 125, 130:200, 210',
 		'120/240'		=>	'110, 115, 120, 125, 130:215, 220, 230, 240',
 		'16/32'			=>	NULL,
 		'208'				=>	'200, 210',
 		'208/120'		=>	'200, 210:110, 115, 120, 125, 130',
 		'220/127'		=>	NULL,
 		'24/48'			=>	NULL,
 		'240'				=>	'215, 220, 230, 240',
 		'240/120'		=>	'215, 220, 230, 240:110, 115, 120, 125, 130',
 		'240/480'		=>	'215, 220, 230, 240:430, 440, 450, 460, 470, 490, 500',
 		'277'				=>	NULL,
 		'380'				=>	'400',
 		'480'				=>	'430, 440, 450, 460, 470, 490, 500',
 		'480/277'		=>	'430, 440, 450, 460, 470, 490, 500',
 		'600'				=>	NULL
 	);
 	
 	/**
 	 * Constructor for class.
 	 * @param String $step, the name of the step, e.g. 'kva', 'phase', 'input', or 'output'
 	 * @param Mixed Array $selections, all current request parameters passed from the controller
 	 */
 	public function __construct($selections) {
 		parent::__construct();
 		$this->_selections = $selections;
 		$this->_step = $this->_selections['step'];
 		$this->_data = array();
 		$this->_back_qs = '';
 	}
 	
 	private function getKvaCondition($selected_kva) {
 		$kva_condition = $selected_kva == 'max' ? 'kva >= 500' : "kva={$this->_selections['kva']}";
 		return $kva_condition;
 	}
 	
 	private function filterForKva() {
		$this->query("
			SELECT DISTINCT(phase) 
			FROM tr_meta INNER JOIN part USING(part_no) LEFT JOIN store USING(part_no)  
			WHERE phase > 0 AND cat_id='tr' AND kva={$this->_selections['kva']} AND display > 0
			ORDER BY phase ASC
		");
		if($this->queryOK()) {
			$this->notifyObserver('default');
			while($row = $this->next()) {
				if($row['phase'] == 1) $this->_data[] = array('AT' => 'Single-Phase (1P)', 'QS' => "kva={$this->_selections['kva']}&phase=1&step=phase");
				else $this->_data[] = array('AT' => 'Three-Phase  (3P)', 'QS' => "kva={$this->_selections['kva']}&phase=3&step=phase");
			}
			// no need to update $this->_back_qs for this step
			return $this->_data;
		} else return NULL;
 	}
 	
 	private function filterForPhase() {
		$this->query("
			SELECT DISTINCT(input_volts) 
			FROM tr_meta INNER JOIN part USING(part_no) LEFT JOIN store USING(part_no) 
			WHERE phase={$this->_selections['phase']} AND cat_id='tr' AND kva={$this->_selections['kva']} AND display > 0 
			ORDER BY input_volts ASC
		");
		if($this->queryOK()) {
			while($row = $this->next()) {
				$vv = explode(':', $this->_volt_vary_map[$row['input_volts']]);
				if(!empty($vv[0])) {
					$vary_volts = $vv;
				} else $vary_volts = NULL;
				$query_string = "kva={$this->_selections['kva']}&phase={$this->_selections['phase']}&input=" . rawurlencode($row['input_volts']) . '&step=input';
				$this->_data[] = array('AT' => $row['input_volts'], 'QS' => $query_string, 'VV' => $vary_volts);
			}
			$this->_back_qs = "kva={$this->_selections['kva']}&step=kva";
			return $this->_data;
		} else return NULL;
 	}
 	
 	private function filterForInput() {
 		/*
 		 * FYI:
 		 * The query parameter removes '_volts' from the corresponding database field for input/output,
 		 * so this affects how you access the value in $this->_selections associative array.
 		 */
 		$input_volts = rawurldecode($this->_selections['input']);
		$this->query("
			SELECT DISTINCT(output_volts) 
			FROM tr_meta INNER JOIN part USING(part_no) LEFT JOIN store USING(part_no) 
			WHERE phase={$this->_selections['phase']} AND input_volts='{$input_volts}' AND cat_id='tr' AND kva={$this->_selections['kva']} AND display > 0 
			ORDER BY output_volts ASC 
		");
		if($this->queryOK()) {
			while($row = $this->next()) {
				$vv = explode(':', $this->_volt_vary_map[$row['output_volts']]);
				if(!empty($vv[0])) {
					$vary_volts = $vv;
				} else $vary_volts = NULL;
				$query_string = "kva={$this->_selections['kva']}&phase={$this->_selections['phase']}&input=" . rawurlencode($this->_selections['input']) . "&output=" . rawurlencode($row['output_volts']) . '&step=output';
				$this->_data[] = array('AT' => $row['output_volts'], 'QS' => $query_string, 'VV' => $vary_volts);
			}
			$this->_back_qs = "kva={$this->_selections['kva']}&phase={$this->_selections['phase']}&step=phase";
			return $this->_data;
		} else return NULL;
 	}
 	
 	/**
 	 * Returns the matching parts based on user selections. 
 	 * Corresponding template for this step is the results landing page.
 	 */
 	private function filterForOutput() {
 		/*
 		 * FYI:
 		 * The query parameter removes '_volts' from the corresponding database field for input/output,
 		 * so this affects how you access the value in $this->_selections associative array.
 		 */ 
 		$input_volts = rawurldecode($this->_selections['input']);
 		$output_volts = rawurldecode($this->_selections['output']);
 		
		$this->query("
			SELECT part.part_no, specs, kva, img, manuf, manuf_slug, ns_new_id, ns_green_id, display, input_volts, output_volts, phase, enclosure_type, mounting_style, notes 
			FROM part INNER JOIN manufacturer USING(manuf_id) LEFT JOIN store USING(part_no) INNER JOIN tr_meta USING(part_no) 
			WHERE cat_id='tr' AND kva={$this->_selections['kva']} AND  phase={$this->_selections['phase']} AND input_volts='{$input_volts}' AND output_volts='{$output_volts}' AND display > 0
			ORDER BY manuf, part.part_no ASC 
		");
		if($this->queryOK()) {
			$i = 0;
			while($row = $this->next()) {
				$query_string = $row['part_no'];
				$this->_data[] = array('part' => $row, 'QS' => $query_string);
				$i++;
			}
			return $this->_data;
		} else return NULL;
 	}
 	
 	public function executeStep() {
 		$step = ucfirst($this->_step);
 		$method = "filterFor{$step}";
 		return $this->$method();
 	}
 	
 	public function getBackQs() {
 		return $this->_back_qs;
 	}
 	
 }
 
 