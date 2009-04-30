<?php

require_once 'DatabaseObject.class.php';

abstract class LocatedObject extends DatabaseObject {

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
	
	function getId() {
		return $this->getData('id');	
	}
	
	abstract function getCellInfo();
}

?>