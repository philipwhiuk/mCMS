<?php

class Content_Module extends Module {
	
	public function load(){
		
		Module::Get('permission');
		Module::Get('form');
		Module::Get('language');
		
		$this->files('content','exception');

		Module::Get('admin');

		Admin::Register('content','Content_Admin','admin',$this);

	}
	
}
