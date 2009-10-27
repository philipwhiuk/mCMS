<?php

class Guest_Authentication extends Authentication {
	
	protected function __construct($data = array()){
		parent::__construct($data);
	} 
	
	public function authentication_available(){
		return CMS_AUTHENTICATION_UNAVAILABLE;
	}
	
	public function release_user(){
		// Guest user :-P
	}
	
	public function authenticate_user($user){
		return false;
	}
	
	public function retrieve_user(){
		try {
			$gid = System::Get_Instance()->config()->get('guest_user');
		} catch(Exception $e){
			$gid = System::Get_Instance()->site()->get('guest_user');
		}
		
		return User::Get_By_ID($gid);
	}	
	
}