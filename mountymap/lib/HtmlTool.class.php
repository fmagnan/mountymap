<?php

class HtmlTool {

	private static $instance;
	
	public static function getInstance() {
		if ( !isset(self::$instance) ) {
			$className = __CLASS__;
			self::$instance = new $className();
    	}
	    return self::$instance;
	}
  
	public static function getHTMLSelect($input_name, $options, $default_value='') {
		$html_select = '<select name="'.$input_name.'" id="'.$input_name.'">';
		if (array_key_exists($input_name, $_REQUEST)) {
			$selected_value = $_REQUEST[$input_name];
		} elseif($default_value != '') {
			$selected_value = $default_value;
		} else {
			$selected_value = '';
		}
		
		while(list($key, $option) = each($options)) {
        	if (is_object($option)) {
				$name = $option->getName();
				$value = $option->getId();
			} else {
				$name = $option;
				$value = $key;
			}
			$html_select .= '<option value="'.$value.'"';
			if ($selected_value == $value) {
				$html_select .= ' selected="selected"';
			}
			$html_select .= '>'.$name.'</option>' . "\n";
		}
	
		$html_select .= '</select>';
		return $html_select;
	}
	
	public static function getCellInfo($factory_name, $item) {
		if ('Monster' == $factory_name) {
			$cellInfo = '['.$item['id'].'] '. self::getMonsterLink($item['id'], $item['taille'], $item['nom'], $item['template'], $item['age'], $item['marquage']) . ' ' . $item['niveau'];
		} elseif('Treasure' == $factory_name) {
			$cellInfo = '['.$item['id'].'] '. $item['nom'];
		} elseif('TrollPosition' == $factory_name) {
			if (array_key_exists('side', $item)) {
				$class = 'class="'.$item['side'].'"';
			} else {
				$class='';
			}
			$cellInfo = '<span '.$class.'>['.$item['id'].'] '. self::getTrollLink($item['id'], $item['nom']) . ' ('.  $item['race'] .' '. $item['niveau'] . ') ' . self::getGuildLink($item['id_guilde'], $item['nom_guilde']).'</span>';
		} else {
			$cellInfo = '['.$item['id'].'] '. $item['nom'];
		}
		return $cellInfo;
	}
	
	public static function getMonsterLink($id, $size, $name, $template, $age, $mark) {
		$fullName = array();
		if ($size != '') {
			$fullName[] = $size;
		}
		$fullName[] = $name;
		if ($template != '') {
			$fullName[] = $template;
		}
		$fullName[] = '[' . $age . ']';
		if ($mark != '') {
			$fullName[] = $mark;
		}
		return '<a href="javascript:EMV('.$id.')">'.implode(' ', $fullName).'</a>';
	}
	
	public static function getTrollLink($id, $name) {
		return  '<a href="javascript:EPV('.$id.')">'. $name . '</a>';
	}
	
	public static function getGuildLink($id, $name) {
		return '<a href="javascript:EAV('.$id.')">'. $name . '</a>';
	}
	
	public static function getPostParameter($parameter) {
		return array_key_exists($parameter, $_POST) ? $_POST[$parameter] : false;
	}
}
?>