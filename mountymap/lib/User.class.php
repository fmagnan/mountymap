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
	
	/*function getDiplomacySideFor($troll) {
		$diplomacyFactory = DiplomacyFactory::getInstance();
		$trollData = array('id' => $this->getDiplomacyId(), 'target_type' => 'T', 'target_id' => $troll->getId());
		$diplomacy = $diplomacyFactory->getInstanceFromArray($trollData);
		if (!$diplomacy->isError()) {
			return $diplomacy->getSide();
		} else {
			$troll->initIdentityData();
			$guildData = array('id' => $this->getDiplomacyId(), 'target_type' => 'G', 'target_id' => $troll->getGuildNumber());
			$diplomacy = $diplomacyFactory->getInstanceFromArray($guildData);
			if (!$diplomacy->isError()) {
				return $diplomacy->getSide();
			}
		}
		return false;		
	}*/
	
}

?>