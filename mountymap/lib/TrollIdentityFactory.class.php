<?php

require_once 'DatabaseObjectFactory.class.php';
require_once 'Troll.class.php';

class TrollIdentityFactory extends DatabaseObjectFactory {
	
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
			'race' => 'string',
			'niveau' => 'int',
			'id_guilde' => 'int',
			'nombre_mouches' => 'int',
		);
	}
	
	function getPrimaryKeyDescr() {
		return array(
			'id' => 'int',
		);
	}
	
	function getTableName() {
		return 'troll_identity';
	}
	
	function getInstanceClassName() {
		return 'troll';
	}
	
	function getTrollsFromGuild($id_guild, $reference, $limit=false) {
		$selectDistanceClause = $this->getSelectDistanceClause($reference);
		$query = '	SELECT `position`.`id`, `position`.`mise_a_jour`, `position_x`, `position_y`, `position_n`, 
					`nom`, `race`, `niveau`, `id_guilde`, `nombre_mouches`'. $selectDistanceClause . '
					FROM `troll_position` AS `position`, `troll_identity` AS `identity`
					WHERE `position`.`id`=`identity`.`id` AND `identity`.`id_guilde`='.intval($id_guild).' ORDER BY `distance`';
		if ($limit) {
			$query .= ' LIMIT ' . $limit;
		}
		return $this->getInstancesWithQuery($query);
	}
}
?>