<?php

require_once 'BaseObject.class.php';
require_once 'DatabaseConnector.class.php';

class DatabaseObjectFactory extends BaseObject {
	var $db, $flag;
	
	function DatabaseObjectFactory() {
		$this->db = DatabaseConnector::getInstance();
	}
	
	function setFlag($flag) {
		if (false != $flag) {
			$this->flag = $flag;
		}
	}
	
	function getAllColumnsDescr() {
		return array_merge($this->getPrimaryKeyDescr(), $this->getDataColumnsDescr());
	}
	
	function getDataColumnsDescr() {
		return array();
	}
	
	function getDataColumnsList() {
		return array_keys($this->getDataColumnsDescr());
	}

	function getPrimaryKeyDescr() {
		return array();
	}
	
	function getPrimaryKeyList() {
		return array_keys($this->getPrimaryKeyDescr());
	}
	
	function getTableName() {
		return '';
	}
	
	function getCompleteTableName() {
		return $this->getTableName() . $this->flag;
	}
	
	function create($data) {
		$this->resetErrors();
		$tableName = $this->getCompleteTableName();
		$primaryKeyDescr = $this->getPrimaryKeyDescr();
		
		$data = $this->filterOnCreate($data);
		
		if(count($primaryKeyDescr) == 1 && current($primaryKeyDescr) == 'auto_increment') {
			$keyName = key($primaryKeyDescr);
			$autoIncrement = true;
		} else {
			$autoIncrement = false;
			$id = $this->extractIdArray($data);
			if(count($id) != count($primaryKeyDescr)) {
				$this->addError('Cl� primaire incompl�te');
				return false;
			}
		}
		$data = $this->formatInputData($data);
		
		if($this->db->insert($this->getCompleteTableName(), $data)) {
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
	
	function filterOnCreate($data) {
		return $data;
	}
	
	function getCount($tableName = '', $where = '') {
		$this->resetErrors();
		$result = $this->mysql_query($this->getCountQuery($tableName) . ' ' . $where);
		$data = $this->mysql_fetch_assoc($result);
		return $data['count'];
	}
	
	function getSelectQuery() {
		return 'SELECT * FROM '.$this->getCompleteTableName();
	}
				
	function getCountQuery($tableName='') {
		if ($tableName == '') {
			$tableName = $this->getCompleteTableName();
		}
		return 'SELECT count(*) AS count FROM ' . $tableName;
	}
	
	function extractIdArray($data) {
		$keys = $this->getPrimaryKeyList();
		$id = array();
		foreach($keys AS $key) {
			$id[$key] = $data[$key];
		}
		return $id;
	}
	
	function emptyTable($whereClause = '') {
		return mysql_query('DELETE FROM '.$this->getCompleteTableName().' '.$whereClause);
	}
	
	function getInstanceClassName() {
		return str_replace('factory', '', strtolower(get_class($this)));
	}
	
/*	function getInstanceType() {
		return str_replace('tx_asecore_', '', $this->getInstanceClassName());
	}*/
	
	function formatInputData($dataArray) {
		$dataFields = $this->getAllColumnsDescr();
		$filteredDataArray = array();
		foreach($dataArray AS $key => $value) {
			if(isset($dataFields[$key])) {
				switch($dataFields[$key]) {
					/*case 'date':
						$filteredDataArray[$key] = $this->formatDateToDatabase($value);
						break;*/
					default:
						$filteredDataArray[$key] = $value;
						break;
				}
			}
		}
		return $filteredDataArray;
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
	
	function getInstanceWithQuery($query) {
		return $this->db->executeRequeteAvecDonneeDeRetourUnique($query, 'TODO');
	}
	
	function getInstancesWithWhereClause($whereClause='') {
		$query = $this->getSelectQuery().' '.$whereClause;
		return $this->getInstancesWithQuery($query);
	}
	
	function getInstancesWithQuery($query) {
		return $this->db->executeRequeteAvecDonneesDeRetourMultiples($query, 'TODO');
		/*$res = $this->db->mysql_query($query);
		if ($res) {
			$instances = array();
			while($data = mysql_fetch_assoc($res)) {
				array_push($instances, $this->getInstanceFromArray($data)); 
			}
			return $instances;
		} else {
			return false;
		}*/
	}

	function escape($sqlField) {
		return $this->db->quoteStr($sqlField, $this->getCompleteTableName());
	}
	
}

?>