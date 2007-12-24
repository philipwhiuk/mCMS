<?php

/**
 * Authentication API File
 *
 * Subversion ID: $Id$
**/

// This is the access control file. This handles all permisssions, logins, logouts, user groups etc.
// It can be replaced by LDAP or another mechanism.
// Each ACL must be able to handle authentication (probably via a block) and deauthentication as well as object permissions.
// The basic ACL uses a simple username/password system and has support for robots, user groups etc.


class Authentication {

	static function Load(){
		if(isset(Fusion::$_->config['authentication']) && class_exists(Fusion::$_->config['authentication'])){
			$c = 'Authentication_' . Fusion::$_->config['authentication'];
			Log::Message("Authentication {$c} loaded.");
			return new $c($fusion);
		} else {
			Log::Message("Default authentication loaded.");
			return new Authentication($fusion);
		}	
	}
	
	function authenticate(){
		session_start();
		if(isset($_SESSION['user_id'])){
			return array('id', $_SESSION['user_id']);
		} else {
			return NULL;
		}
	}
	
	function __construct(){
	
	}

}
