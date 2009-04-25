<?php

require_once 'BaseObject.class.php';
require_once 'DatabaseConnector.class.php';

class DatabaseObject extends BaseObject {
	var $idArray = array();
	var $data, $factory, $db;
	
	function DatabaseObject($factory, $idArray, $data = false) {
		$this->db = DatabaseConnector::getInstance();
		$this->factory = $factory;
		if(is_array($idArray) && count(array_diff(array_keys($idArray), $this->getPrimaryKeyList())) == 0) {
			$this->idArray = $idArray;
			if(is_array($data)) {
				$this->data = $data;
			} else {
				$this->fetchData();
			}
		} else {
			$this->addError('Impossible de créer l\'objet de type : '.get_class($this));
		}
	}
	
	function concatenateFields($keys, $separator) {
		$stringArray = array();
		foreach($keys AS $key) {
			$value = $this->getData($key);
			if ($value) {
				$stringArray[] = $value;
			}
		}
		return implode($stringArray, $separator);
	}
	
	function delete() {
		if(!$this->exists()) {
			trigger_error('Suppression d\'un élément non existant', E_USER_ERROR);
			return false;
		}
		if($this->db->delete($this->getTableName(), $this->getIdWhere())) {
			$this->data = array();
			return true;
		} else {
			return false;
		}
	}
	
	function display() {
		echo '<table>'."\n";
		foreach ($this->data as $key => $value) {
			echo '<tr><td><strong>'.$key.'</strong></td><td>'.$value.'</td></tr>'."\n";
		}
		echo '</table>'."\n";
	}
	
	function exists() {
		return !empty($this->data) && !empty($this->idArray);
	}
	
	function fetchData() {
		$this->db->connectToDB();
		$query = $this->getSelectQuery().' WHERE '.$this->getIdWhere();
		$result = $this->db->sql_query($query);
		if($this->db->sql_num_rows($result) == 1) {
			$this->data = $this->db->sql_fetch_assoc($result);
		} elseif($this->db->sql_num_rows($result) == 0) {
			$this->data = array();
			$this->addError('L\'objet demandé n\'existe pas.');
		} else {
			$this->data = array();
			$this->addError('La clef primaire ne semble pas être unique.');
		}
		$this->db->disconnectFromDB();
	}
	
	function filterOnUpdate($data) {
		return $data;
	}
	
	function getAllColumnsDescr() {
		return $this->getFactory()->getAllColumnsDescr();
	}
	
	function getAllData() {
		$data = array();
		foreach($this->data AS $key => $value) {
			$data[$key] = $this->getData($key);
		}
		return $data;
	}
	
	function getData($column, $useFilter=TRUE) {
		if(isset($this->data[$column])) {
			$columnDescription = $this->getAllColumnsDescr();
			$dataValue = $this->data[$column];
			if(isset($columnDescription[$column])) {
				if ($useFilter) {
					switch($columnDescription[$column]) {
						case 'date':
							$dateElements = explode('-', $dataValue);
							$dataValue = $dateElements[2].'/'.$dateElements[1].'/'.$dateElements[0];
							if($dataValue == '31/12/9999') {
								$dataValue = '-';
							}
							break;
						default:
							break;
					}
				}
			}
			return $dataValue;
		}
		return false;
	}
	
	function getDataColumnsDescr() {
		return $this->getFactory()->getDataColumnsDescr();
	}
	
	function getDataColumnsList() {
		return $this->getFactory()->getDataColumnsList();
	}
	
	function getFactory() {
		if(!isset($this->factory)) {
			$this->factory = call_user_func(array(__CLASS__.'Factory', '::getInstance'));
		}
		return $this->factory;
	}
	
	function getIdArray() {
		return $this->idArray;
	}
	
	function getIdWhere() {
		$primary_key_datatypes = $this->getFactory()->getPrimaryKeyDescr();
		$where = '1=1';
		foreach($this->idArray AS $key => $value) {
			$where .= ' AND `'.$key.'`='.$this->db->getValueByType($value, $primary_key_datatypes[$key]);
		}
		return $where;
	}
	
	function getPrimaryKeyDescr() {
		return $this->getFactory()->getPrimaryKeyDescr();
	}
	
	function getPrimaryKeyList() {
		$factory = $this->getFactory();
		return $factory->getPrimaryKeyList();
	}
	
	function getSelectQuery() {
		return $this->getFactory()->getSelectQuery();
	}
	
	function getTableName() {
		return $this->getFactory()->getTableName();
	}
	
	function update($updatedData, $applyFilters = true) {
		if(!$this->exists()) {
			trigger_error('Mise à jour d\'un élément non existant', E_USER_ERROR);
			return false;
		}
		$factory = $this->getFactory();
		if (true == $applyFilters) {
			$updatedData = $this->filterOnUpdate($updatedData);
		}
		if(!empty($updatedData)) {
			if($this->db->update($this->getTableName(), $this->getIdWhere(), $updatedData, $factory->getDataColumnsDescr())) {
				$this->fetchData();
				return true;
			} else {
				return false;
			}
		}
	}
	
	/*function serializePrimaryKey() {
		ksort($this->idArray);
		return implode(',', $this->idArray);
	}*/
	
	/*function getWhereClauseBaseeSurClePrimaire() {
		$champsDeLaClePrimaire = $this->getPrimaryKeyList();
		$whereClause = 'WHERE 1=1';
		foreach($champsDeLaClePrimaire AS $nomChamp) {
			$whereClause .= ' AND ' . $nomChamp . '=\'' . $this->escape($this->getData($nomChamp)) . '\'';
		}
		return $whereClause;	
	}*/
	
}

?>