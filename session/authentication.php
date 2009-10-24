<?php

class Session_Authentication extends Authentication {
	protected function __construct($data = array()){
		parent::__construct($data);
		session_start();
	}
	
	public function retrieve_user(){
		if(isset($_SESSION['user'])){
			print_r($this);
		} else {
			throw new Session_Authentication_Not_Found_Exception();
		}
	}	
}