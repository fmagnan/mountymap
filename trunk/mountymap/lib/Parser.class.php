<?php

class Parser {

	var $file;
	var $trollsData;
	var $origineData;
	var $errors;
	
	function Parser($file) {
		$this->file = $file;
		$this->trollsData = array();
		$this->origineData = array();
		$this->errors = array();
	}
	
	function parseFile($membre) {
		$viewHandle = fopen($this->file, "r");
		if ($viewHandle) {
			$debutChampignons = false; $debutLieux = false; $debutMonstres = false;
			$debutOrigine = false; $debutTresors = false; $debutTrolls = false;
			
			$finChampignons = true; $finLieux = true; $finMonstres = true;
			$finOrigine = true;	$finTresors = true;	$finTrolls = true;
			
			while (!feof($viewHandle)) {
	   			$line = trim(fgets($viewHandle));
	   			if ('#DEBUT TROLLS' == $line) {
	   				$debutTrolls = true;
	   			} elseif('#FIN TROLLS' == $line) {
	   				$finTrolls = false;
	   			} elseif($debutTrolls && $finTrolls) {
	   				$trollLine = explode(';', $line);
	   				$this->trollsData[] = array(
	   					'id' => $trollLine[0],
	   					'position_x' => $trollLine[1],
	   					'position_y' => $trollLine[2],
	   					'position_n' => $trollLine[3],
	   				);
	   			} elseif('#DEBUT ORIGINE' == $line) {
	   				$debutOrigine = true;
	   			} elseif('#FIN ORIGINE' == $line) {
	   				$finOrigine = false;
	   			} elseif($debutOrigine && $finOrigine) {
	   				$origineLine = explode(';', $line);
	   				$this->trollsData[] = array(
	   					'id' => $membre,
	   					'position_x' => $origineLine[1],
	   					'position_y' => $origineLine[2],
	   					'position_n' => $origineLine[3],
	   				);
	   				$this->origineData = array(
	   					'nombre_cases_vues_horizontales' => $origineLine[0],
	   					'nombre_cases_vues_verticales' => floor(intval($origineLine[0]) / 2),
	   					'position_x' => $origineLine[1],
	   					'position_y' => $origineLine[2],
	   					'position_n' => $origineLine[3],
	   				);
	   			}/* elseif('#DEBUT TRESORS' == $line) {
	   				$debutTresors = true;
	   			} elseif('#FIN TRESORS' == $line) {
	   				$finTresors = false;
	   			} elseif($debutTresors && $finTresors) {
	   				$tresorData = explode(';', $line);
	   				insertOrUpdateTresorPosition($tresorData);
	   			}*/
			}
		} else {
			$this->errors[] = 'erreur à l\'ouverture du fichier ' . $this->file;
		}
		$closeResult = fclose($viewHandle);
		if (!$closeResult) {
			$this->errors[] = 'erreur à la fermeture du fichier ' . $this->file;
		}
	}
	
	function getTrollsData() {
		return $this->trollsData;
	}
	
	function getOrigineData() {
		return $this->origineData;
	}
	
	function isInErrorStatus() {
		return !empty($this->errors);
	}
	
	/*function parseSection($sectionName, $line) {
	if ('#DEBUT ' . $sectionName == $line) {
		$debutTrolls = true;
	} elseif('#FIN TROLLS' == $line) {
		$finTrolls = false;
   	} elseif($debutTrolls && $finTrolls) {
		$trollLine = explode(';', $line);
   		$trollsData[] = array(
   			'id' => $trollLine[0],
   			'position_x' => $trollLine[1],
   			'position_y' => $trollLine[2],
   			'position_n' => $trollLine[3],
   			);
	}}*/
	
}
?>