<?php
	require_once dirname(__FILE__).'/../etc/settings.inc.php';
	require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
	
	$smarty = instantiateSmartyTemplate(dirname(__FILE__));
	$user = getLoggedInUser();
	$membersFactory = MemberFactory::getInstance();
	
	if (array_key_exists('id', $_GET) && is_numeric($_GET['id']) && $user->isAdmin()) {
		$member = $membersFactory->getInstanceFromArray(array('id' => intval($_GET['id'])));	
	} else {
		$member = $membersFactory->getLastUpdatedMember();
	}

	if (is_object($member)) {
		$trollId = $member->getId();
		updateDataFromMountySite(new ViewParser($member));
		$member->update(array('mise_a_jour' => 'NOW()'));
	}

	setDebugTrace($smarty);
	redirectTo('members.php', $smarty);
?>