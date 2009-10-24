<?php

/**
 * Database class file.
 * 
 * Contains the core database class which allows the CMS to store data which is persists from session to session.
 * 
 * @uses System::Get_Instance()
 * @uses CMS::files()
 * @package CMS
 */

// Load exceptions

System::Get_Instance()->files('database/exception','database/interface');

abstract class Database {
	
	static function Load(){
		
		try {
			$config = System::Get_Instance()->config()->get('database');
		} catch(Exception $e){
			throw new Database_Configuration_Exception($e);
		}
		
		if(!isset($config['driver'])){
			throw new Database_Driver_Configuration_Exception($config);
		}
		
		try {
			System::Get_Instance()->file("database/{$config['driver']}");
		} catch (Exception $e){
			throw new Database_Driver_Not_Found_Exception($config['driver'], $e);
		}
		
		$class = "Database_{$config['driver']}";
		
		
		
		if(!class_exists($class) || !class_implements($class,'IDatabase')){
			throw new Database_Driver_Invalid_Exception($config['driver']);
		}
		
		return new $class($config); 
		
	}
	
	
}