<?php

class MapBuilder {
	
	var $startInX, $startInY, $startInN, $horizontalRange, $verticalRange;
	
	function __construct() {
		$this->startInX = -6;
		$this->startInY = 60;
		$this->startInN = -14;
		$this->horizontalRange = 4;
		$this->verticalRange = floor($this->horizontalRange / 2);
	}

	function buildMap() {
		$map = array();
		$beginX = $this->startInX - $this->horizontalRange;
		$endX = $this->startInX + $this->horizontalRange;
		$beginY = $this->startInY - $this->horizontalRange;
		$endY = $this->startInY + $this->horizontalRange;
		echo 'X de '.$beginX.' a ' . $endX . ' et Y de ' .$beginY . ' a ' . $endY . '<br/>';
		for($y = $beginY; $y <= $endY; $y++) {
			for($x = $beginX; $x <= $endX; $x++) {
				$cell = array('position_x' => $x, 'position_y' => $y);
				$map[] = $cell;
			}	
		}
		return $map;
	}
	
	function getRowSize() {
		return (2 * $this->horizontalRange) + 1;
	}
	
}
?>