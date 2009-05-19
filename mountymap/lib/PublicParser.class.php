<?php

require_once 'Parser.class.php';

define('FTP_ROOT_PATH', 'http://www.mountyhall.com/ftp/');

abstract class PublicParser extends Parser {

	function __construct($file) {
		$publicFile = LOCAL_IMPORT_MODE ? '../data/' . $file : FTP_ROOT_PATH . $file;
		parent::__construct($publicFile);
	}

}
?>