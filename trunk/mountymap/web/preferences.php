<?php
	require_once dirname(__FILE__).'/../etc/settings.inc.php';
	require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
	require_once dirname(__FILE__).'/../lib/HtmlTool.class.php';
	
	$smarty = instantiateSmartyTemplate(dirname(__FILE__));
	$user = getLoggedInUser();
	if (array_key_exists('diplomacy', $_POST) && is_numeric($_POST['diplomacy'])) {
		$user->update(array('diplomacy_id' => $_POST['diplomacy']));
	} 
	
	$all_guilds = GuildFactory::getInstance()->getInstancesWithWhereClause(' ORDER BY `nom`');
	$htmlTool = HtmlTool::getInstance();
	$smarty->assign('diplomacy_options', $htmlTool->getHTMLSelect('diplomacy', $all_guilds));
	$smarty->assign('logged_user', $user);
	setDebugTrace($smarty);
	setErrorTrace($smarty);
	$smarty->display('preferences.tpl');
?>