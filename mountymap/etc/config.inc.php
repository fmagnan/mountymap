<?php

define('_HOST_', 'localhost');
define('_USER_', 'mountymap');
define('_PWD_', 'password');
define ('_DB_', 'mountymap');

define('SERVER_ROOT_PATH', 'http://local.mountymap.org');

/*
TODO modifier les chemins des fichiers pour pointer sur le site MH
define(
	'VIEW_FILE_PATH',
	'http://sp.mountyhall.com/SP_Vue2.php?Numero='.intval($membre).'&Motdepasse='.$restrictedPassword.'&Tresors=1&Lieux=1&Champignons=1'
);
*/
define('GUILD_DATA_FILE_PATH', dirname(__FILE__).'/../data/Public_Guildes.txt');
define('TROLL_IDENTITY_DATA_FILE_PATH', dirname(__FILE__).'/../data/Public_Trolls.txt');
define('VIEW_FILE_PATH', dirname(__FILE__).'/../data/vue_');

define('DEBUG_MODE', false);

?>