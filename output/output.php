<?php

abstract class Output {
	
	abstract public static function Create();
	
	public static function Load($formats = array()){
		$exceptions = array();
		foreach($formats as $format){
			try {
				$class = Module::Get($format)->load_section('Output');
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