<?php

class Film_Certificate_Module extends Module {
	
	public function load(){
		
		Module::Get('permission');
		Module::Get('form');
		Module::Get('language');
		Module::Get('content');
		Module::Get('image');
		
		$this->files('film_certificate','exception');
	}
	
}