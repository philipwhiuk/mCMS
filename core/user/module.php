<?php

class User_Module extends Module {
	
	public function load(){
		$this->files('user','exception');
		try {
			Module::Get('admin');
			Admin::Register('user','User_Admin','admin',$this);
		} catch(Exception $e){
		}
	}
	
}