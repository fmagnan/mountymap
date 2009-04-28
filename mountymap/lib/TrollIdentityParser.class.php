<?php

require_once 'Parser.class.php';

class TrollIdentityParser extends Parser {

	function __construct($file) {
		parent::__construct($file); 
		$this->sections = array('UNIQUE' => 'TrollIdentity');
	}
	
	function getFormattedData($section, $array) {
		$data = array(
			'id' => $array[0],
			'nom' => utf8_encode($array[1]),
			'race' => utf8_encode($array[2]),
			'niveau' => $array[3],
			'id_guilde' => $array[6], 
			'nombre_mouches' => $array[7],
		);
		return $data;
	}

}
?>