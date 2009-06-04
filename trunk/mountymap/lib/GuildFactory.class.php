<?php

require_once 'DatabaseObjectFactory.class.php';
require_once 'Guild.class.php';

class GuildFactory extends DatabaseObjectFactory {
	
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
			'nom' => 'string',
		);
	}
	
	function getPrimaryKeyDescr() {
		return array(
			'id' => 'int',
		);
	}
	
	function getTableName() {
		return 'guilde';
	}
	
	function getSearchTableHeaders() {
		return TrollPositionFactory::getInstance()->getSearchTableHeaders();
	}
	
}
?>