<?php

require_once 'LocatedObject.class.php';
require_once 'MonsterFactory.class.php';

class Monster extends LocatedObject {

	function getCellInfo() {
		return $this->getFormattedPosition() . '' . $this->getId() . ' ' . $this->getName();
	}
	
	function getName() {
		return $this->getData('nom');
	}
	
}

?>