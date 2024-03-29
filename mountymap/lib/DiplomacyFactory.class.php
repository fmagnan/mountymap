<?php

require_once 'DatabaseObjectFactory.class.php';
require_once 'Diplomacy.class.php';

class DiplomacyFactory extends DatabaseObjectFactory {
	
	private static $instance;
	
	public static function getInstance() {
		if ( !isset(self::$instance) ) {
			$className = __CLASS__;
			self::$instance = new $className();
    	}
	    return self::$instance;
	}
	
	function getDataColumnsDescr() {
		return array(
			'mise_a_jour' => 'date',
			'name' => 'string',
			'side' => 'string',
		);
	}
	
	function getPrimaryKeyDescr() {
		return array(
			'id' => 'int',
			'target_type' => 'string',
			'target_id' => 'int',
		);
	}
	
	function getTableName() {
		return 'diplomacy';
	}
	
}
?>