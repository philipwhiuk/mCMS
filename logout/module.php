<?php

class Logout_Module extends Module {
	
	public function load(){
		Module::Get('authentication');
	}
	
}
