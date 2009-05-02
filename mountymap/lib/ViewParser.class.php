<?php

require_once 'Parser.class.php';

class ViewParser extends Parser {

	var $member_id, $origin;
	
	function __construct($file, $memberId) {
		parent::__construct($file); 
		$this->sections = array(
			'TROLLS' => 'TrollPosition', 'MONSTRES' => 'Monster', 'TRESORS' => 'Tresor',
			'LIEUX' => 'Lieu', 'CHAMPIGNONS' => 'Champignon', 'ORIGINE' => false,
		);
		$this->member_id = $memberId;
		$this->origin = array();
	}
	
	function initSection($section) {
		parent::initSection($section);
		$this->flags['debut'.$section] = false;
		$this->flags['fin'.$section] = true;
	}
	
	function parseSection($section, $line) {
		if ('#DEBUT ' . $section == $line) {
			$this->flags['debut'.$section] = true;
		} elseif('#FIN '.$section == $line) {
			$this->flags['fin'.$section] = false;
		} elseif($this->flags['debut'.$section] && $this->flags['fin'.$section]) {
			$lineInArray = explode(';', $line);
			$this->data[$section][] = $this->getFormattedData($section, $lineInArray);
		}
	}
	
	function getFormattedData($section, $array) {
		$formattedData = array('id' => $array[0]);
		
		if ($section == 'TROLLS') {
			$formattedData['position_x'] = $array[1];
			$formattedData['position_y'] = $array[2];
			$formattedData['position_n'] = $array[3];
		} elseif($section == 'ORIGINE') {
			$this->origin['id'] = $this->member_id;
			$this->origin['horizontal_range'] = $array[0];
			$this->origin['position_x'] = $array[1];
			$this->origin['position_y'] = $array[2];
			$this->origin['position_n'] = $array[3];
		} elseif(in_array($section, array('MONSTRES', 'LIEUX', 'TRESORS', 'CHAMPIGNONS'))) {
			$formattedData['position_x'] = $array[2];
			$formattedData['position_y'] = $array[3];
			$formattedData['position_n'] = $array[4];
			if (in_array($section, array('MONSTRES', 'LIEUX'))) {
				$formattedData['nom'] = utf8_encode($array[1]);
			} elseif(in_array($section, array('TRESORS', 'CHAMPIGNONS'))) {
				$formattedData['type'] = utf8_encode($array[1]);
			}
	 	} 
		
		return $formattedData;
	}

	function getOrigin() {
		return $this->origin;
	}
}
?>