<?php

abstract class Template {
	
	public static function Start($path, $data = array()){
		
		try {
			System::Get_Instance()->file(join('/', $path));
			
			array_unshift($path, 'Template');
			
			$class = join('_', $path);
			
			if(!class_exists($class) || !is_subclass_of($class, 'Template')){
				throw new Template_Invalid_Exception($class);
			}

			return new $class($data);
		} catch(Exception $e){
			throw new Template_Not_Found_Exception($e);
		}	
	}
	
	public function __construct($data){
		foreach($data as $k => $v){
			$this->$k = $v;
		}
	}
	
	abstract public function display();
	
} 