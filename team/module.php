<?php

class Team_Module extends Module {

	public function load(){
		Module::Get('content');
		Module::Get('member');
		
		$this->files('team','member','exception');
		try {
			Module::Get('admin');
			Admin::Register('team','Team_Admin','admin',$this);
		} catch(Exception $e){
		}
	}

}
