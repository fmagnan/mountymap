<?php

require_once 'LocatedObject.class.php';
require_once 'TrollPositionFactory.class.php';
require_once 'TrollIdentityFactory.class.php';
require_once 'HtmlTool.class.php';

class Troll extends LocatedObject {

	function initIdentityData() {
		if ('' == $this->getName()) {
			$trollIdentityFactory = TrollIdentityFactory::getInstance();
			$identity = $trollIdentityFactory->getInstanceFromObject($this);
			if (is_object($identity)) {
				foreach($identity->getAllData() as $key => $value) {
					if (!array_key_exists($key, $this->data)) {
						$this->data[$key] = $value;
					}
				}
			}
		}
	}
	
	function getRace() {
		return $this->getData('race');	
	}
	
	function getLevel() {
		return $this->getData('niveau');	
	}
	
	function getGuildNumber() {
		return $this->getData('id_guilde');
	}
	
	function getGuildIdentity() {
		return $this->getGuild()->getFormattedIdentity();
	}
	
	function getLink() {
		return HtmlTool::getInstance()->getTrollLink($this->getId(), $this->getName());
	}
	
	function getGuild() {
		return GuildFactory::getInstance()->getInstanceFromArray(array('id' => $this->getGuildNumber()));	
	}
	
	function getSimpleIdentity() {
		$this->initIdentityData();
		return $this->getLink();
	}
	
	function getFullName() {
		$this->initIdentityData();
		return $this->getLink() . ' (' . $this->getRace() . ' ' . $this->getLevel() . ') ' . $this->getGuild()->getFormattedIdentity();
	}
	
}

?>