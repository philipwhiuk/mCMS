<?php

class Group_Module extends Module {
	
	public function load(){
		
		Module::Get('user');
		
		$this->files('group','user');
		
	}
	
}