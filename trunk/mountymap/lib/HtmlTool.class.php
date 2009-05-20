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
  
	public function getHTMLSelect($input_name, $options, $default_value='') {
		$html_select = '<select name="'.$input_name.'" id="'.$input_name.'">';
		if (array_key_exists($input_name, $_REQUEST)) {
			$selected_value = $_REQUEST[$input_name];
		} elseif($default_value != '') {
			$selected_value = $default_value;
		} else {
			$selected_value = '';
		}
		
		while($option=current($options)) {
        	if (is_object($option)) {
				$name = $option->getName();
				$value = $option->getId();
			} else {
				$name = $option;
				$value = key($options);
			}
			$html_select .= '<option value="'.$value.'"';
			if ($selected_value == $value) {
				$html_select .= ' selected="selected"';
			}
			$html_select .= '>'.$name.'</option>' . "\n";
			next($options);
		}
		$html_select .= '</select>';
		return $html_select;
	}
	
}
?>