<?php

class Film_Festival_Module extends Module {
	
	public function load(){
		Module::Get('permission');
		Module::Get('form');
		Module::Get('language');
		
		$this->files('film_festival','film_festival_impl','exception');
	}
	
}