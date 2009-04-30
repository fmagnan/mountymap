<?php

class MapBuilder {
	
	var $startInX, $startInY, $startInN, $horizontalRange, $verticalRange;
	
	function __construct() {
		$this->startInX = -2;
		$this->startInY = 43;
		$this->startInN = -15;
		$this->horizontalRange = 6;
		$this->verticalRange = floor($this->horizontalRange / 2);
	}

	function buildMap() {
		$map = array();
		$beginX = $this->startInX - $this->horizontalRange;
		$endX = $this->startInX + $this->horizontalRange;
		$beginY = $this->startInY - $this->horizontalRange;
		$endY = $this->startInY + $this->horizontalRange;
		echo 'X de '.$beginX.' a ' . $endX . ' et Y de ' .$beginY . ' a ' . $endY . '<br/>';
		for($y = $endY; $y >= $beginY; $y--) {
			for($x = $beginX; $x <= $endX; $x++) {
				$cell = array('position_x' => $x, 'position_y' => $y);
				$cell['info_trolls'] = $this->getInfoInCell($cell, 'TrollPositionFactory');
				$cell['info_monstres'] = $this->getInfoInCell($cell, 'MonsterFactory');
				$cell['info_tresors'] = $this->getInfoInCell($cell, 'TresorFactory');
				$cell['info_champignons'] = $this->getInfoInCell($cell, 'ChampignonFactory');
				$map[] = $cell;
			}	
		}
		return $map;
	}
	
	function getRowSize() {
		return (2 * $this->horizontalRange) + 1;
	}
	
	function getInfoInCell($cell, $factoryName) {
		$factory = call_user_func(array($factoryName, 'getInstance'));
		$objects = $factory->getInstancesFromArray($cell);
		$objectsInfo = array();
		foreach ($objects as $object) {
			$objectsInfo[] = $object->getCellInfo();
		}
		return implode('<br />', $objectsInfo);
	}
}
?>