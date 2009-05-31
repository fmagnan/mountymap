<?php

require_once 'LocatedObject.class.php';
require_once 'PlaceFactory.class.php';

class Place extends LocatedObject {

	function getFullName() {
		return $this->getName();
	}
	
}

?>