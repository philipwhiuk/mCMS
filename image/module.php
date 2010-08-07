<?php

class Image_Module extends Module {
	
	public function load(){
		Module::Get('file');
		$this->files('exception', 'image', 'file');
		try {
			Module::Get('admin');
			Admin::Register('image','Image_Admin','admin',$this);
		} catch(Exception $e){
		}
	}
	
}