<?php

require_once 'DatabaseObjectFactory.class.php';
require_once 'Member.class.php';

class MemberFactory extends DatabaseObjectFactory {

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
			'password' => 'string',
			'mise_a_jour' => 'date',
		);
	}
	
	function getPrimaryKeyDescr() {
		return array(
			'id' => 'int',
		);
	}
	
	function getTableName() {
		return 'membre';
	}
	
	function getMembres() {
		return $this->getInstances('`mise_a_jour`', 'DESC');
	}
	
	function getLastUpdatedMember() {
		$whereClause = 'AND  TO_DAYS(NOW()) - TO_DAYS(`mise_a_jour`) > 0 ORDER BY `mise_a_jour` DESC';
		return $this->getInstanceWithWhereClause($whereClause);
	}
	
}

?>