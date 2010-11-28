<?php

class Raven_Module extends Module {
	
	public function load(){
	
		Module::Get('form');
		Module::Get('language');

		$this->files('ucam_webauth','webauth','exception');
		
	}
	
}
