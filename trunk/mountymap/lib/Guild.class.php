<?php

require_once 'DatabaseObject.class.php';
require_once 'GuildFactory.class.php';

class Guild extends DatabaseObject {
	
	function getName() {
		return $this->getData('nom');
	}
	
	function getFormattedIdentity() {
		return '<a href="javascript:EAV('.$this->getId().')">'. $this->getName() . '</a>';
	}
	
}

?>