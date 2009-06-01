<?php

require_once 'DatabaseObject.class.php';
require_once 'GuildFactory.class.php';
require_once 'HtmlTool.class.php';

class Guild extends DatabaseObject {
	
	function getFormattedIdentity() {
		return HtmlTool::getGuildLink($this->getId(), $this->getName());
	}
	
	function getTableRow($class='') {
		$row = '';
		$trollFactory = TrollIdentityFactory::getInstance();
		$trolls = $trollFactory->getInstancesFromArray(array('id_guilde' => $this->getId()));
		$counter = 0;
		foreach($trolls as $troll) {
			$class = $counter % 2 == 0 ? 'even' : 'odd';
			$row .= $troll->getTableRow($class);
			$counter++;
		}
		return $row;
	}
	
}

?>