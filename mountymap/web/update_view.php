<?php
	require_once dirname(__FILE__).'/../etc/settings.inc.php';
	require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
	
	$smarty = instantiateSmartyTemplate(dirname(__FILE__));
	
	$membersFactory = MemberFactory::getInstance();
	$whereClause = 'AND  TO_DAYS(NOW()) - TO_DAYS(`mise_a_jour`) > 1 ORDER BY `mise_a_jour` DESC';
	$members = $membersFactory->getInstancesWithWhereClause($whereClause);
	if (!empty($members)) {
		$firstMember = $members[0];
		if (is_object($firstMember)) {
			updateView($firstMember);
		}
	}
	setDebugTrace($smarty);
	redirectTo('membres.php', $smarty);
?>