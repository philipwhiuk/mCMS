<?php

class Menu_Module extends Module {
	public function load(){
		Module::Get('permission');
		
		$this->files('menu', 'exception', 'resource');
	}
}