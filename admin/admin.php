<?php

abstract class Admin {

	abstract public function execute();
	abstract public function display();
	abstract public function display_menu();

	protected $name;
	protected $class;
	protected $file;
	protected $module;
	protected $priority;
	protected $parent;

	public function __construct($panel, $parent){
		foreach($panel as $k => $v){
			$this->$k = $v;
		}
		$this->parent = $parent;
	}

	public function url($param = ''){
		return $this->parent->url(trim($this->name . '/' . $param,'/'));
	}

	public static function Register($id, $class, $file, $module, $priority = 50){
		// Register Panel
		System::Get_Instance()->admin['panels'][$priority][$id] = array('class' => $class, 'file' => $file, 'module' => $module, 'priority' => $priority, 'name' => $id);
	}

	public static function Create_All($parent){
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
					$panels[$i] = new $class($panel, $parent);
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
