<?php

require_once 'NonPermanentDatabaseObjectFactory.class.php';

class ChampignonFactory extends NonPermanentDatabaseObjectFactory {
	
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
			'type' => 'string',
			'position_x' => 'int',
			'position_y' => 'int',
			'position_n' => 'int',
		);
	}
	
	function getPrimaryKeyDescr() {
		return array(
			'id' => 'int',
		);
	}
	
	function getTableName() {
		return 'champignon';
	}
	
	function getCellHeader() {
		return 'Champignons';
	}
}
?>