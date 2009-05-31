<?php

require_once 'HtmlTool.class.php';

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
			if (!$parameters['exclude_'.$type]) {
				$this->fillCells($factory, $type, $start_x, $end_x, $start_y, $end_y, $start_n, $end_n);
			}
		}

		for($y = $end_y; $y >= $start_y; $y--) {
			for($x = $start_x; $x <= $end_x; $x++) {
				$map[] = $this->getCell($x, $y);
			}	
		}
		
		return $map;
	}
	
	function fillCells($factory_name, $type, $start_x, $end_x, $start_y, $end_y, $start_n, $end_n) {
		$htmlTool = HtmlTool::getInstance();
		$factory = $this->getFactoryFromName($factory_name);
		$items = $factory->getDataWithPosition($start_x, $end_x, $start_y, $end_y, $start_n, $end_n);
		
		foreach($items as $item) {
			$level = $item['position_n'];
			$position = $item['position_x'] . ',' . $item['position_y'];
			if (!array_key_exists($position, $this->cells)) {
				$this->cells[$position] = array();
				if (!array_key_exists($level, $this->cells[$position])) {
					$this->cells[$position][$level] = array();
				}
			}
			
			if ('Place' == $factory_name) {
				$class='lieu';
			}
			
			$this->cells[$position][$level][] = $htmlTool->getCellInfo($factory_name, $item);
			$this->cells[$position][$type] = true;
			$this->cells[$position]['class'] = $class;
		}
	}
	
	function getRowSize() {
		return (2 * $this->range) + 1;
	}
	
	function getCell($x, $y) {
		$cell = array();
		$key = $x . ',' . $y;
		$cellInfo = '';
		if (array_key_exists($key, $this->cells)) {
			$cellContentByLevel = $this->cells[$key];
			ksort($cellContentByLevel);
			
			foreach($cellContentByLevel as $level => $info) {
				if (is_numeric($level)) {
					if (is_array($info)) {
						$cellInfo .= '<h4>X= '.$x.' | Y= '.$y.' | N = '.$level.'</h4>';
						foreach ($info as $line) {
							$cellInfo .= $line . '<br/>';
						}
					}
				} else {
					$cell[$level] = $info;
				}
			}
			$cell['content'] = $cellInfo;
			return $cell;
		}
		return false;
	}
	
	function getFactoryFromName($name) {
		return call_user_func(array($name.'Factory', 'getInstance'));
	}
	
}
?>