<?php
	require_once dirname(__FILE__).'/../etc/settings.inc.php';
	require_once dirname(__FILE__).'/../lib/core.inc.php';
	require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
	require_once dirname(__FILE__).'/../lib/MapBuilder.class.php';
	
	$smarty = instantiateSmartyTemplate(dirname(__FILE__));
	
	$x = array_key_exists('start_x', $_REQUEST) ? $_REQUEST['start_x'] : 0;
	$y = array_key_exists('start_y', $_REQUEST) ? $_REQUEST['start_y'] : 0;
	$n = array_key_exists('start_n', $_REQUEST) ? $_REQUEST['start_n'] : -30;
	$range = array_key_exists('range', $_REQUEST) ? $_REQUEST['range'] : 10;
	
	$mapBuilder = new MapBuilder($x, $y, $n, $range);
	$smarty->assign('map',  $mapBuilder->buildMap());
	$smarty->assign('row_size', $mapBuilder->getRowSize());
	$smarty->assign('start_x', $x);
	$smarty->assign('start_y', $y);
	$smarty->assign('start_n', $n);
	$smarty->assign('range', $range);
	setDebugTrace($smarty);
	setErrorTrace($smarty);
	$smarty->display('map.tpl');
?>