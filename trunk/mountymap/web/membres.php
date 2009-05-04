<?php
	require_once dirname(__FILE__).'/../etc/settings.inc.php';
	require_once dirname(__FILE__).'/../lib/Member.class.php';
	require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
	
	$smarty = instantiateSmartyTemplate(dirname(__FILE__));
	$memberFactory = MemberFactory::getInstance();
	$membres = $memberFactory->getMembres();
	$smarty->assign('membres', $membres);
	setDebugTrace($smarty);
	setErrorTrace($smarty);
	$smarty->display('liste_membres.tpl');
?>