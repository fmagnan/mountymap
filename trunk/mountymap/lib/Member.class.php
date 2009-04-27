<?php

require_once 'DatabaseObject.class.php';
require_once 'MemberFactory.class.php';

class Member extends DatabaseObject {

	function getPassword() {
		return $this->getData('password');
	}
	
	function getId() {
		return $this->getData('id');
	}
	
	function getUpdate() {
		return getDateEnFrancais($this->getData('mise_a_jour'));
	}
	
	function getFormattedPosition() {
		$trollFactory = TrollFactory::getInstance();
		$troll = $trollFactory->getInstanceFromObject($this);
		return $troll->getFormattedPosition();
	}
	
	function getName() {
		return 'TODO';
	}
}

?>