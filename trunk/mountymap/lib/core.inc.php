<?php

require_once 'database.inc.php';

function debugArray($array, $type='') {
	$debugArray = print_r($array, true);
	if ('log' == $type) {
		error_log($debugArray);
	}
	else {
		echo '<pre>'.$debugArray.'</pre>';
	}
}

function array_add_if_not_present($value, $array) {
	if (!in_array($value, $array)) {
		$array[] = $value;
	}
	return $array;
}

function getTimeStampFromTrollDate($dateCompilation) {
	$date = explode('-', trim(substr($dateCompilation, 0, 10)));
    $time = explode(':', trim(substr($dateCompilation,11,strlen($dateCompilation))));
    return mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
}

function updateView($membre) {
	$restrictedPassword = getRestrictedPasswordFrom($membre);
	/* 	TODO utiliser le bon chemin
		$viewFilePath = VIEW_FILE_PATH . '?Numero='.intval($membre).'&Motdepasse='.$restrictedPassword.'&Tresors=1&Lieux=1&Champignons=1';
	*/
	$viewFilePath = dirname(__FILE__).'/../data/vue_'.intval($membre).'.txt';
	$viewData = array();	
	$viewHandle = fopen($viewFilePath, "r");
	if ($viewHandle) {
		$debutChampignons = false; $debutLieux = false; $debutMonstres = false;
		$debutOrigine = false; $debutTresors = false; $debutTrolls = false;
		
		$finChampignons = true; $finLieux = true; $finMonstres = true;
		$finOrigine = true;	$finTresors = true;	$finTrolls = true;
		
		while (!feof($viewHandle)) {
   			$line = trim(fgets($viewHandle));
   			if ('#DEBUT TROLLS' == $line) {
   				$debutTrolls = true;
   			} elseif('#FIN TROLLS' == $line) {
   				$finTrolls = false;
   			} elseif($debutTrolls && $finTrolls) {
   				$trollData = explode(';', $line);
   				insertOrUpdateTrollPosition($trollData[0], $trollData[1], $trollData[2], $trollData[3]);
   			} elseif('#DEBUT ORIGINE' == $line) {
   				$debutOrigine = true;
   			} elseif('#FIN ORIGINE' == $line) {
   				$finOrigine = false;
   			} elseif($debutOrigine && $finOrigine) {
   				$origineData = explode(';', $line);
   				updateMember($membre);
   				insertOrUpdateTrollPosition($membre, $origineData[1], $origineData[2], $origineData[3]);
   			}
		}
	}
	fclose($viewHandle);
}

function insertOrUpdateTrollPosition($numeroTroll, $positionEnX, $positionEnY, $positionEnN) {
	if (isTrollAlreadyExists($numeroTroll)) {
		updateTrollPosition($numeroTroll, $positionEnX, $positionEnY, $positionEnN);
	} else {
		insertTrollPosition($numeroTroll, $positionEnX, $positionEnY, $positionEnN);
	}
}

function getDateEnFrancais($dateEnAnglais) {
	$dateEtHeure = explode(' ', $dateEnAnglais);
	$date = explode('-', $dateEtHeure[0]);
	$heure = explode(':', $dateEtHeure[1]);
	$dateEnFrancais = $date[2] . '/' . $date[1] . '/' . $date[0] . ' à ' . $heure[0] . 'h' . $heure[1];
	return $dateEnFrancais;
}

function instantiateSmartyTemplate($path) {
	$smarty = new Smarty();
	$smarty->template_dir = $path.'/smarty/templates';
	$smarty->compile_dir = $path.'/smarty/templates_c';
	$smarty->cache_dir = $path.'/smarty/cache';
	$smarty->config_dir = $path.'/smarty/configs';
	$smarty->caching = 0;
	
	$smarty->assign('server_root_path', SERVER_ROOT_PATH);
	return $smarty;
}

function setFiltres($parameters, &$smarty) {
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
}

?>