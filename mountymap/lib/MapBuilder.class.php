<?php

class MapBuilder {
	
	var $startInX, $startInY, $startInN, $horizontalRange, $verticalRange;
	
	function __construct($startInX, $startInY, $startInN, $horizontalRange) {
		$this->startInX = $startInX;
		$this->startInY = $startInY;
		$this->startInN = $startInN;
		$this->horizontalRange = $horizontalRange;
		$this->verticalRange = floor($this->horizontalRange / 2);
	}

	function buildMap() {
		$map = array();
		$beginX = $this->startInX - $this->horizontalRange;
		$endX = $this->startInX + $this->horizontalRange;
		$beginY = $this->startInY - $this->horizontalRange;
		$endY = $this->startInY + $this->horizontalRange;
		for($y = $endY; $y >= $beginY; $y--) {
			for($x = $beginX; $x <= $endX; $x++) {
				$cell_position = array('position_x' => $x, 'position_y' => $y);
				$cell = array('position_x' => $x, 'position_y' => $y);
				$cell['info_champignons'] = $this->getInfoInCell($cell_position, 'ChampignonFactory');
				$cell['info_lieux'] = $this->getInfoInCell($cell_position, 'LieuFactory');
				$cell['info_monstres'] = $this->getInfoInCell($cell_position, 'MonsterFactory');
				$cell['info_tresors'] = $this->getInfoInCell($cell_position, 'TresorFactory');
				$cell['info_trolls'] = $this->getInfoInCell($cell_position, 'TrollPositionFactory');
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