<?php

require_once 'DatabaseObject.class.php';
require_once 'MemberFactory.class.php';

class Member extends DatabaseObject {

	function getPassword() {
		return $this->getData('password');
	}
	
	function getFormattedPosition() {
		$trollFactory = TrollPositionFactory::getInstance();
		$troll = $trollFactory->getInstanceFromObject($this);
		return is_object($troll) ? $troll->getFormattedPosition() : 'position inconnue';
	}
	
	function getName() {
		$identity = TrollIdentityFactory::getInstance()->getInstanceFromObject($this);
		return (is_object($identity) && !$identity->isError()) ? $identity->getName() : 'nom inconnu';
	}
}

?>