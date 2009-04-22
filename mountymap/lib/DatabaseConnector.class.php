<?php

function add_backquotes($string) {
	return '`' . $string . '`';
}

class DatabaseConnector {

	static $allQueries;
	private static $instance;
	var $link;
	
	function __construct() {}
	
	public static function getInstance() {
		if ( !isset(self::$instance) ) {
			self::$instance = new DatabaseConnector();
    	}
	    return self::$instance;
	}
  
	function addError($error) {
		$this->errors[] = $error;
	}
	
	function addQuery($query) {
		if (is_array(DatabaseConnector::$allQueries)) {
			DatabaseConnector::$allQueries[] = $query; 
		} else {
			DatabaseConnector::$allQueries = array($query);
		}
	}
	
	function connectToDB($host='', $user='', $password='', $database='') {
		if ($host == '') { $host = _HOST_; }
		if ($user == '') { $user = _USER_; }
		if ($password == '') { $password = _PWD_; }
		if ($database == '') { $database = _DB_; }
		
		$this->link = mysql_connect($host, $user, $password) or $this->addError('error[connectToDB()]: unable to connect to database');
	 	@mysql_select_db($database) or $this->addError('error[connectToDB()]: unable to select a database');
	}
	
	function disconnectFromDB() {
		@mysql_close();
	}
	
	function addMysqlError($functionName) {
		global $databaseError;
		$mysqlError = mysql_errno();
		$databaseError .= 'fonction ' . $functionName;
		if (1022 == $mysqlError || 1062 == $mysqlError) {
			$databaseError .= ' : clef primaire dupliquée, l\'enregistrement a déjà été soumis.';
		} elseif (1146 == $mysqlError) {
			$databaseError .= ' : le nom d\'une table est incorrect.';
		} elseif (1064 == $mysqlError) {
			$databaseError .= ' : erreur de syntaxe.';
		} elseif (1065 == $mysqlError) {
			$databaseError .= ' : la requête est vide.';
		} else {
			$databaseError .= ' : erreur MySQL n°'.$mysqlError.'.'; 
		}
		$databaseError .= mysql_error();
		$this->addError($databaseError);
	}
	
	function executeRequeteSansDonneesDeRetour($query, $functionName) {
		$this->addQuery($query);
		$this->connectToDB();
		$result = mysql_query($query) or $this->addMysqlError($functionName);
		$this->disconnectFromDB();
		return $result;
	}
	
	function executeRequeteAvecDonneeDeRetourUnique($query, $functionName, $dataName='') {
		$this->addQuery($query);
		$donneesDeRetour = array();
		$this->connectToDB();
		$result = mysql_query($query) or $this->addMysqlError($functionName);
		if ($result) {
			$donneesDeRetour = mysql_fetch_assoc($result);
		}
		$this->disconnectFromDB();
		return $dataName != '' ? $donneesDeRetour[$dataName] :  $donneesDeRetour;
	}
	
	function executeRequeteAvecDonneesDeRetourMultiples($query, $functionName) {
		$this->addQuery($query);
		$donneesDeRetour = array();
		$this->connectToDB();
		$result = mysql_query($query) or $this->addMysqlError($functionName);
		if ($result) {
			while ($row = mysql_fetch_assoc($result)) {
				$donneesDeRetour[] = $row;	
			}
		}
		$this->disconnectFromDB();
		return $donneesDeRetour;
	}
	
	function executeRequeteEtTransformeDates($query, $functionName, $champsDate) {
		$this->addQuery($query);
		$donneesDeRetour = array();
		$this->connectToDB();
		$result = mysql_query($query) or $this->addMysqlError($functionName);
		if ($result) {
			while ($row = mysql_fetch_assoc($result)) {
				foreach($champsDate AS $champ) {
					if (array_key_exists($champ, $row)) {
						$row[$champ] = getDateEnFrancais($row[$champ]);
					}
				}
				$donneesDeRetour[] = $row;
			}
		}
		$this->disconnectFromDB();
		return $donneesDeRetour;
	}
	
	function selectWithWhereClause($whereClause, $orderBy='', $sort='ASC') {
		$fieldsToRetrieve = implode(',', array_map('add_backquotes', array_merge(array_keys($this->keys), array_keys($this->data))));
		if ($orderBy == '') {
			$keyFields = array_keys($this->keys); 
			$orderBy = add_backquotes($keyFields[0]);
		}
		$requete = "SELECT ".$fieldsToRetrieve." FROM `".$this->tableName."` WHERE " . $whereClause . " ORDER BY " . $orderBy . " " . $sort;
		return $this->executeRequeteAvecDonneesDeRetourMultiples($requete, 'TODO');
	}
	
	function select($orderBy='', $sort='ASC') {
		return $this->selectWithWhereClause('1', $orderBy, $sort);
	}
	
	function update($tableName, $whereClause, $updatedData) {
		//TODO;
	}
	
	function delete($tableName, $whereClause) {
		//TODO;
	}
	
	function quoteStr($sqlField, $tableName) {
		return $sqlField;
		//TODO
	}
	
	function insert($tableName, $data) {
		$keys = array_keys($data);
		$values = array_values($data);
		$query = 'INSERT INTO `'.$tableName.'` ('.implode(',',$keys).') VALUES ('.implode(',', $values).')';
		$this->executeRequeteSansDonneesDeRetour($query, 'TODO');
		
		
		/*$query = "	INSERT INTO ".$this->getTableName()."
					VALUES (".intval($data['id']).", NOW(), ".intval($data['position_x']).", ".intval($data['position_y']).", ".intval($data['position_n']).")";
		$this->executeRequeteSansDonneesDeRetour($query, 'insertTroll');*/
		//TODO
	}
	
	function sql_query($query) {
		return mysql_query($query, $this->link);
	}
	
	function sql_num_rows($result) {
		return mysql_num_rows($result);
	}
	
	function sql_fetch_assoc($result) {
		return mysql_fetch_assoc($result);
	}
}
?>