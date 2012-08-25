<?php

abstract class Admin {

	abstract public function execute($parent);
	abstract public function display();
	public function menuHasSubItems() {
		return true;
	}

	protected $id;
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
		return $this->parent->url(trim($this->id . '/' . $param,'/'));
	}

	public function module() {
		return $this->module;
	}
	
	public static function Register($id, $class, $file, $module, $priority = 50){
		// Register Panel
		MCMS::Get_Instance()->admin['panels'][$priority][$id] = array('class' => $class, 'file' => $file, 'module' => $module, 'priority' => $priority, 'id' => $id);
	}

	public static function Create_All($parent){
		$system = MCMS::Get_Instance();
		$registered = isset($system->admin['panels']) ? $system->admin['panels'] : array();
		ksort($registered);
		$panels = array();
		$exceptions = array();
		foreach($registered as $p => $pl){
			ksort($pl);
			foreach($pl as $i => $panel){
				try {
					$panel['module']->file($panel['file']);
					$class = $panel['class'];
					if(!class_exists($class) || !is_subclass_of($class, 'Admin')){
						throw new Admin_Invalid_Exception($panel);
					}
					$panels[$i] = Admin::MakePanel($class,$panel,$parent);
				} catch (Exception $e){
					//var_dump($e);
					$exceptions[] = $e;
				}
			}
		}
		if(count($panels) == 0){
			throw new Admin_Panels_Unavailable_Exception($exceptions);
		}
		return $panels;
	}
	private static function MakePanel($class,$panel,$parent) {
		$panelData = array();
		$panelData['menu'] = call_user_func(array($class,'Load_Menu'),$panel, $parent);
		$panelData['main'] = call_user_func(array($class,'Load_Main'),$panel, $parent);
		if($panelData['menu'] === null || $panelData['main'] === null) {
			throw new Admin_Invalid_Exception($panel);
		}
		return $panelData;
	}

}
