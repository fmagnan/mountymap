<?php

require_once 'LocatedObject.class.php';
require_once 'TrollPositionFactory.class.php';
require_once 'TrollIdentityFactory.class.php';

class Troll extends LocatedObject {

	function initIdentityData() {
		$trollIdentityFactory = TrollIdentityFactory::getInstance();
		$troll = $trollIdentityFactory->getInstanceFromObject($this);
		$this->data = array_merge($this->data, $troll->getAllData());
	}
	
	function getName() {
		return $this->getData('nom');	
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
	
	function getFormattedIdentity() {
		$this->initIdentityData();
		$identity = '<a href="javascript:EPV('.$this->getId().')">'. $this->getName() . '</a> (' . $this->getRace() . ' ' . $this->getLevel() . ') ';
		$guild = $this->getGuild();
		$identity .= $guild->getFormattedIdentity(); 
		return $identity;
	}
	
	function getCellInfo() {
		return parent::getFormattedPosition() . ' ' . $this->getFormattedIdentity();
	}
}

?>