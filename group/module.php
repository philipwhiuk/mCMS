<?php

class Group_Module extends Module {
	
	public function load(){
		
		Module::Get('user');
		
		$this->files('group','user');
		try {
			Module::Get('admin');
			Admin::Register('group','Group_Admin','admin',$this);
		} catch(Exception $e){

		}	
	}
	
}