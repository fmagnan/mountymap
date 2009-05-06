<?php

class MapBuilder {
	
	var $range;
	
	function buildMap($parameters) {
		$map = array();
		
		$startX = array_key_exists('start_x', $parameters) ? $parameters['start_x'] : 0;
		$startY = array_key_exists('start_y', $parameters) ? $parameters['start_y'] : 0;
		$startN = array_key_exists('start_n', $parameters) ? $parameters['start_n'] : -30;
		$range = array_key_exists('range', $parameters) ? $parameters['range'] : 10;
		$this->range = $range;
		$excludeTrolls = array_key_exists('exclude_trolls', $parameters);
		$excludeMonsters = array_key_exists('exclude_monsters', $parameters);
		$excludeTreasures = array_key_exists('exclude_treasures', $parameters);
		$excludePlaces = array_key_exists('exclude_places', $parameters);
		$excludeMushrooms = array_key_exists('exclude_mushrooms', $parameters);
		
		$beginX = $startX - $range;
		$endX = $startX + $range;
		$beginY = $startY - $range;
		$endY = $startY + $range;
		for($y = $endY; $y >= $beginY; $y--) {
			for($x = $beginX; $x <= $endX; $x++) {
				$cell_position = array('position_x' => $x, 'position_y' => $y);
				$cell = array('position_x' => $x, 'position_y' => $y);
				if (!$excludeMushrooms) {
					$cell['info_champignons'] = $this->getInfoInCell($cell_position, 'ChampignonFactory');
				}
				if (!$excludePlaces) {
					$cell['info_lieux'] = $this->getInfoInCell($cell_position, 'LieuFactory');
				}
				if (!$excludeMonsters) {
					$cell['info_monstres'] = $this->getInfoInCell($cell_position, 'MonsterFactory');
				}
				if (!$excludeTreasures) {
					$cell['info_tresors'] = $this->getInfoInCell($cell_position, 'TresorFactory');
				}
				if (!$excludeTrolls) {
					$cell['info_trolls'] = $this->getInfoInCell($cell_position, 'TrollPositionFactory');
				}
				$map[] = $cell;
			}	
		}
		return $map;
	}
	
	function getRowSize() {
		return (2 * $this->range) + 1;
	}
	
	function getInfoInCell($cell, $factoryName) {
		$factory = call_user_func(array($factoryName, 'getInstance'));
		$objects = $factory->getInstancesFromArray($cell);
		if (empty($objects)) {
			return false;
		} else {
			$objectsInfo = '<h3>'.$factory->getCellHeader().' : </h3>';
			foreach ($objects as $object) {
				$objectsInfo .= $object->getCellInfo().'<br />';
			}
			return $objectsInfo;
		}
	}
}
?>