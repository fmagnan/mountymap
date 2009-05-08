<?php

require_once 'DatabaseObject.class.php';
require_once 'GuildFactory.class.php';

class Guild extends DatabaseObject {
	
	function getName() {
		return $this->getData('nom');
	}
	
	function getId() {
		return $this->getData('id');
	}
	
	function getFormattedIdentity() {
		return '<a href="javascript:EAV('.$this->getId().')">'. $this->getName() . '</a>';
	}
	
	function getTableRow() {
		$row = '';
		$trollFactory = TrollIdentityFactory::getInstance();
		$trolls = $trollFactory->getInstancesFromArray(array('id_guilde' => $this->getId()));
		foreach($trolls as $troll) {
			$row .= $troll->getTableRow();
		}
		return $row;
	}
	
}

?>