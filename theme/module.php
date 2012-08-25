<?php

class Theme_Module extends Module {
	
	public function load(){
	
		Module::Get('template');
		$this->files('exception','theme');
		
		try {
			Module::Get('admin');
			Admin::Register('theme','Theme_Admin','admin',$this);
		} catch(Exception $e){

		}	
	}
	
}