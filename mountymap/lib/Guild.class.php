<?php

require_once 'DatabaseObject.class.php';
require_once 'GuildFactory.class.php';
require_once 'HtmlTool.class.php';

class Guild extends DatabaseObject {
	
	function getFormattedIdentity() {
		return HtmlTool::getGuildLink($this->getId(), $this->getName());
	}
	
	function getAllTrolls() {
		$trollsWithPosition = array();
		$trolls = TrollIdentityFactory::getInstance()->getInstancesFromArray(array('id_guilde' => $this->getId()));
		foreach($trolls as $troll) {
			$position = TrollPositionFactory::getInstance()->getInstanceFromArray(array('id' => $troll->getId()));
			if (is_object($position) && !$position->isError()) {
				$trollsWithPosition[] = $position;
			}
		}
		return $trollsWithPosition;
	}
	
}

?>