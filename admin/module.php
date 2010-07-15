<?php

class Admin_Module extends Module {

	public function load(){
		Module::Get('permission');
		Module::Get('form');
		Module::Get('language');
		$this->files('admin','exception');
		Admin::Register('dashboard','Admin_Dashboard','dashboard',$this, 0);
	}

}
