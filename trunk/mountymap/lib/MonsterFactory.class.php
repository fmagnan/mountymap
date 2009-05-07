<?php

require_once 'NonPermanentDatabaseObjectFactory.class.php';
require_once 'Monster.class.php';

class MonsterFactory extends NonPermanentDatabaseObjectFactory {
	
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
			'template' => 'string',
			'taille' => 'string',
			'age' => 'string',
			'marquage' => 'string',
			'famille' => 'string',
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
		return 'monstre';
	}
	
	function getCellHeader() {
		return 'Monstres';
	}
	
	function getMonsterTypes() {
		//$query = 'SELECT `nom`, COUNT(`id`) AS `occurrences` FROM ' . $this->getTableName() . ' GROUP BY `nom` ORDER BY `nom`';
		return array();
	}
}
?>