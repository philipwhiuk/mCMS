<?php

class HTML_Module extends Module {
	
	public function load(){
	
		Module::Get('theme');
		//$this->files('exception','page','main','block','block_main');
		
	}
	
}