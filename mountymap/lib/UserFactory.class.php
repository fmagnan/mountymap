<?php

require_once 'DatabaseObjectFactory.class.php';
require_once 'User.class.php';

class UserFactory extends DatabaseObjectFactory {

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
			'email' => 'string',
			'activation_code' => 'string',
			'is_active' => 'int',
			'is_admin' => 'int',
			'diplomacy_id' => 'int',
		);
	}
	
	function getPrimaryKeyDescr() {
		return array(
			'id' => 'int',
		);
	}
	
	function getTableName() {
		return 'user';
	}
	
	function login($loginRequest, $passwordRequest) {
		$login = $loginRequest ? intval($loginRequest) : false;
		$md5pass = $passwordRequest ? md5($passwordRequest) : false;
		if ($login && $md5pass) {
			$user = $this->getInstanceFromArray(array('id' => $login, 'password' => $md5pass, 'is_active' => 1));
			if (is_object($user) && $md5pass == $user->getPassword()) {
				session_start();
				$_SESSION['logged_user_id'] = $login;
				header("Location: index.php");
			}
		}
		return false;
	}

	function logout() {
		session_start();
	  	session_unset();
	  	session_destroy();
		header("Location: index.php");
	}
	
}

?>