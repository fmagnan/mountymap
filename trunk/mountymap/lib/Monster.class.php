<?php

require_once 'LocatedObject.class.php';
require_once 'MonsterFactory.class.php';
require_once 'HtmlTool.class.php';

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
		return HtmlTool::getInstance()->getMonsterLink($this->getId(), $this->getSize(), $this->getName(), $this->getTemplate(), $this->getAge(), $this->getMark());
	}
	
}

?>