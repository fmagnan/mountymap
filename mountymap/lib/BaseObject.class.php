<?php

class BaseObject {
	var $errors = array();

	function addError($error) {
		$this->errors[] = $error;
	}
	
	function isError() {
		return !empty($this->errors);
	}
	
	function getErrors() {
		return $this->errors;
	}
	
	function printErrors() {
		print_r($this->errors);
	}
	
	function resetErrors() {
		$this->errors = array();
	}
	
}

?>