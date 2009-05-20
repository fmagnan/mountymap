<?php

require_once 'PublicParser.class.php';

class GuildParser extends PublicParser {

	function __construct() {
		parent::__construct('Public_Guildes.txt'); 
		$this->sections = array('UNIQUE' => 'Guild');
	}
	
	function getFormattedData($section, $array) {
		$patterns = array('/\x83/', '/\x92/', '/\x95/', '/\x99/');
		$replacements = array('f', '\'', '.', 'tm');
		
		$data = array(
			'id' => $array[0],
			'nom' => utf8_encode(preg_replace($patterns, $replacements, $array[1])),
		); 
		return $data;
	}

}
?>