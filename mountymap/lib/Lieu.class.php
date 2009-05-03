<?php

require_once 'LocatedObject.class.php';
require_once 'LieuFactory.class.php';

class Lieu extends LocatedObject {

	function getNom() {
		return $this->getData('nom');
	}
	
	function getCellInfo() {
		return $this->getFormattedPosition().' '.$this->getNom().' ('.$this->getId().')';
	}
	
}

?>