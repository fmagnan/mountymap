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
			'niveau' => 'int',
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
	
	function getMonsterFamilies() {
		$query = 'SELECT `famille` AS `key`,
			CONCAT(`famille`, \' (\', COUNT(`id`), \')\') AS `value`
			FROM ' . $this->getTableName() . ' GROUP BY `famille` ORDER BY `famille`';
		return $this->db->executeRequeteAvecDonneesDeRetourMultiples($query);
	}
	
	function getInstancesByFamily($family) {
		return $this->getInstancesFromArray(array('famille' => $family));
	}
	
	function getSearchTableHeaders() {
		return array(
			'Id' => 'getId', 'Nom' => 'getFullName', 'Niveau' => 'getLevel',
			'X' => 'getPositionX', 'Y' => 'getPositionY', 'N' => 'getPositionN', 'Date' => 'getUpdate', 'Actions' => 'getLinkToMap'
		);
	}
	
	function getInstancesBetweenLevels($minLevel, $maxLevel) {
		$min_level = is_numeric($minLevel) ? intval($minLevel) : 1;
		$max_level = is_numeric($maxLevel) ? intval($maxLevel) : 80;
		$where_clause = ' AND `niveau` BETWEEN '.$min_level . ' AND ' . $max_level. ' ORDER BY `niveau` LIMIT 300';
		return $this->getInstancesWithWhereClause($where_clause);
	}
	
}
?>