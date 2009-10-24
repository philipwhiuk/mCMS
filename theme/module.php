<?php

class Theme_Module extends Module {
	
	public function load(){
	
		Module::Get('template');
		$this->files('exception','theme');
		
	}
	
}