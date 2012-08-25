<?php
class TravelAgent_Module extends Module {
	public function load() {
		Module::Get('content');
		Module::Get('permission');
		Module::Get('form');
		Module::Get('language');
		
		$this->files('resort','flight','package','exception');

		try {
			Module::Get('admin');
			Admin::Register('content','Content_Admin','admin',$this);
		} catch(Exception $e){

		}	
	}
}