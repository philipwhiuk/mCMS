<?php

class Login_Module extends Module {
	public function load(){
		Module::Get('authentication');
	}
}