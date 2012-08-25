<?php
MCMS::Get_Instance()->file('database/database');
class Storage_Database implements IStorage {
	public static function GetStorageSystem() {
		return Database::GetDatabase();
	}

}