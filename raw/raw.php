<?php

abstract class Raw {
	
	protected $resource;
	
	protected function __construct($resource){
		$this->resource = $resource;
	}
	

	abstract public function display();
	
	abstract public function mimetype();
	abstract public function output();
	
	public static function Load($resource){
		$exceptions = array();
		try {				
			$class = $resource->get_module()->load_section('Raw');
			$raw = call_user_func(array($class, 'Load'), $resource);
			
			if(!($raw instanceof Raw)){
				throw new Raw_Invalid_Exception($class, $raw);
			}
			
			return $raw;
		} catch(Exception $e){
			$exceptions[] = $e;
		}
		
		// Darn, critical error. What do we do now?	
		
		// TODO: Implement last gasp system
		
		throw new Raw_Fatal_Exception($exceptions);
	}
	
}