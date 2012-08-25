<?php

class Authentication_Module extends Module {
	
	public function load(){
		Module::Get('user');
		$this->files('exception','authentication');
	}
	
}