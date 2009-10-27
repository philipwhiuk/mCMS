<?php

class Session_Authentication extends Authentication {
	protected function __construct($data = array()){
		parent::__construct($data);
		session_start();
	}
	
	public function authentication_available(){
		return CMS_AUTHENTICATION_AVAILABLE;
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
			print_r($this);
		} else {
			throw new Session_Authentication_Not_Found_Exception();
		}
	}	
}