<?php

require_once 'Parser.class.php';

class GuildParser extends Parser {

	function __construct($file) {
		parent::__construct($file); 
		$this->sections = array('UNIQUE' => 'Guild');
	}
	
	function getFormattedData($section, $array) {
		return array('id' => $array[0], 'nom' => utf8_encode($array[1]));
	}

}
?>