<?php
	require_once dirname(__FILE__).'/../etc/settings.inc.php';
	require_once dirname(__FILE__).'/../Smarty/Smarty.class.php';
	
	function getFactory() {
		$factories = array(
			'troll' => 'TrollPosition',
			'guild' => 'Guild',
			'monster' => 'Monster',
			'treasure' => 'Tresor',
			'mushroom' => 'Champignon',
			'place' => 'Lieu',
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
	
	setDebugTrace($smarty);
	setErrorTrace($smarty);
	$smarty->display('search.tpl');
?>