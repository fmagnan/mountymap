<?php

require_once 'LocatedObject.class.php';
require_once 'PlaceFactory.class.php';

class Place extends LocatedObject {

	function getName() {
		return $this->getData('nom');
	}
	
	function getCellInfo() {
		return parent::getCellInfo() . ' ('.$this->getId().')';
	}
	
	function getFullName() {
		return $this->getName();
	}
	
}

?>