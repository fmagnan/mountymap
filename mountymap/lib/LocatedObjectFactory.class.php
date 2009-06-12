<?php

require_once 'DatabaseObjectFactory.class.php';

abstract class LocatedObjectFactory extends DatabaseObjectFactory {
	
	private static $instance;
	
	public static function getInstance() {
		if ( !isset(self::$instance) ) {
			$className = __CLASS__;
			self::$instance = new $className();
    	}
	    return self::$instance;
	}
	
	function getDataWithPosition($start_x, $end_x, $start_y, $end_y, $start_n, $end_n) {
		$query = '	SELECT * FROM `'.$this->getTableName().'` 
					WHERE (`position_x` BETWEEN '.intval($start_x). ' AND ' .intval($end_x). ') 
					AND (`position_y` BETWEEN '.intval($start_y). ' AND ' .intval($end_y). ')
					AND (`position_n` BETWEEN ' . intval($end_n). ' AND ' .intval($start_n) . ')';
		return getDb()->executeRequeteAvecDonneesDeRetourMultiples($query);
	}
}
?>