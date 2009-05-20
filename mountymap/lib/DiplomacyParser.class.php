<?php

require_once 'PublicParser.class.php';

class DiplomacyParser extends PublicParser {

	function __construct() {
		parent::__construct('Public_Diplomatie.txt'); 
		$this->sections = array('UNIQUE' => 'Diplomacy');
	}
	
	function getFormattedData($section, $array) {
		$data = array(
			'id' => $array[0],
			'target_type' => $array[1],
			'target_id' => $array[2],
			'name' => utf8_encode($array[3]),
			'side' => strtolower($array[4]),
		);
		return $data;
	}

}
?>