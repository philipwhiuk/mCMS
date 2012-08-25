<?php
class Link_Module extends Module {
	public function load() {
		
		Module::Get('permission');
		Module::Get('form');
		Module::Get('language');
		Module::Get('content');
		
		$this->files('link','exception');

		try {
			Module::Get('admin');
			Admin::Register('link','Link_Admin','admin',$this);
		} catch(Exception $e){

		}	
	}
}