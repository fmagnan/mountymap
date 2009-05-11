<?php

require_once 'LocatedObject.class.php';
require_once 'TreasureFactory.class.php';

class Treasure extends LocatedObject {

	function getName() {
		return $this->getData('nom');
	}
	
	function getFullName() {
		return '<a href="javascript:ETV('.$this->getId().')">'. $this->getName() . '</a>';
	}
	
}

?>