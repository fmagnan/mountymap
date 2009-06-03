<?php

require_once dirname(__FILE__).'/../etc/config.inc.php';
require_once 'Diplomacy.class.php';
require_once 'DiplomacyParser.class.php';
require_once 'Guild.class.php';
require_once 'GuildParser.class.php';
require_once 'Member.class.php';
require_once 'Monster.class.php';
require_once 'Mushroom.class.php';
require_once 'Place.class.php';
require_once 'Treasure.class.php';
require_once 'Troll.class.php';
require_once 'TrollIdentityParser.class.php';
require_once 'User.class.php';
require_once 'ViewParser.class.php';

function debugArray($array, $type='') {
	$debugArray = print_r($array, true);
	if ('log' == $type) {
		error_log($debugArray);
	} else {
		echo '<pre>'.$debugArray.'</pre>';
	}
}

function updateDataFromMountySite($parser) {
	$parser->parseFile();
	$sections = $parser->getSections();
	
	if (!$parser->isInErrorStatus()) {
		$extraData = count($sections) > 1 ? $parser->getOrigin() : false; 
		foreach ($sections as $section => $object) {
			$data = $parser->getData($section);
			if ($object) {
				$factoryName = $object . 'Factory';
				$factory = call_user_func(array($factoryName, 'getInstance'));
				$factory->publicImport($data, $extraData);
			}
		}
	}
}

function getDateEnFrancais($dateEnAnglais) {
	$dateEtHeure = explode(' ', $dateEnAnglais);
	$date = explode('-', $dateEtHeure[0]);
	$heure = explode(':', $dateEtHeure[1]);
	$dateEnFrancais = 'le ' . $date[2] . '/' . $date[1] . '/' . $date[0] . ' à ' . $heure[0] . 'h' . $heure[1];
	return $dateEnFrancais;
}

function instantiateSmartyTemplate($path) {
	$smarty = new Smarty();
	$smarty->template_dir = $path.'/smarty/templates';
	$smarty->compile_dir = $path.'/smarty/templates_c';
	$smarty->cache_dir = $path.'/smarty/cache';
	$smarty->config_dir = $path.'/smarty/configs';
	$smarty->caching = 0;
	
	$smarty->assign('logged_in_user', getLoggedInUser());
	$smarty->assign('server_root_path', SERVER_ROOT_PATH);
	$smarty->assign('menu_items', unserialize(MENU_ITEMS));
	$smarty->assign('debug_mode', DEBUG_MODE);
	$smarty->assign('sql_debug', SQL_DEBUG);
	return $smarty;
}

function setDebugTrace($smartyTemplate) {
	if (DEBUG_MODE) {
		$databaseConnector = DatabaseConnector::getInstance();
		$allSqlQueries = $databaseConnector->getAllSqlQueries();
		$smartyTemplate->assign('all_sql_queries', $allSqlQueries);
		$smartyTemplate->assign('nb_queries', count($allSqlQueries));
	}
}

function setErrorTrace($smartyTemplate) {
	$databaseConnector = DatabaseConnector::getInstance();
	if ($databaseConnector->isInError()) {
		$smartyTemplate->assign('all_errors', $databaseConnector->getAllErrors());
	}
}

function redirectTo($page, $smartyTemplate) {
	if (DEBUG_MODE) {
		$smartyTemplate->assign('page', $page);
		$smartyTemplate->display('empty.tpl');
	} else {
		header('Location: '. $page);
	}
}

function getLoggedInUser() {
	if (array_key_exists('logged_user_id', $_SESSION)) {
		$userFactory = UserFactory::getInstance();
		$userData = array('id' => $_SESSION['logged_user_id']);
		return $userFactory->getInstanceFromArray($userData);
	}
	return false;
}

function getTime() {
    static $timer = false, $start;
    if ($timer === false) {
        $start = array_sum(explode(' ',microtime()));
        $timer = true;
        return NULL;
    } else {
        $timer = false;
        $end = array_sum(explode(' ',microtime()));
        return round(($end - $start), 3);
    }
}

function isValidEmail($email) {
	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email);
}

function isValidLogin($login) {
	return is_numeric($login);
}

function cancelValidation(&$smarty, $error) {
	$smarty->assign('erreur_globale', $error);
	return false;
}

function generateActivationCode() {
	$list = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	mt_srand((double)microtime()*1000000);
	$activationCode="";
	while(strlen($activationCode) < 8) {
		$activationCode .= $list[mt_rand(0, strlen($list)-1)];
	}
	return $activationCode;
}

function getMailHeaders($copiesCachees='') {
	$headers = 'Mime-Version: 1.0'."\r\n";
 	$headers .= 'Content-type: text/html; charset="utf-8"'."\r\n";
 	$headers .= 'From: "Herb\'"<herb.mh@gmail.com>'."\n";
 	$headers .= 'Reply-To: herb.mh@gmail.com'."\n";
 	if ('' != $copiesCachees) {
 		$headers .= 'Bcc: ' . $copiesCachees; 
 	}
	return $headers;
}

function envoiMailNouvelInscrit($activationCode, $email) {
	$subject = "Inscription au site des AAs";
	$message = "Bonjour, \nVous voilà désormais inscrit au site des AAs. \nVeuillez noter votre code d'activation : ".$activationCode
	."\nVotre compte n'est pas encore activé. Vous ne pouvez pas vous connecter au site tant que votre compte n'est pas activé.\n".
	"Afin que votre compte soit activé, vous devez envoyer le code d'activation par MP au troll Herb' (6807).\n".
	"Je me chargerai d'activer votre compte.\n\nA très bientôt sur le site des AAs.\n\nHerb'";
	return mail($email, $subject, $message, getMailHeaders());
}

function generateNewPasswordAndSendItTo($user, $email) {
	$trollNumber = $user->getId();
	$nouveauMotDePasse = generateActivationCode();
	$user->update(array('password' => md5($nouveauMotDePasse)));
	$subject = "Oubli de mot de passe du site des AAs";
	$message = "Bonjour n°$trollNumber,\nVous recevez cet e-mail parce que vous avez demandé à ce qu'un nouveau mot de passe vous soit envoyé pour votre compte sur le site des AAs\n".
	"Ce nouveau mot de passe est le suivant : " . $nouveauMotDePasse . "\nVous pouvez bien sûr changer vous-même ce mot de passe via les préférences du site des AAs\n".
	"Si vous rencontrez des difficultés, veuillez me contacter à cette adresse : herb.mh@gmail.com.\n\nHerb'";
	return mail($email, $subject, $message, getMailHeaders());
}

?>