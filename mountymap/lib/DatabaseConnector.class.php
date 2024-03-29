<?php

function add_backquotes($string) {
	return '`' . $string . '`';
}

class DatabaseConnector {

	private static $instance;
	var $link, $all_sql_queries;
	
	function __construct() {
		$this->all_sql_queries = array();
	}
	
	public static function getInstance() {
		if ( !isset(self::$instance) ) {
			$className = __CLASS__;
			self::$instance = new $className();
    	}
	    return self::$instance;
	}
  
	function addError($error) {
		$this->errors[] = $error;
	}
	
	function addQuery($query) {
		$this->all_sql_queries[] = $query; 
	}
	
	function getAllSqlQueries() {
		return $this->all_sql_queries;
	}
	
	function getAllErrors() {
		return $this->errors;
	}
	
	function isInError() {
		return !empty($this->errors);
	}
	
	function connectToDB($host='', $user='', $password='', $database='') {
		if ($host == '') { $host = _HOST_; }
		if ($user == '') { $user = _USER_; }
		if ($password == '') { $password = _PWD_; }
		if ($database == '') { $database = _DB_; }
		
		$this->link = mysql_connect($host, $user, $password) or $this->addError('error[connectToDB()]: unable to connect to database');
	 	@mysql_select_db($database) or $this->addError('error[connectToDB()]: unable to select a database');
	 	mysql_query("SET NAMES 'utf8'");
	}
	
	function disconnectFromDB() {
		@mysql_close();
	}
	
	function addMysqlError($query) {
		$mysqlError = mysql_errno();
		$error = 'requête ' . $query;
		if (1022 == $mysqlError || 1062 == $mysqlError) {
			$error .= ' : clef primaire dupliquée, l\'enregistrement a déjà été soumis.';
		} elseif (1146 == $mysqlError) {
			$error .= ' : le nom d\'une table est incorrect.';
		} elseif (1064 == $mysqlError) {
			$error .= ' : erreur de syntaxe.';
		} elseif (1065 == $mysqlError) {
			$error .= ' : la requête est vide.';
		} else {
			$error .= ' : erreur MySQL n°'.$mysqlError.'.'; 
		}
		$error .= mysql_error();
		$this->addError($error);
	}
	
	function executeRequeteSansDonneesDeRetour($query) {
		$this->addQuery($query);
		$this->connectToDB();
		$result = mysql_query($query) or $this->addMysqlError($query);
		$this->disconnectFromDB();
		return $result;
	}
	
	function executeRequeteAvecDonneeDeRetourUnique($query, $dataName='') {
		$this->addQuery($query);
		$donneesDeRetour = array();
		$this->connectToDB();
		$result = mysql_query($query) or $this->addMysqlError($query);
		if ($result) {
			$donneesDeRetour = mysql_fetch_assoc($result);
		}
		$this->disconnectFromDB();
		return $dataName != '' ? $donneesDeRetour[$dataName] :  $donneesDeRetour;
	}
	
	function executeRequeteAvecDonneesDeRetourMultiples($query) {
		$this->addQuery($query);
		$donneesDeRetour = array();
		$this->connectToDB();
		$result = mysql_query($query) or $this->addMysqlError($query);
		if ($result) {
			while ($row = mysql_fetch_assoc($result)) {
				if (array_key_exists('key', $row)) {
					$donneesDeRetour[$row['key']] = $row['value'];
				} else {
					$donneesDeRetour[] = $row;
				}	
			}
		}
		$this->disconnectFromDB();
		return $donneesDeRetour;
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
	
	function getLink() {
		if (!$this->link) {
			$this->connectToDB();
		}
		return $this->link;
	}
}
?>