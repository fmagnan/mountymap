<?php

require_once 'PublicParser.class.php';

class GuildParser extends PublicParser {

	function __construct() {
		parent::__construct('Public_Guildes.txt'); 
		$this->sections = array('UNIQUE' => 'Guild');
	}
	
	function getFormattedData($section, $array) {
		return array('id' => $array[0], 'nom' => utf8_encode($array[1]));
	}

}
?>