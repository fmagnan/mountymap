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
	
	function isActive() {
		return $this->getData('is_active') == 1;
	}
	
	function getName() {
		$identity = TrollIdentityFactory::getInstance()->getInstanceFromObject($this);
		return (is_object($identity) && !$identity->isError()) ? $identity->getName() : 'inconnu';
	}
	
	function getDiplomacyId() {
		return $this->getData('diplomacy_id');
	}
	
	function getPositionX() {
		return $this->getData('position_x');
	}
	
	function getPositionY() {
		return $this->getData('position_y');
	}

	function getPositionN() {
		return $this->getData('position_n');
	}
	
	function getDiplomacyGuild() {
		return GuildFactory::getInstance()->getInstanceFromArray(array('id' => $this->getDiplomacyId()));
	}
	
	function setIsActive($value) {
		$this->update(array('is_active' => $value));
	}
	
	function activate() {
		$this->setIsActive(1);
	}
	
	function deactivate() {
		$this->setIsActive(0);
	}
	
	function getActivationCode() {
		return $this->getData('activation_code');
	}
}

?>