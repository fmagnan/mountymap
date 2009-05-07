<?php

require_once 'LocatedObject.class.php';
require_once 'PlaceFactory.class.php';

class Place extends LocatedObject {

	function getNom() {
		return $this->getData('nom');
	}
	
	function getCellInfo() {
		return $this->getFormattedPosition().' '.$this->getNom().' ('.$this->getId().')';
	}
	
}

?>