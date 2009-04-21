<?
require_once dirname(__FILE__).'/../etc/config.inc.php';

define ('MEMBERS_TABLE_NAME', 'membre');
define ('TROLLS_TABLE_NAME', 'troll');

function connectToDB($host='', $user='', $password='', $database='') {
	if ($host == '') { $host = _HOST_; }
	if ($user == '') { $user = _USER_; }
	if ($password == '') { $password = _PWD_; }
	if ($database == '') { $database = _DB_; }
	
	$link = mysql_connect($host, $user, $password) or trigger_error('error[connectToDB()]: unable to connect to database');
 	@mysql_select_db($database) or trigger_error('error[connectToDB()]: unable to select a database');
 	return $link;
}

function disconnectFromDB() {
	@mysql_close();
}

function addMysqlError($functionName) {
	global $databaseError;
	$mysqlError = mysql_errno();
	$databaseError .= '<span>fonction ' . $functionName;
	if (1022 == $mysqlError || 1062 == $mysqlError) {
		$databaseError .= ' : clef primaire dupliquée, l\'enregistrement a déjà été soumis.';
	}
	elseif (1146 == $mysqlError) {
		$databaseError .= ' : le nom d\'une table est incorrect.';
	}
	elseif (1064 == $mysqlError) {
		$databaseError .= ' : erreur de syntaxe.';
	}
	elseif (1065 == $mysqlError) {
		$databaseError .= ' : la requête est vide.';
	}
	else {
		$databaseError .= ' : erreur MySQL n°'.$mysqlError.'.'; 
	}
	$databaseError .= '</span><br/>';
	$databaseError .= '<span>'.mysql_error().'</span><br/>';
}

function executeRequeteSansDonneesDeRetour($query, $functionName) {
	connectToDB();
	$result = mysql_query($query) or addMysqlError($functionName);
	disconnectFromDB();
	return $result;
}

function executeRequeteAvecDonneeDeRetourUnique($query, $functionName, $dataName='') {
	$donneesDeRetour = array();
	connectToDB();
	$result = mysql_query($query) or addMysqlError($functionName);
	if ($result) {
		$donneesDeRetour = mysql_fetch_assoc($result);
	}
	disconnectFromDB();
	if ($dataName != '') {
		return $donneesDeRetour[$dataName];
	} else {
		return $donneesDeRetour;
	}		
}

function executeRequeteAvecDonneesDeRetourMultiples($query, $functionName) {
	$donneesDeRetour = array();
	connectToDB();
	$result = mysql_query($query) or addMysqlError($functionName);
	if ($result) {
		while ($row = mysql_fetch_assoc($result)) {
			$donneesDeRetour[] = $row;	
		}
	}
	disconnectFromDB();
	return $donneesDeRetour;
}

function executeRequeteEtTransformeDates($query, $functionName, $champsDate) {
	$donneesDeRetour = array();
	connectToDB();
	$result = mysql_query($query) or addMysqlError($functionName);
	if ($result) {
		while ($row = mysql_fetch_assoc($result)) {
			foreach($champsDate AS $champ) {
				if (array_key_exists($champ, $row)) {
					$row[$champ] = getDateEnFrancais($row[$champ]);
				}
			}
			$donneesDeRetour[] = $row;
		}
	}
	disconnectFromDB();
	return $donneesDeRetour;
}

function getMembres() {
	$requete = "SELECT `id`, `mise_a_jour` FROM `".MEMBERS_TABLE_NAME."` WHERE `password` <> '' ORDER BY `mise_a_jour` DESC";
	return executeRequeteAvecDonneesDeRetourMultiples($requete, 'getMembres');
}

function getRestrictedPasswordFrom($membre) {
	if (is_numeric($membre)) {
		$query = "SELECT `password` FROM ".MEMBERS_TABLE_NAME." WHERE `id`=".intval($membre)." LIMIT 1";
		$password = executeRequeteAvecDonneeDeRetourUnique($query, 'getRestrictedPasswordFrom', 'password');
		return md5($password);
	} else {
		return '';
	}
}

