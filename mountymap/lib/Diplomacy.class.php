<?php

require_once 'DatabaseObject.class.php';
require_once 'DiplomacyFactory.class.php';

class Diplomacy extends DatabaseObject {
	
	function getSide() {
		return $this->getData('side');
	}
	
}

?>