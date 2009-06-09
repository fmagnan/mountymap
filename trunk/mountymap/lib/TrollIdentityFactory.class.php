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
	
	function getTrollsFromGuild($id_guild, $limit=false) {
		$query = '	SELECT `position`.`id`, `position`.`mise_a_jour`, `position`.`position_x`, `position`.`position_y`, `position`.`position_n`, 
					`identity`.`nom`, `identity`.`race`, `identity`.`niveau`, `identity`.`id_guilde`, `identity`.`nombre_mouches`
					FROM `troll_position` AS `position`, `troll_identity` AS `identity`
					WHERE `position`.`id`=`identity`.`id` AND `identity`.`id_guilde`='.intval($id_guild);
		if ($limit) {
			$query .= ' LIMIT ' . $limit;
		}
		return $this->getInstancesWithQuery($query);
	}
}
?>