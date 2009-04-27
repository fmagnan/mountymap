<?php

require_once 'DatabaseObject.class.php';
require_once 'TrollFactory.class.php';

class Troll extends DatabaseObject {

	function getPositionX() {
		return $this->getData('position_x');
	}
	
	function getPositionY() {
		return $this->getData('position_y');
	}
	
	function getPositionN() {
		return $this->getData('position_n');
	}
	
	function getFormattedPosition() {
		return implode(' / ', array($this->getPositionX(), $this->getPositionY(), $this->getPositionN()));
	}
}

?>