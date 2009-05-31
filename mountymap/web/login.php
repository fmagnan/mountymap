<?php

	require_once dirname(__FILE__).'/../etc/settings.inc.php';
	require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';

	$smarty = instantiateSmartyTemplate(dirname(__FILE__));
	if (array_key_exists('submit', $_POST) && '' != $_POST['submit']) {
		$userFactory = UserFactory::getInstance(); 
		$isLoginOk = $userFactory->login($_POST['login'], $_POST['password']);
		if (!$isLoginOk) {
			$smarty->assign('message', 'Identifiant ou mot de passe incorrect');
		}
	}
	$smarty->display('login.tpl');
?>