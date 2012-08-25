<?php

abstract class Output {
	
	//E_STRICT
	//abstract public static function Create();
	
	public static function Load($formats = array()){
		$exceptions = array();
		foreach($formats as $format){
			try {
				if(!($format instanceof Module)){
					$module = Module::Get($format); 
				} else {
					$module = $format;
				}
				$class = $module->load_section('Output');
				$output = call_user_func(array($class, 'Create'));
				return $output;
			} catch (Exception $e){
				$exceptions[] = $e;
			}
		}
		throw new Output_Not_Found_Exception($formats, $exceptions);
	}
	
	abstract public function logic($path);
	abstract public function render($data); 
}