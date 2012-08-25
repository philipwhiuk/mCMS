<?php

abstract class Form_Field {
	
	protected $name;
	private $info;
	
	protected function __construct($name, $info){
		$this->name = $name;
		$this->info = $info;
	}
	
	public function get_name(){
		return $this->name;
	}
	
	abstract public function execute($parent, $data);
	
	abstract public function display($parent);
	
	public static function Register($name, $class, $file, $module){
		MCMS::Get_Instance()->form['fields'][$name][] = array('class' => $class, 'file' => $file,'module' => $module);
	}
	
	public static function Register_All($data){
		foreach($data as $k => $v){
			Form_Field::Register($v[0],$v[1],$v[2],$v[3]);
		}
	}
	
	public static function Create($name, $types){
		if(!is_array($types)){
			$types = array($types);
		}
		$exceptions = array();
		
		foreach($types as $type){
			if(isset(MCMS::Get_Instance()->form['fields'][$type])){
				foreach(MCMS::Get_Instance()->form['fields'][$type] as $info){
					try {
						$info['module']->file($info['file']);
						$class = $info['class'];
						if(!class_exists($class) || !is_subclass_of($class, 'Form_Field')){
							throw new Form_Field_Invalid_Exception($info);
						}
						return new $class($name, $info);
					} catch (Exception $e){
						$exceptions[] = $e;
					}
				}
			}
		}
		var_dump($exceptions);
		throw new Form_Field_Not_Found_Exception($name, $types, $exceptions);
		
	}
	
}