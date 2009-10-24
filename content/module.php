<?php

class Content_Module extends Module {
	
	public function load(){
		
		Module::Get('permission');
		$this->files('content','exception');
	}
	
}