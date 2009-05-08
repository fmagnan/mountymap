<?php

require_once 'LocatedObject.class.php';
require_once 'MonsterFactory.class.php';

class Monster extends LocatedObject {

	function getCellInfo() {
		return $this->getFormattedPosition() . $this->getFullName();
	}
	
	function getName() {
		return $this->getData('nom');
	}
	
	function getSize() {
		return $this->getData('taille');
	}
	
	function getTemplate() {
		return $this->getData('template');
	}
	
	function getAge() {
		return $this->getData('age');
	}
	
	function getMark() {
		return $this->getData('marquage');
	}

	function getFullName() {
		$name = $this->getName();
		$template = $this->getTemplate();
		$size = $this->getSize();
		$age = $this->getAge();
		$mark = $this->getMark();
		$fullName = $size . ' '. $name . ' '. $template . ' ['.$age.']'.$mark;
		return '<a href="javascript:EMV('.$this->getId().')">'.$fullName.'</a>';
	}
	
}

?>