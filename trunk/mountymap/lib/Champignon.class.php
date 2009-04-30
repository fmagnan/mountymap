<?php

require_once 'LocatedObject.class.php';
require_once 'ChampignonFactory.class.php';

class Champignon extends LocatedObject {

	function getType() {
		return $this->getData('type');
	}
	
	function getCellInfo() {
		return $this->getFormattedPosition() . ' ' . $this->getId() . ' ' . $this->getType();
	}
	
}

?>