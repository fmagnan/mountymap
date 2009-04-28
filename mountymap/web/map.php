<?php
	require_once dirname(__FILE__).'/../etc/settings.inc.php';
	require_once dirname(__FILE__).'/../lib/core.inc.php';
	require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
	require_once dirname(__FILE__).'/../lib/MapBuilder.class.php';
	
	$smarty = instantiateSmartyTemplate(dirname(__FILE__));
	$mapBuilder = new MapBuilder();
	$smarty->assign('map',  $mapBuilder->buildMap());
	$smarty->assign('row_size', $mapBuilder->getRowSize());
	setDebugTrace($smarty);
	setErrorTrace($smarty);
	$smarty->display('map.tpl');
?>