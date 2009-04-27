<?php

class Parser {

	var $file, $data, $errors, $flags;
	var $sections = array(
		'Troll' => 'TROLLS',
		'Monster' => 'MONSTRES',
		'Tresor' => 'TRESORS',
		'Lieu' => 'LIEUX',
		'Champignon' => 'CHAMPIGNONS',
		'Troll' => 'ORIGINE',
	);
	
	function Parser($file) {
		$this->file = $file;
		$this->data = array();
		$this->errors = array();
		$this->flags = array();
	}
	
	function getSections() {
		return $this->sections;
	}
	
	function parseFile($memberId) {
		$this->member_id = $memberId;
		$viewHandle = fopen($this->file, "r");
		if ($viewHandle) {
			foreach($this->sections AS $section) {
				$this->initSection($section);
			}
			
			while (!feof($viewHandle)) {
				$line = trim(fgets($viewHandle));
				foreach ($this->sections AS $section) {
					$this->parseSection($section, $line);	
				}
			}
		} else {
			$this->errors[] = 'erreur à l\'ouverture du fichier ' . $this->file;
		}
		$closeResult = fclose($viewHandle);
		if (!$closeResult) {
			$this->errors[] = 'erreur à la fermeture du fichier ' . $this->file;
		}
	}
	
	function getData($section) {
		return $this->data[$section];
	}
	
	function isInErrorStatus() {
		return !empty($this->errors);
	}
	
	function initSection($section) {
		$this->flags['debut'.$section] = false;
		$this->flags['fin'.$section] = true;
		$this->data[$section] = array();
	}
	
	function parseSection($section, $line) {
		if ('#DEBUT ' . $section == $line) {
			$this->flags['debut'.$section] = true;
		} elseif('#FIN '.$section == $line) {
			$this->flags['fin'.$section] = false;
		} elseif($this->flags['debut'.$section] && $this->flags['fin'.$section]) {
			$lineInArray = explode(';', $line);
			$formatFunction = 'get'.$section.'data';
   			$this->data[$section][] = $this->$formatFunction($lineInArray);
		}
	}
	
	function getTROLLSdata($array) {
		return array(
			'id' => $array[0],
   			'position_x' => $array[1],
   			'position_y' => $array[2],
   			'position_n' => $array[3],
   		);
	}
	
	function getORIGINEdata($array) {
		return array(
			'id' => $this->member_id,
   			'position_x' => $array[1],
   			'position_y' => $array[2],
   			'position_n' => $array[3],
   		);
	}
	
	function getMONSTRESdata($array) {
		return array(
			'id' => $array[0],
			'nom' => utf8_encode($array[1]),
   			'position_x' => $array[2],
   			'position_y' => $array[3],
   			'position_n' => $array[4],
   		);
	}
	
	function getTRESORSdata($array) {
		return array(
			'id' => $array[0],
			'type' => utf8_encode($array[1]),
   			'position_x' => $array[2],
   			'position_y' => $array[3],
   			'position_n' => $array[4],
   		);
	}
	
	function getCHAMPIGNONSdata($array) {
		return array(
			'id' => $array[0],
			'type' => utf8_encode($array[1]),
   			'position_x' => $array[2],
   			'position_y' => $array[3],
   			'position_n' => $array[4],
   		);
	}
	
	function getLIEUXdata($array) {
		return array(
			'id' => $array[0],
			'nom' => utf8_encode($array[1]),
   			'position_x' => $array[2],
   			'position_y' => $array[3],
   			'position_n' => $array[4],
   		);
	}

}
?>