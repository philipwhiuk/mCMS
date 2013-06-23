<?php
MCMS::Get_Instance()->files('package/exception');
/**
 * A Package is a set of related Modules distributed together.
 * Often packaged modules will have circular dependencies.
 * @author Philip Whitehouse
 */
abstract class Package {
    /**
	 * Indicates the given package is available.
	 */	
	public static function Available($package){
		if(!isset(MCMS::Get_Instance()->packages[$package])){
			throw new Package_Not_Available_Exception($package);
		}
	}
	/**
	 * Fetch a package by it's ID
	 */
	public static function Get_ID($id){
		foreach(MCMS::Get_Instance()->packages as $k => $package){
			if($package->id == $id){
				package::Load_package($k);
				return $package;
			}
		}
		throw new Package_Not_Available_Exception($id);
	}
	/**
	 * Fetch all packages.
	 */
	public static function Get_All($operator = null, $operand = null){
		if(isset($operator) && isset($operand)){
			$query = MCMS::Get_Instance()->storage()->Get()->From('package')->where($operator, $operand);
		} else {
			$query = MCMS::Get_Instance()->storage()->Get()->From('package');
		}
		$result = $query->execute();
		
		$packages = array();
		
		while($package = $result->fetch_assoc()){
			try {
				$package['dir'] = strtolower($package['name']);
				MCMS::Get_Instance()->file($package['dir'].'/package');
				$class = "{$package['name']}_package";
				if(!class_exists($class) || !is_subclass_of($class, 'package')){
					throw new package_Invalid_Exception($package);
				}
				$packages[$package['dir']] = new $class($package);
			} catch (Exception $e){
				// package not loaded.
			}		
		}
		
		return $packages;
		
	}
	/**
	 * Get a selection of packages.
	 */ 
	public static function Get_Selection($limit = null, $skip = null){
		$query = MCMS::Get_Instance()->Storage()->Get()->From('package')->order(array('name' => true));

		if(isset($limit)){
			$query->limit($limit);
			if(isset($skip)){
				$query->offset($skip);
			}
		}
		
		$result = $query->execute();
		
		$packages = array();
		
		while($package = $result->fetch_assoc()){
			try {
				$package['dir'] = strtolower($package['name']);
				MCMS::Get_Instance()->file("{$package['dir']}/package");
				$class = "{$package['name']}_Package";
				if(!class_exists($class) || !is_subclass_of($class, 'package')){
					throw new package_Invalid_Exception($package);
				}
				$packages[$package['dir']] = new $class($package);
			} catch (Exception $e){
				// package not loaded.
			}		
		}
		
		return $packages;
	}
	/**
	 * Load all packages.
	 */
	public static function Load_All() {
		MCMS::Get_Instance()->packages = package::Get_All('=', array(array('col', 'active'), array('u', 1)));
		// Now we have a bunch of package classes!
		foreach(MCMS::Get_Instance()->packages as $k => $package){
			try {
				package::Load_package($k);
			} catch(Exception $e){
			}
		}
	}
	/**
	 * Get a package by it's name.
	 */
	public static function Get($package) {
		try {
			self::Load_package($package);
		} catch (Exception $e){
			throw new package_Not_Available_Exception($package, $e);
		}
		
		return MCMS::Get_Instance()->packages[$package];
	}
	/**
	 * Load a specific package.
	 */
	private static function Load_package($package){
		if(!isset(MCMS::Get_Instance()->packages[$package])){
			throw new package_Not_Found_Exception($package);
		}
		// Circular depedancy resolver.
		if(MCMS::Get_Instance()->packages[$package]->loaded){
			return;
		}
		if(MCMS::Get_Instance()->packages[$package]->loading){
			throw new package_Circular_Dependancy_Exception($package);
		}
		MCMS::Get_Instance()->packages[$package]->loading = true;
		try {
			MCMS::Get_Instance()->packages[$package]->load();
			MCMS::Get_Instance()->packages[$package]->loaded = true;
		} catch(Exception $e){
			unset(MCMS::Get_Instance()->packages[$package]);
			throw new package_Load_Exception($package, $e);
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
	public function file($path, $once = true){
		try {
			if($this->package() == null) {
				$file = $this->dir.'/'.$path;
			}
			else {
				$file = $this->package()->get_directory().'/'.$this->dir.'/'.$path;
			}
			return MCMS::Get_Instance()->file($file, $once);
		} catch(Exception $e){
			throw new package_File_Not_Found_Exception($this->name, $path);
		}
	}
	
	public function files(){
		foreach(func_get_args() as $file){
			$this->file($file, true);	
		}
	}
	public function package() {
		if(!$this->package instanceof Package && $this->package != MCMS_NOT_PACKAGED) {
			$this->package = Package::Get_ID($package);
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
}