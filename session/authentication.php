<?php

class Session_Authentication extends Authentication {
	protected function __construct($data = array()){
		parent::__construct($data);
		session_start();
		register_shutdown_function('session_write_close');
	}
	
	public function authentication_available(){
		if(!isset($_SESSION['user'])){
			return CMS_AUTHENTICATION_AVAILABLE;
		}
		return CMS_AUTHENTICATION_UNAVAILABLE;
	}
	
	public function release_user(){
		unset($_SESSION['user']);
		session_destroy();
	}
	
	public function authenticate_user($user){
		$_SESSION['user'] = $user->get_id();
		return true;
	}
	
	public function retrieve_user(){
		if(isset($_SESSION['user'])){
			return User::Get_By_ID($_SESSION['user']);
		} else {
			throw new Session_Authentication_Not_Found_Exception();
		}
	}	
}