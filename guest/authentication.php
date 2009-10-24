<?php

class Guest_Authentication extends Authentication {
	
	protected function __construct($data = array()){
		parent::__construct($data);
	} 
	
	public function retrieve_user(){
		$this->get_module()->load_section('User');
		
		return Guest_User::Get_One($_SERVER['REMOTE_ADDR']);
	}	
	
}