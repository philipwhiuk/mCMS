<?php

class Admin_Module extends Module {

	public function load(){
		try {
		$this->files('admin','exception');
		Admin::Register('dashboard','Admin_Dashboard','dashboard',$this, 0);
			Module::Get('form');
			Module::Get('language');		
		}
		catch(Exception $e) {
			
		}
	}

}
