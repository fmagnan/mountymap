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
	
	function getLastUpdatedMember($id=false) {
		$whereClause = '';
		if ($id && is_numeric($id)) {
			$whereClause .= 'AND `id`='.intval($id);
		}
		//$whereClause .= ' AND CURDATE() <> DATE(`mise_a_jour`)';
		$whereClause .= ' ORDER BY `mise_a_jour` ASC';
		return $this->getInstanceWithWhereClause($whereClause);
	}
	
}

?>