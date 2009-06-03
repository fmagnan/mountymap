<?php
	require_once dirname(__FILE__).'/../etc/settings.inc.php';
	require_once dirname(__FILE__).'/../lib/Member.class.php';
	require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
	
	$user_actions = array('delete', 'activate', 'deactivate'); 
	
	$smarty = instantiateSmartyTemplate(dirname(__FILE__));
	$userFactory = UserFactory::getInstance();
	
	if (array_key_exists('action', $_REQUEST) && array_key_exists('id', $_REQUEST)) {
		$user = $userFactory->getInstanceFromArray(array('id' => intval($_REQUEST['id'])));
		if (is_object($user) && !$user->isError() && in_array($action= $_REQUEST['action'], $user_actions)) {
			$user->$action();
		}
	}
	
	$smarty->assign('users', $userFactory->getInstances());
	setDebugTrace($smarty);
	setErrorTrace($smarty);
	$smarty->display('users.tpl');
?>