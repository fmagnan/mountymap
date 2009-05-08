<?php

require_once 'LocatedObjectFactory.class.php';

abstract class NonPermanentDatabaseObjectFactory extends LocatedObjectFactory {
	
	private static $instance;
	
	public static function getInstance() {
		if ( !isset(self::$instance) ) {
			$className = __CLASS__;
			self::$instance = new $className();
    	}
	    return self::$instance;
	}
	
	function deleteInArea($origin) {
		if ($origin) {
			$originInX = intval($origin['position_x']);
			$originInY = intval($origin['position_y']);
			$originInN = intval($origin['position_n']);
			$horizontalRange = intval($origin['horizontal_range']);
			$verticalRange = floor($horizontalRange / 2);
			
			$whereClause = ' `position_x` BETWEEN '.($originInX - $horizontalRange). ' AND ' .($originInX + $horizontalRange). '
							AND `position_y` BETWEEN '.($originInY - $horizontalRange). ' AND ' .	($originInY + $horizontalRange). '
							AND `position_n` BETWEEN '.($originInN - $verticalRange). ' AND ' .	($originInN + $verticalRange);
			
			$this->deleteWithWhereClause($whereClause);
		}
	}
	
	function getGroupByField() {
		return 'nom';
	}
	
	function getInstancesByTypes() {
		$field = $this->getGroupByField();
		$query = 'SELECT `'.$field.'` AS `group_by_field` , COUNT(`id`) AS `number` FROM ' . $this->getTableName() . ' GROUP BY `'.$field.'` ORDER BY `'.$field.'`';
		return $this->db->executeRequeteAvecDonneesDeRetourMultiples($query);
	}
	
	function getInstancesByGroupByField($name) {
		return $this->getInstancesFromArray(array($this->getGroupByField() => $name));
	}
}
?>