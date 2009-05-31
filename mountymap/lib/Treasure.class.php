<?php

require_once 'LocatedObject.class.php';
require_once 'TreasureFactory.class.php';
require_once 'HtmlTool.class.php';

class Treasure extends LocatedObject {

	function getFullName() {
		return HtmlTool::getInstance()->getTreasureLink($this->getId(), $this->getName());
	}
	
}

?>