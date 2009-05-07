<?php

require_once 'LocatedObject.class.php';
require_once 'TreasureFactory.class.php';

class Treasure extends LocatedObject {

	function getType() {
		return $this->getData('type');
	}
	
	function getCellInfo() {
		return $this->getFormattedPosition() . ' <a href="javascript:ETV('.$this->getId().')">'. $this->getType() . '</a>';
	}
	
}

?>