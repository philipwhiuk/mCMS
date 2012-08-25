<?php

class User_Status_Module extends Module {
	public function load(){
		Module::Get('user');
		Module::Get('authentication');
		Module::Get('session');
		Module::Get('permission');
		Module::Get('form');
		Module::Get('language');
		Module::Get('login');
		Module::Get('logout');
		$this->files('exception');
	}
}