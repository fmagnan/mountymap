<?php

require_once 'DatabaseObject.class.php';
require_once 'MemberFactory.class.php';

class Member extends DatabaseObject {
	/*function __construct() {
		parent::__construct();
		$this->tableName = 'membre';
		$this->keys = array('id' => 'int');
		$this->data = array('password' => 'string', 'mise_a_jour' => 'date');
	}

	
	
	function getRestrictedPasswordFrom($membre) {
		if (is_numeric($membre)) {
			$query = "SELECT `password` FROM ".$this->tableName." WHERE `id`=".intval($membre)." LIMIT 1";
			$password = $this->executeRequeteAvecDonneeDeRetourUnique($query, 'getRestrictedPasswordFrom', 'password');
			return md5($password);
		} else {
			return '';
		}
	}
	
	function updateMember($numeroTroll) {
		$query = "UPDATE ".$this->tableName." SET `mise_a_jour`=NOW() WHERE `id`=".intval($numeroTroll);
		$this->executeRequeteSansDonneesDeRetour($query, 'updateMember');
	}*/	
}

?>