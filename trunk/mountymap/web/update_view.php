<?php
	require_once dirname(__FILE__).'/../etc/settings.inc.php';
	require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
	
	$smarty = instantiateSmartyTemplate(dirname(__FILE__));
	$membersFactory = MemberFactory::getInstance();
	
	$id = (array_key_exists('id', $_GET) && is_numeric($_GET['id'])) ? intval($_GET['id']) : false; 
	$member = $membersFactory->getLastUpdatedMember($id);
	
	if (is_object($member)) {
		$trollId = $member->getId();
		updateDataFromMountySite(new ViewParser($member));
		$member->update(array('mise_a_jour' => 'NOW()'));
	}

	setDebugTrace($smarty);
	redirectTo('members.php', $smarty);
?>