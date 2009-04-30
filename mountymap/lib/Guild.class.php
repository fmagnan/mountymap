<?php

require_once 'DatabaseObject.class.php';
require_once 'GuildFactory.class.php';

class Guild extends DatabaseObject {
	
	function getName() {
		return $this->getData('nom');
	}
	
}

?>