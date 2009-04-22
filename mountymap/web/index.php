<?php
	require_once dirname(__FILE__).'/../etc/settings.inc.php';
	require_once dirname(__FILE__).'/../lib/Member.class.php';
	require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
	
	$smarty = instantiateSmartyTemplate(dirname(__FILE__));
	$membersFactory = getFactory('Member');
	$membres = $membersFactory->getMembres();
	$smarty->assign('membres', $membres);
	$allQueries = DatabaseConnector::$allQueries;
	$smarty->assign('all_queries', $allQueries);
	$smarty->assign('nb_queries', count($allQueries));
	$smarty->display('liste_membres.tpl');
?>