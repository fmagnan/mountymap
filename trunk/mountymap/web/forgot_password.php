<?php

require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
require_once dirname(__FILE__).'/../etc/settings.inc.php';

$smarty = instantiateSmartyTemplate(dirname(__FILE__));

$submit = $_POST['submit'];
$login = $_POST['login'];
$email = $_POST['email'];
$validation = true;

if ($submit) {
	if (!$login || !$email) {
		$validation = cancelValidation($smarty, 'Tous les champs sont obligatoires');
	}
	elseif (!is_numeric($login)) {
		$validation = cancelValidation($smarty, 'L\'identifiant doit être le numéro de votre troll');
	}
	elseif (!isValidEmail($email)) {
		$validation = cancelValidation($smarty, 'L\'adresse mail saisie n\'est pas valide');
	}
	elseif (!isUserExists(intval($login), $email)) {
		$validation = cancelValidation($smarty, 'L\'adresse email que vous avez fournie ne correspond pas avec celle qui a été utilisée pour ce troll');
	}
	$smarty->assign('login', $login);
	$smarty->assign('email', $email);
}

if ($submit && $validation) {
	$result = generateNewPasswordAndSendItTo(intval($login), $email);
	if ($result) {
		$submissionMessage = "Un nouveau mot de passe a été généré. Vous le recevrez prochainement par email";
		$smarty->assign('submissionMessage', $submissionMessage);
	}
	else {
		$smarty->assign('submissionMessage', 'Un problème est survenu lors de la génération du nouveau mot de passe');
	}
	$smarty->display('forgot_password_validation.tpl');
}
else {
	$smarty->display('forgot_password.tpl');	
}


?>