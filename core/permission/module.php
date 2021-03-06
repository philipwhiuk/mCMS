<?php

class Permission_Module extends Module {
	
	public function load(){
		
		Module::Get('authentication','user');
		$this->files('exception','permission','user');
		
		try {
			Module::Get('group');
			$this->file('group');
			MCMS::Get_Instance()->permission_group = true;
		} catch(Exception $e){
			// No group permissions support
			MCMS::Get_Instance()->permission_group = false;
		}
		
	}
	
}