<?php

/**
 * User API File
 *
 * Subversion ID: $Id$
**/

// This file controls user management and settings.
// Authentication is handled by the ACL.
// The ACL passes a key => value pair which should identify the user.


class User {

	function __construct($data){
		foreach($data as $f => $v){
			$this->$f = $v;
		}
	}

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

class User_Guest extends User {


}
