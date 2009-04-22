<?php

require_once 'DatabaseObjectFactory.class.php';
require_once 'Troll.class.php';

class TrollFactory extends DatabaseObjectFactory {
	
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
		return 'troll';
	}
	
	function insertTroll($data) {
		$this->create($data);
		/*$query = "	INSERT INTO ".$this->getTableName()."
					VALUES (".intval($data['id']).", NOW(), ".intval($data['position_x']).", ".intval($data['position_y']).", ".intval($data['position_n']).")";
		$this->executeRequeteSansDonneesDeRetour($query, 'insertTroll');*/
	}
	
	function updateTroll($data) {
		//$troll->update($data);
		/*$query = "	UPDATE ".$this->getTableName()."
					SET `mise_a_jour`=NOW(), `position_x`=".intval($data['position_x']).", `position_y`=".intval($data['position_y']).", `position_n`=".intval($data['position_n'])."
					WHERE `id`=".intval($data['id']);
		$this->executeRequeteSansDonneesDeRetour($query, 'updateTroll');*/
	}
	
	function isTrollAlreadyExists($data) {
		return is_object($this->getInstanceFromArray($data));
		/*$query = 'SELECT `id` FROM `'.$this->getTableName().'` WHERE `id` = '.intval($numeroTroll);
		$id = $this->executeRequeteAvecDonneeDeRetourUnique($query, 'isTrollAlreadyExists', 'id');
		return is_numeric($id);*/
	}

	function insertOrUpdateTroll($trollData) {
		$troll = $this->getInstanceFromArray($trollData);
		if ($troll->isError()) {
			$trollData['mise_a_jour'] = 'NOW()';
			$this->insertTroll($trollData);
		} else {
			$troll->update($trollData);
		}
	}
	
}
?>