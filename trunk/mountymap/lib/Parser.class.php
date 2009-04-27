<?php

abstract class Parser {

	var $file, $data, $errors, $flags;
	var $sections = array('UNIQUE' => 'Guild');
	
	function __construct($file) {
		$this->file = $file;
		$this->data = array();
		$this->errors = array();
		$this->flags = array();
	}
	
	function getSections() {
		return $this->sections;
	}
	
	function parseFile() {
		$viewHandle = fopen($this->file, "r");
		if ($viewHandle) {
			foreach($this->sections AS $section => $object) {
				$this->initSection($section);
			}
			
			while (!feof($viewHandle) && ($line = trim(fgets($viewHandle))) != '') {
				foreach ($this->sections AS $section => $object) {
					$this->parseSection($section, $line);	
				}
			}
		} else {
			$this->errors[] = 'erreur à l\'ouverture du fichier ' . $this->file;
		}
		$closeResult = fclose($viewHandle);
		if (!$closeResult) {
			$this->errors[] = 'erreur à la fermeture du fichier ' . $this->file;
		}
	}
	
	function getData($section) {
		return $this->data[$section];
	}
	
	function isInErrorStatus() {
		return !empty($this->errors);
	}
	
	function initSection($section) {
		$this->data[$section] = array();
	}
	
	function parseSection($section, $line) {
		$lineInArray = explode(';', $line);
		$this->data[$section][] = $this->getFormattedData($section, $lineInArray);
	}
	
	abstract function getFormattedData($section, $array);

}
?>