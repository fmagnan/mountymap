<?php

class MapBuilder {
	
	var $range;
	var $cells;
	var $items = array(
		'TrollPosition' => 'trolls', 'Monster' => 'monsters', 'Treasure' => 'treasures',
		'Place' => 'places', 'Mushroom' => 'mushrooms',
	);
	
	function buildMap($parameters) {
		$map = array();
		$this->cells = array();
		
		$position_x = array_key_exists('position_x', $parameters) ? $parameters['position_x'] : 0;
		$position_y = array_key_exists('position_y', $parameters) ? $parameters['position_y'] : 0;
		$start_n = array_key_exists('start_n', $parameters) ? $parameters['start_n'] : -30;
		$end_n = array_key_exists('end_n', $parameters) ? $parameters['end_n'] : -30;
		$range = array_key_exists('range', $parameters) ? $parameters['range'] : 10;
		$this->range = $range;
		
		$start_x = $position_x - $range;
		$end_x = $position_x + $range;
		$start_y = $position_y - $range;
		$end_y = $position_y + $range;
		foreach($this->items as $factory => $type) {
			$this->fillCells($factory, $type, $start_x, $end_x, $start_y, $end_y, $start_n, $end_n);
		}
		
		for($y = $end_y; $y >= $start_y; $y--) {
			for($x = $start_x; $x <= $end_x; $x++) {
				$key = $x . ',' . $y;
				
				$cell = array();
				foreach ($this->items as $factory => $type) {
					if (!$parameters['exclude_'.$type]) {
						$cell[$type] = $this->getInfoInCell($key, $factory, $type);
					}
				}
				
				$map[] = $cell;
			}	
		}
		return $map;
	}
	
	function fillCells($factory_name, $type, $start_x, $end_x, $start_y, $end_y, $start_n, $end_n) {
		$factory = $this->getFactoryFromName($factory_name);
		$items = $factory->getInstancesWithPosition($start_x, $end_x, $start_y, $end_y, $start_n, $end_n);
		foreach($items as $item) {
			$level = $item->getPositionN();
			$position = $item->getPositionX() . ',' . $item->getPositionY();
			if (!array_key_exists($position, $this->cells)) {
				$this->cells[$position] = array();
				if (!array_key_exists($level, $this->cells[$position])) {
					$this->cells[$position][$level] = array();
				}
				if (!array_key_exists($type, $this->cells[$position][$level])) {
					$this->cells[$position][$level][$type] = array();
				}
			}
			$this->cells[$position][$level][$type][] = $item;
		}
	}
	
	function getRowSize() {
		return (2 * $this->range) + 1;
	}
	
	function getInfoInCell($key, $factory_name, $type) {
		$factory = $this->getFactoryFromName($factory_name);
		$cellInfo = '';
		if (array_key_exists($key, $this->cells)) {
			foreach($this->cells[$key] as $level => $level_content) {
				echo 'level = ' . $level . '<br/>';
				if (array_key_exists($type, $level_content)) {
					$located_objects = $level_content[$type];
					if (!empty($located_objects)) {
						foreach ($located_objects as $located_object) {
							if (is_object($located_object)) {
								echo $located_object->getCellInfo() . '<br />';
								$cellInfo .= $located_object->getCellInfo() . '<br />';
							}
						}
					}
				}
			}
			return $cellInfo;
		}
		return false;
	}
	
	function getFactoryFromName($name) {
		return call_user_func(array($name.'Factory', 'getInstance'));
	}
}
?>