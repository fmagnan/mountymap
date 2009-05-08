<?php

require_once 'LocatedObject.class.php';
require_once 'TreasureFactory.class.php';

class Treasure extends LocatedObject {

	function getName() {
		return $this->getData('nom');
	}
	
	function getCellInfo() {
		return $this->getFormattedPosition() . ' <a href="javascript:ETV('.$this->getId().')">'. $this->getName() . '</a>';
	}
	
}

?>