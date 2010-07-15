<?php

abstract class Admin {

	abstract public function execute();
	abstract public function display();

	public static function Register($id, $class, $file, $module, $priority = 50){
		// Register Panel
		System::Get_Instance()->admin['panels'][$priority][$id] = array('class' => $class, 'file' => $file, 'module' => $module);
	}

	public static function Create_All(){
		$system = System::Get_Instance();
		$registered = isset($system->admin['panels']) ? $system->admin['panels'] : array();
		ksort($registered);
		$panels = array();
		$exceptions = array();
		foreach($registered as $p => $pl){
			foreach($pl as $i => $panel){
				try {
					$panel['module']->file($panel['file']);
					$class = $panel['class'];
					if(!class_exists($class) || !is_subclass_of($class, 'Admin')){
						throw new Admin_Invalid_Exception($panel);
					}
					$panels[$i] = new $class($panel);
				} catch (Exception $e){
					// Ignore Panel
					$exceptions[] = $e;
				}
			}
		}
		if(count($panels) == 0){
			throw new Admin_Panels_Unavailable_Exception($exceptions);
		}
		return $panels;
	}

}
