<?php

class Menu_Module extends Module {
	public function load(){
		Module::Get('permission');
		$this->files('menu', 'exception', 'item');
		try {
			Module::Get('admin');
			Admin::Register('menu','Menu_Admin','admin',$this);
		} catch(Exception $e){
		}
	}
}
