<?php

require_once 'DatabaseObject.class.php';
require_once 'GuildFactory.class.php';
require_once 'HtmlTool.class.php';

class Guild extends DatabaseObject {
	
	function getFormattedIdentity() {
		return HtmlTool::getGuildLink($this->getId(), $this->getName());
	}
	
	function getAllTrolls($limit=false) {
		return TrollIdentityFactory::getInstance()->getTrollsFromGuild($this->getId(), $limit);
	}
	
}

?>