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
	
	function getInstancesBetweenLevels($minLevel, $maxLevel) {
		$min_level = is_numeric($minLevel) ? intval($minLevel) : 1;
		$max_level = is_numeric($maxLevel) ? intval($maxLevel) : 80;
		$query = 'SELECT `position`.`id` FROM `'.$this->getTableName(). '` AS `position`, `troll_identity` as `identity`
		WHERE `position`.`id` = `identity`.`id` AND `identity`.`niveau` BETWEEN '.$min_level . ' AND ' . $max_level. ' ORDER BY `identity`.`niveau`';
		return $this->getInstancesWithQuery($query);
	}
}
?>