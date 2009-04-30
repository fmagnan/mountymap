<?php

require_once 'LocatedObject.class.php';
require_once 'MonsterFactory.class.php';

class Monster extends LocatedObject {

	function getCellInfo() {
		return $this->getFormattedPosition() . ' <a href="javascript:EMV('.$this->getId().')">'. $this->getName() . '</a>';
	}
	
	function getName() {
		return $this->getData('nom');
	}
	
}

?>