function insertTrollPosition($data) {
	$query = "	INSERT INTO ".TROLLS_TABLE_NAME."
				VALUES (".intval($data['id']).", NOW(), ".intval($data['position_x']).", ".intval($data['position_y']).", ".intval($data['position_n']).")";
	executeRequeteSansDonneesDeRetour($query, 'insertTrollPosition');
}

function updateTrollPosition($data) {
	$query = "	UPDATE ".TROLLS_TABLE_NAME."
				SET `mise_a_jour`=NOW(), `position_x`=".intval($data['position_x']).", `position_y`=".intval($data['position_y']).", `position_n`=".intval($data['position_n'])."
				WHERE `id`=".intval($data['id']);
	executeRequeteSansDonneesDeRetour($query, 'updateTrollPosition');
}

/*function deleteTrolls($origineData) {
	$origineEnX = intval($origineData['position_x']);
	$origineEnY = intval($origineData['position_y']);
	$origineEnN = intval($origineData['position_n']);
	$nombreCasesVuesEnHorizontal = intval($origineData['nombre_cases_vues_horizontales']);
	$nombreCasesVuesEnVertical = intval($origineData['nombre_cases_vues_verticales']);
	
	$query = "	DELETE FROM `".TROLLS_TABLE_NAME."`
				WHERE (`position_x` BETWEEN ".($origineEnX - $nombreCasesVuesEnHorizontal) ." AND " .($origineEnX + $nombreCasesVuesEnHorizontal).")
				AND (`position_y` BETWEEN " .($origineEnY - $nombreCasesVuesEnHorizontal) ." AND " .($origineEnY + $nombreCasesVuesEnHorizontal).")
				AND (`position_n` BETWEEN " .($origineEnN - $nombreCasesVuesEnVertical) ." AND " .($origineEnN + $nombreCasesVuesEnVertical).")";
	executeRequeteSansDonneesDeRetour($query, 'deleteTrolls');
}*/



function updateMember($numeroTroll) {
	$query = "UPDATE ".MEMBERS_TABLE_NAME." SET `mise_a_jour`=NOW() WHERE `id`=".intval($numeroTroll);
	executeRequeteSansDonneesDeRetour($query, 'updateMember');
}

function isTrollAlreadyExists($numeroTroll) {
	$query = 'SELECT `id` FROM `'.TROLLS_TABLE_NAME.'` WHERE `id` = '.intval($numeroTroll);
	$id = executeRequeteAvecDonneeDeRetourUnique($query, 'isTrollAlreadyExists', 'id');
	return is_numeric($id);
}

