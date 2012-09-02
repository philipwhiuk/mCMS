<?php
/*
 * File: module.php
 * Purpose: MCMS Module Class
 */ 
MCMS::Get_Instance()->files('module/exception');
abstract class Module {
	/** Determine if the provided module is available **/
	public static function Available($module){
		if(!isset(MCMS::Get_Instance()->modules[$module])){
			throw new Module_Not_Available_Exception($module);
		}
	}
	public static function Count_All(){
		
		$query = MCMS::Get_Instance()->Storage()->Count()->From('module');
		return $query->execute();

	}
	public static function Get_ID($id){
		foreach(MCMS::Get_Instance()->modules as $k => $module){
			if($module->id == $id){
				Module::Load_Module($k);
				return $module;
			}
		}
		throw new Module_Not_Available_Exception($id);
	}
	public static function Get_All($operator = null, $operand = null){
		if(isset($operator) && isset($operand)){
			$query = MCMS::Get_Instance()->storage()->Get()->From('module')->where($operator, $operand);
		} else {
			$query = MCMS::Get_Instance()->storage()->Get()->From('module');
		}
		$result = $query->execute();
		
		$modules = array();
		
		while($module = $result->fetch_assoc()){
			try {
				$module['dir'] = strtolower($module['name']);
				if($module['package'] == MCMS_NOT_PACKAGED) {
					$file = $module['dir'].'/module';
				}
				else {
					$file = Package::Get_ID($module['package'])->get_directory().'/'.$module['dir'].'/module';
				}		
				MCMS::Get_Instance()->file($file);
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
	public static function Get_Selection($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('module')->order(array('name' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$modules = array();
		
		while($module = $result->fetch_assoc()){
			try {
				$module['dir'] = strtolower($module['name']);
				if($module['package'] == MCMS_NOT_PACKAGED) {
					$file = $module['dir'].'/module';
				}
				else {
					$file = Package::Get_ID($module['package'])->get_directory().'/'.$module['dir'].'/module';
				}		
				MCMS::Get_Instance()->file($file);
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
	public static function Load_All() {
		MCMS::Get_Instance()->modules = Module::Get_All('=', array(array('col', 'active'), array('u', 1)));
		// Now we have a bunch of module classes!
		foreach(MCMS::Get_Instance()->modules as $k => $module){
			try {
				Module::Load_Module($k);
			} catch(Exception $e){
			}
		}
	}
	public static function Get($module) {
		try {
			self::Load_Module($module);
		} catch (Exception $e){
			throw new Module_Not_Available_Exception($module, $e);
		}
		
		return MCMS::Get_Instance()->modules[$module];
	}
	private static function Load_Module($module){
		if(!isset(MCMS::Get_Instance()->modules[$module])){
			throw new Module_Not_Found_Exception($module);
		}
		// Circular depedancy resolver.
		if(MCMS::Get_Instance()->modules[$module]->loaded){
			return;
		}
		if(MCMS::Get_Instance()->modules[$module]->loading){
			throw new Module_Circular_Dependancy_Exception($module);
		}
		MCMS::Get_Instance()->modules[$module]->loading = true;
		try {
			MCMS::Get_Instance()->modules[$module]->load();
			MCMS::Get_Instance()->modules[$module]->loaded = true;
		} catch(Exception $e){
			unset(MCMS::Get_Instance()->modules[$module]);
			throw new Module_Load_Exception($module, $e);
		}
	}
	//Loading
	private $loaded = false;
	private $loading = false;
	//Stored
	private $id;
	private $name;
	private $active;
	private $version;
	private $system;
	private $package;
	//Generated
	private $dir;

	protected function __construct($data){
		foreach($data as $k => $v){
			$this->$k = $v;
		}
	}
	public function id(){
		return $this->id;
	}
	public function name() {
		return $this->name;
	}
	public function version() {
		return $this->version;
	}	
	public function file($path, $once = true){
		try {
			if($this->package() === null) {
				$file = $this->dir.'/'.$path;
			}
			else {
				$file = $this->package()->get_directory().'/'.$this->dir.'/'.$path;
			}
			return MCMS::Get_Instance()->file($file, $once);
		} catch(Exception $e){
			throw new Module_File_Not_Found_Exception($this->name, $path);
		}
	}
	
	public function files(){
		foreach(func_get_args() as $file){
			$this->file($file, true);	
		}
	}
	public function package() {
		if(!$this->package instanceof Package && $this->package != MCMS_NOT_PACKAGED) {
			$this->package = Package::Get_ID($this->package);
		}
		elseif(!$this->package instanceof Package && $this->package == MCMS_NOT_PACKAGED) {
			$this->package = null;
		}
		return $this->package;
	}
	
	public function get_directory(){
		return $this->dir;
	}
	abstract public function load();
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
}