<?php

require_once 'LocatedObject.class.php';
require_once 'MonsterFactory.class.php';

class Monster extends LocatedObject {

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
		$fullName = array();
		if ($this->getSize() != '') {
			$fullName[] = $this->getSize();
		}
		$fullName[] = $this->getName();
		if ($this->getTemplate() != '') {
			$fullName[] = $this->getTemplate();
		}
		$fullName[] = '[' . $this->getAge() . ']';
		if ($this->getMark() != '') {
			$fullName[] = $this->getMark();
		}
		return '<a href="javascript:EMV('.$this->getId().')">'.implode(' ', $fullName).'</a>';
	}
	
}

?>