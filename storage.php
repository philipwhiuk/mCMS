<?php
MCMS::Get_Instance()->files('storage/istorage','storage/exception','storage/retrievalprocess');
/**
 * Storage class. 
 */
class Storage {
    /**
	 * Retrieves the configured storage system.
	 */
	public static function GetStorageSolution() {
		try {
			$config = MCMS::Get_Instance()->config()->get('storage');	
		} catch(Exception $e){
			throw new Storage_Configuration_Exception($e);
		}		
		try {
			MCMS::Get_Instance()->file("storage/{$config['driver']}");
		} catch (Exception $e){
			throw new Storage_Driver_Not_Found_Exception($config['driver'], $e);
		}
		$class = "Storage_{$config['driver']}";
		if(!class_exists($class) || !class_implements($class,'IStorage')){
			throw new Storage_Driver_Invalid_Exception($config['driver']);
		}
		return $class::GetStorageSystem();
	}
}