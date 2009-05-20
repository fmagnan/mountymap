<?php

require_once 'LocatedObject.class.php';
require_once 'TrollPositionFactory.class.php';
require_once 'TrollIdentityFactory.class.php';

class Troll extends LocatedObject {

	function initIdentityData() {
		$trollIdentityFactory = TrollIdentityFactory::getInstance();
		$identity = $trollIdentityFactory->getInstanceFromObject($this);
		$this->data = array_merge($this->data, $identity->getAllData());
	}
	
	function initPositionData() {
		$trollPositionFactory = TrollPositionFactory::getInstance();
		$position = $trollPositionFactory->getInstanceFromObject($this);
		if (is_object($position)) {
			$this->data = array_merge($this->data, $position->getAllData());
		}
	}
	
	function getRace() {
		return $this->getData('race');	
	}
	
	function getLevel() {
		return $this->getData('niveau');	
	}
	
	function getNumeroGuilde() {
		return $this->getData('id_guilde');
	}
	
	function getGuild() {
		$guildFactory = GuildFactory::getInstance();
		return $guildFactory->getInstanceFromArray(array('id' => $this->getNumeroGuilde()));	
	}
	
	function getFullName() {
		$this->initIdentityData();
		$identity = '<a href="javascript:EPV('.$this->getId().')">'. $this->getName() . '</a> (' . $this->getRace() . ' ' . $this->getLevel() . ') ';
		$guild = $this->getGuild();
		$identity .= $guild->getFormattedIdentity(); 
		return $identity;
	}
	
	function getTableRow($class='') {
		$this->initPositionData();
		return parent::getTableRow($class);
	}
	
}

?>