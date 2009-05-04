<?php
	require_once dirname(__FILE__).'/../etc/settings.inc.php';
	require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
	
	$smarty = instantiateSmartyTemplate(dirname(__FILE__));
	updatePublicTrolls();	
	setDebugTrace($smarty);
	redirectTo('membres.php', $smarty);
?>