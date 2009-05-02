<?php

require_once 'DatabaseObjectFactory.class.php';

abstract class NonPermanentDatabaseObjectFactory extends DatabaseObjectFactory {
	
	private static $instance;
	
	public static function getInstance() {
		if ( !isset(self::$instance) ) {
			$className = __CLASS__;
			self::$instance = new $className();
    	}
	    return self::$instance;
	}
	
	function publicImport($multipleData, $origin) {
		$ids = parent::publicImport($multipleData);
		
		$originInX = intval($origin['position_x']);
		$originInY = intval($origin['position_y']);
		$originInN = intval($origin['position_n']);
		$horizontalRange = intval($origin['horizontal_range']);
		$verticalRange = floor($horizontalRange / 2);
		
		$whereClause = ' AND  `position_x` BETWEEN '.($originInX - $horizontalRange). ' AND ' .($originInX + $horizontalRange). '
						AND `position_y` BETWEEN '.($originInY - $horizontalRange). ' AND ' .	($originInY + $horizontalRange). '
						AND `position_n` BETWEEN '.($originInN - $verticalRange). ' AND ' .	($originInN + $verticalRange);
		
		$objectsInArea = $this->getInstancesWithWhereClause($whereClause);
		foreach($objectsInArea as $object) {
			if(!in_array($object->getId(), $ids)) {
				$object->delete();
			}
		}
	}
	
}
?>