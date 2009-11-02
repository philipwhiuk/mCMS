<?php

class Content_Module extends Module {
	
	public function load(){
		
		Module::Get('permission');
		Module::Get('form');
		Module::Get('language');
		
		$this->files('content','exception');
	}
	
}