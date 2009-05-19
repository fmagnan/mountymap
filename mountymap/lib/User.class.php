<?php

require_once 'DatabaseObject.class.php';
require_once 'UserFactory.class.php';

class User extends DatabaseObject {

	function getPassword() {
		return $this->getData('password');
	}
	
	function isAdmin() {
		return $this->getData('is_admin') == 1;
	}
	
	function getName() {
		return TrollIdentityFactory::getInstance()->getInstanceFromObject($this)->getName();
	}
	
	function getDiplomacyId() {
		return $this->getData('diplomacy_id');
	}
	
	function getDiplomacyGuild() {
		return GuildFactory::getInstance()->getInstanceFromArray(array('id' => $this->getDiplomacyId()));
	}
	
}

?>