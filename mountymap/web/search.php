<?php
	require_once dirname(__FILE__).'/../etc/settings.inc.php';
	require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
	require_once dirname(__FILE__).'/../lib/HtmlTool.class.php';
	
	function getFactory() {
		$factories = array(
			'troll' => 'TrollPosition',
			'guild' => 'Guild',
			'monster' => 'Monster',
			'treasure' => 'Treasure',
			'mushroom' => 'Mushroom',
			'place' => 'Place',
		);
		$entityName = array_key_exists('type_entite', $_POST) ? $_POST['type_entite'] : '';
		return (array_key_exists($entityName, $factories)) ? call_user_func(array($factories[$entityName].'Factory', 'getInstance')) : false;
	}
	
	$smarty = instantiateSmartyTemplate(dirname(__FILE__));
	
	if (array_key_exists('submit', $_POST) && array_key_exists('id', $_POST)) {
		$id = intval($_POST['id']);
		$smarty->assign('id', $id);
		$factory = getFactory();
		if ($factory) {
			$table_headers = $factory->getSearchTableHeaders();
			$instance = $factory->getInstanceFromArray(array('id' => $id));
			if (!$instance->isError()) {
				if ($factory->getTableName() == 'guilde') {
					$instances = $instance->getAllTrolls();
				} else {
					$smarty->assign('unique_instance', $instance);
				}
			}
		}
	}
	
	$search_by_types = array('monster' => 'Monster', 'treasure' => 'Treasure', 'place' => 'Place', 'monster_family' => 'Monster');
	foreach($search_by_types as $type => $factoryName) {
		$factory = call_user_func(array($factoryName.'Factory', 'getInstance'));
		$options = ($type == 'monster_family') ? $factory->getMonsterFamilies() : $factory->getInstancesByTypes();
		$html_select = HtmlTool::getHTMLSelect($type, $options);
		$smarty->assign($type.'_options', $html_select);
		
		$selected_type = array_key_exists($type, $_POST) ? $_POST[$type] : '';
		if ($selected_type != '') {
			$table_headers = $factory->getSearchTableHeaders();
			$instances = ($type == 'monster_family') ? $factory->getInstancesByFamily($selected_type) : $factory->getInstancesByGroupByField($selected_type);
		}
	}
	
	$troll_race = array_key_exists('troll_race', $_POST) ? intval($_POST['troll_race']) : false;
	$troll_min_level = array_key_exists('troll_min_level', $_POST) && is_numeric($_POST['troll_min_level']) ? intval($_POST['troll_min_level']) : 1;
	$troll_max_level = array_key_exists('troll_max_level', $_POST) && is_numeric($_POST['troll_max_level']) ? intval($_POST['troll_max_level']) : 80;
	$smarty->assign('troll_min_level', $troll_min_level);
	$smarty->assign('troll_max_level', $troll_max_level);
	$smarty->assign('troll_race', $troll_race);
	$troll_races = array_merge(array(false), unserialize(TROLLS_RACES));
	$troll_race_options = HtmlTool::getHTMLSelect('troll_race', $troll_races);
	$smarty->assign('troll_race_options', $troll_race_options);
	if(array_key_exists('search_by_troll', $_POST)) {
		$trollFactory = TrollPositionFactory::getInstance();
		$table_headers = $trollFactory->getSearchTableHeaders();
		$instances = $trollFactory->getInstancesBetweenLevels($troll_min_level, $troll_max_level, $troll_race);
	}
	
	if (array_key_exists('monster_min_level', $_POST) && is_numeric($_POST['monster_min_level']) ||
		array_key_exists('monster_max_level', $_POST) && is_numeric($_POST['monster_max_level'])) {
		$monsterFactory = MonsterFactory::getInstance();
		$table_headers = $monsterFactory->getSearchTableHeaders();
		$instances = $monsterFactory->getInstancesBetweenLevels($_POST['monster_min_level'], $_POST['monster_max_level']);
	}
	
	if (isset($instances) && is_array($instances)) {
		$smarty->assign('multiple_instances', $instances);
	}
	if (isset($table_headers)) {
		$smarty->assign('table_headers', $table_headers);
	}
	setDebugTrace($smarty);
	setErrorTrace($smarty);
	$smarty->display('search.tpl');
?>