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
		$formattedPosition = '<strong>X = ' .$this->getPositionX().' | Y = '.$this->getPositionY();
		$formattedPosition .= ' | N = '.$this->getPositionN() .'</strong>';
		return $formattedPosition;
	}
	
	abstract function getCellInfo();
}

?>