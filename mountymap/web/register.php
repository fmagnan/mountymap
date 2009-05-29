<?php

require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
require_once dirname(__FILE__).'/../etc/settings.inc.php';

$tailleMaximalePourLeMotDePasse = 10;

$smarty = instantiateSmartyTemplate(dirname(__FILE__));

$submit = $_POST['submit'];
$login = $_POST['login'];
$pass = $_POST['password'];
$confirmation = $_POST['confirmation'];
$email = $_POST['email'];
$validation = true;

if ($submit) {
	$userFactory = UserFactory::getInstance();
	if (!$login || !$pass || !$confirmation || !$email) {
		$validation = cancelValidation($smarty, 'Tous les champs sont obligatoires');
	}
	elseif (!isValidLogin($login)) {
		$validation = cancelValidation($smarty, 'L\'identifiant doit être votre numéro de troll');
	}
	elseif(strlen($pass) > $tailleMaximalePourLeMotDePasse) {
		$validation = cancelValidation($smarty, 'La longueur du mot de passe ne doit pas excéder ' . $tailleMaximalePourLeMotDePasse . ' caractères');
	}
	elseif ($pass != $confirmation) {
		$validation = cancelValidation($smarty, 'Les 2 mots de passes saisis sont différents');
	}
	elseif (!isValidEmail($email)) {
		$validation = cancelValidation($smarty, 'L\'adresse mail saisie n\'est pas valide');
	}
	elseif ($userFactory->isUserAlreadyRegistered(intval($login))) {
		$validation = cancelValidation($smarty, 'Ce troll est déjà inscrit');
	}
	elseif ($userFactory->isEmailAlreadyExists($email)) {
		$validation = cancelValidation($smarty, 'Cette adresse email est déjà utilisée');
	}
	
	$smarty->assign('login', $login);
	$smarty->assign('password', $pass);
	$smarty->assign('confirmation', $confirmation);
	$smarty->assign('email', $email);
}

if ($submit && $validation) {
	$activationCode = generateActivationCode();
	$userData = array(
		'id' => intval($login), 'password' => md5($pass),
		'email' => $email, 'activation_code' => $activationCode,
		'is_active' => 0, 'is_admin' => 0, 'diplomacy_id' => 0,
	);
	$user_id = $userFactory->create($userData);
	if ($user_id) {
		$result = envoiMailNouvelInscrit($activationCode, $email);
		if ($result) {
			$submissionMessage = "Votre inscription a bien été prise en compte. Vous allez prochainement recevoir un email contenant
			votre code d'activation. Pour que votre compte soit activé, vous devrez envoyer un MP contenant ce code d'activation
			à Herb' (troll 6807).";
			$smarty->assign('submissionMessage', $submissionMessage);
		}
		else {
			$smarty->assign('submissionMessage', 'Un problème est survenu lors de l\'envoi du mail, veuillez prendre contact avec les administrateurs du site');
		}
	}
	else {
		$smarty->assign('submissionMessage', 'Un problème est survenu lors de la création de votre compte, aucun compte n\'a été créé');
	}
	$smarty->display('register_validation.tpl');
}
else {
	$smarty->display('register.tpl');	
}

?>