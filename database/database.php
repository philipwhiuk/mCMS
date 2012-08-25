<?php
MCMS::Get_Instance()->files('database/interface','database/exception','database/provider');
class Database {
	static function GetDatabase(){
		try {
			$config = MCMS::Get_Instance()->config()->get('database');
		} catch(Exception $e){
			throw new Database_Configuration_Exception($e);
		}
		
		if(!isset($config['driver'])){
			throw new Database_Driver_Configuration_Exception($config);
		}
		
		try {
			MCMS::Get_Instance()->file("database/{$config['driver']}");
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