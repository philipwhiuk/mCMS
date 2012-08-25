<?php

class Page_Module extends Module {
	
	public function load(){
	
		Module::Get('resource');
		$this->files('exception','page','main','block','block_main');
		
	}
	
}