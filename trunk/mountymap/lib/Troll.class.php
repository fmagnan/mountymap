<?php

require_once 'LocatedObject.class.php';
require_once 'TrollPositionFactory.class.php';
require_once 'TrollIdentityFactory.class.php';
require_once 'HtmlTool.class.php';

class Troll extends LocatedObject {

	function initIdentityData() {
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
	
	function getRace() {
		return $this->getData('race');	
	}
	
	function getLevel() {
		return $this->getData('niveau');	
	}
	
	function getGuildNumber() {
		return $this->getData('id_guilde');
	}
	
	function getGuild() {
		$guildFactory = GuildFactory::getInstance();
		return $guildFactory->getInstanceFromArray(array('id' => $this->getGuildNumber()));	
	}
	
	function getFullName() {
		if ('' == $this->getName()) {
			$this->initIdentityData();
		}
		$identity = HtmlTool::getInstance()->getTrollLink($this->getId(), $this->getName(), $this->getRace(), $this->getLevel());
		$guild = $this->getGuild();
		$identity .= $guild->getFormattedIdentity();
		return $identity;
	}
	
}

?>