<?php
MCMS::Get_Instance()->file('database/database');
/**
 * Provides a connector for databases as a storage system.
 */ 
class Storage_Database implements IStorage {
	public static function GetStorageSystem() {
		return Database::GetDatabase();
	}

}