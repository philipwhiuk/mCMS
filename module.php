<?php

System::Get_Instance()->files('module/exception');

abstract class Module {
	
	// Used in Load_Module
	
	private $loaded = false;
	private $loading = false;
	
	// Database
	
	private $id;
	private $name;
	private $active;
	private $version;
	private $system;
	
	private $dir; // Generated
	
	protected function __construct($data){
		foreach($data as $k => $v){
			$this->$k = $v;
		}
	}
	
	public function id(){
		return $this->id;
	}
	
	public function get_directory(){
		return $this->dir;
	}
	
	public static function Get_ID($id){
		foreach(System::Get_Instance()->modules as $k => $module){
			if($module->id == $id){
				Module::Load_Module($k);
				return $module;
			}
		}
		throw new Module_Not_Available_Exception($id);
	}
	
	public static function Get_All($operator = null, $operand = null){
		
		if(isset($operator) && isset($operand)){
			$query = System::Get_Instance()->database()->Select()->table('module')->where($operator, $operand);
		} else {
			$query = System::Get_Instance()->database()->Select()->table('module');
		}
		
		$result = $query->execute();
		
		$modules = array();
		
		while($module = $result->fetch_assoc()){
			try {
				$module['dir'] = strtolower($module['name']);
				System::Get_Instance()->file("{$module['dir']}/module");
				$class = "{$module['name']}_Module";
				if(!class_exists($class) || !is_subclass_of($class, 'Module')){
					throw new Module_Invalid_Exception($module);
				}
				$modules[$module['dir']] = new $class($module);
			} catch (Exception $e){
				// Module not loaded.
			}		
		}
		
		return $modules;
		
	}
	
	public static function Available($module){
		if(!isset(System::Get_Instance()->modules[$module])){
			throw new Module_Not_Available_Exception($module);
		}
	}
	
	public static function Get($module){
		try {
			self::Load_Module($module);
		} catch (Exception $e){
			throw new Module_Not_Available_Exception($module, $e);
		}
		
		return System::Get_Instance()->modules[$module];
	}
	
	private static function Load_Module($module){
		// Dependandcy resolver.
		
		if(!isset(System::Get_Instance()->modules[$module])){
			throw new Module_Not_Found_Exception($module);
		}
		// Circular depedancy resolver.
		if(System::Get_Instance()->modules[$module]->loaded){
			return;
		}
		if(System::Get_Instance()->modules[$module]->loading){
			throw new Module_Circular_Dependancy_Exception($module);
		}
		System::Get_Instance()->modules[$module]->loading = true;
		try {
			System::Get_Instance()->modules[$module]->load();
			System::Get_Instance()->modules[$module]->loaded = true;
		} catch(Exception $e){
			unset(System::Get_Instance()->modules[$module]);
			throw new Module_Load_Exception($module, $e);
		}
	}
	
	abstract public function load();
	
	public function file($path, $once = true){
		try {
			return System::Get_Instance()->file("{$this->dir}/{$path}", $once);
		} catch(Exception $e){
			throw new Module_File_Not_Found_Exception($this->name, $path);
		}
	}
	
	public function files(){
		foreach(func_get_args() as $file){
			$this->file($file, true);	
		}
	}
	
	public function load_section($section){
		try {
			$this->file(strtolower($section));
			$class = "{$this->name}_{$section}";
			if(!class_exists($class) || !is_subclass_of($class, $section)){
				throw new Module_Section_Invalid_Exception($class, $section);
			}
			return $class;
		} catch (Exception $e) {
			throw new Module_Section_Exception($this->name, $section, $e);
		}		
	}
	
	public static function Load_All(){
		
		// First we want to get a list of all the Modules
		
		System::Get_Instance()->modules = Module::Get_All('=', array(array('col', 'active'), array('u', 1)));
		
		// Now we have a bunch of module classes!
		
		foreach(System::Get_Instance()->modules as $k => $module){
			try {
				Module::Load_Module($k);
			} catch(Exception $e){
				// Ignore module
			}
		}
		
	}
	
}
