<?php

require_once dirname(__FILE__).'/../etc/config.inc.php';
require_once 'Parser.class.php';
require_once 'Troll.class.php';
require_once 'Monster.class.php';
require_once 'Tresor.class.php';
require_once 'Champignon.class.php';
require_once 'Lieu.class.php';
require_once 'Member.class.php';

function debugArray($array, $type='') {
	$debugArray = print_r($array, true);
	if ('log' == $type) {
		error_log($debugArray);
	} else {
		echo '<pre>'.$debugArray.'</pre>';
	}
}

/*function array_add_if_not_present($value, $array) {
	if (!in_array($value, $array)) {
		$array[] = $value;
	}
	return $array;
}

function getTimeStampFromTrollDate($dateCompilation) {
	$date = explode('-', trim(substr($dateCompilation, 0, 10)));
    $time = explode(':', trim(substr($dateCompilation,11,strlen($dateCompilation))));
    return mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
}*/

function updateView($membre) {
	$memberFactory = MemberFactory::getInstance();
	$restrictedPassword = $memberFactory->getRestrictedPasswordFrom($membre);
	/* 	TODO utiliser le bon chemin
		$viewFilePath = VIEW_FILE_PATH . '?Numero='.intval($membre).'&Motdepasse='.$restrictedPassword.'&Tresors=1&Lieux=1&Champignons=1';
	*/
	$viewFilePath = dirname(__FILE__).'/../data/vue_'.intval($membre).'.txt';
	
	$parser = new Parser($viewFilePath);
	$parser->parseFile($membre);
	
	if (!$parser->isInErrorStatus()) {
		$trollsData = $parser->getData('TROLLS');
		if (!empty($trollsData)) {
			$trollsFactory = TrollFactory::getInstance();
			$trollsFactory->insertOrUpdate($trollsData);
		}
		$monstersData = $parser->getData('MONSTRES');
		if (!empty($monstersData)) {
			$monstersFactory = MonsterFactory::getInstance();
			$monstersFactory->insertOrUpdate($monstersData);
		}
		$treasuresData = $parser->getData('TRESORS');
		if (!empty($treasuresData)) {
			$treasuresFactory = TresorFactory::getInstance();
			$treasuresFactory->insertOrUpdate($treasuresData);
		}
		$lieuxData = $parser->getData('LIEUX');
		if (!empty($lieuxData)) {
			$lieuxFactory = LieuFactory::getInstance();
			$lieuxFactory->insertOrUpdate($lieuxData);
		}
		$champignonsData = $parser->getData('CHAMPIGNONS');
		if (!empty($champignonsData)) {
			$champignonsFactory = ChampignonFactory::getInstance();
			$champignonsFactory->insertOrUpdate($champignonsData);
		}
		/*$origineData = $parser->getData('ORIGINE');
		if (!empty($origineData)) {
			$memberData = array('id' => $membre, 'mise_a_jour' => 'NOW()');
			$member = $memberFactory->getInstanceFromArray($memberData);
			$member->update($memberData);
		}*/
	}
}

/*function getDateEnFrancais($dateEnAnglais) {
	$dateEtHeure = explode(' ', $dateEnAnglais);
	$date = explode('-', $dateEtHeure[0]);
	$heure = explode(':', $dateEtHeure[1]);
	$dateEnFrancais = $date[2] . '/' . $date[1] . '/' . $date[0] . ' à ' . $heure[0] . 'h' . $heure[1];
	return $dateEnFrancais;
}*/

function instantiateSmartyTemplate($path) {
	$smarty = new Smarty();
	$smarty->template_dir = $path.'/smarty/templates';
	$smarty->compile_dir = $path.'/smarty/templates_c';
	$smarty->cache_dir = $path.'/smarty/cache';
	$smarty->config_dir = $path.'/smarty/configs';
	$smarty->caching = 0;
	
	$smarty->assign('server_root_path', SERVER_ROOT_PATH);
	$smarty->assign('debug_mode', DEBUG_MODE);
	return $smarty;
}

function setDebugTrace($smartyTemplate) {
	if (DEBUG_MODE) {
		$databaseConnector = DatabaseConnector::getInstance();
		$smartyTemplate->assign('all_sql_queries', $databaseConnector->getAllSqlQueries());
		$smartyTemplate->assign('nb_queries', count($databaseConnector->getAllSqlQueries()));
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

/*function setFiltres($parameters, &$smarty) {
	$filtres = array();
	$params='';
	foreach ($parameters AS $parameter) {
		if (array_key_exists($parameter, $_REQUEST) && '' != $_REQUEST[$parameter]) {
			$parameterValue = $_REQUEST[$parameter];
			$filtres[$parameter] = $parameterValue;
			$params .= '&amp;' . $parameter . '=' . $parameterValue;
			$smarty->assign($parameter, $parameterValue);
		}
	}
	$filtres['params']=$params;
	return $filtres;
}

function replaceWordsBySymbol($inputString) {
	$patternsToReplace = array(
		'/entre/', '/ /', '/et/', '/supérieurà/', '/inférieurà/',
	);
	$replacements = array(
		'', '', '-', '>', '<',
	);
	return preg_replace($patternsToReplace, $replacements, $inputString);
}*/

?>