<?php

class Login_Page_Main extends Page_Main {
	
	public static function Load($parent){
		
		$user = Authentication::User();
		
		if(!$user->authenticated()){
			return new Login_Page_Main($parent);
		}
		
	}
	
	public function display(){
		$template = System::Get_Instance()->output()->start(array('login','page'));
		
		return $template;
	}
}