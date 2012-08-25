<?php

abstract class Logout_Page_Main extends Page_Main {
	
	public static function Load($parent){
		
		Authentication::Release();
		$system = MCMS::Get_Instance();
		$system->redirect($system->url('home'));
		exit;
		
	}
	
}