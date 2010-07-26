<?php

class News_Module extends Module {
	
	public function load(){
		Module::Get('content');
		
		$this->files('article','category', 'exception');
		try {
			Module::Get('admin');
			Admin::Register('news','News_Admin','admin',$this);
		} catch(Exception $e){

		}
	}
	
}