<?php

/**
 * User Management Class File
 *
 * This file contains the User class which allows user management across the system.
 * @version $Id:$
 * @package Fusion
 * @subpackage API
**/

/**
 * User
 *
 * User is the base class which represents all the users in the system.
 * 
 * It is responsible for managing these users and presenting a consistent information to allow data retrieval.
 *
 * @package Fusion
 * @subpackage API
**/

class User extends API  {

/**
 * User
 *
 * Simplistic constructor which allows initalisation of a User object.
 *
 * @param array $data Key => Value array of preset data.
**/

	function __construct($data = array()){
		foreach($data as $f => $v){
			$this->$f = $v;
		}
	}
	
/**
 * Load
 *
 * Loads the user object.
 *
 * It firsts requests the relevant user data from the Authentication API.
 *
 * If this is valid, it the tries to find a user matching said data. It then creates a User object representing this user.
 * 
 * Otherwise, it looks for a Guest user to use instead.
 *
 * If both of these fail, then it passes to the installation function.
 *
 * @uses Authentication::authenticate()
 * @uses Fusion::$storage
 * @uses Log::Message()
 * @uses User_Guest
 * @uses Install::User()
**/

	static function Load(){
		$user_data = Fusion::$_->auth->authenticate();
		if(isset($user_data)){
			$sql = "SELECT * FROM user WHERE ";
			$sqls = array();
			foreach($user_data as $u => $v){
				$sqls[] = " `$u` = %s ";
			}
			$sql .= join($sqls, ' AND ');
			$result = Fusion::$_->storage->query($sql, $user_data);
			if($result && $row = $result->fetch_assoc()){
				Log::Message("{$row['type']} User loaded.");
				$c = 'User_' . $row['type'];
				return new $c($row);
			}
		}
		$sql = "SELECT * FROM user WHERE type = %s";
		$result = Fusion::$_->storage->query($sql, 'Guest');
		if($result && $row = $result->fetch_assoc()){
			Log::Message("{$row['type']} User loaded.");
			$c = 'User_' . $row['type'];
			return new $c($row);
		}
		Install::User();
	}
	
}

/**
 * Guest User
 *
 * This class represents any guest in the system. They are the default type of user if authentication fails.
 *
 * @package Fusion
 * @subpackage Users
**/

class User_Guest extends User {


}
