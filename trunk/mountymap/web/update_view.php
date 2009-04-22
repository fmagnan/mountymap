<?php
	require_once dirname(__FILE__).'/../etc/settings.inc.php';
	require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
	
	$smarty = instantiateSmartyTemplate(dirname(__FILE__));
	$membre = $_GET['membre'];
	updateView($membre);	
	/*$smarty->assign('all_queries', $GLOBALS['all_queries']);
	$smarty->assign('nb_queries', count($GLOBALS['all_queries']));
	$smarty->display('liste_membres.tpl');*/
	header('Location: index.php');
	
?>