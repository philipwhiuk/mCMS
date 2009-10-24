<?php

class Permission_Module extends Module {
	
	public function load(){
		
		Module::Get('user','authentication');
		$this->files('exception','permission','user');
		
		try {
			Module::Get('group');
			$this->file('group');
			System::Get_Instance()->permission_group = true;
		} catch(Exception $e){
			// No group permissions support
			System::Get_Instance()->permission_group = false;
		}
		
	}
	
}