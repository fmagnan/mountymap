<?php

require_once 'BaseObject.class.php';
require_once 'DatabaseConnector.class.php';

abstract class DatabaseObjectFactory extends BaseObject {
	
	var $db;
	private static $instance;
	
	function DatabaseObjectFactory() {
		$this->db = DatabaseConnector::getInstance();
	}
	
	function create($data) {
		$this->resetErrors();
		$tableName = $this->getTableName();
		$primaryKeyDescr = $this->getPrimaryKeyDescr();
		
		$data = $this->filterOnCreate($data);
		
		if(count($primaryKeyDescr) == 1 && current($primaryKeyDescr) == 'auto_increment') {
			$keyName = key($primaryKeyDescr);
			$autoIncrement = true;
		} else {
			$autoIncrement = false;
			$id = $this->extractIdArray($data);
			if(count($id) != count($primaryKeyDescr)) {
				$this->addError('Clef primaire incomplete');
				return false;
			}
		}

		if($this->db->executeRequeteSansDonneesDeRetour($this->getInsertQuery($data))) {
			if($autoIncrement) {
				return array($keyName => mysql_insert_id());
			} else {
				return $id;
			}
		} else {
			$this->addError(mysql_error());
			return false;
		}
	}
		
	function emptyTable($whereClause = '') {
		return $this->deleteWithWhereClause($whereClause);
	}
	
	function extractIdArray($data) {
		$keys = $this->getPrimaryKeyList();
		$id = array();
		foreach($keys AS $key) {
			$id[$key] = $data[$key];
		}
		return $id;
	}
	
	function filterOnCreate($data) {
		return $data;
	}
				
	function getAllColumnsDescr() {
		return array_merge($this->getPrimaryKeyDescr(), $this->getDataColumnsDescr());
	}
	
	function getAllColumnsList() {
		return array_merge($this->getPrimaryKeyList(), $this->getDataColumnsList());
	}
	
	function getCount($tableName = '', $where = '') {
		$this->resetErrors();
		$result = $this->mysql_query($this->getCountQuery($tableName) . ' ' . $where);
		$data = $this->mysql_fetch_assoc($result);
		return $data['count'];
	}
	
	function getCountQuery($tableName='') {
		if ($tableName == '') {
			$tableName = $this->getTableName();
		}
		return 'SELECT count(*) AS count FROM ' . $tableName;
	}
	
	abstract function getDataColumnsDescr();
	
	function getDataColumnsList() {
		return array_keys($this->getDataColumnsDescr());
	}

	public static function getInstance() {
		if ( !isset(self::$instance) ) {
			$className = __CLASS__;
			self::$instance = new $className();
    	}
	    return self::$instance;
	}
	
	function getInstanceClassName() {
		return str_replace('factory', '', strtolower(get_class($this)));
	}
	
	function getInstanceFromArray($data) {
		$this->db->connectToDB();
		$primaryKeyList = $this->getPrimaryKeyList();
		$dataColumnsList = $this->getDataColumnsList();
		$allDataDescr = array_merge($primaryKeyList, $dataColumnsList);
		
		$this->resetErrors();
		if(is_array($data)) {
			$idsArray = $this->extractIdArray($data);
			if(count($primaryKeyList) == count($idsArray)) {
				$instanceName = $this->getInstanceClassName();
				if(count(array_diff($allDataDescr, array_keys($data))) == 0) {
					$instance = new $instanceName($this, $idsArray, $data);
				} else {
					$instance = new $instanceName($this, $idsArray);
				}
				return $instance;
			}
		}
		$this->db->disconnectFromDB();
		trigger_error('Impossible d\'instancier l\'objet avec '.get_class($this).'::getInstanceFromArray()');
		return false;
	}
	
	function getInstanceFromObject($object) {
		$primaryKeyList = $this->getPrimaryKeyList();
		$primaryKey = array();
		
		foreach($primaryKeyList AS $primaryKeyElement) {
			$primaryKeyElementValue = $object->getData($primaryKeyElement);
			if($primaryKeyElementValue === false) {
				return false;
			}
			$primaryKey[$primaryKeyElement] = $object->getData($primaryKeyElement);
		}
		$instanceName = $this->getInstanceClassName();
		$instance = new $instanceName($this, $primaryKey);
		if(!$instance->isError()) {
			return $instance;
		} else {
			return false;
		}
	}
	
	function getInstanceWithWhereClause($whereClause) {
		$query = $this->getSelectQuery().' '.$whereClause;
		return $this->getInstanceWithQuery($query);
	}
	
