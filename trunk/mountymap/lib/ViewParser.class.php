<?php

require_once 'Parser.class.php';

class ViewParser extends Parser {

	var $member_id, $origin, $monsters_data, $giant_female_monsters, $giant_male_monsters, $giant_monsters; 
	var $monsters_templates, $monsters_sizes, $places_types;
	
	function __construct($member) {
		$this->member_id = $member->getId();
		$parameters = '?Numero='.$this->member_id.'&Motdepasse='.$member->getPassword().'&Tresors=1&Lieux=1&Champignons=1';
		$file = LOCAL_IMPORT_MODE ? '../data/vue_'.$this->member_id.'.txt' : VIEW_FILE_PATH . $parameters;
		parent::__construct($file); 
		$this->sections = array(
			'TROLLS' => 'TrollPosition', 'MONSTRES' => 'Monster', 'TRESORS' => 'Treasure',
			'LIEUX' => 'Place', 'CHAMPIGNONS' => 'Mushroom', 'ORIGINE' => false,
		);
		$this->origin = array();
		$this->monsters_data = unserialize(MONSTERS_DATA);
		$this->giant_female_monsters = unserialize(GIANT_FEMALE_MONSTERS);
		$this->giant_male_monsters = unserialize(GIANT_MALE_MONSTERS);
		$this->giant_monsters = array_merge($this->giant_female_monsters, $this->giant_male_monsters);
		$this->monsters_templates = unserialize(MONSTERS_TEMPLATES);
		$this->monsters_sizes = unserialize(MONSTERS_SIZES);
		$this->places_types = unserialize(PLACES_TYPES);
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
		} elseif ($section == 'ORIGINE') {
			$this->origin['id'] = $this->member_id;
			$this->origin['horizontal_range'] = $array[0];
			$this->origin['position_x'] = $array[1];
			$this->origin['position_y'] = $array[2];
			$this->origin['position_n'] = $array[3];
		} elseif(in_array($section, array('MONSTRES', 'LIEUX', 'TRESORS', 'CHAMPIGNONS'))) {
			$formattedData['position_x'] = $array[2];
			$formattedData['position_y'] = $array[3];
			$formattedData['position_n'] = $array[4];
			if(in_array($section, array('TRESORS', 'CHAMPIGNONS'))) {
				$formattedData['nom'] = utf8_encode($array[1]);
			} elseif($section == 'LIEUX') {
				$place_name = utf8_encode($array[1]);
				$place_type = 'Divers';
				foreach($this->places_types as $type) {
					preg_match('/('.$type.')(.*)/', $place_name, $type_matches);
					if (!empty($type_matches) && trim($type_matches[1]) != '') {
						$place_type = trim($type_matches[1]);
					}
				}
				$formattedData['nom'] = $place_name;
				$formattedData['type'] = $place_type;
			} elseif($section == 'MONSTRES') {
				$complete_monster_name = utf8_encode($array[1]);
				//echo '0 ' . $complete_monster_name;
				preg_match('/(.*)\[(.*)\](.*)/', $complete_monster_name, $matches);
				$monster_name = trim($matches[1]);
				//echo ' => 1 ' . $monster_name;
				$formattedData['age'] = trim($matches[2]);
				$formattedData['marquage'] = trim($matches[3]);
				
				$extract = $this->extractTemplateFromMonsterName($monster_name);
				$formattedData['template'] = $extract['template'];
				$monster_name = $extract['name'];
				
				//echo ' => 2 ' . $monster_name;
				
				$extract = $this->extractSizeFromMonsterName($monster_name);
				$formattedData['taille'] = $extract['size'];
				$monster_name = $extract['name'];
				
				//echo ' => 3 ' . $monster_name . '<br/>';
				$formattedData['nom'] = $monster_name;
				if (array_key_exists($monster_name, $this->monsters_data)) {
					$formattedData['famille'] = $this->monsters_data[$monster_name]['family'];
				}
			}
	 	} 
		
		return $formattedData;
	}

	function extractSizeFromMonsterName($monster_name) {
		$size = '';
		
		foreach($this->monsters_sizes as $monster_size) {
			if (0 != preg_match('/('.$monster_size.') (.*)/', $monster_name, $size_matches)) {
				$size = trim($size_matches[1]);
				if (trim($size_matches[2]) != '') {
					$monster_name = trim($size_matches[2]);
					break;
				}
			}
		}
		if (0 != preg_match('/(.*) (Gigantesque)/', $monster_name, $exception_matches)) {
			if (trim($exception_matches[1]) != '') {
				$monster_name = trim($exception_matches[1]);
			}
			if (in_array($monster_name, $this->giant_female_monsters)) {
				$size = 'Grosse';
				$monster_name .= ' Géante';
			} else {
				$size = 'Gros';
				$monster_name .= ' Géant';
			}
		}
		if (in_array($monster_name, $this->giant_female_monsters)) {
			$size = 'Petite';
			$monster_name .= ' Géante';
		} elseif(in_array($monster_name, $this->giant_male_monsters)) {
			$size = 'Petit';
			$monster_name .= ' Géant';
		}
		return array('size' => $size, 'name' => $monster_name);
	}
	
	function extractTemplateFromMonsterName($monster_name) {
		$template = '';
		foreach($this->monsters_templates as $monster_template => $level) {
			$results = preg_match('/^(.*) ('.$monster_template.')$/', $monster_name, $template_matches);
			if ($results != 0) {
				$monster_name = trim($template_matches[1]);
				$template .= trim($template_matches[2]);
			} else {
				$results = preg_match('/^('.$monster_template.') (.*)$/', $monster_name, $template_matches);
				if ($results != 0) {
					$monster_name = trim($template_matches[2]);
					$template .= trim($template_matches[1]);
				}
			}
		}
		return array('template' => $template, 'name' => $monster_name);
	}
	
	function getOrigin() {
		return $this->origin;
	}
}
?>