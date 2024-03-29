<?php
	require_once dirname(__FILE__).'/../etc/settings.inc.php';
	require_once dirname(__FILE__).'/../lib/core.inc.php';
	require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
	require_once dirname(__FILE__).'/../lib/MapBuilder.class.php';
	
	function getCheckStatus($checked) {
		return $checked ? 'checked="checked"' : '';
	}
	
	function getNavigatorLink($parameters, $side) {
		$inline_parameters = array();
		foreach($parameters as $key => $value) {
			if ($side == 'up' && $key == 'position_y') {
				$value = $value + 5;
			} elseif($side == 'down' && $key == 'position_y') {
				$value = $value - 5;
			} elseif($side == 'left' && $key == 'position_x') {
				$value = $value - 5;
			} elseif($side == 'right' && $key == 'position_x') {
				$value = $value + 5;
			}
			$inline_parameters[] = $key . '=' . $value;
		}
		return 'map.php?'.implode('&amp;', $inline_parameters);
	}
	
	$form_parameters = array(
		array('name' => 'position_x', 'type' => 'int', 'default' => 0),
		array('name' => 'position_y', 'type' => 'int', 'default' => 0),
		array('name' => 'start_n', 'type' => 'int', 'default' => -25),
		array('name' => 'end_n', 'type' => 'int', 'default' => -35),
		array('name' => 'range', 'type' => 'int', 'default' => 6),
		array('name' => 'exclude_trolls', 'type' => 'bool'),
		array('name' => 'exclude_treasures', 'type' => 'bool'),
		array('name' => 'exclude_places', 'type' => 'bool'),
		array('name' => 'exclude_monsters', 'type' => 'bool'),
		array('name' => 'exclude_mushrooms', 'type' => 'bool'),
	);
	
	$smarty = instantiateSmartyTemplate(dirname(__FILE__));
	
	$map_parameters = array();
	foreach ($form_parameters as $param) {
		$name = $param['name'];
		$type = $param['type'];
		
		if ($type == 'int') {
			$value = array_key_exists($name, $_REQUEST) ? intval($_REQUEST[$name]) : $param['default'];
			$map_parameters[$name] = $value;
			$smarty->assign($name, $value);
		} elseif($type == 'bool') {
			$value = array_key_exists($name, $_REQUEST) ? $_REQUEST[$name] == true : false;
			$map_parameters[$name] = $value;
			$smarty->assign($name, getCheckStatus($value));
		}
	}
	
	$mapBuilder = new MapBuilder();
	$smarty->assign('map',  $mapBuilder->buildMap($map_parameters));
	$smarty->assign('row_size', $mapBuilder->getRowSize());
	$smarty->assign('up_link', getNavigatorLink($map_parameters, 'up'));
	$smarty->assign('left_link', getNavigatorLink($map_parameters, 'left'));
	$smarty->assign('right_link', getNavigatorLink($map_parameters, 'right'));
	$smarty->assign('down_link', getNavigatorLink($map_parameters, 'down'));
	setDebugTrace($smarty);
	setErrorTrace($smarty);
	$smarty->display('map.tpl');
?>