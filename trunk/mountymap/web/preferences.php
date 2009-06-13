<?php
	require_once dirname(__FILE__).'/../etc/settings.inc.php';
	require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
	require_once dirname(__FILE__).'/../lib/HtmlTool.class.php';
	
	$smarty = instantiateSmartyTemplate(dirname(__FILE__));
	$user = getLoggedInUser();
	
	$data = array(
		'diplomacy_id' => HtmlTool::getNumericPostParameter('diplomacy', $smarty, $user->getDiplomacyId()),
		'position_x' => HtmlTool::getNumericPostParameter('position_x', $smarty, $user->getPositionX()),
		'position_y' => HtmlTool::getNumericPostParameter('position_y', $smarty, $user->getPositionY()),
		'position_n' => HtmlTool::getNumericPostParameter('position_n', $smarty, $user->getPositionN()),
	);
	
	if (array_key_exists('submit', $_POST)) {
		$user->update($data);
	} 
	
	$all_guilds = GuildFactory::getInstance()->getInstancesWithWhereClause(' ORDER BY `nom`');
	$smarty->assign('diplomacy_options', HtmlTool::getHTMLSelect('diplomacy', $all_guilds));
	setDebugTrace($smarty);
	setErrorTrace($smarty);
	$smarty->display('preferences.tpl');
?>