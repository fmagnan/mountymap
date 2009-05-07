<?php

require_once 'DatabaseObject.class.php';

abstract class LocatedObject extends DatabaseObject {

	function isPositionKnown() {
		return $this->getPositionX() != '' && $this->getPositionY() != '' && $this->getPositionN() != '';
	}
	
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
	
	function output() {
		if ($this->isPositionKnown()) {
			return '<li>'.$this->getCellInfo() . ' ' . $this->getLinkToMap().'</li>';
		}
	}
	
	function getLinkToMap() {
		$range = 10;
		$start_n = $this->getPositionN() + 5;
		$end_n = $this->getPositionN() - 5; 
		$href = 'map.php?position_x='.$this->getPositionX().'&position_y='.$this->getPositionY().'&start_n='.$start_n.'&end_n='.$end_n.'&range=10';
		return '<a href="'.$href.'">visualiser sur la carte</a>';
	}
	
	abstract function getCellInfo();
}

?>