<?php

class Feed_Module extends Module {
	
	public function load(){
	
		Module::Get('resource');
		$this->files('exception','feed','main');
		
	}
	
}
