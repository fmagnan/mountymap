<?php

require_once 'BaseObject.class.php';
require_once 'DatabaseConnector.class.php';

class DatabaseObject extends BaseObject {
	var $idArray = array();
	var $data, $factory;
	
	function DatabaseObject($factory, $idArray, $data = false) {
		$this->factory = $factory;
		if($this->isKeyInInputData($idArray)) {
			$this->idArray = $idArray;
			if($this->isDataEnoughToInstanciateObject($data)) {
				$this->data = array_merge($idArray, $data);
			} else {
				$this->fetchData();
			}
		} else {
			$this->addError('Impossible de créer l\'objet de type : '.get_class($this));
		}
	}
	
	function isKeyInInputData($idArray) {
		return is_array($idArray) && (0 == count(array_diff_key($this->getPrimaryKeyDescr(), $idArray)));
	}
	
	function isDataEnoughToInstanciateObject($data) {
		return is_array($data) && (0 == count(array_diff_key($this->getDataColumnsDescr(), $data)));
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
		if(getDb()->executeRequeteSansDonneesDeRetour($this->getFactory()->getDeleteQuery($this->getIdWhere()))) {
			$this->data = array();
			return true;
		} else {
			return false;
		}
	}
	
	function getIdWhere() {
		$factory = $this->getFactory();
		$primary_key_datatypes = $this->getPrimaryKeyDescr();
		$where = '1=1';
		foreach($this->idArray AS $key => $value) {
			$where .= ' AND `'.$key.'`='.$factory->getValueByType($value, $primary_key_datatypes[$key]);
		}
		
		return $where;
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
		$query = $this->getSelectQueryWithWhereClause($this->getIdWhere());
		$assoc = getDb()->executeRequeteAvecDonneeDeRetourUnique($query);
		if ($assoc) {
			$this->data = $assoc;
		} else {
			$this->data = array();
			$this->addError('L\'objet demandé n\'existe pas.');
		}
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
			$this->factory = call_user_func(array(__CLASS__.'Factory', 'getInstance'));
		}
		return $this->factory;
	}
	
	function getIdArray() {
		return $this->idArray;
	}
	
	function getPrimaryKeyDescr() {
		return $this->getFactory()->getPrimaryKeyDescr();
	}
	
	function getPrimaryKeyList() {
		$factory = $this->getFactory();
		return $factory->getPrimaryKeyList();
	}
	
	function getTableName() {
		return $this->getFactory()->getTableName();
	}
	
	function getSelectQueryWithWhereClause($whereClause) {
		return $this->getFactory()->getSelectQueryWithWhereClause($whereClause);
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
			if(getDb()->executeRequeteSansDonneesDeRetour($factory->getUpdateQuery($updatedData, $this->getIdWhere()))) {
				$this->fetchData();
				return true;
			} else {
				return false;
			}
		}
	}
	
	function getId() {
		return $this->getData('id');
	}
	
	function getUpdate() {
		return getDateEnFrancais($this->getData('mise_a_jour'));
	}
	
	function getName() {
		return htmlspecialchars($this->getData('nom'));
	}
		
}

?>