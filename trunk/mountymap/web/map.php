<?php
	require_once dirname(__FILE__).'/../etc/settings.inc.php';
	require_once dirname(__FILE__).'/../lib/core.inc.php';
	require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
	require_once dirname(__FILE__).'/../lib/MapBuilder.class.php';
	
	function getCheckStatus($checked) {
		if($checked) {
			return 'checked="checked"';
		} else {
			return '';
		}
	}
	
	$smarty = instantiateSmartyTemplate(dirname(__FILE__));
	
	$x = array_key_exists('start_x', $_REQUEST) ? $_REQUEST['start_x'] : 0;
	$y = array_key_exists('start_y', $_REQUEST) ? $_REQUEST['start_y'] : 0;
	$n = array_key_exists('start_n', $_REQUEST) ? $_REQUEST['start_n'] : -30;
	$range = array_key_exists('range', $_REQUEST) ? $_REQUEST['range'] : 10;
	$trolls = array_key_exists('trolls', $_REQUEST);
	$monsters = array_key_exists('monsters', $_REQUEST);
	$treasures = array_key_exists('treasures', $_REQUEST);
	$places = array_key_exists('places', $_REQUEST);
	$mushrooms = array_key_exists('mushrooms', $_REQUEST);
	
	$parameters = array('start_x' => $x, 'start_y' => $y, 'start_n' => $n, 'range' => $range);
	if ($trolls) {
		$parameters['exclude_trolls'] = true;
	}
	if ($monsters) {
		$parameters['exclude_monsters'] = true;
	}
	if ($treasures) {
		$parameters['exclude_treasures'] = true;
	}
	if ($places) {
		$parameters['exclude_places'] = true;
	}
	if ($mushrooms) {
		$parameters['exclude_mushrooms'] = true;
	}
	
	$mapBuilder = new MapBuilder();
	$smarty->assign('map',  $mapBuilder->buildMap($parameters));
	$smarty->assign('row_size', $mapBuilder->getRowSize());
	$smarty->assign('start_x', $x);
	$smarty->assign('start_y', $y);
	$smarty->assign('start_n', $n);
	$smarty->assign('range', $range);
	$smarty->assign('trolls', getCheckStatus($trolls));
	$smarty->assign('monsters', getCheckStatus($monsters));
	$smarty->assign('treasures', getCheckStatus($treasures));
	$smarty->assign('places', getCheckStatus($places));
	$smarty->assign('mushrooms', getCheckStatus($mushrooms));
	setDebugTrace($smarty);
	setErrorTrace($smarty);
	$smarty->display('map.tpl');
?>