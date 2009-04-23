<?php

require_once 'DatabaseObjectFactory.class.php';
require_once 'Troll.class.php';

class TrollFactory extends DatabaseObjectFactory {
	
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
		return 'troll';
	}
	
	function insertOrUpdateTroll($data) {
		$troll = $this->getInstanceFromArray($data);
		if ($troll->isError()) {
			$data['mise_a_jour'] = 'NOW()';
			$this->create($data);
		} else {
			$troll->update($data);
		}
	}
	
}
?>