<?php

require_once 'LocatedObjectFactory.class.php';
require_once 'Troll.class.php';

class TrollPositionFactory extends LocatedObjectFactory {
	
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
		return 'troll_position';
	}
	
	function getInstanceClassName() {
		return 'troll';
	}
	
	function getCellHeader() {
		return 'Trolls';
	}
}
?>