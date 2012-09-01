<?php
abstract class Admin_Dashboard_Overview_Widget {
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
		// Register Widget
		MCMS::Get_Instance()->admin['dashboard']['overview']['widgets'][$priority][$id] = array('class' => $class, 'file' => $file, 'module' => $module, 'priority' => $priority, 'id' => $id);
	}

	public static function Create_All($parent){
		$system = MCMS::Get_Instance();
		$registered = isset($system->admin['dashboard']['overview']['widgets']) ? $system->admin['dashboard']['overview']['widgets'] : array();
		ksort($registered);
		$widgets = array();
		$exceptions = array();
		foreach($registered as $w => $wi){
			ksort($wi);
			foreach($wi as $i => $widget){
				try {
					$widget['module']->file($widget['file']);
					$class = $widget['class'];
					if(!class_exists($class) || !is_subclass_of($class, 'Admin_Dashboard_Overview_Widget')){
						throw new Admin_Invalid_Exception($widget);
					}
					$widgets[$i] = array('class' => $class, 'widget' => $widget, 'parent' => $parent);
				} catch (Exception $e){
					var_dump($e);
					$exceptions[] = $e;
				}
			}
		}
		return $widgets;
	}
}