	function getInstanceWithQuery($query, $dataName='') {
		$uniqueResult = $this->db->executeRequeteAvecDonneeDeRetourUnique($query, $dataName);
		return is_array($uniqueResult) ? $this->getInstanceFromArray($uniqueResult) : false;
	}
	
	function getInstances($orderBy='', $sort='') {
		return $this->getInstancesWithQuery($this->getSelectQuery($orderBy, $sort));
	}
	
	function getInstancesFromArray($array) {
		$whereClause = '';
		foreach($array as $key => $value) {
			$columnsDescr = $this->getAllColumnsDescr();
			if (array_key_exists($key, $columnsDescr)) {
				$whereClause .= ' AND `'.$key.'` = ' . $this->getValueByType($value, $columnsDescr[$key]);	
			}
		}
		return $this->getInstancesWithWhereClause($whereClause);
	}
	
	function getInstancesWithWhereClause($whereClause='') {
		$query = $this->getSelectQuery().' '.$whereClause;
		return $this->getInstancesWithQuery($query);
	}
	
	function getInstancesWithQuery($query) {
		$instanceName = $this->getInstanceClassName();
		$instances = array();
		$multipleData = $this->db->executeRequeteAvecDonneesDeRetourMultiples($query);
		foreach($multipleData as $data) {
			$idsArray = array_intersect_key($data, $this->getPrimaryKeyDescr());
			$instances[] = new $instanceName($this, $idsArray);
		}
		return $instances;
	}
		
	abstract function getPrimaryKeyDescr();
	
	function getPrimaryKeyList() {
		return array_keys($this->getPrimaryKeyDescr());
	}
	
	function getSelectQuery($orderBy='', $sort='') {
		return $this->getSelectQueryWithWhereClause('1', $orderBy, $sort);
	}
	
	function getSelectQueryWithWhereClause($whereClause, $orderBy='', $sort='') {
		$fieldsToRetrieve = implode(',', array_map('add_backquotes', $this->getAllColumnsList()));
		if ($orderBy == '') {
			$keyFields = $this->getPrimaryKeyList(); 
			$orderBy = add_backquotes($keyFields[0]);
		}
		if ($sort != '') {
			$orderClause = " ORDER BY " . $orderBy . " " . $sort;
		} else {
			$orderClause = '';
		}
		return "SELECT ".$fieldsToRetrieve." FROM `".$this->getTableName()."` WHERE " . $whereClause . $orderClause;
	}
	
	function deleteWithWhereClause($whereClause) {
		return $this->db->executeRequeteSansDonneesDeRetour($this->getDeleteQuery($whereClause));
	}
	
	abstract function getTableName();
	
	function deleteInArea($origin) {
		//do nothing
	}
	
	function getValueByType($value, $type) {
		if ($type == 'string') {
			return '\'' . mysql_real_escape_string($value, $this->db->getLink()) . '\'';
		} elseif ($type == 'int') {
			return intval($value);
		} else {
			return $value;
		}
	}
	
	function getInsertQuery($data) {
		$keys = array_map('add_backquotes', array_keys($data));
		$datatypes = $this->getAllColumnsDescr();
		$values = array();
		foreach ($data as $key => $value) {
			if (array_key_exists($key, $datatypes)) {
				$values[] = $this->getValueByType($value, $datatypes[$key]);
			}
		}
		$query = 'INSERT INTO `'.$this->getTableName().'` ('.implode(',',$keys).') VALUES ('.implode(',', $values).')';
		$query .= ' ON DUPLICATE KEY UPDATE '.$this->getSetClauseForUpdateQuery($data);
		return $query;
	}
	
	function getSetClauseForUpdateQuery($data) {
		$datatypes = $this->getDataColumnsDescr();
		$setClauseArray = array();
		foreach ($data as $key => $value) {
			if (array_key_exists($key, $datatypes)) {
				$setClauseArray[] = "`".$key."`=".$this->getValueByType($value, $datatypes[$key]);
			}
		}
		return implode(', ', $setClauseArray);
	}
	
	function getUpdateQuery($data, $whereClause) {
		$setClause = $this->getSetClauseForUpdateQuery($data);
		return 'UPDATE `'.$this->getTableName().'` SET '. $setClause . ' WHERE ' . $whereClause;
	}
	
	function getDeleteQuery($whereClause) {
		return 'DELETE FROM `'.$this->getTableName().'` WHERE ' . $whereClause;
	}
	
	function publicImport($multipleData, $extraData = false) {
		$this->deleteInArea($extraData);
		foreach($multipleData as $data) {
			$data['mise_a_jour'] = 'NOW()';
			$this->db->executeRequeteSansDonneesDeRetour($this->getInsertQuery($data));
		}
	}
}

?>