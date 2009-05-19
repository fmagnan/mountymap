<?php
	require_once dirname(__FILE__).'/../etc/settings.inc.php';
	require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
	
	$smarty = instantiateSmartyTemplate(dirname(__FILE__));
	
	$membersFactory = MemberFactory::getInstance();
	$member = $membersFactory->getLastUpdatedMember();
	if (is_object($member)) {
		$trollId = $member->getId();
		updateDataFromMountySite(new ViewParser($member));
		$member->update(array('mise_a_jour' => 'NOW()'));
	}
	setDebugTrace($smarty);
	redirectTo('members.php', $smarty);
?>