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
		$entityName = $_POST['type_entite'];
		if (array_key_exists($entityName, $factories)) {
			$factory = call_user_func(array($factories[$entityName].'Factory', 'getInstance'));
			return $factory;
		} else {
			return false;
		}
	}
	
	$smarty = instantiateSmartyTemplate(dirname(__FILE__));
	
	if (array_key_exists('submit', $_POST) && array_key_exists('id', $_POST)) {
		$id = intval($_POST['id']);
		$factory = getFactory();
		if ($factory) {
			$instance = $factory->getInstanceFromArray(array('id' => $id));
			if (!$instance->isError()) {
				$smarty->assign('unique_instance', $instance);
			}
		}
	}
	
	$search_by_types = array('monster' => 'Monster', 'treasure' => 'Treasure', 'place' => 'Place', 'monster_family' => 'Monster');
	
	foreach($search_by_types as $type => $factoryName) {
		$factory = call_user_func(array($factoryName.'Factory', 'getInstance'));
		if ($type == 'monster_family') {
			$options = $factory->getMonsterFamilies();
		} else {
			$options = $factory->getInstancesByTypes();
		}
		$html_select = HtmlTool::getInstance()->getHTMLSelect($type, $options);
		$smarty->assign($type.'_options', $html_select);
		
		$selected_type = array_key_exists($type, $_POST) ? $_POST[$type] : '';
		if ($selected_type != '') {
			if ($type == 'monster_family') {
				$instances = $factory->getInstancesByFamily($selected_type);
			} else {
				$instances = $factory->getInstancesByGroupByField($selected_type);
			}
			$smarty->assign('multiple_instances', $instances);
		}
	}
	
	if (array_key_exists('min_level', $_POST) && is_numeric($_POST['min_level']) ||
		array_key_exists('max_level', $_POST) && is_numeric($_POST['max_level'])) {
		$trollFactory = TrollPositionFactory::getInstance();
		$trolls = $trollFactory->getInstancesBetweenLevels($_POST['min_level'], $_POST['max_level']);
		$smarty->assign('multiple_instances', $trolls);
	}
	
	setDebugTrace($smarty);
	setErrorTrace($smarty);
	$smarty->display('search.tpl');
?>