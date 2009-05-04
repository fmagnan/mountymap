<?php

require_once 'DatabaseObject.class.php';
require_once 'MemberFactory.class.php';

class Member extends DatabaseObject {

	function getPassword() {
		return $this->getData('password');
	}
	
	function getUpdate() {
		return getDateEnFrancais($this->getData('mise_a_jour'));
	}
	
	function getFormattedPosition() {
		$trollFactory = TrollPositionFactory::getInstance();
		$troll = $trollFactory->getInstanceFromObject($this);
		if (is_object($troll)) {
			return $troll->getFormattedPosition();
		} else {
			return 'position inconnue';
		}
	}
	
	function getName() {
		$trollFactory = TrollIdentityFactory::getInstance();
		return $trollFactory->getInstanceFromObject($this)->getName();
	}
}

?>