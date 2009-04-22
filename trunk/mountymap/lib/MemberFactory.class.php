<?php

require_once 'DatabaseObjectFactory.class.php';
require_once 'Member.class.php';

class MemberFactory extends DatabaseObjectFactory {

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
		return $this->getInstancesWithWhereClause();
		//return $this->select("`mise_a_jour`", "DESC");
	}
	
	function getRestrictedPasswordFrom($membre) {
		if (is_numeric($membre)) {
			$query = "SELECT `password` FROM ".$this->getTableName()." WHERE `id`=".intval($membre)." LIMIT 1";
			$password = $this->getInstanceWithQuery($query);
			return md5($password['password']);
		} else {
			return '';
		}
	}
	
	function updateMember($numeroTroll) {
		//TODO
		/*$query = "UPDATE ".$this->tableName." SET `mise_a_jour`=NOW() WHERE `id`=".intval($numeroTroll);
		$this->executeRequeteSansDonneesDeRetour($query, 'updateMember');*/
	}
	
}

?>