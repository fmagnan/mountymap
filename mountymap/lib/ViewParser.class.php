<?php

require_once 'Parser.class.php';

class ViewParser extends Parser {

	var $member_id;
	
	function __construct($file, $memberId) {
		parent::__construct($file); 
		$this->sections = array(
			'TROLLS' => 'Troll', 'MONSTRES' => 'Monster', 'TRESORS' => 'Tresor',
			'LIEUX' => 'Lieu', 'CHAMPIGNONS' => 'Champignon', 'ORIGINE' => 'Troll',
		);
		$this->member_id = $memberId;
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
		if ($section == 'ORIGINE') {
			$formattedData = array('id' => $this->member_id);
		} else {
			$formattedData = array('id' => $array[0]);			
		}
		
		if (in_array($section, array('TROLLS', 'ORIGINE'))) {
			$formattedData['position_x'] = $array[1];
			$formattedData['position_y'] = $array[2];
			$formattedData['position_n'] = $array[3];
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

}
?>