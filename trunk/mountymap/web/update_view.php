<?php
	require_once dirname(__FILE__).'/../etc/settings.inc.php';
	require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
	
	$smarty = instantiateSmartyTemplate(dirname(__FILE__));
	$membre = $_GET['membre'];
	updateView($membre);	
	$membres = getMembres();
	$smarty->assign('membres', $membres);
	$smarty->display('liste_membres.tpl');
?>