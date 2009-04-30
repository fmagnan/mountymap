<?php

require_once 'LocatedObject.class.php';
require_once 'TresorFactory.class.php';

class Tresor extends LocatedObject {

	function getType() {
		return $this->getData('type');
	}
	
	function getCellInfo() {
		return $this->getFormattedPosition() . ' <a href="javascript:ETV('.$this->getId().')">'. $this->getType() . '</a>';
	}
	
}

?>