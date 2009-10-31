<?php

class Local_Module extends Module {
	
	public function load(){
		
		Module::Get('form');
		Module::Get('language');
		
		$this->file('exception');
		
	}
	
}