/*

function getTrollsFromGuilde($numeroGuilde) {
	$query = "	SELECT  DISTINCT private.`numero`, `nom`, `niveau`, `vie`, `attaque`, `esquive`, `degats`, `regeneration`, `armure`, `vue`, `date_compilation`
				FROM ".PUBLIC_DATA_TABLE_NAME." AS public, ".PRIVATE_DATA_TABLE_NAME." AS private
				WHERE public.`numero_guilde`=$numeroGuilde AND public.`numero`=private.`numero`
				ORDER BY private.`numero`, `date_compilation` DESC";
	return executeRequeteAvecDonneesDeRetourMultiples($query);
}



function getNombreAnalysesDeLaSemaine() {
	$requete = "SELECT COUNT(`user_id`) AS `nombre_analyses_semaine` FROM ".APPLICATIVE_LOGS_TABLE_NAME." WHERE `applicative_log_date` >=  DATE_SUB(NOW(),INTERVAL 7 DAY)";
	$result = executeRequeteAvecDonneeDeRetourUnique($requete, 'getNombreAnalysesDeLaSemaine');
	return $result['nombre_analyses_semaine'];
}

function getContributionsParSemaine() {
	$contributions = array();
	$requete = "SELECT MIN(`applicative_log_date`) AS date_debut FROM ".APPLICATIVE_LOGS_TABLE_NAME;
	$resultat = executeRequeteAvecDonneeDeRetourUnique($requete, 'rechercheDateDebutContributions');
	$dateDebutContributions = $resultat['date_debut'];
	$requete = "SELECT MAX(`applicative_log_date`) AS date_fin FROM ".APPLICATIVE_LOGS_TABLE_NAME;
	$resultat = executeRequeteAvecDonneeDeRetourUnique($requete, 'rechercheDateFinContributions');
	$dateFinContributions = $resultat['date_fin'];
	$requete = "SELECT (DATEDIFF('$dateFinContributions', '$dateDebutContributions')) AS nombreJours";
	$resultat = executeRequeteAvecDonneeDeRetourUnique($requete, 'rechercheNombreJoursTotal');
	$nombreDeJoursAExplorer = $resultat['nombreJours'];
	$nombreDeSemaines = intval(abs($nombreDeJoursAExplorer / 7)); 
	for ($i=0; $i < $nombreDeSemaines; $i++) {
	$requete = "SELECT COUNT(`user_id`) AS `nombre_analyses_par_semaine` FROM ".APPLICATIVE_LOGS_TABLE_NAME."
				WHERE `applicative_log_date` >= DATE_ADD('$dateDebutContributions', INTERVAL ".($i*7)." DAY)
				AND `applicative_log_date` < DATE_ADD('$dateDebutContributions', INTERVAL ".(($i+1)*7)." DAY)";
		$nombreAnalysesParSemaines = executeRequeteAvecDonneeDeRetourUnique($requete, 'rechercheNombreAnalysesParSemaine');
		$contributions[$i] = $nombreAnalysesParSemaines['nombre_analyses_par_semaine'];
	}
	
	return $contributions;
}

function getMd5PassFromDB($userId) {
	$query = 'SELECT user_pass from `'.USERS_TABLE_NAME.'` WHERE user_id='.$userId;
	$donnees = executeRequeteAvecDonneeDeRetourUnique($query, 'getMd5PassFromDB');
	return $donnees['user_pass'];
}

function getCssStyle($userId) {
	$query = 'SELECT user_css_style from `'.USERS_TABLE_NAME.'` WHERE user_id='.intval($userId);
	$donnees = executeRequeteAvecDonneeDeRetourUnique($query, 'getCssStyle');
	return $donnees['user_css_style'];
}

function getInfosTrollFromDB($numero, $date) {
	$query = "	SELECT private.`numero`, `nom`, private.`niveau`, private.`vie`, private.`attaque`, private.`esquive`,
				 `niveau_actuel`, `race`, `numero_guilde`, `guilde`, private.`degats`, private.`regeneration`, private.`armure`,
				 private.`vue`, private.`date_compilation`, merged.`sortileges`
				FROM ".PUBLIC_DATA_TABLE_NAME." AS public, ".PRIVATE_DATA_TABLE_NAME." AS private, ".MERGED_DATA_TABLE_NAME." AS merged
				WHERE public.`numero`=private.`numero` AND public.`numero`=merged.`numero`
				AND public.`numero`=$numero AND private.`date_compilation`='$date'";
	return executeRequeteAvecDonneeDeRetourUnique($query, 'getInfosTrollFromDB');
}

function makeJavascriptFunctionFrom($infos) {
	if (is_array($infos)) {
		$content = "new Array(".implode(",", $infos).")";
	}
	else {
		$content = $infos;
	}
	return "function getInfosSurLesTrolls() { return ".$content.";}";
}

function makeInfosTrollsForJavascript($idsTrolls) {
	$infosTrolls = array();
	foreach ($idsTrolls AS $numeroTroll) {
		$query = "SELECT private.`numero`, private.`niveau`, private.`vie`, private.`attaque`, private.`esquive`, private.`degats`, 
				private.`regeneration`, private.`armure`, private.`vue`, private.`date_compilation`, merged.`sortileges`
				FROM ".PRIVATE_DATA_TABLE_NAME." AS private, ".MERGED_DATA_TABLE_NAME." AS merged
				WHERE private.`numero`=merged.`numero` AND private.`numero`=$numeroTroll ORDER BY private.`date_compilation` DESC";
		$infos = executeRequeteAvecDonneesDeRetourMultiples($query);
		if (false == $infos) {
			$infosTrolls[] = 'new Array()';	
		}
		else {
			$troll = $infos[0];
			$infosTrolls[] = "new Array('".getDateEnFrancais($troll['date_compilation'])."', '".$troll['niveau']."', '".$troll['vie']."', '".$troll['attaque'].
			"', '".$troll['esquive']."', '".$troll['degats']."', '".$troll['regeneration']."', '".$troll['armure']."', '".$troll['vue']."', '".$troll['sortileges']."')";
		}
	}
	
	return makeJavascriptFunctionFrom($infosTrolls);
}

function addUser($userId, $userPass,$group) {
	$addUserQuery = "INSERT INTO ".USERS_TABLE_NAME." VALUES ($userId, '".md5($userPass)."', 'defaut', 1, 10, 0)";
	executeRequeteSansDonneesDeRetour($addUserQuery, 'addUser');
	addUserToGroup($userId, $group);
}

function augmenterDroits($userId) {
	modifierDroits($userId, getGroup($userId) + 1); 
}

function diminuerDroits($userId) {
	$groupActuel = getGroup($userId);
	$nouveauGroupe = $groupActuel > 0 ? $groupActuel - 1 : 0;
	modifierDroits($userId, $nouveauGroupe); 
}

function modifierDroits($userId, $groupId) {
	$requete = "UPDATE `".GROUPS_TABLE_NAME."` SET `group_id`=".intval($groupId)." WHERE `user_id`=".intval($userId);
	executeRequeteSansDonneesDeRetour($requete, 'modifierDroits');
}

function modifierUtilisateur($userId, $data) {
	$elementsToUpdate = array();
	foreach($data AS $key => $value) {
		$elementsToUpdate[] = "`$key`='$value'";
	}
	$requete = "UPDATE `".USERS_TABLE_NAME."` SET ".implode(', ', $elementsToUpdate)." WHERE `user_id`=".intval($userId);
	executeRequeteSansDonneesDeRetour($requete, 'modifierUtilisateur');
}

function modifierPassword($userId, $userPass) {
	modifierUtilisateur($userId, array('user_pass' => md5($userPass)));
}

function modifierStyle($userId, $userCssStyle) {
	modifierUtilisateur($userId, array('user_css_style' => "'$userCssStyle'"));
}

function modifierPagination($userId, $pagination, $trollsParPage, $affichagePopup) {
	$data = array('pagination' => intval($pagination), 'nb_trolls_page' => intval($trollsParPage), 'affichage_popup' => intval($affichagePopup));
	modifierUtilisateur($userId, $data);
}

function deleteUser($userId) {
	deleteUserFromGroup($userId);
	executeRequeteSansDonneesDeRetour("DELETE FROM `".USERS_TABLE_NAME."` WHERE `user_id`=".intval($userId), 'deleteUser');
}

function deleteUserFromGroup($userId) {
	executeRequeteSansDonneesDeRetour("DELETE FROM `".GROUPS_TABLE_NAME."` WHERE `user_id`=".intval($userId), 'deleteUserFromGroup');
}

function addUserToGroup($userId, $group) {
	$addGroupQuery = "INSERT INTO ".GROUPS_TABLE_NAME." VALUES ($group, $userId)";
	executeRequeteSansDonneesDeRetour($addGroupQuery, 'addUserToGroup');
}

function getGroup($userId) {
	$query = "SELECT `group_id` FROM ".GROUPS_TABLE_NAME." WHERE `user_id`=".intval($userId);
	$group = executeRequeteAvecDonneeDeRetourUnique($query, 'getGroup');
	return intval($group['group_id']);
}

function getTroll($userId) {
	$query = "SELECT `nom`, `numero` FROM ".PUBLIC_DATA_TABLE_NAME." WHERE `numero`=".intval($userId);
	return executeRequeteAvecDonneeDeRetourUnique($query, 'getTroll');
}

function getDonneesDePagination($login) {
	$requete = "SELECT * FROM `".USERS_TABLE_NAME."` WHERE `user_id`=".intval($login);
	return executeRequeteAvecDonneeDeRetourUnique($requete, 'getDonneesDePagination');
}

function isNotEmptyInputArray($inputArray) {
	$isNotEmptyInputArray = FALSE;
	if (!is_array($inputArray)) {
		trigger_error('error: input data is not an array');
	}
	elseif (empty($inputArray)) {
		trigger_error('error: input data array is empty');
	}
	else {
		$isNotEmptyInputArray = TRUE;
	}
	return $isNotEmptyInputArray;
}

function getDerniereContribution() {
	$applicativeLogs = getApplicativeLogs();
	return $applicativeLogs[0];
}

function getRequeteMeilleurPosteur($interval = '') {
	return "SELECT COUNT(*) AS `nombre_analyses`, public.`nom` AS `nom_analyseur`, public.`numero` AS `numero_analyseur`
			FROM `".APPLICATIVE_LOGS_TABLE_NAME."` AS log, `".PUBLIC_DATA_TABLE_NAME."` AS public,
			`".PUBLIC_DATA_TABLE_NAME."` AS public2 WHERE log.`user_id` = public.`numero` AND log.`aa_user` = public2.`numero`
			$interval GROUP BY `nom_analyseur` ORDER BY `nombre_analyses` DESC";
}

function getMeilleurPosteur() {
	$data = executeRequeteAvecDonneesDeRetourMultiples(getRequeteMeilleurPosteur(), 'getMeilleurPosteur');
	return $data[0];
}

function getMeilleurPosteurDeLaSemaine() {
	$data = executeRequeteAvecDonneesDeRetourMultiples(getRequeteMeilleurPosteur("AND log.`applicative_log_date` >=  DATE_SUB(NOW(),INTERVAL 7 DAY)"), 'getMeilleurPosteurDeLaSemaine');
	return $data[0];
}

function getNombreTotalTrollsAnalyses() {
	$requete = "SELECT COUNT(DISTINCT private.`numero`) AS `nombre_trolls` FROM `".PRIVATE_DATA_TABLE_NAME."` AS private, 
				`".PUBLIC_DATA_TABLE_NAME."` AS public WHERE private.`numero` = public.`numero`";
	$result = executeRequeteAvecDonneeDeRetourUnique($requete, 'getNombreTotalTrollAnalyses');
	return $result['nombre_trolls'];
}

function getTrollLePlusAnalyse() {
	$requete = "SELECT COUNT(*) AS `nombre_analyses`, public.`nom`, public.`numero` 
				FROM `".PRIVATE_DATA_TABLE_NAME."` AS private, `".PUBLIC_DATA_TABLE_NAME."` AS public
				WHERE public.`numero` = private.`numero` GROUP BY private.`numero` ORDER BY `nombre_analyses` DESC";
	$data = executeRequeteAvecDonneesDeRetourMultiples($requete, 'getTrollLePlusAnalyse');
	return $data[0];
}

function getNombreTotalInscrits() {
	$requete = "SELECT COUNT(*) AS `nombre_inscrits` FROM `".USERS_TABLE_NAME."`";
	return executeRequeteAvecDonneeDeRetourUnique($requete, 'getNombreTotalInscrits');
}

function storeApplicativeLogs($analyserId, $analysisId, $compilationDate='NOW()') {
	$insertApplicativeLogQuery = "INSERT INTO `".APPLICATIVE_LOGS_TABLE_NAME."` (`user_id`, `aa_user`, `applicative_log_date`, `aa_date`) 
		VALUES (".intval($analyserId).", ".intval($analysisId).", NOW(), $compilationDate)";
	executeRequeteSansDonneesDeRetour($insertApplicativeLogQuery, 'storeApplicativeLogs');
}

function storeHttpLogs($userId) {
	$httpUserAgent  = addslashes($_SERVER['HTTP_USER_AGENT']);
	$httpReferer  = $_SERVER['HTTP_REFERER'];
	$httpCookie = $_SERVER['HTTP_COOKIE'];
	
	if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
   		if ($_SERVER["HTTP_CLIENT_IP"]) {
    		$proxyIpAddress = $_SERVER["HTTP_CLIENT_IP"];
  		} else {
    		$proxyIpAddress = $_SERVER["REMOTE_ADDR"];
  		}
  		$remoteIpAddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} else {
  		if ($_SERVER["HTTP_CLIENT_IP"]) {
    		$remoteIpAddress = $_SERVER["HTTP_CLIENT_IP"];
  		} else {
    		$remoteIpAddress = $_SERVER["REMOTE_ADDR"];
  		}
	}
	if ('' != $proxyIpAddress) {
		$proxyNameAddress = gethostbyaddr($proxyIpAddress);
	}
	if ('' != $remoteIpAddress) {
		$remoteNameAddress = gethostbyaddr($remoteIpAddress);
	}

	$insertHttpLogQuery = "INSERT INTO `".HTTP_LOGS_TABLE_NAME."` (".
		"`user_id`, `http_user_agent`, `http_referer`, `http_cookie`, `remote_ip_address`, `remote_name_address`,".
		"`proxy_ip_address`, `proxy_name_address`, `http_log_date`) VALUES (". 
		"$userId, '$httpUserAgent', '$httpReferer', '$httpCookie', '$remoteIpAddress', '$remoteNameAddress',".
		"'$proxyIpAddress', '$proxyNameAddress', NOW())";
	executeRequeteSansDonneesDeRetour($insertHttpLogQuery, 'storeHttpLogs');
}

function triAnalysesParNumeroTroll($result) {
	global $ANALYSES_INTERDITES;
	$trolls = array();
	while ($troll = mysql_fetch_array($result)) {
		if (!in_array($troll['numero'], $ANALYSES_INTERDITES)) {
			$trolls[] = $troll;
		}
	}
	return $trolls;
}



function createOrUpdateTrollInDB($infosTroll, $getQueryFunctionName) {
	if (isNotEmptyInputArray($infosTroll)) {
		$result = executeRequeteSansDonneesDeRetour($getQueryFunctionName($infosTroll), 'createOrUpdateTrollInDB');
		$resultSortileges = initialiseSortileges($infosTroll);
		return $result && $resultSortileges;
	}
}

function initialiseSortileges($infosTroll) {
	$resultSortileges = true;
	$requeteSelection = "SELECT `numero` FROM `".MERGED_DATA_TABLE_NAME."` WHERE `numero`=".$infosTroll['numero'];
	$isTrollConnu = executeRequeteAvecDonneeDeRetourUnique($requeteSelection, 'rechercheTrollConnu');
	if (!$isTrollConnu['numero']) {
		$requeteInitSorts = "INSERT INTO `".MERGED_DATA_TABLE_NAME."` (".
			"`numero`, `niveau`, `vie`, `attaque`, `esquive`, `degats`, `regeneration`, `armure`, `vue`, ".
			"`date_compilation`, `sortileges`) VALUES ({$infosTroll['numero']}, '', '', '', '', '', '', '', '', '', '')";
		$resultSortileges = executeRequeteSansDonneesDeRetour($requeteInitSorts, 'initialiseSortileges');
	}
	return $resultSortileges;
}

function addslashesForArray($inputArray) {
	$escapedArray = array();
	foreach ($inputArray AS $key => $value) {
		$escapedArray[$key] = addslashes($value);
	}
	return $escapedArray;
}

function getQueryForCreate($infosTroll) {
	$data = addslashesForArray($infosTroll);
	$dateCompilation = $data['date_compilation'] != '' ? "'{$data['date_compilation']}'" : 'NOW()';
	$createTrollQuery = "INSERT INTO `".PRIVATE_DATA_TABLE_NAME."` (".
		"`numero`, `niveau`, `vie`, `attaque`, `esquive`, `degats`, `regeneration`, `armure`, `vue`, ".
		"`date_compilation`) VALUES ". 
		"({$data['numero']},{$data['niveau']},'{$data['vie']}','{$data['attaque']}','{$data['esquive']}',".
		"'{$data['degats']}','{$data['regeneration']}','{$data['armure']}','{$data['vue']}',$dateCompilation)";
	return $createTrollQuery;
}

function addTrollParAnalyseDirecte($analyseDirecte) {
	$requete = "INSERT INTO `".PRIVATE_DATA_TABLE_NAME."` (".
		"`numero`, `niveau`, `vie`, `attaque`, `esquive`, `degats`, `regeneration`, `armure`, `vue`, ".
		"`date_compilation`) VALUES ". 
		"(".$analyseDirecte[0].",".$analyseDirecte[1].",'".$analyseDirecte[2]."','".$analyseDirecte[3]."','
		".$analyseDirecte[4]."','".$analyseDirecte[5]."','".$analyseDirecte[6]."','".$analyseDirecte[7]."','
		".$analyseDirecte[8]."', NOW())";
	echo $requete;
	
}

function emptyPublicInfosInDB() {
	executeRequeteSansDonneesDeRetour("TRUNCATE TABLE `".PUBLIC_DATA_TABLE_NAME."`", 'emptyPublicInfosInDB');
}

function fillPublicInfosInDB($publicInfos) {
	emptyPublicInfosInDB();
	foreach ($publicInfos AS $numeroGuilde => $trolls) {
		$nomGuilde = addslashes($publicInfos[$numeroGuilde]['guilde']);
		foreach ($trolls AS $numeroTroll => $infosTroll) {
			$numeroTroll = intval($numeroTroll);
			if ($numeroTroll) {
				$nomTroll = addslashes($infosTroll['nom']);
				$query = "INSERT INTO `".PUBLIC_DATA_TABLE_NAME."` (`numero`, `nom`, `race`, `numero_guilde`, `guilde`, `niveau_actuel`) ".
				"VALUES ({$numeroTroll},'{$nomTroll}','{$infosTroll['race']}',".
				"{$numeroGuilde},'{$nomGuilde}',{$infosTroll['niveau_actuel']})";
				executeRequeteSansDonneesDeRetour($query, 'fillPublicInfosInDB');
			}
		}
	}
}

function getQueryForUpdate($infosTroll) {
	$data = addslashesForArray($infosTroll);
	$updateFieldsArray = array();
	$updateTrollQuery = "UPDATE `mountyhall_troll` SET ";
	foreach($data AS $clefChamp => $valeurChamp) {
		if ('numero' != $clefChamp && 'niveau' != $clefChamp) {
			$valeurChamp = "'$valeurChamp'";
		}
		$updateFieldsArray[] = "`$clefChamp`=$valeurChamp";
	}
	$updateTrollQuery .= implode(",", $updateFieldsArray) . " WHERE `numero`={$infosTroll['numero']}";
	return $updateTrollQuery;
}

function getQueryForDelete($trollId) {
	return 'DELETE FROM `mountyhall_troll` WHERE `numero` = '.$trollId;
}

function createTrollInDB($infosTroll) {
	return createOrUpdateTrollInDB($infosTroll, 'getQueryForCreate');
}

function updateTrollInDB($infosTroll) {
	return createOrUpdateTrollInDB($infosTroll, 'getQueryForUpdate');
}

function deleteTrollInDB($trollId) {
	executeRequeteSansDonneesDeRetour(getQueryForDelete($trollId), 'deleteTrollInDB');
}

function getTableDump($tableName) {
	$dump = '';
	connectToDB();
	$tableDescription = mysql_query("SHOW CREATE TABLE $tableName");
	if ($tableDescription) {
		$tableau = mysql_fetch_array($tableDescription);
		$dump.= str_replace("\n", "", $tableau[1] . ';') . "\n";
	}
	
	$allRowsQuery = mysql_query("SELECT * FROM $tableName");
	$numberOfFields = mysql_num_fields($allRowsQuery);
	while ($row = mysql_fetch_array($allRowsQuery)) {
		$insert .= "INSERT INTO $tableName VALUES(";
		for ($i=0; $i<=$numberOfFields-1; $i++) {
			$insert .= "'" . mysql_real_escape_string($row[$i]) . "', ";
		}
		$insert = substr($insert, 0, -2) . ");\n";
	}
	if ($insert != "") {
	    $dump .= $insert . "\n";
	}
	disconnectFromDB();
	return $dump;
}*/
?>