<?php

/**
 * Authentication File
 *
 * This file contains the Authentication API which controls all user authentication and authorisation.
 *
 * @version $Id:$
 * @package Fusion
 * @subpackage API
**/

/**
 * Authentication API
 *
 * This is the access control class. This handles all permissions, logins, logouts, user groups etc.
 * It can be replaced by a subclass by specifying a option in the configuration.
 * The authentication class must be able to handle authentication and deauthentication (possibly by a block) as well as permissions.
 * This basic class uses a simple username / password system with support for user groups etc.
 *
 * The current authentication API can be accessed using: Fusion::$_->auth once Fusion::load() has run.
 *
 * @package Fusion
 * @subpackage API
 * @see Fusion::load()
 * @uses Fusion::$auth
**/

class Authentication extends API {

/**
 * Load Authentication
 *
 * This static function loads the Authentication module.
 *
 * It checks the configuration for the type of authentication and then loads it.
 * 
 * Any authentication module used must begin with Authentication_
**/

	static function Load(){
		if(isset(Fusion::$_->config['authentication']) && class_exists(Fusion::$_->config['authentication'])){
			$c = 'Authentication_' . Fusion::$_->config['authentication'];
			Log::Message("Authentication {$c} loaded.");
			return new $c($fusion);
		} else {
			Log::Message("Default authentication loaded.");
			return new Authentication();
		}	
	}
	
/**
 * Permissions
 *
 * This function handles permissions control for the base authentication class.
 *
 * @todo implement
**/
	
	function permissions($type, $id, $modes){
		// Implement
		
		return $modes;	
	}
	
/**
 * Authentication
 *
 * This function handles per page authentication.
 *
 * It returns an array which specifies the user object using a key value system.
 *
 * @see User::Load
**/
	
	function authenticate(){
		session_start();
		if(isset($_SESSION['user_id'])){
			return array('id' => $_SESSION['user_id']);
		} else {
			return NULL;
		}
	}
	
/**
 * Constructor
 *
 * This function constructs the authentication module
**/
	
	function __construct(){
	
	}

}
